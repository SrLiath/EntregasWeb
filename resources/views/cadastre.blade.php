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
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/css/templatemo-style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
</head>

<body>
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
                .plans-container {
                    display: flex;
                    justify-content: center;
                    margin: 20px 0;
                    flex-wrap: wrap;
                }

                .plan {
                    background-color: rgba(255, 255, 255, 0.9);
                    border-radius: 15px;
                    margin: 10px;
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
            </style>
            <br>
            <center>
                <h3>Escolha um plano</h3>
            </center>
            <div class="plans-container">
                <div class="plan selected" onclick="selectPlan(this, 'Plano Brasil')">
                    <h2>Plano Brasil</h2>
                    <p>1 banner no Brasil (index) e em todos os estados<br>+ resultado da busca <br>+ página do
                        anunciante</p>
                </div>
                <div class="plan" onclick="selectPlan(this, 'Plano Estadual')">
                    <h2>Plano Estadual</h2>
                    <p>1 banner no estado<br>+ resultado da busca <br>+ página do anunciante</p>
                </div>
                <div class="plan" onclick="selectPlan(this, 'Plano Busca')">
                    <h2>Plano Busca</h2>
                    <p>+ página do anunciante</p>
                </div>
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

            <form class="tm-search-form row" id="formcadastro">
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

                <!-- Email de cobrança -->
                <div class="col-12 col-md-4 mb-2">
                    <label for="email-cobranca">Email de cobrança</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        <input type="email" class="form-control" id="email-cobranca" placeholder="Email de cobrança"
                            required>
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
                <div class="col-12 col-md-4 mb-2">
                    <label for="login">Login</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-user-lock"></i></span>
                        <input type="text" class="form-control" id="login" placeholder="Login" required>
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
                        <input type="url" class="form-control" id="link-instagram"
                            placeholder="LINK PRO INSTAGRAM ">
                    </div>
                </div>

                <div class="col-12 col-md-4 mb-2">
                    <label for="link-facebook">Link para o Facebook</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fab fa-facebook"></i></span>
                        <input type="url" class="form-control" id="link-facebook"
                            placeholder="LINK PRO FACEBOOK ">
                    </div>
                </div>

                <div class="col-12 col-md-4 mb-2">
                    <label for="whatsapp">WhatsApp</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fab fa-whatsapp"></i></span>
                        <input type="tel" class="form-control" id="whatsapp" placeholder="WHATSAPP">
                    </div>
                </div>

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
                        <input type="time" class="form-control" id="horario-abertura"
                            placeholder="Horário de Abertura" required>
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

                <!-- Entregas -->
                <div class="col-12 mb-2">
                    <h5>Regiões de Entrega</h5>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="entrego-todo-brasil"
                            onclick="updateCheckboxes(this)">
                        <label class="form-check-label" for="entrego-todo-brasil">Entrego em todo Brasil</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="entrego-todo-estado"
                            onclick="updateCheckboxes(this)">
                        <label class="form-check-label" for="entrego-todo-estado">Entrego em todo o estado</label>
                        <select id="estado" class="form-control mt-2" aria-label="Estado" style="display:none;">
                            <option value="">Estado</option>
                            <option value="SP">São Paulo</option>
                            <option value="RJ">Rio de Janeiro</option>
                            <option value="MG">Minas Gerais</option>
                            <!-- Adicione outros estados conforme necessário -->
                        </select>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="entrego-todo-cidade"
                            onclick="updateCheckboxes(this)">
                        <label class="form-check-label" for="entrego-todo-cidade">Entrego em toda cidade</label>
                        <select id="estado-cidade" class="form-control mt-2" aria-label="Estado"
                            style="display:none;">
                            <option value="">Estado</option>
                            <option value="SP">São Paulo</option>
                            <option value="RJ">Rio de Janeiro</option>
                            <option value="MG">Minas Gerais</option>
                            <!-- Adicione outros estados conforme necessário -->
                        </select>
                        <select id="cidade" class="form-control mt-2" aria-label="Cidade" style="display:none;">
                            <option value="">Cidade</option>
                            <option value="SP">São Paulo</option>
                            <option value="RJ">Rio de Janeiro</option>
                            <option value="BH">Belo Horizonte</option>
                            <!-- Adicione outras cidades conforme necessário -->
                        </select>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="entrego-especifico"
                            onclick="updateCheckboxes(this)">
                        <label class="form-check-label" for="entrego-especifico">Entrego em regiões
                            específicas</label>
                        <div id="locais-especificos" style="display:none;">
                            <input type="text" class="form-control mt-2" placeholder="Especifique os locais">
                        </div>
                    </div>
                </div>
                <div class="col-12 mb-2">
                    <div class="g-recaptcha" data-sitekey="6LexI14qAAAAAA3joWVkVxqhe-dlSeEN5uKoinXb"></div>
                </div>

                <!-- Botão de Confirmar -->
                <div class="col-12 mb-2">
                    <button class="btn btn-outline-success tm-search-btn" type="button" id="btn-search">
                        <i class="fas fa-check"></i> Confirmar
                    </button>
                </div>
            </form>

            <script>
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

                function updateVisibility() {
                    const brasil = document.getElementById('entrego-todo-brasil').checked;
                    const estado = document.getElementById('entrego-todo-estado').checked;
                    const cidade = document.getElementById('entrego-todo-cidade').checked;

                    // Oculta todos os selects inicialmente
                    document.getElementById('estado').style.display = 'none';
                    document.getElementById('estado-cidade').style.display = 'none';
                    document.getElementById('cidade').style.display = 'none';
                    document.getElementById('locais-especificos').style.display = 'none';

                    // Mostra select de estado se 'entrego em todo estado' for selecionado
                    if (estado) {
                        document.getElementById('estado').style.display = 'block';
                    }

                    // Mostra selects de estado e cidade se 'entrego em toda cidade' for selecionado
                    if (cidade) {
                        document.getElementById('estado-cidade').style.display = 'block';
                        document.getElementById('cidade').style.display = 'block';
                    }

                    // Mostra locais específicos se selecionado
                    if (document.getElementById('entrego-especifico').checked) {
                        document.getElementById('locais-especificos').style.display = 'block';
                    }
                }
            </script>

        </div>
    </div>


    <script>
        $(document).ready(function() {
            // Função para carregar os estados

            function carregarEstados() {
                $.post('/api/estados')
                    .done(function(data) {
                        data.forEach(function(val) {
                            $('#estado').append('<option value="' + val.id_estado + '">' + val.nome +
                                '</option>');
                        });
                    })
                    .fail(function(xhr, status, error) {
                        console.error('Erro ao carregar estados:', status, error);
                        console.log('Erro ao carregar estados: ' + xhr.responseText);
                    });
            }

            // Função para carregar as cidades com base no estado
            function carregarCidades(estadoId) {
                if (estadoId) {
                    $.post('/api/cidades', {
                            estado: estadoId
                        })
                        .done(function(data) {
                            $('#cidade').empty().append('<option value="">Selecione a Cidade</option>');
                            data.forEach(function(val) {
                                $('#cidade').append('<option value="' + val.id_cidade + '">' + val
                                    .nome + '</option>');
                            });
                            $('#cidade').prop('disabled', false);
                        })
                        .fail(function(xhr, status, error) {
                            console.error('Erro ao carregar cidades:', status, error);
                            console.log('Erro ao carregar cidades: ' + xhr.responseText);
                        });
                } else {
                    $('#cidade').empty().append('<option value="">Selecione a Cidade</option>').prop('disabled',
                        true);
                }
            }

            // Função para carregar bairros a partir do ID do município
            function carregarBairros(cidadeId) {
                if (cidadeId) {
                    $.post('/api/bairros', {
                            cidade: cidadeId
                        })
                        .done(function(data) {
                            $('#bairro').empty().append('<option value="">Selecione o Bairro</option>');
                            data.forEach(function(val) {
                                $('#bairro').append('<option value="' + val.id_bairro + '">' + val
                                    .nome + '</option>');
                            });
                            $('#bairro').prop('disabled', false);
                        })
                        .fail(function(xhr, status, error) {
                            console.error('Erro ao carregar bairros:', status, error);
                            console.log('Erro ao carregar bairros: ' + xhr.responseText);
                            $('#bairro').empty().append('<option value="">Nenhum bairro encontrado</option>')
                                .prop('disabled', true);
                        });
                } else {
                    $('#bairro').empty().append('<option value="">Selecione o Bairro</option>').prop('disabled',
                        true);
                }
            }

            // Mapeamento de categorias com base no tipo
            const categoriasPorTipo = {
                residencial: [{
                        valor: "venda",
                        texto: "Venda Residencial"
                    },
                    {
                        valor: "aluguel",
                        texto: "Aluguel Residencial"
                    }
                ],
                comercial: [{
                        valor: "venda",
                        texto: "Venda Comercial"
                    },
                    {
                        valor: "aluguel",
                        texto: "Aluguel Comercial"
                    }
                ]
            };

            // Carregar os estados
            carregarEstados();

            // Evento para carregar cidades quando o estado for selecionado
            $('#estado').on('change', function() {
                let estadoId = $(this).val();
                carregarCidades(estadoId);
            });

            // Evento para carregar bairros quando a cidade for selecionada
            $('#cidade').on('change', function() {
                let cidadeId = $(this).val();
                carregarBairros(cidadeId);
            });

            // Evento para carregar categorias quando o tipo for selecionado
            $('#tipo').on('change', function() {
                let tipoSelecionado = $(this).val();
                $('#categoria').empty().append('<option value="">Selecione a Categoria</option>');
                if (tipoSelecionado && categoriasPorTipo[tipoSelecionado]) {
                    categoriasPorTipo[tipoSelecionado].forEach(function(categoria) {
                        $('#categoria').append('<option value="' + categoria.valor + '">' +
                            categoria.texto + '</option>');
                    });
                    $('#categoria').prop('disabled', false);
                } else {
                    $('#categoria').prop('disabled', true);
                }
            });

            // Ação ao clicar no botão Confirmar
            $('#btn-search').on('click', function() {
                // Obtém os valores selecionados
                let estado = $('#estado').find('option:selected').text();
                let cidade = $('#cidade').find('option:selected').text();
                let bairro = $('#bairro').find('option:selected').text();
                let tipo = $('#tipo').find('option:selected').text();
                let categoria = $('#categoria').find('option:selected').text();

                let url = '';

                if (estado && $('#estado').val() != '') {
                    url += '/' + encodeURIComponent(estado);

                    if (cidade && $('#cidade').val() != '') {
                        url += '/' + encodeURIComponent(cidade);
                        if (bairro && $('#bairro').val() != '') {
                            url += '/' + encodeURIComponent(bairro);
                        }
                    }


                    let params = [];
                    if (tipo) {
                        params.push('tipo=' + encodeURIComponent(tipo));
                    }
                    if (categoria) {
                        params.push('categoria=' + encodeURIComponent(categoria));
                    }

                    // Se houver parâmetros, adiciona à URL
                    if (params.length > 0) {
                        url += '?' + params.join('&');
                    }

                    window.location.href = url;
                } else {
                    alert('Por favor, selecione pelo menos o estado.');
                }
            });

        });
    </script>

    <footer class="tm-bg-gray pt-5 pb-3 tm-text-gray tm-footer">
        <div class="container-fluid tm-container-small">
            <div class="row">
                <div class="col-lg-6 col-md-12 col-12 px-5 mb-5">
                    <h3 class="tm-text-primary mb-4 tm-footer-title">Disk entrega</h3>
                    <p>Disk entrega é um sistema de locação de lojas</p>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12 px-5 mb-5">
                    <ul class="tm-footer-links pl-0">
                        <li><a href="/cadastre">Contrate</a></li>
                        <li><a href="/sobre">Sobre nós</a></li>
                        <li><a href="/contato">Contato</a></li>
                        <li><a href="/login">Login Estabelecimento</a></li>
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 col-md-7 col-12 px-5 mb-3">
                    Copyright 2024 Disk entrega.
                </div>
            </div>
        </div>
    </footer>

    <script>
        $(window).on("load", function() {
            $('body').addClass('loaded');
        });
    </script>
</body>

</html>
