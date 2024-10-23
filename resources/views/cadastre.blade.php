<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Disk entrega</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
        </script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/css/templatemo-style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


</head>

<body>
    @include('template.menu')
    <!-- Page Loader -->
    <div id="loader-wrapper">
        <div id="loader"></div>

        <div class="loader-section section-left"></div>
        <div class="loader-section section-right"></div>

    </div>


    <div class="tm-hero d-flex justify-content-center align-items-center" data-parallax="scroll"
        data-image-src="img/hero.jpg">
        <div class="container">
            <style>
                .btn-location {
                    margin: 5px;
                    border-radius: 20px;
                    font-size: 14px;
                    padding: 8px 16px;
                    transition: all 0.3s ease;
                    border: 2px solid #e0e0e0;
                    background-color: white;
                    color: #333;
                    position: relative;
                    overflow: hidden;
                }

                .btn-location:hover {
                    transform: translateY(-2px);
                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                }

                .btn-location.active {
                    background-color: #4CAF50;
                    color: white;
                    border-color: #4CAF50;
                    padding-left: 30px;
                }

                .btn-location.active::before {
                    content: '\f00c';
                    font-family: 'Font Awesome 5 Free';
                    font-weight: 900;
                    position: absolute;
                    left: 10px;
                    top: 50%;
                    transform: translateY(-50%);
                }
                .btn-tipo {
                    margin: 5px;
                    border-radius: 20px;
                    font-size: 14px;
                    padding: 8px 16px;
                    transition: all 0.3s ease;
                    border: 2px solid #e0e0e0;
                    background-color: white;
                    color: #333;
                    position: relative;
                    overflow: hidden;
                }

                .btn-tipo:hover {
                    transform: translateY(-2px);
                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                }

                .btn-tipo.active {
                    background-color: #4CAF50;
                    color: white;
                    border-color: #4CAF50;
                    padding-left: 30px;
                }

                .btn-tipo.active::before {
                    content: '\f00c';
                    font-family: 'Font Awesome 5 Free';
                    font-weight: 900;
                    position: absolute;
                    left: 10px;
                    top: 50%;
                    transform: translateY(-50%);
                }
                #selectedLocations {
                    font-size: 14px;
                    color: #6c757d;
                    background-color: #f8f9fa;
                    border-radius: 10px;
                    padding: 10px;
                    margin-top: 10px;
                }

                h2,
                h3 {
                    color: #333;
                    font-weight: 600;
                }

                .section {
                    margin-bottom: 20px;
                }

                .plans-container {
                    display: flex;
                    justify-content: center;
                    margin: 20px 0;
                    flex-wrap: wrap;
                }

                .plan {
                    background-color: rgba(255, 255, 255, 0.9);
                    border-radius: 15px;
                    margin: 21px;
                    padding: 20px;
                    text-align: center;
                    width: 30%;
                    /* Ajuste para telas grandes */
                    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
                    transition: transform 0.2s, border 0.2s;
                    cursor: pointer;
                }

                .plan:hover {
                    transform: scale(1.05);
                }

                .plan.selected {
                    border: 3px solid navy;
                    transform: scale(1.1);
                }

                .plan h2 {
                    font-size: 36px;
                    margin: 10px 0;
                }

                .plan p {
                    font-size: 14px;
                }

                /* Estilos responsivos */
                @media (max-width: 768px) {
                    .plan {
                        width: 45%;
                        /* Ajusta para telas médias */
                    }
                }

                @media (max-width: 480px) {
                    .plan {
                        width: 90%;
                        /* Ajusta para telas pequenas */
                    }

                    .plan h2 {
                        font-size: 28px;
                        /* Reduz o tamanho do texto em telas pequenas */
                    }

                    .plan p {
                        font-size: 12px;
                        /* Reduz o tamanho do texto em telas pequenas */
                    }
                }

                .custom-checkbox {
                    display: inline-block;
                    position: relative;
                    padding-left: 35px;
                    margin-bottom: 12px;
                    cursor: pointer;
                    font-size: 18px;
                    user-select: none;
                }

                .custom-checkbox input {
                    position: absolute;
                    opacity: 0;
                    cursor: pointer;
                    height: 0;
                    width: 0;
                }

                .checkmark {
                    position: absolute;
                    top: 0;
                    left: 0;
                    height: 25px;
                    width: 25px;
                    background-color: #eee;
                    border-radius: 5px;
                    transition: all 0.3s ease;
                }

                .custom-checkbox:hover input~.checkmark {
                    background-color: #ccc;
                }

                .custom-checkbox input:checked~.checkmark {
                    background-color: #2196F3;
                }

                .checkmark:after {
                    content: "\f00c";
                    font-family: "Font Awesome 6 Free";
                    font-weight: 900;
                    position: absolute;
                    display: none;
                    left: 50%;
                    top: 50%;
                    transform: translate(-50%, -50%);
                    color: white;
                }

                .custom-checkbox input:checked~.checkmark:after {
                    display: block;
                }

                .custom-checkbox input:checked~.checkmark {
                    animation: rubberBand 0.8s;
                }
            </style>
            <br>
            <center>
                <h3>Escolha um plano</h3>
            </center>
            <div class="plans-container">
            @foreach ($planos as $index => $p)

