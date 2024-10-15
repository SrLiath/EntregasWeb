<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Sidebar e Barra Inferior</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Estilo customizado para o menu */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            height: 100%;
            background-color: #f7f7f7;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.2);
            z-index: 100;
        }

        .sidebar .nav-link {
            color: #72739f;
            padding: 20px;
            text-align: left;
            font-size: 1.1em;
        }

        .sidebar .nav-link .fa {
            margin-right: 10px;
            font-size: 1.5em;
        }

        .sidebar .nav-link.active,
        .sidebar .nav-link:hover {
            background-color: #267fdd;
            color: white !important;
        }

        /* Barra inferior customizada para mobile */
        .menu-bar {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            background-color: #f7f7f7;
            box-shadow: 0px -2px 10px rgba(0, 0, 0, 0.2);
            z-index: 100;
        }

        .menu-bar .nav-link {
            color: #72739f;
            padding: 10px;
            text-align: center;
            font-size: 0.9em;
        }

        .menu-bar .nav-link .fa {
            display: block;
            font-size: 1.2em;
            margin-bottom: 3px;
        }

        .menu-bar .nav-link.active,
        .menu-bar .nav-link:hover {
            background-color: #267fdd;
            color: white !important;
        }

        /* Esconde o menu sidebar em telas menores */
        @media (max-width: 1000px) {
            .sidebar {
                display: none;
            }
        }

        /* Esconde a barra inferior em telas maiores */
        @media (min-width: 1000px) {
            .menu-bar {
                display: none;
            }
        }
    </style>
</head>

<body>

    <!-- Sidebar fixa para desktop -->
    <div class="sidebar d-none d-md-block">
        <ul class="nav flex-column mt-3">
            <li class="nav-item">
                <a href="#" class="nav-link active">
                    <i class="fa fa-home"></i>
                    Home
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fa fa-search"></i>
                    Pedidos
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fa fa-list"></i>
                    Categorias
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fa fa-box"></i>
                    Produtos
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fa fa-user"></i>
                    Meus dados
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fa fa-life-ring"></i>
                    Suporte
                </a>
            </li>
        </ul>
    </div>

    <!-- Barra inferior para mobile com hambúrguer -->
    <nav class="navbar fixed-bottom bg-light menu-bar d-md-none">
        <ul class="nav nav-pills justify-content-around w-100">
            <li class="nav-item">
                <a href="#" class="nav-link active">
                    <i class="fa fa-home"></i>
                    Home
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fa fa-search"></i>
                    Pedidos
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fa fa-list"></i>
                    Categorias
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fa fa-box"></i>
                    Produtos
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fa fa-user"></i>
                    Meus dados
                </a>
            </li>
            <!-- Ícone do menu hambúrguer como item da barra inferior -->
            <li class="nav-item">
                <a href="#" class="nav-link" data-bs-toggle="collapse" data-bs-target="#menuMobile">
                    <i class="fa fa-bars"></i>
                    Menu
                </a>
            </li>
        </ul>
    </nav>

    <!-- Menu expansível (apenas para mobile) -->
    <div class="collapse full-menu d-md-none" id="menuMobile">
        <ul class="nav nav-pills flex-column menu-bar">
            <li class="nav-item">
                <a href="#" class="nav-link active" data-bs-dismiss="collapse">
                    <i class="fa fa-home"></i>
                    Home
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link" data-bs-dismiss="collapse">
                    <i class="fa fa-search"></i>
                    Pedidos
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link" data-bs-dismiss="collapse">
                    <i class="fa fa-list"></i>
                    Categorias
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link" data-bs-dismiss="collapse">
                    <i class="fa fa-box"></i>
                    Produtos
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link" data-bs-dismiss="collapse">
                    <i class="fa fa-user"></i>
                    Meus dados
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link" data-bs-dismiss="collapse">
                    <i class="fa fa-life-ring"></i>
                    Suporte
                </a>
            </li>
        </ul>
    </div>

    <!-- Bootstrap JS e dependências -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Fecha o menu ao clicar fora dele
        document.addEventListener('click', function(event) {
            const menuMobile = document.getElementById('menuMobile');
            const toggleButton = document.querySelector('[data-bs-target="#menuMobile"]');

            // Verifica se o clique foi fora do menu e do botão de alternância
            if (menuMobile.classList.contains('show') && !menuMobile.contains(event.target) && !toggleButton
                .contains(event.target)) {
                const bsCollapse = new bootstrap.Collapse(menuMobile, {
                    toggle: false
                });
                bsCollapse.hide();
            }
        });
    </script>
</body>

</html>
