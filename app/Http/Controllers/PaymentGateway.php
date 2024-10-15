<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;

use Illuminate\Http\Request;

class PaymentGateway extends Controller
{
    public function verifyCheckout(Request $request)
    {
        // Validação dos dados recebidos
        $request->validate([
            'responsavel' => 'required|string|max:255',
            'cpf' => 'required|string|max:14',
            'email-cobranca' => 'required|email|max:255',
            'telefone' => 'required|string|max:15',
            'login' => 'required|string|max:255|unique:users,login',
            'senha' => 'required|string|min:8', // por exemplo, mínimo de 8 caracteres
            'nome-estabelecimento' => 'required|string|max:255',
            'link-site' => 'nullable|url|max:255',
            'link-instagram' => 'nullable|url|max:255',
            'link-facebook' => 'nullable|url|max:255',
            'whatsapp' => 'nullable|string|max:15',
            'telefone-2' => 'nullable|string|max:15',
            'horario-abertura' => 'required|date_format:H:i',
            'horario-fechamento' => 'required|date_format:H:i',
            'entrego-todo-brasil' => 'nullable|boolean',
            'entrego-todo-estado' => 'nullable|boolean',
            'estado' => 'nullable|string', // Adicione a validação para o estado
            'entrego-todo-cidade' => 'nullable|boolean',
            'estado-cidade' => 'nullable|string', // Adicione a validação para o estado da cidade
            'cidade' => 'nullable|string|max:255', // Adicione a validação para a cidade
            'entrego-especifico' => 'nullable|boolean',
            'locais-especificos' => 'nullable|string|max:255', // Especificação dos locais
            'g-recaptcha-response' => 'required|captcha', // Validação do reCAPTCHA
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

        // Coletar as variáveis do request após a validação e reCAPTCHA
        $dadosCheckout = [
            'responsavel' => $request->input('responsavel'),
            'cpf' => $request->input('cpf'),
            'email_cobranca' => $request->input('email-cobranca'),
            'telefone' => $request->input('telefone'),
            'login' => $request->input('login'),
            'senha' => $request->input('senha'),
            'nome_estabelecimento' => $request->input('nome-estabelecimento'),
            'link_site' => $request->input('link-site'),
            'link_instagram' => $request->input('link-instagram'),
            'link_facebook' => $request->input('link-facebook'),
            'whatsapp' => $request->input('whatsapp'),
            'telefone_2' => $request->input('telefone-2'),
            'horario_abertura' => $request->input('horario-abertura'),
            'horario_fechamento' => $request->input('horario-fechamento'),
            'entrego_todo_brasil' => $request->input('entrego-todo-brasil'),
            'entrego_todo_estado' => $request->input('entrego-todo-estado'),
            'estado' => $request->input('estado'),
            'entrego_todo_cidade' => $request->input('entrego-todo-cidade'),
            'estado_cidade' => $request->input('estado-cidade'),
            'cidade' => $request->input('cidade'),
            'entrego_especifico' => $request->input('entrego-especifico'),
            'locais_especificos' => $request->input('locais-especificos'),
        ];

        // Retornar uma view com os dados do checkout
        return view('checkout', compact('dadosCheckout'));
    }

}