<div class="plan {{ $index === 0 ? 'selected' : '' }}" onclick="selectPlan(this, 'Plano Brasil')">
    <h2>{{$p->nome}}</h2>
    <h3>
        {{ ($p->valor == floor($p->valor)) ? intval($p->valor) : $p->valor }} R$
    </h3>
    <p>{!! $p->descricao !!}</p>
</div>

@endforeach

            </div>
            <script>
                let selectedPlanValue = 'Plano Brasil'; // Inicializa com o plano pré-selecionado

                function selectPlan(element, planName) {
                    const plans = document.querySelectorAll('.plan');
                    plans.forEach(plan => plan.classList.remove('selected'));
                    element.classList.add('selected');
                    selectedPlanValue = planName;
                    $('#plano').val(planName);
                }
            </script>


            <!-- Incluindo a biblioteca do Font Awesome -->
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

            <div class="tm-search-form row" id="formcadastro">
                <input type="hidden" class="form-control hidden" id="plano" value="Plano Brasil" required>
                <!-- Responsável -->
                <div class="col-12 col-md-4 mb-2">
                    <label for="responsavel">Responsável</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                        <input type="text" class="form-control" id="responsavel" placeholder="Responsável" required>
                    </div>
                </div>

                <!-- CPF -->
                <div class="col-12 col-md-4 mb-2">
                    <label for="cpf">CPF</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                        <input type="text" class="form-control" id="cpf" placeholder="CPF" required>
                    </div>
                </div>



                <!-- Telefone -->
                <div class="col-12 col-md-4 mb-2">
                    <label for="telefone">Telefone</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                        <input type="tel" class="form-control" id="telefone" placeholder="Telefone" required>
                    </div>
                </div>

                <!-- Login -->
                <!-- Email de cobrança -->
                <div class="col-12 col-md-4 mb-2">
                    <label for="email-cobranca">Email de Login</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        <input type="email" class="form-control" id="email-cobranca" placeholder="Email de cobrança"
                            required>
                    </div>
                </div>

                <!-- Senha -->
                <div class="col-12 col-md-4 mb-2">
                    <label for="senha">Senha</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password" class="form-control" id="senha" placeholder="Senha" required>
                    </div>
                </div>

                <!-- Nome do Estabelecimento -->
                <div class="col-12 col-md-4 mb-2">
                    <label for="nome-estabelecimento">Nome do Estabelecimento</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-store"></i></span>
                        <input type="text" class="form-control" id="nome-estabelecimento"
                            placeholder="Nome do Estabelecimento" required>
                    </div>
                </div>

                <!-- Links -->
                <div class="col-12 col-md-4 mb-2">
                    <label for="link-site">Link para o Site</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-link"></i></span>
                        <input type="url" class="form-control" id="link-site" placeholder="LINK PRO SITE ">
                    </div>
                </div>

                <div class="col-12 col-md-4 mb-2">
                    <label for="link-instagram">Link para o Instagram</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fab fa-instagram"></i></span>
                        <input type="url" class="form-control" id="link-instagram" placeholder="LINK PRO INSTAGRAM ">
                    </div>
                </div>

                <div class="col-12 col-md-4 mb-2">
                    <label for="link-facebook">Link para o Facebook</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fab fa-facebook"></i></span>
                        <input type="url" class="form-control" id="link-facebook" placeholder="LINK PRO FACEBOOK ">
                    </div>
                </div>

                <div class="col-12 col-md-4 mb-2">
                    <label for="whatsapp">WhatsApp</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fab fa-whatsapp"></i></span>
                        <input type="tel" class="form-control" id="whatsapp" placeholder="WHATSAPP">
                    </div>
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
                <div class="col-12 col-md-4 mb-2">
                    <label for="telefone-2">Telefone Alternativo</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                        <input type="tel" class="form-control" id="telefone-2" placeholder="TELEFONE">
                    </div>
                </div>

                <div class="col-12 col-md-4 mb-2">
                    <label for="horario-abertura">Horário de Abertura</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-clock"></i></span>
                        <input type="time" class="form-control" id="horario-abertura" placeholder="Horário de Abertura"
                            required>
                    </div>
                </div>

                <div class="col-12 col-md-4 mb-2">
                    <label for="horario-fechamento">Horário de Fechamento</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-clock"></i></span>
                        <input type="time" class="form-control" id="horario-fechamento"
                            placeholder="Horário de Fechamento" required>
                    </div>
                </div>
                <div class="col-md-4">
                                <label for="site" class="form-label">Link para o Site</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-globe"></i></span>
                                <input type="url" class="form-control" id="url" oninput="addPrefix(this)">
                                </div>
                            </div>
                <div class="col-12 col-md-4 mb-2">
                    <label class="form-label">Dias trabalhados e feriados</label>
                    <div class="dias-container">
                        <input type="checkbox" id="dia1" name="dias-trabalhados" value="1" class="dia-checkbox">
                        <label for="dia1" class="dia-label" title="Segunda-feira">
                            <i class="fas fa-calendar-day"></i>
                            <span class="dia-nome">Seg</span>
                        </label>

                        <input type="checkbox" id="dia2" name="dias-trabalhados" value="2" class="dia-checkbox">
                        <label for="dia2" class="dia-label" title="Terça-feira">
                            <i class="fas fa-calendar-day"></i>
                            <span class="dia-nome">Ter</span>
                        </label>

                        <input type="checkbox" id="dia3" name="dias-trabalhados" value="3" class="dia-checkbox">
                        <label for="dia3" class="dia-label" title="Quarta-feira">
                            <i class="fas fa-calendar-day"></i>
                            <span class="dia-nome">Qua</span>
                        </label>

                        <input type="checkbox" id="dia4" name="dias-trabalhados" value="4" class="dia-checkbox">
                        <label for="dia4" class="dia-label" title="Quinta-feira">
                            <i class="fas fa-calendar-day"></i>
                            <span class="dia-nome">Qui</span>
                        </label>

                        <input type="checkbox" id="dia5" name="dias-trabalhados" value="5" class="dia-checkbox">
                        <label for="dia5" class="dia-label" title="Sexta-feira">
                            <i class="fas fa-calendar-day"></i>
                            <span class="dia-nome">Sex</span>
                        </label>

                        <input type="checkbox" id="dia6" name="dias-trabalhados" value="6" class="dia-checkbox">
                        <label for="dia6" class="dia-label" title="Sábado">
                            <i class="fas fa-calendar-day"></i>
                            <span class="dia-nome">Sáb</span>
                        </label>

                        <input type="checkbox" id="dia7" name="dias-trabalhados" value="7" class="dia-checkbox">
                        <label for="dia7" class="dia-label" title="Domingo">
                            <i class="fas fa-calendar-day"></i>
                            <span class="dia-nome">Dom</span>
                        </label>

                        <input type="checkbox" id="dia8" name="dias-trabalhados" value="8" class="dia-checkbox">
                        <label for="dia8" class="dia-label feriado-label" title="Feriados">
                            <i class="fas fa-star"></i>
                            <span class="dia-nome">Feriado</span>
                        </label>
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
                        var url = $('#url').val('www.diskentregas.com/');
                        })
                            </script>
                <style>
                    .dias-container {
                        display: flex;
                        flex-wrap: wrap;
                        gap: 5px;
                    }

                    .dia-checkbox {
                        display: none;
                    }

                    .dia-label {
                        display: flex;
                        flex-direction: column;
                        align-items: center;
                        justify-content: center;
                        width: 40px;
                        height: 40px;
                        border: 1px solid #ced4da;
                        border-radius: 50%;
                        cursor: pointer;
                        transition: all 0.3s ease;
                        font-size: 0.8rem;
                    }

                    .dia-label:hover {
                        background-color: #f8f9fa;
                    }

                    .dia-checkbox:checked+.dia-label {
                        background-color: #007bff;
                        color: white;
                        border-color: #007bff;
                    }

                    .dia-nome {
                        font-size: 0.7rem;
                        margin-top: 2px;
                    }

                    .feriado-label {
                        background-color: white;
                        border-color: #ffc107;
                        width: 20%;
                        border-radius: 27px;
                    }

                    .feriado-label:hover {
                        background-color: #ffca2c;
                    }

                    .dia-checkbox:checked+.feriado-label {
                        background-color: #ff9800;
                        border-color: #ff9800;
                    }

                    @media (max-width: 768px) {
                        .dia-label {
                            width: 35px;
                            height: 35px;
                        }
                    }
                </style>
                <!-- Entregas -->
                <div class="container">
                    <h2 class="mb-4 text-center">Locais de atuação</h2>

                    <div class="section">
                        <h3 class="mb-3">Estados</h3>
                        <label class="custom-checkbox">
                            Entrego em todo o Brasil
                            <input type="checkbox" id="allest">
                            <span class="checkmark"></span>
                        </label>
                        <div id="estadosContainer" class="d-flex flex-wrap justify-content-center"></div>
                    </div>

                    <div class="section cidadesDiv">
                        <label class="custom-checkbox">
                            Entrego em todas as cidades
                            <input type="checkbox" id="allcid">
                            <span class="checkmark"></span>
                        </label>
                        <h3 class="mb-3">Cidades</h3>
                        <div id="cidadesContainer" class="d-flex flex-wrap justify-content-center"></div>
                    </div>

                    <div class="bairrosdiv">

                        <div class="section ">
                            <label class="custom-checkbox">
                                Entrego em todos os bairros
                                <input type="checkbox" id="allbai">
                                <span class="checkmark"></span>
                            </label>
                            <h3 class="mb-3">Bairros</h3>
                            <div id="bairrosContainer" class="d-flex flex-wrap justify-content-center"></div>
                           
                        </div>
                    </div>

                </div>
                <div class="section">
                    <h2 class="mb-4 text-center">Tipos</h2>

                    <div id="tiposContainer" class="d-flex flex-wrap justify-content-center"></div>
                </div>
                <div class="col-12 mb-2">
                    <div class="g-recaptcha" data-sitekey="6LexI14qAAAAAA3joWVkVxqhe-dlSeEN5uKoinXb"></div>
                </div>

                <!-- Botão de Confirmar -->
                <div class="col-12 mb-2">
                    <button class="btn btn-outline-success tm-search-btn" type="button" id="btn-confirm">
                        <i class="fas fa-check"></i> Confirmar
                    </button>
                </div>
            </div>

            <script>
            var selectedTypes = [];
            var tipos = [];
            function createButton(id, text, container, type, id_cidade = false) {
                if(type=="tipo"){
                    const button = $('<button>')
                    .addClass('btn btn-tipo')
                    .attr('data-id', id)
                    .attr('data-type', type)
                    .text(text)
                    .click(function () {
                        $(this).toggleClass('active');
                        updateSelectedLocations();
                    })
                        container.append(button);
                        return button;
                }
                const button = $('<button>')
                    .addClass('btn btn-location')
                    .attr('data-id', id)
                    .attr('data-type', type)
                    .text(text)
                    .click(function () {
                        $(this).toggleClass('active');
                        updateSelectedLocations();
                        if (type === 'estado') {
                            if ($(this).hasClass('active')) {
                                carregarCidades(id); 
                            } else {
                                removerCidades(id);
                            }
                        }else if (type === 'cidade'){
                            if ($(this).hasClass('active')) {
                                carregarBairros(id); 
                            } else {
                                removerBairros(id);
                            }
                        }
                    })
                    if(id_cidade){
                        button.attr('data-cidade-id', id_cidade)
                    };
                container.append(button);
                return button;
            }
                  function carregarTiposComoBotoes() {
            $.ajax({
                url: '/api/tipos', // URL da rota que retorna os tipos
                method: 'POST', // Supondo que seja um GET
                success: function (response) {
                    // Limpa o container de tipos
                    $('#tiposContainer').empty();
                    console.log(response)
                    $.each(response, function (key, tipo) {
                        createButton(tipo.id, tipo.tipo, $('#tiposContainer'), 'tipo');
                    });
                },
                error: function (xhr, status, error) {
                    console.error('Erro ao carregar tipos:', error);
                    console.log('Resposta do erro:', xhr.responseText);
                    
                    // Exibe uma mensagem caso ocorra um erro
                    $('#tiposContainer').empty().append('<p>Nenhum tipo encontrado</p>');
                }
            });
        }
        carregarTiposComoBotoes();
                function onSubmit(token) {
                    document.getElementById("formcadastro").submit();
                }

                function updateCheckboxes(selectedCheckbox) {
                    // Desmarcar todos os checkboxes
                    const checkboxes = document.querySelectorAll('.form-check-input');
                    checkboxes.forEach(checkbox => {
                        if (checkbox !== selectedCheckbox) {
                            checkbox.checked = false; // Desmarcar
                        }
                    });

                    // Atualizar a visibilidade dos selects
                    updateVisibility();
                }
            </script>

        </div>
    </div>


    <script>
            var estados = [];
            var cidades = {};
            var bairros = [];

            $('#allest').change(function () {
                const isChecked = $(this).is(':checked');
                if (isChecked) {
                    $('.bairrosdiv').hide();
                    $('.btn-location[data-type="estado"]').addClass('active');
                    $('.cidadesDiv').hide();
                    $('#cidadesContainer').empty();
                    $('#bairrosContainer').empty();
                } else {
                    $('.cidadesDiv').show();
                    $('.bairrosdiv').show();
                    $('.btn-location[data-type="estado"]').removeClass('active');
                    $('#cidadesContainer').empty();
                    $('#bairrosContainer').empty();
                }
                updateSelectedLocations();
            });

            $('#allcid').change(function () {
                const isChecked = $(this).is(':checked');
                if (isChecked) {
                    $('.bairrosdiv').hide();
                    $('.btn-location[data-type="cidade"]').addClass('active');
                    $('#bairrosContainer').empty();
                } else {
                    $('.bairrosdiv').show();
                    $('.btn-location[data-type="cidade"]').removeClass('active');
                    $('#bairrosContainer').empty();

                }
                updateSelectedLocations();
            });

            $('#allbai').change(function () {
                const isChecked = $(this).is(':checked');
                if (isChecked) {
                    $('.btn-location[data-type="bairro"]').addClass('active');
                } else {
                    $('.btn-location[data-type="bairro"]').removeClass('active');
                }
                updateSelectedLocations();
            });

            const estadosContainer = $('#estadosContainer');
            const cidadesContainer = $('#cidadesContainer');
            const bairrosContainer = $('#bairrosContainer');
            const selectedLocations = $('#selectedLocations');


            function updateSelectedLocations() {
                estados = [];
                cidades = {};
                bairros = [];
                selectedTypes = []
                tipos = []
                $('.btn-location.active').each(function () {
                    selectedTypes.push($(this).attr('data-id'));
                });
                $('.btn-tipo.active').each(function () {
                    tipos.push($(this).attr('data-id'));
                });
                
                console.log(`Tipos selecionados: ${tipos.join(', ')}`);
                // Adiciona estados selecionados
                $('.btn-location[data-type="estado"].active').each(function () {
                    const estadoId = $(this).attr('data-id');
                    estados.push($(this).attr('data-id'));
                    cidades[estadoId] = []; // Inicializa o array para as cidades desse estado
                });

                // Adiciona cidades selecionadas
                $('.btn-location[data-type="cidade"].active').each(function () {
                    const cidadeId = $(this).attr('data-id');
                    const estadoId = $(this).data('estado-id'); // Acessa o ID do estado relacionado
                    if (estadoId) {
                        cidades[estadoId].push($(this)
                            .attr('data-id')); // Adiciona a cidade ao estado correspondente
                    }
                });

                // Adiciona bairros selecionados
                $('.btn-location[data-type="bairro"].active').each(function () {
                    bairros.push($(this).attr('data-id'));
                });

                // Atualiza a exibição das localizações selecionadas
                selectedLocations.text(
                    `Estados: ${estados.join(', ')}, Cidades: ${Object.entries(cidades).map(([key, val]) => `${key}: ${val.join(', ')}`).join('; ')}, Bairros: ${bairros.join(', ')}`
                );
            }

            function carregarEstados() {
                $.post('/api/estados')
                    .done(function (data) {
                        estadosContainer.empty();
                        data.forEach(function (val) {
                            createButton(val.id_estado, val.nome, estadosContainer, 'estado');
                        });
                    })
                    .fail(function (xhr, status, error) {
                        console.error('Erro ao carregar estados:', status, error);
                    });
            }

            function carregarCidades(estadoId) {
                if (estadoId) {
                    $.post('/api/cidades', {
                        estado: estadoId
                    })
                        .done(function (data) {
                            // Verifica se as cidades já foram carregadas
                            if (!cidades[estadoId]) {
                                cidades[estadoId] = []; // Inicializa o array para as cidades desse estado
                            }
                            const estadoHeader = $('<h1 class="addmore">').attr('data-estado-id', estadoId).attr('data-type', 'bairro').text(data.estado);
                            cidadesContainer.append(`<div class="addmore" data-type="bairro" data-estado-id="${estadoId}" style="height: 30px; width: 100vw;"></div>`);
                            
                            cidadesContainer.append(estadoHeader);
                            cidadesContainer.append(`<div class="addmore" data-type="bairro"  data-estado-id="${estadoId}" style="height: 30px; width: 100vw;"></div>`);
                            data.cidades.forEach(function (val) {
                                createButton(val.id_cidade, val.nome, cidadesContainer, 'cidade')
                                    .attr('data-estado-id',
                                        estadoId); // Adiciona o ID do estado à cidade
                            });
                        })
                        .fail(function (xhr, status, error) {
                            console.error('Erro ao carregar cidades:', status, error);
                        });
                }
            }

            function removerCidades(estadoId) {
                // Remove as cidades relacionadas ao estado que foi desmarcado
                cidadesContainer.find(`.btn-location[data-estado-id="${estadoId}"]`)
                    .remove(); 
                    cidadesContainer.find(`.addmore[data-estado-id="${estadoId}"]`)
                    .remove(); 
                updateSelectedLocations(); // Atualiza as localizações selecionadas
            }


            function removerBairros(estadoId) {
                // Remove as cidades relacionadas ao estado que foi desmarcado
                bairrosContainer.find(`.btn-location[data-type="bairro"][data-cidade-id="${estadoId}"]`)
                    .remove(); 
                    bairrosContainer.find(`.addmore[data-cidade-id="${estadoId}"]`)
                    .remove(); 
                updateSelectedLocations(); // Atualiza as localizações selecionadas
            }

            function carregarBairros(cidadeId) {
                if (cidadeId) {
                    $.post('/api/bairros', {
                        cidade: cidadeId
                    })
                    .done(function(data) {

                            if (data.length > 0) {
                                // Acessa o primeiro bairro do array
                                const primeiroBairro = data[0];

                                const bairroId = primeiroBairro.id_bairro;
                                const nomeBairro = primeiroBairro.nome;
                                const cidadeId = primeiroBairro.cidade;

                                // Criando o cabeçalho do bairro
                                const estadoHeader = $('<h1 class="addmore">')
                                    .attr('data-cidade-id', cidadeId)
                                    .text(nomeBairro);

                                // Adicionando elementos ao contêiner
                                bairrosContainer.append(`<div class="addmore" data-cidade-id="${cidadeId}" style="height: 30px; width: 100vw;"></div>`);
                                bairrosContainer.append(estadoHeader);
                                bairrosContainer.append(`<div class="addmore" data-cidade-id="${cidadeId}" style="height: 30px; width: 100vw;"></div>`);
                                
                                // Loop através dos bairros, se necessário
                                data.forEach(function(val) {
                                    createButton(val.id_bairro, val.nome_bairro, bairrosContainer, 'bairro',cidadeId);
                                })
                            } else {
                                console.error("Nenhum bairro encontrado.");
                            }
                        })
                        .fail(function (xhr, status, error) {
                            console.log(xhr.responseText)
                            console.error('Erro ao carregar bairros:', status, error);
                        });
                } else {
                    bairrosContainer.empty();
                }
            }

            $('#adicionarBairro').click(function () {
                const novoBairro = $('#novoBairro').val().trim();
                if (novoBairro) {
                    createButton('novo_' + Date.now(), novoBairro, bairrosContainer, 'bairro');
                    $('#novoBairro').val('');
                }
            });

            carregarEstados();

            // Evento para carregar categorias quando o tipo for selecionado
            $('#tipo').on('change', function () {
                let tipoSelecionado = $(this).val();
                $('#categoria').empty().append('<option value="">Selecione a Categoria</option>');
                if (tipoSelecionado && categoriasPorTipo[tipoSelecionado]) {
                    categoriasPorTipo[tipoSelecionado].forEach(function (categoria) {
                        $('#categoria').append('<option value="' + categoria.valor + '">' +
                            categoria.texto + '</option>');
                    });
                    $('#categoria').prop('disabled', false);
                } else {
                    $('#categoria').prop('disabled', true);
                }
            });
            // Função para coletar dias trabalhados
