<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\PedidoController;
use App\Http\Middleware\LojaAdmin;
use App\Models\Pedido;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Route;
use App\Models\Loja;
use App\Models\Estado;
use App\Models\Bairro;
use App\Models\Cidade;
use App\Models\Tipo;
use App\Models\Plano;
use App\Http\Controllers\LocalidadesController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PaymentGateway;
use App\Http\Middleware\CheckAdmin;
Route::middleware([CheckAdmin::class])->group(function () {
    Route::get('/xxmigadmin', function () {
        $tipos = Tipo::all();
        $lojas = Loja::with(['tipo', 'categoria'])->get();
        $planos = Plano::take(3)->get();

        return view('admin.admin', ['tipos' => $tipos, 'planos' => $planos, 'lojas' => $lojas]);
    });
    Route::post('/api/estados/store', [LocalidadesController::class, 'storeEstado']);
    Route::post('/api/cidades/store', [LocalidadesController::class, 'storeCidade']);
    Route::post('/api/bairros/store', [LocalidadesController::class, 'storeBairro']);
    Route::post('/tipos', [Controller::class, 'Tipostore']);
    Route::delete('/tipos/{id}', [Controller::class, 'Tipodestroy']);
    Route::post('/tipos/categorias/add', [Controller::class, 'addCategoria']);
    Route::delete('/tipos/categorias/{id}', [Controller::class, 'destroyCategoria']);
    Route::put('/api/planos/{id}', [Controller::class, 'updatePlanos']);
});

Route::middleware([LojaAdmin::class])->group(function () {
    Route::post('/pedido/confirmar/{id}', [PedidoController::class, 'confirmar'])->name('pedido.confirmar');
    Route::post('/pedido/negar/{id}', [PedidoController::class, 'negar'])->name('pedido.negar');
    Route::post('/pedido/completar/{id}', [PedidoController::class, 'completar'])->name('pedido.completar');
    Route::post('/perfil', [PedidoController::class, 'atualizarLoja'])->name('perfil');
    Route::post('/lojas/categorias', [Controller::class, 'adicionarCategoria'])->name('lojas.adicionarCategoria');
    Route::delete('/lojas/categorias/{categoriaNome}', [Controller::class, 'deletarCategoria'])->name('lojas.deletarCategoria');
    Route::post('/api/lojas/produtos', [Controller::class, 'adicionarProduto'])->name('lojas.adicionarProduto');
    Route::delete('/lojas/produtos/{categoriaNome}/{produtoNome}', [Controller::class, 'deletarProduto'])->name('lojas.deletarProduto');
    Route::get('/loja', function () {
        $user = Auth::user();

        if ($user && $user->lojaId) {
            $loja = Loja::find($user->lojaId);
            if ($loja) {
                return view('usuario.loja', ['loja' => $loja]);
            } else {
                return redirect()->back()->withErrors('Loja não encontrada.');
            }
        } else {
            return redirect()->route('login'); // Redireciona para o login se não estiver autenticado
        }
    });

    Route::get('/loja/pedidos', function () {
        $pedidos = Pedido::paginate(16);
        $today = Carbon::today();

        // Contagem de pedidos por status
        $totalHoje = Pedido::whereDate('data_pedido', $today)->count();
        $completo = Pedido::whereDate('data_pedido', $today)->where('status', 'completo')->count();
        $negado = Pedido::whereDate('data_pedido', $today)->where('status', 'negado')->count();
        $andamento = Pedido::whereDate('data_pedido', $today)->where('status', 'andamento')->count();

        // Passando as variáveis para a view
        return view('usuario.pedidos', [
            'pedidos' => $pedidos,
            'totalHoje' => $totalHoje,
            'completo' => $completo,
            'negado' => $negado,
            'andamento' => $andamento,
            'loja',
            'teste'
        ]);
    });

    Route::get('/loja/categorias', function () {
        $user = Auth::user();
        $idLoja = $user->lojaId;
        $produtos = Loja::where(['id' => $idLoja])->first();
        return view('usuario.itens', ['produtos' => $produtos]);
    });

    Route::get('/loja/produtos', function () {
        $user = Auth::user();
        $idLoja = $user->lojaId;
        $produtos = Loja::where(['id' => $idLoja])->first();
        return view('usuario.produtos', ['produtos' => $produtos->produtos]);
    });

    Route::get('/loja/dados', function () {
        $user = Auth::user();
        $idLoja = $user->lojaId;
        $produtos = Loja::join('users', 'lojas.id', '=', 'users.lojaId')
            ->where('lojas.id', $idLoja)
            ->select('lojas.*', 'users.*')  // Seleciona os campos necessários
            ->first();
        return view('usuario.dados', ['produtos' => $produtos]);
    });

    Route::get('/loja/suporte', function () {
        return view('usuario.suporte');
    });

});

Route::get('/xxmigadmin/login', [AuthController::class, 'showLoginForm']);
Route::post('/xxmigadmin/login', [AuthController::class, 'login'])->name('admin.login.validate');
Route::get('/xxmigadmin/logout', [AuthController::class, 'logout'])->name('admin.logout');
Route::get('/logout', [AuthController::class, 'logout'])->name('admin.logout');

