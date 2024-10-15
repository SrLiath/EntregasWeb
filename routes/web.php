<?php

use Illuminate\Support\Facades\Route;
use App\Models\Loja;
use App\Models\Estado;
use App\Models\Bairro;
use App\Models\Cidade;
use App\Models\Tipo;
use App\Http\Controllers\LocalidadesController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PaymentGateway;
use App\Http\Middleware\CheckAdmin;
Route::middleware([CheckAdmin::class])->group(function () {
    Route::get('/xxmigadmin', function () {
        return view('admin.admin');
    });
});

Route::get('/xxmigadmin/login', [AuthController::class, 'showLoginForm']);
Route::post('/xxmigadmin/login', [AuthController::class, 'login'])->name('admin.login.validate');
Route::post('/xxmigadmin/logout', [AuthController::class, 'logout'])->name('admin.logout');

Route::get('/', function () {
    $lojas = Loja::paginate(16);
    $tipos = Tipo::find('*');
    return view('welcome', ['lojas' => $lojas]);
})->name('index');

Route::get('/cadastre', function () {
    $lojas = Loja::paginate(16);
    $tipos = Tipo::find('*');
    return view('cadastre', ['lojas' => $lojas]);
});
Route::get('/checkout', [LocalidadesController::class, 'verifyCheckout']);

Route::get('/sobre', function () {
    return view('sobre');

});


Route::get('/contato', function () {
    return view('contato');

});

Route::get('/login', function () {
    return view('usuario.login');

});



Route::get('/loja', function () {
    return view('usuario.loja');
});

Route::get('/{estado}', function ($estado) {
    $estadoObj = Estado::where('nome', $estado)->orWhere('uf', $estado)->first();

    if (!$estadoObj) {
        return abort(404, 'Estado não encontrado');
    }

    $lojas = Loja::whereJsonContains('estados_atendidos', $estadoObj->id_estado)->paginate(16);

    return view('welcome', ['lojas' => $lojas]);
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
    $lojas = Loja::whereJsonContains('estados_atendidos', $estadoObj->id_estado)
        ->whereJsonContains('cidades_atendidas', $cidadeObj->id_cidade)
        ->paginate(16);

    return view('welcome', ['lojas' => $lojas]);
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
    $lojas = Loja::whereJsonContains('estados_atendidos', $estadoObj->id_estado)
        ->whereJsonContains('cidades_atendidas', $cidadeObj->id_cidade)
        ->whereJsonContains('bairros_atendidos', $bairroObj->id_bairro)
        ->paginate(16);

    return view('welcome', ['lojas' => $lojas]);
});


// Rotas para Estados
Route::post('/api/estados', [LocalidadesController::class, 'estados']);
Route::post('/api/estados/store', [LocalidadesController::class, 'storeEstado']);

// Rotas para Cidades
Route::post('/api/cidades', [LocalidadesController::class, 'cidades']);
Route::post('/api/cidades/store', [LocalidadesController::class, 'storeCidade']);

// Rotas para Bairros
Route::post('/api/bairros', [LocalidadesController::class, 'bairros']);
Route::post('/api/bairros/store', [LocalidadesController::class, 'storeBairro']);