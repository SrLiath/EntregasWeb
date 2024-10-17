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
        $request->validate([
            'nome' => 'required|string',
        ]);

        $user = Auth::user();
        $idLoja = $user->lojaId;
        $loja = Loja::where('id', $idLoja)->first();

        $produtos = json_decode($loja->produtos, true);

        // Verificar se a categoria já existe
        foreach ($produtos['categorias'] as $categoria) {
            if ($categoria['nome'] == $request->nome) {
                return response()->json(['message' => 'Categoria já existe'], 400);
            }
        }

        // Adicionar nova categoria
        $produtos['categorias'][] = [
            'nome' => $request->nome,
            'produtos' => [],
        ];

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

        $produtos = json_decode($loja->produtos, true);

        // Filtrar e remover a categoria
        $produtos['categorias'] = array_filter($produtos['categorias'], function($categoria) use ($categoriaNome) {
            return $categoria['nome'] !== $categoriaNome;
        });

        $loja->produtos = json_encode($produtos);
        $loja->save();

        return response()->json(['message' => 'Categoria removida com sucesso!'], 200);
    }

    // Adicionar um produto a uma categoria
    public function adicionarProduto(Request $request)
    {
        $request->validate([
            'categoriaNome' => 'required|string',
            'nome' => 'required|string',
            'preco' => 'required|numeric',
            'descricao' => 'required|string',
            'foto' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user = Auth::user();
        $idLoja = $user->lojaId;
        $loja = Loja::where('id', $idLoja)->first();

        $produtos = json_decode($loja->produtos, true);

        // Diretório onde a imagem será armazenada
        $diretorio = 'public/' . $loja->url . '/produtos';
        $caminhoImagem = $request->file('foto')->store($diretorio);

        // Adicionar o novo produto na categoria correspondente
        foreach ($produtos['categorias'] as &$categoria) {
            if ($categoria['nome'] == $request->categoriaNome) {
                $categoria['produtos'][] = [
                    'nome' => $request->nome,
                    'preco' => $request->preco,
                    'descricao' => $request->descricao,
                    'foto' => $caminhoImagem,
                ];
                break;
            }
        }

        $loja->produtos = json_encode($produtos);
        $loja->save();

        return response()->json(['message' => 'Produto adicionado com sucesso!'], 201);
    }

    // Deletar um produto de uma categoria
    public function deletarProduto($categoriaNome, $produtoNome)
    {
        $user = Auth::user();
        $idLoja = $user->lojaId;
        $loja = Loja::where('id', $idLoja)->first();

        $produtos = json_decode($loja->produtos, true);

        // Encontrar a categoria e remover o produto
        foreach ($produtos['categorias'] as &$categoria) {
            if ($categoria['nome'] == $categoriaNome) {
                $categoria['produtos'] = array_filter($categoria['produtos'], function($produto) use ($produtoNome) {
                    return $produto['nome'] !== $produtoNome;
                });
                break;
            }
        }

        $loja->produtos = json_encode($produtos);
        $loja->save();

        return response()->json(['message' => 'Produto removido com sucesso!'], 200);
    }
}