Route::get('/', function () {
    $tipos = Tipo::all();
    if (Request::has('tipo')) {
        $tipoEncoded = Request::get('tipo');
        $tipoDecoded = urldecode($tipoEncoded);
        $tipo = Tipo::where('tipo', $tipoDecoded)->first();
        $lojas = Loja::where('pago', true)->whereJsonContains('id_tipo', strval($tipo->id))->paginate(16);
        return view('welcome', ['lojas' => $lojas, 'tipos' => $tipos]);
    }
    $lojas = Loja::where('pago', true)->paginate(16);

    return view('welcome', ['lojas' => $lojas, 'tipos' => $tipos]);
})->name('index');

Route::get('/cadastre', function () {
    $tipos = Tipo::find('*');
    $planos = Plano::take(3)->get();

    return view('cadastre', ['planos' => $planos]);
});
Route::post('/checkout', [PaymentGateway::class, 'verifyCheckout']);
Route::get('/checkout', [PaymentGateway::class, 'page']);
Route::get('/checagem', [PaymentGateway::class, 'checagem']);
Route::post('/process_payment', [PaymentGateway::class, 'processPayment']);
Route::post('/api/tipos', [Controller::class, 'tipos']);
Route::get('/sobre', function () {
    return view('sobre');

});


Route::get('/contato', function () {
    return view('contato');

});

Route::get('/login', function () {
    return view('usuario.login');

});

Route::get('/{estado}', function ($estado) {
    $estadoObj = Estado::where('nome', $estado)->orWhere('uf', $estado)->first();

    if (!$estadoObj) {
        $loja = Loja::where('nome', $estado)->first();
        if ($loja) {
            return view('loja', ['loja' => $loja]);
        }
    }

    $query = Loja::whereJsonContains('estados_atendidos', $estadoObj->id_estado)
        ->where('pago', true);

    if (Request::has('tipo')) {
        $tipoEncoded = Request::get('tipo');
        $tipoDecoded = urldecode($tipoEncoded);
        $tipo = Tipo::where('tipo', $tipoDecoded)->first();
        if ($tipo) {
            $query->whereJsonContains('id_tipo', strval($tipo->id));
        }
    }

    $lojas = $query->paginate(16);
    $tipos = Tipo::all();

    return view('welcome', ['lojas' => $lojas, 'tipos' => $tipos]);
});

Route::get('/{estado}/{cidade}', function ($estado, $cidade) {
    $estadoObj = Estado::where('nome', $estado)->orWhere('uf', $estado)->first();
    if (!$estadoObj) {
        return abort(404, 'Estado não encontrado');
    }

    $cidadeObj = Cidade::where('nome', $cidade)->where('estado', $estadoObj->id_estado)->first();
    if (!$cidadeObj) {
        return abort(404, 'Cidade não encontrada');
    }

    $query = Loja::whereJsonContains('estados_atendidos', $estadoObj->id_estado)
        ->whereJsonContains('cidades_atendidas', $cidadeObj->id_cidade)
        ->where('pago', true);

    if (Request::has('tipo')) {
        $tipoEncoded = Request::get('tipo');
        $tipoDecoded = urldecode($tipoEncoded);
        $tipo = Tipo::where('tipo', $tipoDecoded)->first();
        if ($tipo) {
            $query->whereJsonContains('id_tipo', strval($tipo->id));
        }
    }

    $lojas = $query->paginate(16);
    $tipos = Tipo::all();

    return view('welcome', ['lojas' => $lojas, 'tipos' => $tipos]);
});

Route::get('/{estado}/{cidade}/{bairro}', function ($estado, $cidade, $bairro) {
    $estadoObj = Estado::where('nome', $estado)->orWhere('uf', $estado)->first();
    if (!$estadoObj) {
        return abort(404, 'Estado não encontrado');
    }

    $cidadeObj = Cidade::where('nome', $cidade)->where('estado', $estadoObj->id_estado)->first();
    if (!$cidadeObj) {
        return abort(404, 'Cidade não encontrada');
    }

    $bairroObj = Bairro::where('nome', $bairro)->where('cidade', $cidadeObj->id_cidade)->first();
    if (!$bairroObj) {
        return abort(404, 'Bairro não encontrado');
    }

    $query = Loja::whereJsonContains('estados_atendidos', $estadoObj->id_estado)
        ->whereJsonContains('cidades_atendidas', $cidadeObj->id_cidade)
        ->whereJsonContains('bairros_atendidos', $bairroObj->id_bairro)
        ->where('pago', true);

    if (Request::has('tipo')) {
        $tipoEncoded = Request::get('tipo');
        $tipoDecoded = urldecode($tipoEncoded);
        $tipo = Tipo::where('tipo', $tipoDecoded)->first();
        if ($tipo) {
            $query->whereJsonContains('id_tipo', strval($tipo->id));
        }
    }

    $lojas = $query->paginate(16);
    $tipos = Tipo::all();

    return view('welcome', ['lojas' => $lojas, 'tipos' => $tipos]);
});

Route::post('/api/estados', [LocalidadesController::class, 'estados']);
Route::post('/api/cidades', [LocalidadesController::class, 'cidades']);
Route::post('/api/bairros', [LocalidadesController::class, 'bairros']);
Route::post('/tipos/categorias', [Controller::class, 'getCategorias']);