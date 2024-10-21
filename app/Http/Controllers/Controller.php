<?php

namespace App\Http\Controllers;

use App\Models\Loja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Tipo;
use App\Models\Categoria;
use App\Models\Plano;
class Controller
{
    public function tipos()
    {
        $tipos = Tipo::all();
        return response()->json($tipos);
    }
    public function Tipostore(Request $request)
    {
        // Validação simples
        $request->validate([
            'tipo' => 'required|string|max:255',
        ]);

        // Criação do novo tipo
        $tipo = new Tipo();
        $tipo->tipo = $request->input('tipo');
        $tipo->save();

        return response()->json(['message' => 'Tipo criado com sucesso!', 'data' => $tipo], 201);
    }

    // Método para deletar um tipo pelo ID
    public function Tipodestroy($id)
    {
        // Buscar o tipo pelo ID
        $tipo = Tipo::find($id);

        // Verificar se o tipo existe
        if (!$tipo) {
            return response()->json(['message' => 'Tipo não encontrado.'], 404);
        }

        // Excluir o tipo
        $tipo->delete();

        return response()->json(['message' => 'Tipo deletado com sucesso.'], 200);
    }
    public function getCategorias(Request $request)
    {
        // Valida a entrada para garantir que o 'id_tipo' seja passado
        $request->validate([
            'id_tipo' => 'required|exists:tipos,id',
        ]);

        // Busca todas as categorias associadas ao tipo
        $categorias = Categoria::where('id_tipo', $request->id_tipo)->get();

        // Retorna as categorias como uma resposta JSON
        return response()->json($categorias);
    }

    public function addCategoria(Request $request)
    {
        // Validação dos dados enviados
        $request->validate([
            'id_tipo' => 'required|exists:tipos,id', // Verifica se o tipo existe
            'categoria' => 'required|string|max:255', // Nome da categoria obrigatório
        ]);

        // Cria a nova categoria
        $novaCategoria = Categoria::create([
            'id_tipo' => $request->id_tipo,
            'categoria' => $request->categoria,
        ]);

        // Retorna a nova categoria como resposta JSON
        return response()->json($novaCategoria);
    }

    public function destroyCategoria($id)
    {
        $categoria = Categoria::findOrFail($id);
        $categoria->delete();

        return response()->json(['message' => 'Categoria deletada com sucesso!']);
    }

