<?php

namespace App\Http\Controllers;

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

}