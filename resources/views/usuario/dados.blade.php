<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
    crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
    integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
</script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

@include('usuario.templates.menu', ['menu' => 'dado'])
<div class="conteudo">
    <!DOCTYPE html>
    <html lang="pt-br">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Dados do Estabelecimento</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/animate.css@4.1.1/animate.min.css" rel="stylesheet">
        <style>
            body {
                background-color: #f0f2f5;
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            }

            .container {
                max-width: 1200px;
                margin-top: 50px;
            }

            .card {
                border: none;
                border-radius: 15px;
                box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            }

            .card-header {
                background-color: #4e73df;
                color: white;
                border-radius: 15px 15px 0 0 !important;
                padding: 20px;
            }

            .form-label {
                font-weight: 600;
                color: #5a5c69;
            }

            .btn-primary {
                background-color: #4e73df;
                border-color: #4e73df;
            }

            .btn-primary:hover {
                background-color: #2e59d9;
                border-color: #2e59d9;
            }

            .profile-header {
                position: relative;
                height: 200px;
            }

            .profile-banner {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            .profile-photo {
                position: absolute;
                bottom: -50px;
                left: 50px;
                width: 150px;
                height: 150px;
                border-radius: 50%;
                border: 5px solid white;
                object-fit: cover;
            }

            .change-photo,
            .change-banner {
                position: absolute;
                background-color: rgba(0, 0, 0, 0.5);
                color: white;
                padding: 5px 10px;
                border-radius: 5px;
                cursor: pointer;
            }

            .change-photo {
                bottom: -30px;
                left: 70px;
            }

            .change-banner {
                top: 10px;
                right: 10px;
            }
        </style>
    </head>

    <body>
        <div class="container animate__animated animate__fadeIn">
            <div class="card mb-4">
                <div class="profile-header">
                    <img src="{{ $produtos->banner }}" alt="Banner" class="profile-banner" id="profileBanner">
                    <img src="{{ $produtos->imagem }}" alt="Foto de Perfil" class="profile-photo" id="profilePhoto">
                    <label for="bannerInput" class="change-banner">
                        <i class="fas fa-camera"></i> Alterar Banner
                    </label>
                    <input type="file" id="bannerInput" style="display: none;" accept="image/*">
                    <label for="photoInput" class="change-photo">
                        <i class="fas fa-camera"></i> Alterar Foto
                    </label>
                    <input type="file" id="photoInput" style="display: none;" accept="image/*">
                </div>
                <div class="card-body" style="padding-top: 60px;">
                    <h2 class="text-center mb-4">Perfil</h2>
                    <form id="estabelecimentoForm">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="nomeEstabelecimento" class="form-label">Nome do Estabelecimento</label>
                                <input type="text" class="form-control" value="{{ $produtos->estabelecimento}}" id="nomeEstabelecimento" required>
                            </div>
                            <div class="col-md-6">
                                <label for="cpf" class="form-label">CPF</label>
                                <input type="text" class="form-control" value="{{ $produtos->cpf}}"  id="cpf" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="emailCobranca" class="form-label">Email de Cobrança</label>
                                <input type="email" class="form-control" value="{{ $produtos->email}}"  id="emailCobranca" required>
                            </div>
                            <div class="col-md-6">
                                <label for="telefone" class="form-label">Telefone</label>
                                <input type="tel" class="form-control" value="{{ $produtos->estabelecimento}}"  id="telefone" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="login" class="form-label">Login</label>
                                <input type="text" value="{{ $produtos->email}}"  class="form-control" id="login" required>
                            </div>
                            <div class="col-md-6">
                                <label for="senha" class="form-label">Senha</label>
                                <input type="password" class="form-control" id="senha" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="site" class="form-label">Link para o Site</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-globe"></i></span>
                                    <input type="url" class="form-control" value="{{ $produtos->site}}"  id="site">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="instagram" class="form-label">Link para o Instagram</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fab fa-instagram"></i></span>
                                    <input type="url" class="form-control" value="{{ $produtos->insta}}"  id="instagram">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="facebook" class="form-label">Link para o Facebook</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fab fa-facebook"></i></span>
                                    <input type="url" class="form-control" value="{{ $produtos->fb}}"  id="facebook">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="whatsapp" class="form-label">WhatsApp</label>
                                <input type="tel" class="form-control" value="{{ $produtos->wpp}}"  id="whatsapp">
                            </div>
                            <script>
                                      $('#whatsapp').on('input', function () {
                        var input = $(this).val();

                        // Remove qualquer caractere que não seja número
                        input = input.replace(/\D/g, '');

                        // Formata o número para o formato (xx) xxxxx-xxxx
                        if (input.length > 10) {
                            input = input.replace(/^(\d{2})(\d{5})(\d{4}).*/, '($1) $2-$3');
                        } else if (input.length > 6) {
                            input = input.replace(/^(\d{2})(\d{4})(\d{0,4}).*/, '($1) $2-$3');
                        } else if (input.length > 2) {
                            input = input.replace(/^(\d{2})(\d{0,5})/, '($1) $2');
                        } else {
                            input = input.replace(/^(\d*)/, '($1');
                        }

                        // Atualiza o valor do campo de entrada
                        $(this).val(input);
                    });
               
                            </script>
                            <div class="col-md-6">
                                <label for="url" class="form-label">Url do site</label>
                                <input type="url" class="form-control" id="url" oninput="addPrefix(this)">
                            </div>
                        </div>
                        <script>
                        function addPrefix(input) {
                            const prefix = "www.diskentregas.com/";
                            
                            // Impede repetição do prefixo
                            if (!input.value.startsWith(prefix)) {
                                input.value = prefix;
                            }
                        }
                        $(document).ready(()=>{
                        var url = $('#url').val('www.diskentregas.com/'+ '{{ $produtos->nome}}');
                        })
                        </script>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="horarioAbertura" class="form-label">Horário de Abertura</label>
                                <input type="time" class="form-control" value="{{ $produtos->horario_inicio }}" id="horarioAbertura" required>
                            </div>
                            <div class="col-md-6">
                                <label for="horarioFechamento" class="form-label">Horário de Fechamento</label>
                                <input type="time" class="form-control" value="{{ $produtos->horario_fim }}" id="horarioFechamento" required>
                            </div>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-lg">Salvar Alterações</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            $(document).ready(function() {

                let isPhotoChanged = false;
                let isBannerChanged = false;

                // Função para visualizar o preview das imagens e marcar como alterado
                function readURL(input, targetId, isChangedFlag) {
                    if (input.files && input.files[0]) {
                        var reader = new FileReader();
                        reader.onload = function(e) {
                            $('#' + targetId).attr('src', e.target.result);
                        };
                        reader.readAsDataURL(input.files[0]);
                        isChangedFlag = true;
                    }
                }

                // Marca a mudança da imagem do perfil
                $("#photoInput").change(function() {
                    readURL(this, 'profilePhoto', isPhotoChanged);
                    isPhotoChanged = true;
                });

                // Marca a mudança do banner
                $("#bannerInput").change(function() {
                    readURL(this, 'profileBanner', isBannerChanged);
                    isBannerChanged = true;
                });

                // Submissão do formulário com $.ajax
                $('#estabelecimentoForm').on('submit', function(e) {
                    e.preventDefault();

                    // Cria um objeto FormData para enviar os dados incluindo os arquivos
                    var formData = new FormData(this);

                    // Remove os arquivos de imagem se não tiverem sido alterados
                    if (!isPhotoChanged) {
                        formData.delete('photoInput');
                    }
                    if (!isBannerChanged) {
                        formData.delete('bannerInput');
                    }

                    // Envia os dados via AJAX
                    $.ajax({
                        url: '', // URL da rota para atualizar
                        type: 'POST',
                        data: formData,
                        processData: false, // Necessário para enviar dados do FormData
                        contentType: false,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                'content') // Inclui CSRF token
                        },
                        success: function(response) {
                            Swal.fire({
                                title: 'Sucesso!',
                                text: 'Dados salvos com sucesso',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            });
                        },
                        error: function(response) {
                            Swal.fire({
                                title: 'Erro!',
                                text: 'Ocorreu um erro ao salvar os dados',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                });
            });
        </script>
    </body>

    </html>
</div>