    public function updatePlanos(Request $request, $id)
    {
        // Validação dos dados de entrada
        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'valor' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
        ]);

        // Encontrar o plano pelo ID
        $plano = Plano::find($id);

        if (!$plano) {
            return response()->json(['message' => 'Plano não encontrado.'], 404);
        }

        // Atualizar os atributos do plano
        $plano->update($request->only(['nome', 'descricao', 'valor']));

        return response()->json(['message' => 'Plano atualizado com sucesso.', 'plano' => $plano], 200);
    }

    public function adicionarCategoria(Request $request)
    {
        // Validação do campo 'nome'
        $request->validate([
            'nome' => 'required|string',
        ]);

        $user = Auth::user();
        $idLoja = $user->lojaId;
        $loja = Loja::where('id', $idLoja)->first();

        // Decodificar o campo 'produtos'
        $produtos = json_decode($loja->produtos, true);

        // Se 'produtos' for null ou não existir a chave 'categorias', inicializar
        if (!$produtos || !isset($produtos['categorias'])) {
            $produtos = [
                'categorias' => [] // Inicializar com uma array vazia de categorias
            ];
        }

        // Verificar se a categoria já existe
        foreach ($produtos['categorias'] as $categoria) {
            if ($categoria['nome'] == $request->nome) {
                return response()->json(['message' => 'Categoria já existe'], 400);
            }
        }

        // Adicionar nova categoria
        $produtos['categorias'][] = [
            'nome' => $request->nome,
            'produtos' => [], // Inicializar com uma array vazia de produtos
        ];

        // Atualizar o campo 'produtos' da loja
        $loja->produtos = json_encode($produtos);
        $loja->save();

        return response()->json(['message' => 'Categoria adicionada com sucesso!'], 201);
    }


    // Deletar uma categoria existente
    public function deletarCategoria($categoriaNome)
    {
        $user = Auth::user();
        $idLoja = $user->lojaId;
        $loja = Loja::where('id', $idLoja)->first();

        // Verificando se a loja existe
        if (!$loja) {
            return response()->json(['message' => 'Loja não encontrada!'], 404);
        }

        // Decodificando os produtos da loja
        $produtos = json_decode($loja->produtos, true);

        // Verificando se a categoria está presente
        $hasCategory = false;
        foreach ($produtos['categorias'] as $categoria) {
            if ($categoria['nome'] === $categoriaNome) {
                $hasCategory = true;
                break;
            }
        }

        if (!$hasCategory) {
            return response()->json(['message' => 'Categoria não encontrada! ' . $categoriaNome], 404);
        }

        // Removendo a categoria
        $produtos['categorias'] = array_values(array_filter($produtos['categorias'], function ($categoria) use ($categoriaNome) {
            return $categoria['nome'] !== $categoriaNome;
        }));

        // Atualizando os produtos da loja
        $loja->produtos = json_encode($produtos);
        $loja->save();

        return response()->json(['message' => 'Categoria removida com sucesso!', 'json' => $produtos], 200);
    }

    public function adicionarProduto(Request $request)
    {
        $request->validate([
            'categoriaNome' => 'required|string',
            'nome' => 'required|string',
            'preco' => 'required|numeric',
            'foto' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user = Auth::user();
        $idLoja = $user->lojaId;
        $loja = Loja::where('id', $idLoja)->first();

        // Verificar se a loja foi encontrada
        if (!$loja) {
            return response()->json(['message' => 'Loja não encontrada!'], 404);
        }

        $produtos = json_decode($loja->produtos, true);

        // Diretório onde a imagem será armazenada
        $diretorio = 'lojas/' . $loja->nome . '/produtos';

        // Certificar-se de que o diretório existe, se não, criá-lo
        if (!file_exists(public_path($diretorio))) {
            mkdir(public_path($diretorio), 0755, true); // Cria o diretório com as permissões corretas
        }

        // Gerar um nome único para o arquivo
        $nomeArquivo = time() . '-' . $request->file('foto')->getClientOriginalName();

        // Redimensionar a imagem usando GD
        $imagemOriginal = imagecreatefromstring(file_get_contents($request->file('foto')));
        if ($imagemOriginal === false) {
            return response()->json(['message' => 'Erro ao processar a imagem.'], 400);
        }

        // Obter dimensões da imagem original
        list($larguraOriginal, $alturaOriginal) = getimagesize($request->file('foto'));

        // Criar uma nova imagem em branco com as dimensões desejadas
        $novaImagem = imagecreatetruecolor(400, 200);

        // Redimensionar a imagem original e copiá-la para a nova imagem
        imagecopyresampled($novaImagem, $imagemOriginal, 0, 0, 0, 0, 400, 200, $larguraOriginal, $alturaOriginal);

        // Salvar a nova imagem
        $caminhoCompleto = public_path($diretorio . '/' . $nomeArquivo);
        imagejpeg($novaImagem, $caminhoCompleto, 90); // Qualidade 90

        // Liberar a memória
        imagedestroy($imagemOriginal);
        imagedestroy($novaImagem);

        // Caminho relativo da imagem
        $caminhoImagem = $diretorio . '/' . $nomeArquivo;

        // Adicionar o novo produto na categoria correspondente
        foreach ($produtos['categorias'] as &$categoria) {
            if ($categoria['nome'] == $request->categoriaNome) {
                $categoria['produtos'][] = [
                    'nome' => $request->nome,
                    'preco' => $request->preco,
                    'descricao' => $request->descricao,
                    'foto' => "/" . $caminhoImagem, // Caminho da imagem
                ];
                break;
            }
        }

        // Atualizar os produtos da loja
        $loja->produtos = json_encode($produtos);
        $loja->save();

        // Retornar o caminho da imagem na resposta
        return response()->json([
            'message' => 'Produto adicionado com sucesso!',
            'imagem' => asset($caminhoImagem) // Retorna a URL completa da imagem
        ], 201);
    }



    // Deletar um produto de uma categoria// Deletar um produto de uma categoria
    public function deletarProduto($categoriaNome, $produtoNome)
    {
        $user = Auth::user();
        $idLoja = $user->lojaId;
        $loja = Loja::where('id', $idLoja)->first();

        // Decodifica os produtos da loja
        $produtos = json_decode($loja->produtos, true);
        $caminhoImagemRemovida = '';

        // Encontrar a categoria e remover o produto
        foreach ($produtos['categorias'] as &$categoria) {
            if ($categoria['nome'] == $categoriaNome) {
                // Encontrar o produto para remover e pegar o caminho da imagem
                foreach ($categoria['produtos'] as $key => $produto) {
                    if ($produto['nome'] === $produtoNome) {
                        // Guardar o caminho da imagem para deletar depois
                        $caminhoImagemRemovida = public_path($produto['foto']);
                        unset($categoria['produtos'][$key]); // Remove o produto
                        // Reindexar o array para garantir que ele permaneça um array
                        $categoria['produtos'] = array_values($categoria['produtos']);
                        break 2; // Sair dos dois loops
                    }
                }
            }
        }

        // Excluir a imagem do servidor se o caminho for válido
        if ($caminhoImagemRemovida && file_exists($caminhoImagemRemovida)) {
            unlink($caminhoImagemRemovida);
        }

        // Re-encode os produtos para salvar de volta no banco
        $loja->produtos = json_encode($produtos);
        $loja->save();

        return response()->json(['message' => 'Produto removido com sucesso!'], 200);
    }

}