<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    <style>
        body {
            overflow-x: hidden;
        }

        .sidebar {
            min-height: 100vh;
            width: 250px;
            background-color: #343a40;
            color: #fff;
            padding: 15px;
            position: fixed;
            left: -250px;
            transition: left 0.3s ease;
            z-index: 1000;
        }

        .sidebar.active {
            left: 0;
        }

        .content {
            transition: margin-left 0.3s ease;
        }

        .content.active {
            margin-left: 0;
        }

        .navbar {
            z-index: 1001;
        }

        /* Oculta todos os conteúdos por padrão */
        .content-section {
            display: none;
        }

        /* Exibe a seção ativa */
        .content-section.active {
            display: block;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">
            <button class="btn btn-outline-light" id="toggleSidebar">
                <i class="fas fa-bars"></i>
            </button>
            <button class="btn btn-danger ms-auto" id="logoutButton">
                <i class="fas fa-sign-out-alt"></i> Sair
            </button>
        </div>
    </nav>

    <div id="sidebar" class="sidebar">
        <h4 class="text-center">Painel Admin</h4>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link text-white" href="#" onclick="showSection('categorias')">
                    <i class="fas fa-th-list"></i> Tipos e Categorias
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="#" onclick="showSection('bairro')">
                    <i class="fas fa-map-marker-alt"></i> Adicionar locais
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="#" onclick="showSection('planos')">
                    <i class="fas fa-file-invoice-dollar"></i> Planos
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="#" onclick="showSection('lojas')">
                    <i class="fas fa-store"></i> Lojas
                </a>
            </li>
        </ul>
    </div>

    <div class="content p-4" id="mainContent">
        <div id="categorias" class="content-section active">
            @include('admin.pages.tipos')

        </div>
        <div id="bairro" class="content-section">
            @include('admin.pages.locais')
        </div>
        <div id="planos" class="content-section">
            @include('admin.pages.planos')

        </div>
        <div id="lojas" class="content-section">
            @include('admin.pages.lojas')
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $("#toggleSidebar").click(function() {
                $("#sidebar").toggleClass("active");
                $(".content").toggleClass("active");
            });

            $("#logoutButton").click(function() {
                window.location.href = '/xxmigadmin/logout';
            });

            // Oculta a barra lateral ao clicar fora dela
            $(document).click(function(event) {
                var target = $(event.target);
                if (!target.closest('#sidebar').length && !target.closest('#toggleSidebar').length) {
                    if ($("#sidebar").hasClass("active")) {
                        $("#sidebar").removeClass("active");
                        $(".content").removeClass("active");
                    }
                }
            });
        });

        function showSection(section) {
            // Oculta todas as seções
            $(".content-section").removeClass("active").hide();
            // Exibe a seção correspondente
            $("#" + section).addClass("active").show();
        }
    </script>

</body>

</html>
