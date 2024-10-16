<?php
namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    public function confirmar($id)
    {
        $pedido = Pedido::find($id);
        $pedido->status = 'progresso';
        $pedido->save();

        return response()->json(['success' => true, 'status' => 'progresso']);
    }

    public function negar($id)
    {
        $pedido = Pedido::find($id);
        $pedido->status = 'negado';
        $pedido->save();

        return response()->json(['success' => true, 'status' => 'negado']);
    }

    public function completar($id)
    {
        $pedido = Pedido::find($id);
        $pedido->status = 'entregue';
        $pedido->save();

        return response()->json(['success' => true, 'status' => 'entregue']);
    }
}