function obterDiasTrabalhados() {
    const diasCheckboxes = document.querySelectorAll('.dia-checkbox');
    const diasTrabalhados = [];

    diasCheckboxes.forEach(checkbox => {
        if (checkbox.checked) {
            diasTrabalhados.push(parseInt(checkbox.value));
        }
    });

    return diasTrabalhados;
}

$('#btn-confirm').click(async () => {
    // Verificar valor do reCAPTCHA
    const recaptchaResponse = grecaptcha.getResponse();
    if($('#url').val() == 'www.diskentregas.com/'){
        Swal.fire({
            title: 'Erro!',
            text: "Preencha o link para o site da loja.",
            icon: 'error',
            confirmButtonText: 'OK'
        });
        return
    }
    // Validar se todos os campos estão preenchidos
    if (
        estados && cidades && bairros && selectedPlanValue &&
        $('#responsavel').val() && $('#cpf').val() && $('#telefone').val() &&
        $('#email-cobranca').val() && $('#senha').val() &&
        $('#nome-estabelecimento').val() && $('#link-site').val() &&
        $('#link-instagram').val() && $('#link-facebook').val() &&
        $('#whatsapp').val() && $('#telefone-2').val() &&
        $('#horario-abertura').val() && $('#horario-fechamento').val() &&
        $('#url').val() && await obterDiasTrabalhados().length > 0 &&
        recaptchaResponse // Certificar que o reCAPTCHA foi validado
    ) {
        var dados = {
            estados,
            cidades,
            bairros,
            'plano': selectedPlanValue,
            'responsavel': $('#responsavel').val(),
            'cpf': $('#cpf').val(),
            'tel': $('#telefone').val(),
            'email': $('#email-cobranca').val(),
            'senha': $('#senha').val(),
            'nome-estabelecimento': $('#nome-estabelecimento').val(),
            'site': $('#link-site').val(),
            'insta': $('#link-instagram').val(),
            'fb': $('#link-facebook').val(),
            'wpp': $('#whatsapp').val(),
            'tel': $('#telefone-2').val(),
            'abertura': $('#horario-abertura').val(),
            'fechamento': $('#horario-fechamento').val(),
            'url': $('#url').val(),
            'dias': await obterDiasTrabalhados(),
            'g-recaptcha-response': recaptchaResponse,
            'tipos': tipos
        };

        // Realizar a requisição AJAX
        $.ajax({
            url: `/checkout`,
            type: 'POST',
            data: dados,
            success: function (response) {
                // console.log(response)
                window.location.href = window.location.origin + '/checkout?plano=' + response.message + '&user=' + response.user;
            },
            error: function (xhr, error) {
                console.log(xhr.responseText);
            }
        });
    } else {
        // Exibir um alerta de erro se algum campo estiver vazio ou o reCAPTCHA não estiver preenchido
        Swal.fire({
            title: 'Erro!',
            text: "Por favor, preencha todos os campos e valide o reCAPTCHA.",
            icon: 'error',
            confirmButtonText: 'OK'
        });
    }
}); // <-- Aqui fechamos a função corretamente


    </script>
    @include('template.footer')


    <script>
        $(window).on("load", function () {
            $('body').addClass('loaded');
        });
    </script>
</body>

</html>