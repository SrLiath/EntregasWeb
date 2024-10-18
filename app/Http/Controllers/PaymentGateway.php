<?php

namespace App\Http\Controllers;
use App\Models\Plano;
use MercadoPago\Client\Common\RequestOptions;
use MercadoPago\Client\Payment\PaymentClient;
use MercadoPago\Exceptions\MPApiException;
use MercadoPago\MercadoPagoConfig;
use Illuminate\Http\Request;

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
            "description" => "Descrição do produto", // descrição do pagamento
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

        // // Verificar o reCAPTCHA
        // $recaptchaSecret = env('RECAPTCHA_SECRET_KEY');
        // $recaptchaResponse = $request->input('g-recaptcha-response');

        // $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
        //     'secret' => $recaptchaSecret,
        //     'response' => $recaptchaResponse,
        // ]);

        // $responseData = $response->json();

        // // Verifica se o reCAPTCHA foi validado com sucesso
        // if (!$responseData['success']) {
        //     return back()->withErrors(['recaptcha' => 'Falha na verificação do reCAPTCHA. Tente novamente.']);
        // }

        // Coletar as variáveis do request após a validação e reCAPTCHA
        $dadosCheckout = [
            'estados' => $request->input('estados'),
            'cidades' => $request->input('cidades'),
            'bairros' => $request->input('bairros'),
            'plano' => $request->input('plano'),
            'responsavel' => $request->input('responsavel'),
            'cpf' => $request->input('cpf'),
            'tel' => $request->input('tel'), 
            'email' => $request->input('email'),
            'senha' => $request->input('senha'),
            'nome-estabelecimento' => $request->input('nome-estabelecimento'),
            'site' => $request->input('site'),
            'insta' => $request->input('insta'),
            'fb' => $request->input('fb'),
            'wpp' => $request->input('wpp'),
            'tel2' => $request->input('tel2'), 
            'abertura' => $request->input('abertura'),
            'fechamento' => $request->input('fechamento'),
            'url' => $request->input('url'),
            'dias' => $request->input('dias') 
        ];
        session(['dadosCheckout' => $dadosCheckout]);
        $plano = Plano::where('nome', $request->input('plano'))->first();
        return response()->json(['message' => $plano->id], 201);

    }
    public function page(Request $request)
    {
        $plano = $request->query('plano');
        return view('checkout', compact('plano'));
    }

}
