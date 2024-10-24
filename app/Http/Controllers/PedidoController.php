<?php
namespace App\Http\Controllers;

use App\Models\Loja;
use App\Models\Pedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function atualizarLoja(Request $request)
    {
        $user = Auth::user();
        $idLoja = $user->lojaId;
        $loja = Loja::find($idLoja);

        if (!$loja) {
            return response()->json(['message' => 'Loja não encontrada!'], 404);
        }

        $diretorio = 'lojas/' . $loja->nome;

        if (!file_exists(public_path($diretorio))) {
            mkdir(public_path($diretorio), 0755, true);
        }

        // Processar imagem
        if ($request->hasFile('imagem')) {
            if ($loja->imagem && file_exists(public_path($loja->imagem))) {
                unlink(public_path($loja->imagem));
            }

            $nomeImagem = time() . '-imagem-' . $request->file('imagem')->getClientOriginalName();
            $caminhoImagem = $diretorio . '/' . $nomeImagem;
            $request->file('imagem')->move(public_path($diretorio), $nomeImagem);
            $loja->imagem = "/" . $caminhoImagem;
        }

        // Processar banner
        if ($request->hasFile('banner')) {
            if ($loja->banner && file_exists(public_path($loja->banner))) {
                unlink(public_path($loja->banner));
            }

            $nomeBanner = time() . '-banner-' . $request->file('banner')->getClientOriginalName();
            $caminhoBanner = $diretorio . '/' . $nomeBanner;
            $request->file('banner')->move(public_path($diretorio), $nomeBanner);
            $loja->banner = "/" . $caminhoBanner;
        }

        // Atualizar outros campos somente se não forem null
        if ($request->filled('nomeEstabelecimento')) {
            $loja->nome = $request->input('nomeEstabelecimento');
        }
        if ($request->filled('cpf')) {
            $loja->cpf = $request->input('cpf');
        }
        if ($request->filled('emailCobranca')) {
            $loja->email = $request->input('emailCobranca');
        }
        if ($request->filled('telefone')) {
            $loja->tel = $request->input('telefone');
        }
        if ($request->filled('site')) {
            $loja->site = $request->input('site');
        }
        if ($request->filled('instagram')) {
            $loja->insta = $request->input('instagram');
        }
        if ($request->filled('facebook')) {
            $loja->fb = $request->input('facebook');
        }
        if ($request->filled('whatsapp')) {
            $loja->wpp = $request->input('whatsapp');
        }
        if ($request->filled('horarioAbertura')) {
            $loja->horario_inicio = $request->input('horarioAbertura');
        }
        if ($request->filled('horarioFechamento')) {
            $loja->horario_fim = $request->input('horarioFechamento');
        }

        // Salvar loja
        $loja->save();

        return response()->json([
            'message' => 'Loja atualizada com sucesso!',
            'imagem' => asset($loja->imagem),
            'banner' => asset($loja->banner),
            'request' => $request->all()
        ], 200);
    }




}