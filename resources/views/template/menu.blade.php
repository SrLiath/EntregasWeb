
    <title>Disk entrega</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"
        integrity="sha512-2rNj2KJ+D8s1ceNasTIex6z4HWyOnEYLVC3FigGOmyQCZc2eBXKgOxQmo3oKLHyfcj53uz4QMsRCWNbLd32Q1g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/css/templatemo-style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
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
    <style>
        body {
            overflow-x: hidden
        }

        .banner {
            width: 100vw;
        }
    </style>
    <!-- Page Loader -->
    <div id="loader-wrapper">
        <div id="loader"></div>

        <div class="loader-section section-left"></div>
        <div class="loader-section section-right"></div>

    </div>
    <div class="d-flex justify-content-center">
        <a href="/">
            <img src="/baner.jpg" class="banner" alt="" />
        </a>
    </div>


    <div class="tm-hero d-flex justify-content-center align-items-center" data-parallax="scroll"
        data-image-src="img/hero.jpg">
        <div class="container">
            <!-- Banner -->
            <div class="container-fluid p-0">
                <div class="banner">
                    <div class="banner-overlay text-center">
                        {{-- <h1 class="display-4">Brasil</h1>
                        <p class="lead">Selecione seu estado, cidade e bairro</p>
                        <a href="#" class="btn btn-light btn-lg">Saiba Mais</a> --}}
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center">
                <form class="tm-search-form row justify-content-center">
                    <!-- Estado -->
                    <div class="col-12 col-md-2 mb-2">
                        <select id="estado" class="form-control" aria-label="Estado">
                            <option value="">Estado</option>
                        </select>
                    </div>
            
                    <!-- Cidade -->
                    <div class="col-12 col-md-2 mb-2">
                        <select id="cidade" class="form-control" aria-label="Cidade" disabled>
                            <option value="">Cidade</option>
                        </select>
                    </div>
            
                    <!-- Bairro -->
                    <div class="col-12 col-md-2 mb-2">
                        <select id="bairro" class="form-control" aria-label="Bairro" disabled>
                            <option value="">Bairro</option>
                        </select>
                    </div>
            
                    <!-- Tipo -->
                    <div class="col-12 col-md-2 mb-2">
                        <select id="tipo" class="form-control" aria-label="Tipo">
                            <option value="">Tipo</option>
                        </select>
                    </div>
            
                    <!-- Botão de Confirmar -->
                    <div class="col-12 col-md-2 mb-2">
                        <button class="btn btn-outline-success tm-search-btn" type="button" id="btn-search">
                            Confirmar
                        </button>
                    </div>
                </form>
            </div>
            
        </div>

    </div>
    <style>
        @media (max-width: 767px) {
            .banner {
                height: 170px;
                width: auto;
                margin-bottom: -70px;
            }

            #dynamicText {
                margin-top: 40px;
            }
        }
    </style>
    <div class="col-12 text-center pe-md-5 ps-md-5">
        <h6 class="tm-text-primary" id="dynamicText">
            Disk Entregas no Brasil &rsaquo;
        </h6>
    </div>

    <script>
        $(document).ready(function() {
            const urlParams = new URLSearchParams(window.location.search);
        
        let estado = '';
        let cidade = '';
        let bairro = '';

        if (urlParams.has('estado')) {
            estado = urlParams.get('estado');
        }
        if (urlParams.has('cidade')) {
            cidade = urlParams.get('cidade');
        }
        if (urlParams.has('bairro')) {
            bairro = urlParams.get('bairro');
        }

        let novoTitulo = 'Disk entrega';
        if (estado) {
            novoTitulo += ' ' + estado;
            if (cidade) {
                novoTitulo += ', ' + cidade;
                if (bairro) {
                    novoTitulo += ', ' + bairro;
                }
            }
            document.title = novoTitulo;
        }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

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
                            console.log(data)
                            $('#cidade').empty().append('<option value="">Selecione a Cidade</option>');
                            data.cidades.forEach(function(val) {
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
                            console.log(data)
                            $('#bairro').empty().prop('disabled', true);
                            $('#bairro').append(' <option value="">Bairro</option>');
                            $.each(data, function(key, categoria) {
                                $('#bairro').append('<option value="' + categoria.id_bairro + '">' +
                                    categoria.nome_bairro + '</option>');
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

            function carregarTipos() {
        $.ajax({
            url: '/api/tipos',
            method: 'POST',
            success: function(response) {
                $('#tipo').empty().append('<option value="">Tipo</option>');
                
                $.each(response, function(key, tipo) {
                    $('#tipo').append('<option value="' + tipo.id + '">' + tipo.tipo + '</option>');
                });
            },
            error: function(xhr, status, error) {
                console.error('Erro ao carregar tipos:', error);
                console.log('Resposta do erro:', xhr.responseText);
                
                $('#tipo').empty().append('<option value="">Nenhum tipo encontrado</option>');
            }
        });
    }

            carregarTipos();
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
            $('#btn-search').on('click', function() {
                // Obtém os valores selecionados
                let estado = $('#estado').find('option:selected').text();
                let cidade = $('#cidade').find('option:selected').text();
                let bairro = $('#bairro').find('option:selected').text();
                let tipo = $('#tipo').find('option:selected').text();

                let url = '';

                if (estado && $('#estado').val() != '') {
                    url += '/' + encodeURIComponent(estado);

                    if (cidade && $('#cidade').val() != '') {
                        url += '/' + encodeURIComponent(cidade);
                        if (bairro && $('#bairro').val() != '') {
                            url += '/' + encodeURIComponent(bairro);
                        }
                    }
                }


                let params = [];
                if (tipo && tipo != 'Tipo') {
                    params.push('tipo=' + encodeURIComponent(tipo));
                }

                // Se houver parâmetros, adiciona à URL
                if (params.length > 0) {
                    url += '?' + params.join('&');
                }
                if (
                    (!tipo || tipo == 'Tipo') &&
                    (!estado || $('#estado').val() == '') &&
                    (!cidade || $('#cidade').val() == '') &&
                    (!bairro || $('#bairro').val() == '')
                ) {
                    window.location.href = window.location.origin;
                } else {
                    window.location.href = url;
                }

            });
        });
    </script>
    <div class="container-fluid tm-container-content tm-mt-60">
        <div class="row mb-4">


            <script>
                // Obtém a URL (caminho)
                const url = window.location.pathname;

                // Divide o caminho em segmentos (usando "/" como separador)
                const segments = url.split('/').filter(segment => segment); // Remove strings vazias

                // Constrói o texto com os segmentos da URL
                let newText = 'Disk Entregas no Brasil &rsaquo; ' + segments.join(' &rsaquo; ');

                // Obtém os parâmetros da query string
                const params = new URLSearchParams(window.location.search);

                // Se houver parâmetros, adiciona no texto
                if (params.toString()) {
                    params.forEach((value, key) => {
                        if (key != "page") {
                            newText += ` &rsaquo; ${value}`;
                        }
                    });
                }

                // Altera o texto do elemento HTML
                const dynamicText = document.getElementById('dynamicText');
                dynamicText.innerHTML = decodeURIComponent(newText);
            </script>



        </div>
    </div>