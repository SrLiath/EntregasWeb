<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurante Moderno</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #FF5A5F;
            --secondary-color: #00A699;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
        }

        .banner {
            height: 200px;
            background-image: url('{{ $loja->banner }}');
            background-size: cover;
            background-position: center;
        }

        .profile-pic {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            margin-top: -75px;
            border: 4px solid white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .menu-item {
            border: none;
            border-radius: 12px;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            cursor: pointer;
        }

        .menu-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .menu-item img {
            height: 200px;
            object-fit: cover;
        }

        .nav-tabs {
            flex-wrap: nowrap;
            overflow-x: auto;
            overflow-y: hidden;
            -webkit-overflow-scrolling: touch;
            -ms-overflow-style: -ms-autohiding-scrollbar;
            white-space: nowrap;
        }

        .nav-tabs::-webkit-scrollbar {
            display: none;
        }

        .nav-tabs .nav-link {
            color: #495057;
            border: none;
            padding: 10px 20px;
            margin-right: 5px;
            border-radius: 20px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .nav-tabs .nav-link.active {
            background-color: var(--primary-color);
            color: white;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: #ff4146;
            border-color: #ff4146;
        }

        #cart-badge {
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: var(--primary-color);
            color: white;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        #cart-badge:hover {
            transform: scale(1.1);
        }

        .card {
            max-height: 360px;
            min-height: 360px;
        }
    </style>
</head>

<body>
    <div class="container-fluid p-0">
        <!-- Banner -->
        <div class="banner mb-4"></div>

        <!-- Foto de perfil e informações -->
        <div class="container text-center mb-5">
            <img src="{{ $loja->imagem }}" alt="Logo do restaurante" class="profile-pic mb-3">
            <h2 class="mt-3">{{ $loja->nome }}</h2>
            <p class="lead">{{ $loja->descricao }}</p>
            <div class="d-flex justify-content-center align-items-center">
                @if ($loja->qntsNotas > 0)
                    <span class="me-3">
                        <i class="fas fa-star text-warning"></i>
                        {{ $loja->totalNotas / $loja->qntsNotas }} ({{ $loja->qntsNotas }} avaliações)
                    </span>
                @endif

                <span class="me-3">
                    @if ($loja->tempo != '' && $loja->tempo != null)
                        <i class="fas fa-motorcycle text-secondary"></i>
                        {{ $loja->tempo }}
                    @endif

                </span>

                <span>
                    <i class="fas fa-tag text-success"></i>

                    @if ($loja->frete > 0)
                        Frete {{ $loja->frete }}
                    @else
                        Sem frete
                    @endif
                </span>
            </div>

        </div>
        <div class="d-flex justify-content-center my-4">
            @if (!empty($loja->site))
                <a href="{{ $loja->site }}" target="_blank" class="text-decoration-none mx-2">
                    <i class="fas fa-globe fa-lg"></i> <!-- Ícone do site -->
                </a>
            @endif

            @if (!empty($loja->insta))
                <a href="{{ $loja->insta }}" target="_blank" class="text-decoration-none mx-2">
                    <i class="fab fa-instagram fa-lg"></i> <!-- Ícone do Instagram -->
                </a>
            @endif

            @if (!empty($loja->fb))
                <a href="{{ $loja->fb }}" target="_blank" class="text-decoration-none mx-2">
                    <i class="fab fa-facebook fa-lg"></i> <!-- Ícone do Facebook -->
                </a>
            @endif

        </div>

        <!-- Campo de busca -->
        <div class="container mb-5">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Buscar item..." id="search-input">
                        <button class="btn btn-primary" type="button" id="search-button">
                            <i class="fas fa-search"></i> Buscar
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sistema de tabs -->
        <div class="container">
            <ul class="nav nav-tabs mb-4" id="menuTabs" role="tablist"></ul>
            <div class="tab-content" id="menuTabsContent"></div>
        </div>

        <!-- Modal do produto -->
        <div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="productModalLabel">Detalhes do Produto</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <img id="productImage" src="" alt="Imagem do Produto" class="img-fluid rounded">
                            </div>
                            <div class="col-md-6">
                                <h3 id="productName"></h3>
                                <p id="productDescription"></p>
                                <p class="fw-bold" id="productPrice"></p>
                                <div class="mb-3">
                                    <label for="quantity" class="form-label">Quantidade:</label>
                                    <input type="number" class="form-control" id="quantity" value="1"
                                        min="1">
                                </div>
                                <div class="mb-3">
                                    <label for="note" class="form-label">Nota (opcional):</label>
                                    <textarea class="form-control" id="note" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        <button type="button" class="btn btn-primary" id="addToCartBtn">Adicionar ao Carrinho</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Carrinho de compras -->
        <div id="cart-badge" data-bs-toggle="modal" data-bs-target="#cartModal">
            <i class="fas fa-shopping-cart"></i> <span id="cart-count">0</span>
        </div>

        <!-- Modal do carrinho -->
        <div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="cartModalLabel">Seu Carrinho</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <ul id="cart-items" class="list-group mb-3">
                            <!-- Itens do carrinho serão adicionados aqui dinamicamente -->
                        </ul>
                        <div class="d-flex justify-content-between">
                            <span class="fw-bold">Total:</span>
                            <span id="cart-total" class="fw-bold">R$ 0,00</span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Continuar
                            Comprando</button>
                        <button type="button" class="btn btn-primary" id="checkout-btn">Finalizar Pedido</button>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            const data = {!! $loja->produtos !!}
            document.addEventListener('DOMContentLoaded', function() {
                const menuTabs = document.getElementById('menuTabs');
                const menuTabsContent = document.getElementById('menuTabsContent');

                // Criar abas e conteúdo com base no JSON
                data.categorias.forEach((categoria, index) => {
                    // Criar aba
                    const tabButton = document.createElement('li');
                    tabButton.className = 'nav-item';
                    tabButton.innerHTML = `
            <button class="nav-link ${index === 0 ? 'active' : ''}" id="${categoria.nome.toLowerCase()}-tab"
                data-bs-toggle="tab" data-bs-target="#${categoria.nome.toLowerCase()}" type="button"
                role="tab" aria-controls="${categoria.nome.toLowerCase()}" aria-selected="${index === 0}">
                ${categoria.nome}
            </button>
        `;
                    menuTabs.appendChild(tabButton);

                    // Criar conteúdo da aba
                    const tabContent = document.createElement('div');
                    tabContent.className = `tab-pane fade ${index === 0 ? 'show active' : ''}`;
                    tabContent.id = categoria.nome.toLowerCase();
                    tabContent.setAttribute('role', 'tabpanel');
                    tabContent.setAttribute('aria-labelledby', `${categoria.nome.toLowerCase()}-tab`);

                    // Adicionar a div row para os produtos
                    const rowDiv = document.createElement('div');
                    rowDiv.className = 'row';

                    // Adicionar produtos à aba no novo formato
                    categoria.produtos.forEach(produto => {
                        const productCard = document.createElement('div');
                        productCard.className = 'col-md-4 mb-4';
                        productCard.innerHTML = `
                <div class="menu-item card" data-bs-toggle="modal" data-bs-target="#productModal"
                    data-name="${produto.nome}" data-price="${produto.preco}"
                    data-description="${produto.descricao}"
                    data-image="${produto.foto}">
                    <img src="${produto.foto}" alt="${produto.nome}" class="card-img-top">
                    <div class="card-body">
                        <h5 class="card-title">${produto.nome}</h5>
                        <p class="card-text">${produto.descricao}</p>
                        <p class="fw-bold mb-2">R$ ${produto.preco}</p>
                    </div>
                </div>
            `;
                        rowDiv.appendChild(productCard);
                    });

                    // Adicionar a row com produtos ao conteúdo da aba
                    tabContent.appendChild(rowDiv);
                    menuTabsContent.appendChild(tabContent);
                });
            });

            // Função para mostrar os detalhes do produto no modal
            document.addEventListener('click', function(event) {
                if (event.target.closest('.menu-item')) {
                    const productCard = event.target.closest('.menu-item');
                    const productName = productCard.getAttribute('data-name');
                    const productPrice = productCard.getAttribute('data-price');
                    const productDescription = productCard.getAttribute('data-description');
                    const productImage = productCard.getAttribute('data-image');

                    document.getElementById('productModalLabel').innerText = productName;
                    document.getElementById('productImage').src = productImage;
                    document.getElementById('productDescription').innerText = productDescription;
                    document.getElementById('productPrice').innerText = `R$ ${productPrice}`;
                }
            });


            document.addEventListener('DOMContentLoaded', function() {
                const cart = [];
                const productModal = document.getElementById('productModal');
                const cartItems = document.getElementById('cart-items');
                const cartTotal = document.getElementById('cart-total');
                const cartCount = document.getElementById('cart-count');
                const checkoutBtn = document.getElementById('checkout-btn');
                const searchInput = document.getElementById('search-input');
                const searchButton = document.getElementById('search-button');
                const addToCartBtn = document.getElementById('addToCartBtn');

                productModal.addEventListener('show.bs.modal', function(event) {
                    const button = event.relatedTarget;
                    const name = button.getAttribute('data-name');
                    const price = button.getAttribute('data-price');
                    const description = button.getAttribute('data-description');
                    const image = button.getAttribute('data-image');

                    document.getElementById('productName').textContent = name;
                    document.getElementById('productDescription').textContent = description;
                    document.getElementById('productPrice').textContent = `R$ ${price}`;
                    document.getElementById('productImage').src = image;
                    document.getElementById('quantity').value = 1;
                    document.getElementById('note').value = '';
                });

                addToCartBtn.addEventListener('click', function() {
                    const name = document.getElementById('productName').textContent;
                    const price = parseFloat(document.getElementById('productPrice').textContent.replace(
                        'R$ ',
                        ''));
                    const quantity = parseInt(document.getElementById('quantity').value);
                    const note = document.getElementById('note').value;

                    addToCart(name, price, quantity, note);
                    const modal = bootstrap.Modal.getInstance(productModal);
                    modal.hide();
                });

                function addToCart(name, price, quantity, note) {
                    const existingItem = cart.find(item => item.name === name && item.note === note);
                    if (existingItem) {
                        existingItem.quantity += quantity;
                    } else {
                        cart.push({
                            name,
                            price,
                            quantity,
                            note
                        });
                    }
                    updateCart();
                }

                function updateCart() {
                    cartItems.innerHTML = '';
                    let total = 0;
                    cart.forEach((item, index) => {
                        const li = document.createElement('li');
                        li.className = 'list-group-item d-flex justify-content-between align-items-center';
                        li.innerHTML = `
                        <div>
                            <h6 class="my-0">${item.name}</h6>
                            <small class="text-muted">Quantidade: ${item.quantity}</small>
                            ${item.note ? `<small class="text-muted d-block">Nota: ${item.note}</small>` : ''}
                        </div>
                        <span>R$ ${(item.price * item.quantity)}</span>
                        <button class="btn btn-sm btn-danger remove-item" data-index="${index}">
                            <i class="fas fa-trash"></i>
                        </button>
                    `;
                        cartItems.appendChild(li);
                        total += item.price * item.quantity;
                    });
                    cartTotal.textContent = `R$ ${total}`;
                    cartCount.textContent = cart.reduce((sum, item) => sum + item.quantity, 0);

                    // Add event listeners to remove buttons
                    document.querySelectorAll('.remove-item').forEach(button => {
                        button.addEventListener('click', function() {
                            const index = this.getAttribute('data-index');
                            cart.splice(index, 1);
                            updateCart();
                        });
                    });
                }

                checkoutBtn.addEventListener('click', function() {
                    let cartDetails =
                        `Pedido finalizado! \n\nItens do carrinho:\n`;

                    cart.forEach(item => {
                        cartDetails +=
                            `${item.name} - Quantidade: ${item.quantity} - R$ ${(item.price * item.quantity)}`;
                        if (item.note) {
                            cartDetails += ` (Nota: ${item.note})`;
                        }
                        cartDetails += `\n`;
                    });

                    cartDetails += `\nTotal do pedido: ${cartTotal.textContent}`;
                    const message = encodeURIComponent(cartDetails.trim());
                    const phoneNumber = '5511932849265';


                    const whatsappUrl = `https://wa.me/${phoneNumber}?text=${message}`;
                    window.open(whatsappUrl, '_blank');
                    cart.length = 0;
                    updateCart();
                });

                function searchItems() {
                    const searchTerm = searchInput.value.toLowerCase();
                    const menuItems = document.querySelectorAll('.menu-item');
                    menuItems.forEach(item => {
                        const itemName = item.querySelector('.card-title').textContent.toLowerCase();
                        const itemDescription = item.querySelector('.card-text').textContent.toLowerCase();
                        if (itemName.includes(searchTerm) || itemDescription.includes(searchTerm)) {
                            item.style.display = 'block';
                        } else {
                            item.style.display = 'none';
                        }
                    });
                }

                searchButton.addEventListener('click', searchItems);
                searchInput.addEventListener('keyup', function(event) {
                    if (event.key === 'Enter') {
                        searchItems();
                    }
                });
            });
        </script>
</body>

</html>
