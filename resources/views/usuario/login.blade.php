<!DOCTYPE html>
<html lang=pt-BR>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <title>Login</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        body {
            background-color: #f8f9fa;
        }

        .login-container {
            width: 100%;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-box {
            background-color: #ffffff;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            max-width: 400px;
            width: 100%;
        }

        .alert {
            margin-bottom: 1rem;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="login-box">
            <img src="/baner.jpg" style="width: 100%" alt="" />

            <h2 class="text-center mb-4">Login Estabelecimento</h2>

            <input type="hidden" name="_token" value="{{ csrf_token() }}"> <!-- Token CSRF -->
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>

            <button type="submit" id="loginconfirm" class="btn btn-primary w-100">Login</button>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#password').keypress(function (e) {
                if (e.which == 13) {
                    e.preventDefault();
                    $('#loginconfirm').click();
                }
            });
            $('#loginconfirm').click(function (e) {
                e.preventDefault(); // Impede o envio padrão do formulário

                var formData = {
                    email: $('#email').val(),
                    password: $('#password').val(),
                };

                $.ajax({
                    type: 'POST',
                    url: "{{ route('admin.login.validate') }}", // Rota de validação
                    data: formData,
                    success: function (response) {
                        // Redireciona ou executa qualquer lógica após o login bem-sucedido
                        console.log(response)
                        window.location.href = '/loja'; // Redireciona para a área admin
                    },
                    error: function (xhr) {
                        // Limpa qualquer alerta anterior
                        console.log(xhr.responseText)
                        if (xhr.status === 422) { // Erro de validação
                            var errors = xhr.responseJSON.errors;
                            var errorMessages = '';
                            $.each(errors, function (key, value) {
                                errorMessages += value.join('<br>') + '<br>';
                            });

                            // Exibe um alerta SweetAlert com os erros
                            Swal.fire({
                                icon: 'error',
                                title: 'Erro de Validação',
                                html: errorMessages, // Permite HTML para mostrar múltiplas linhas
                                confirmButtonText: 'OK'
                            });
                        } else {
                            // Mensagem de erro genérica
                            Swal.fire({
                                icon: 'error',
                                title: 'Erro ao fazer login',
                                text: 'Tente novamente.',
                                confirmButtonText: 'OK'
                            });
                        }
                    }

                });
            });
        });
    </script>

</body>

</html>