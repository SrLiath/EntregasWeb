<?php

namespace App\Http\Controllers;
use App\Models\Loja;
use App\Models\Plano;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
use MercadoPago\Client\Common\RequestOptions;
use MercadoPago\Client\Payment\PaymentClient;
use MercadoPago\Exceptions\MPApiException;
use MercadoPago\MercadoPagoConfig;
use Illuminate\Http\Request;
use Carbon\Carbon;
class PaymentGateway extends Controller
{
    public function __construct()
    {
        // Configuração do Mercado Pago
        MercadoPagoConfig::setAccessToken(env('MP_TOKEN')); // Substitua pelo seu token de acesso
        // Se desejar usar o ambiente de testes, descomente a linha abaixo
        // MercadoPagoConfig::setRuntimeEnviroment(MercadoPagoConfig::LOCAL);
    }

    public function processPayment(Request $request)
    {
        // Inicializa o cliente de pagamento
        $client = new PaymentClient();

        // Cria o array de requisição
        $requestData = [
            "transaction_amount" => $request->transaction_amount, // valor a ser cobrado
            "token" => $request->token, // token gerado pelo Mercado Pago
            "description" => "Plano Disk Entregas", // descrição do pagamento
            "installments" => $request->installments, // número de parcelas
            "payment_method_id" => $request->payment_method_id, // método de pagamento
            "payer" => [
                "email" => $request->payer['email'], // email do pagador
            ]
        ];

        // Cria as opções de requisição, configurando o cabeçalho X-Idempotency-Key
        $requestOptions = new RequestOptions();
        $requestOptions->setCustomHeaders(["X-Idempotency-Key: " . uniqid()]); // Gera um valor único

        try {
            // Faz a requisição para criar o pagamento
            $payment = $client->create($requestData, $requestOptions);
            return response()->json(['status' => 'success', 'payment_id' => $payment->id]);

        } catch (MPApiException $e) {
            // Trata exceções da API
            return response()->json([
                'status' => 'error',
                'status_code' => $e->getApiResponse()->getStatusCode(),
                'content' => $e->getApiResponse()->getContent()
            ]);
        } catch (\Exception $e) {
            // Trata todas as outras exceções
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
    public function verifyCheckout(Request $request)
    {
        $request->validate([
            'tipos' => 'required|array', // 'tipos' deve ser um ID válido na tabela 'tipos'
            'estados' => 'required|array', // 'estados' deve ser um array
            'cidades' => 'required|array', // 'cidades' deve ser um array
            'bairros' => 'array|null', // 'bairros' deve ser um array
            'responsavel' => 'required|string', // 'responsavel' deve ser uma string
            'tel' => 'required|string', // 'tel' deve ser uma string
            'site' => 'nullable|string', // 'site' pode ser opcional
            'insta' => 'nullable|string', // 'insta' pode ser opcional
            'fb' => 'nullable|string', // 'fb' pode ser opcional
            'wpp' => 'nullable|string', // 'wpp' pode ser opcional
            'abertura' => 'required|string', // 'abertura' deve ser uma string (horário)
            'fechamento' => 'required|string', // 'fechamento' deve ser uma string (horário)
            'nome-estabelecimento' => 'required|string', // 'nome-estabelecimento' deve ser uma string
        ]);
        // Verificar o reCAPTCHA
        $recaptchaSecret = env('RECAPTCHA_SECRET_KEY');
        $recaptchaResponse = $request->input('g-recaptcha-response');

        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => $recaptchaSecret,
            'response' => $recaptchaResponse,
        ]);

        $responseData = $response->json();

        // Verifica se o reCAPTCHA foi validado com sucesso
        if (!$responseData['success']) {
            return back()->withErrors(['recaptcha' => 'Falha na verificação do reCAPTCHA. Tente novamente.']);
        }
        $url = $request->input('url');
        $url = str_replace('www.diskentregas.com/', '', $url);
        $dadosCheckout = [
            'id_tipo' => $request->input('tipos'),
            'estados_atendidos' => $request->input('estados'),
            'cidades_atendidas' => $request->input('cidades'),
            'bairros_atendidos' => $request->input('bairros'),
            'responsavel' => $request->input('responsavel'),
            'tel' => $request->input('tel'),
            'site' => $request->input('site'),
            'insta' => $request->input('insta'),
            'fb' => $request->input('fb'),
            'wpp' => $request->input('wpp'),
            'horario_inicio' => $request->input('abertura'),
            'horario_fim' => $request->input('fechamento'),
            'nome' => $url,
            'pago' => false,
            'estabelecimento' => $request->input('nome-estabelecimento') ?: 'aaaaaaa'
        ];

        $loja = Loja::create($dadosCheckout);
        $userData = [
            'name' => $request->input('nome-estabelecimento'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('senha')),
            'cpf' => $request->input('cpf'),
            'is_admin' => 0,
            'lojaId' => $loja->id
        ];
        $user = User::create($userData);

        $plano = Plano::where('nome', $request->input('plano'))->first();
        return response()->json(['message' => $plano->id, 'user' => $user->id], 201);

    }
    public function page(Request $request)
    {
        $plano = Plano::where('id', $request->query('plano'))->first();
        return view('checkout', ['plano' => $plano]);
    }

    public function checagem(Request $request)
    {
        try {
            $client = new PaymentClient();
            $payment = $client->get($request->query('payment_id'));

            $user = User::where('id', $request->query('user'))->first();
            $loja = Loja::where('id', $user->lojaId)->first();

            if ($payment) {
                $loja->id_payment = $request->query('payment_id');
            }
            $loja->save();

            if ($payment->status == "approved") {
                Loja::where('id_payment', $request->query('payment_id'))
                    ->update([
                        'pago' => true,
                        'dataPlano' => Carbon::now()->addYear()
                    ]);
                return redirect('/loja');
            }

            return view('checagem', ['payment_id' => $request->query('payment_id')]);

        } catch (MPApiException $e) {
            $apiResponse = $e->getApiResponse();
            $content = $apiResponse->getContent();
            $lineNumber = $e->getLine();

            return response()->json([
                'error' => $content,
                'line' => $lineNumber,
                'var' => $payment
            ], 400);
        }
    }

}