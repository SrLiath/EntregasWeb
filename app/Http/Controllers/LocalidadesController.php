<?php
namespace App\Http\Controllers;

use App\Models\Estado;
use App\Models\Cidade;
use App\Models\Bairro;
use Illuminate\Http\Request;

class LocalidadesController extends Controller
{
    // Retorna todos os estados
    public function estados()
    {
        return response()->json(Estado::all());
    }

    // Armazena um novo estado
    public function storeEstado(Request $request)
    {
        $request->validate([
            'uf' => 'required|string|max:2|unique:estados,uf',
            'nome' => 'required|string|max:100'
        ]);

        $estado = Estado::create($request->all());
        return response()->json($estado, 201); // Retorna o estado criado
    }

    // Retorna todas as cidades de um estado específico
    public function cidades(Request $request)
    {
        $request->validate([
            'estado' => 'required|exists:estados,id_estado' // Verifica se o estado existe
        ]);
        
        $cidades = Cidade::where('estado', $request->estado)->with('estado')->get();
        $estado = Estado::where(['id_estado' => $request->estado])->first();
        return response()->json(['cidades' => $cidades, 'estado' => $estado->nome]);
    }

    // Armazena uma nova cidade
    public function storeCidade(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:150',
            'estado' => 'required|exists:estados,id_estado' // Verifica se o estado existe
        ]);

        $cidade = Cidade::create($request->all());
        return response()->json($cidade, 201); // Retorna a cidade criada
    }

    // Retorna todos os bairros de uma cidade específica
    public function bairros(Request $request)
    {
        $request->validate([
            'cidade' => 'required|exists:cidades,id_cidade' // Verifica se a cidade existe
        ]);

        $bairros = Bairro::join('cidades', 'bairros.cidade', '=', 'cidades.id_cidade')
        ->where('cidades.id_cidade', $request->cidade) 
        ->select('bairros.*', 'cidades.*', 'bairros.nome as nome_bairro')
        ->get();
    
        return response()->json($bairros);
    }

    // Armazena um novo bairro
    public function storeBairro(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:200',
            'cidade' => 'required|exists:cidades,id_cidade' // Verifica se a cidade existe
        ]);

        $bairro = Bairro::create($request->all());
        return response()->json($bairro, 201); // Retorna o bairro criado
    }
}
