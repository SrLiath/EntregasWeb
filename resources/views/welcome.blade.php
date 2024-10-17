<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
</head>

<body>
    <style>
        body {
            overflow-x: hidden
        }
    </style>
    <!-- Page Loader -->
    <div id="loader-wrapper">
        <div id="loader"></div>

        <div class="loader-section section-left"></div>
        <div class="loader-section section-right"></div>

    </div>
    <img src="/baner.jpg" style="width: 100vw;" alt="" />


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

            <form class="tm-search-form row">
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
                        @foreach ($tipos as $tipo)
                            <option value="{{ $tipo->id }}">{{ $tipo->tipo }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Categoria -->
                <div class="col-12 col-md-2 mb-2">
                    <select id="categorias" class="form-control" aria-label="Categoria" disabled>
                        <option value="">Categoria</option>
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
    <style>
        @media (max-width: 767px) {

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
            // Função para carregar os estados
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
                            console.log(data)
                            $('#bairro').empty().prop('disabled', true);
                            $('#bairro').append(' <option value="">Bairro</option>');
                            $.each(data, function(key, categoria) {
                                $('#bairro').append('<option value="' + categoria.id_bairro + '">' +
                                    categoria.nome + '</option>');
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

            $('#tipo').change(function() {
                var id_tipo = $(this).val();

                $.ajax({
                    url: '/tipos/categorias',
                    method: 'POST',
                    data: {
                        id_tipo: id_tipo,
                        _token: '{{ csrf_token() }}' // Necessário para proteger contra ataques CSRF
                    },
                    success: function(response) {
                        $('#categorias').empty();
                        $.each(response, function(key, categoria) {
                            $('#categorias').append(
                                ' <option value="">Categoria</option>');

                            $('#categorias').append('<option value="' + categoria.id +
                                '">' + categoria.categoria + '</option>')
                        });
                        $('#categorias').prop('disabled', false);

                    }
                });
            });

            // Ação ao clicar no botão Confirmar
            $('#btn-search').on('click', function() {
                // Obtém os valores selecionados
                let estado = $('#estado').find('option:selected').text();
                let cidade = $('#cidade').find('option:selected').text();
                let bairro = $('#bairro').find('option:selected').text();
                let tipo = $('#tipo').find('option:selected').text();
                let categoria = $('#categorias').find('option:selected').text();

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
                if (categoria && categoria != 'Categoria') {
                    params.push('categoria=' + encodeURIComponent(categoria));
                }

                // Se houver parâmetros, adiciona à URL
                if (params.length > 0) {
                    url += '?' + params.join('&');
                }
                if (
                    (!categoria || categoria == 'Categoria') &&
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
                const url = window.location.pathname; // Retorna o caminho da URL (exemplo: /estado/cidade/bairro/alo)

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
        <div class="row tm-mb-90 tm-gallery">
            @if ($lojas->isEmpty())
                <div class="col-12 mb-5 text-center">
                    <div
                        style="border: 1px dotted cyan; background-color: lightgray; padding: 20px; border-radius: 5px; margin-left:30%; margin-right: 30%">
                        <span style="font-size: 50px;">😞</span>
                        <div>Sem lojas disponíveis</div>
                    </div>
                </div>
            @else
                <style>
                    .product-grid {
                        display: grid;
                        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
                        gap: 20px;
                    }

                    .product-card {
                        background-color: #ffffff;
                        border-radius: 8px;
                        overflow: hidden;
                        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                        transition: transform 0.3s ease;
                    }

                    .product-card:hover {
                        transform: translateY(-5px);
                    }

                    .product-name {
                        background-color: #3498db;
                        color: #ffffff;
                        padding: 10px;
                        text-align: center;
                        font-size: 18px;
                        font-weight: bold;
                    }

                    .product-image {
                        width: 100%;
                        height: 200px;
                        object-fit: cover;
                    }

                    .product-details {
                        padding: 15px;
                        display: flex;
                        justify-content: space-between;
                        align-items: center;
                        background-color: #ecf0f1;
                    }

                    .product-price {
                        font-size: 18px;
                        font-weight: bold;
                        color: #2c3e50;
                    }

                    .view-more {
                        background-color: #2ecc71;
                        color: #ffffff;
                        border: none;
                        padding: 8px 15px;
                        border-radius: 4px;
                        cursor: pointer;
                        transition: background-color 0.3s ease;
                    }

                    .view-more:hover {
                        background-color: #27ae60;
                    }
                </style>
                @foreach ($lojas as $loja)
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12 mb-5">
                        <div class="card border-0 shadow-sm" style="background-color: #008585; color: white;">
                            <!-- Fundo do card -->
                            <div class="card-header text-center"
                                style="background-color: #006f6f; border-bottom: none;">
                                <h5 class="mb-0">{{ $loja->nome }}</h5> <!-- Nome da loja no cabeçalho -->
                            </div>
                            <figure class="effect-ming tm-video-item">
                                <img src="{{ asset($loja->imagem) }}" alt="Image" class="img-fluid card-img-top">
                                <!-- Classe para imagem do card -->
                                <figcaption class="d-flex align-items-center justify-content-center">
                                    <a href="" class="btn btn-primary">View more</a> <!-- Botão para ver mais -->
                                </figcaption>
                            </figure>
                            <div class="mb-1 mt-1 " style="margin-top: -15px !important">
                                <div class="d-flex justify-content-center">
                                    <span style="color: white;">Aberto</span> <!-- Status -->
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div> <!-- row -->

        <div class="row tm-mb-90">
            <div class="col-12 d-flex justify-content-between align-items-center tm-paging-col">
                <a href="{{ $lojas->previousPageUrl() }}"
                    class="btn btn-primary tm-btn-prev mb-2 {{ $lojas->onFirstPage() ? 'disabled' : '' }}">Anterior</a>
                <div class="tm-paging d-flex">
                    @for ($i = 1; $i <= $lojas->lastPage(); $i++)
                        <a href="{{ $lojas->url($i) }}"
                            class="tm-paging-link {{ request()->get('page') == $i || (request()->get('page') == null && $i == 1) ? 'active' : '' }}">
                            {{ $i }}
                        </a>
                    @endfor

                </div>
                <a href="{{ $lojas->nextPageUrl() }}"
                    class="btn btn-primary tm-btn-next {{ $lojas->hasMorePages() ? '' : 'disabled' }}">Proxima</a>
            </div>
        </div>
    </div> <!-- container-fluid, tm-container-content -->
    {{-- <div class="d-flex justify-content-center align-items-center">
        <div class="col-6 d-flex justify-content-center align-items-center">
            <form action="" class="tm-text-primary">
                Pagina <input type="text" value="{{ $lojas->currentPage() }}" size="1"
                    class="tm-input-paging tm-text-primary">
                de {{ $lojas->lastPage() }}
            </form>
        </div>
    </div> --}}



    <style>
        .linha {
            display: none;
        }

        @media (max-width: 767px) {

            .linha {
                display: flex;
                width: 70%;
                height: 0.5px;
                background-color: #008585;
                margin: -20px auto 20px;
            }
        }
    </style>
    <footer class="tm-bg-gray pt-5 pb-0 tm-text-gray tm-footer w-100">
        <div class=" tm-container-fullscreen">
            <!-- Primeira linha com 3 colunas -->
            <div class="row text-center">
                <!-- Primeira coluna -->
                <div class="col-lg-4 col-md-6 col-12 px-5 mb-5">
                    <p>
                        PRODUTOS, SERVIÇOS E ALIMENTOS QUE CHEGAM ATÉ VOCÊ.
                        <br>
                        PARTICIPE VOCÊ TAMBÉM!
                    </p>
                </div>
                <div class="linha"></div>
                <!-- Segunda coluna com barra à esquerda -->
                <div class="col-lg-4 col-md-6 col-12 px-5 mb-5" style="border-left: 1px solid #ccc;">
                    <ul class="tm-footer-links list-unstyled pl-0">
                        <li><a href="/cadastre">CONTRATE</a></li>
                        <li><a href="/sobre">SOBRE NÓS</a></li>
                        <li><a href="/contato">CONTATO</a></li>
                    </ul>
                </div>
                <div class="linha"></div>

                <!-- Terceira coluna com barra à esquerda -->
                <div class="col-lg-4 col-md-12 col-12 px-5 mb-5" style="border-left: 1px solid #ccc;">
                    <p>
                        ENTRE EM CONTATO:
                        <br>
                        suporte@diskentregas.com
                    </p>
                </div>
            </div>

            <!-- Texto <h3> abaixo das colunas -->
            <div class="row">
                <div class="col-12 d-flex justify-content-center align-items-center"
                    style="background-color: #008585; color: white; width: 100%; ">
                    <h3 class="tm-text-primary mb-2 mt-2 tm-footer-title text-align-center" style="color: white;">
                        DISK ENTREGAS | PORTAL OFICIAL ®
                    </h3>
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
