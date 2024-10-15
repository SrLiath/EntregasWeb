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
        background-image: url('https://via.placeholder.com/1200x200');
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
    </style>
</head>

<body>
    <div class="container-fluid p-0">
        <!-- Banner -->
        <div class="banner mb-4"></div>

        <!-- Foto de perfil e informações -->
        <div class="container text-center mb-5">
            <img src="https://via.placeholder.com/150" alt="Logo do restaurante" class="profile-pic mb-3">
            <h2 class="mt-3">Restaurante Moderno</h2>
            <p class="lead">Culinária contemporânea com ingredientes frescos e locais</p>
            <div class="d-flex justify-content-center align-items-center">
                <span class="me-3"><i class="fas fa-star text-warning"></i> 4.8 (203 avaliações)</span>
                <span class="me-3"><i class="fas fa-motorcycle text-secondary"></i> Entrega em 30-45 min</span>
                <span><i class="fas fa-tag text-success"></i> Frete grátis acima de R$ 50</span>
            </div>
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
            <ul class="nav nav-tabs mb-4" id="menuTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="entradas-tab" data-bs-toggle="tab" data-bs-target="#entradas"
                        type="button" role="tab" aria-controls="entradas" aria-selected="true">Entradas</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="principais-tab" data-bs-toggle="tab" data-bs-target="#principais"
                        type="button" role="tab" aria-controls="principais" aria-selected="false">Pratos
                        Principais</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="sobremesas-tab" data-bs-toggle="tab" data-bs-target="#sobremesas"
                        type="button" role="tab" aria-controls="sobremesas" aria-selected="false">Sobremesas</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="bebidas-tab" data-bs-toggle="tab" data-bs-target="#bebidas"
                        type="button" role="tab" aria-controls="bebidas" aria-selected="false">Bebidas</button>
                </li>
            </ul>
            <div class="tab-content" id="menuTabsContent">
                <div class="tab-pane fade show active" id="entradas" role="tabpanel" aria-labelledby="entradas-tab">
                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <div class="menu-item card" data-bs-toggle="modal" data-bs-target="#productModal"
                                data-name="Bruschetta" data-price="18.90"
                                data-description="Pão italiano com tomate, manjericão e azeite extra virgem"
                                data-image="https://via.placeholder.com/400x200?text=Bruschetta">
                                <img src="https://via.placeholder.com/400x200?text=Bruschetta" alt="Bruschetta"
                                    class="card-img-top">
                                <div class="card-body">
                                    <h5 class="card-title">Bruschetta</h5>
                                    <p class="card-text">Pão italiano com tomate, manjericão e azeite extra virgem</p>
                                    <p class="fw-bold mb-2">R$ 18,90</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="menu-item card" data-bs-toggle="modal" data-bs-target="#productModal"
                                data-name="Carpaccio" data-price="24.90"
                                data-description="Finas fatias de carne crua com molho de mostarda e alcaparras"
                                data-image="https://via.placeholder.com/400x200?text=Carpaccio">
                                <img src="https://via.placeholder.com/400x200?text=Carpaccio" alt="Carpaccio"
                                    class="card-img-top">
                                <div class="card-body">
                                    <h5 class="card-title">Carpaccio</h5>
                                    <p class="card-text">Finas fatias de carne crua com molho de mostarda e alcaparras
                                    </p>
                                    <p class="fw-bold mb-2">R$ 24,90</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="menu-item card" data-bs-toggle="modal" data-bs-target="#productModal"
                                data-name="Salada Caesar" data-price="22.90"
                                data-description="Alface romana, croutons, parmesão e molho Caesar"
                                data-image="https://via.placeholder.com/400x200?text=Salada+Caesar">
                                <img src="https://via.placeholder.com/400x200?text=Salada+Caesar" alt="Salada Caesar"
                                    class="card-img-top">
                                <div class="card-body">
                                    <h5 class="card-title">Salada Caesar</h5>
                                    <p class="card-text">Alface romana, croutons, parmesão e molho Caesar</p>
                                    <p class="fw-bold mb-2">R$ 22,90</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="principais" role="tabpanel" aria-labelledby="principais-tab">
                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <div class="menu-item card" data-bs-toggle="modal" data-bs-target="#productModal"
                                data-name="Feijoada Completa" data-price="39.90"
                                data-description="Prato típico brasileiro com arroz, farofa e couve"
                                data-image="https://via.placeholder.com/400x200?text=Feijoada">
                                <img src="https://via.placeholder.com/400x200?text=Feijoada" alt="Feijoada"
                                    class="card-img-top">
                                <div class="card-body">
                                    <h5 class="card-title">Feijoada Completa</h5>
                                    <p class="card-text">Prato típico brasileiro com arroz, farofa e couve</p>
                                    <p class="fw-bold mb-2">R$ 39,90</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="menu-item card" data-bs-toggle="modal" data-bs-target="#productModal"
                                data-name="Salmão Grelhado" data-price="45.90"
                                data-description="Salmão grelhado com legumes e molho de ervas"
                                data-image="https://via.placeholder.com/400x200?text=Salmão+Grelhado">
                                <img src="https://via.placeholder.com/400x200?text=Salmão+Grelhado"
                                    alt="Salmão Grelhado" class="card-img-top">
                                <div class="card-body">
                                    <h5 class="card-title">Salmão Grelhado</h5>
                                    <p class="card-text">Salmão grelhado com legumes e molho de ervas</p>
                                    <p class="fw-bold mb-2">R$ 45,90</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="menu-item card" data-bs-toggle="modal" data-bs-target="#productModal"
                                data-name="Risoto de Funghi" data-price="36.90"
                                data-description="Arroz arbóreo com mix de cogumelos e parmesão"
                                data-image="https://via.placeholder.com/400x200?text=Risoto+de+Funghi">
                                <img src="https://via.placeholder.com/400x200?text=Risoto+de+Funghi"
                                    alt="Risoto de Funghi" class="card-img-top">
                                <div class="card-body">
                                    <h5 class="card-title">Risoto de Funghi</h5>
                                    <p class="card-text">Arroz arbóreo com mix de cogumelos e parmesão</p>
                                    <p class="fw-bold mb-2">R$ 36,90</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="sobremesas" role="tabpanel" aria-labelledby="sobremesas-tab">
                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <div class="menu-item card" data-bs-toggle="modal" data-bs-target="#productModal"
                                data-name="Pudim de Leite" data-price="15.90"
                                data-description="Pudim cremoso de leite condensado com calda de caramelo"
                                data-image="https://via.placeholder.com/400x200?text=Pudim">
                                <img src="https://via.placeholder.com/400x200?text=Pudim" alt="Pudim"
                                    class="card-img-top">
                                <div class="card-body">
                                    <h5 class="card-title">Pudim de Leite</h5>
                                    <p class="card-text">Pudim cremoso de leite condensado com calda de caramelo</p>
                                    <p class="fw-bold mb-2">R$ 15,90</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="menu-item card" data-bs-toggle="modal" data-bs-target="#productModal"
                                data-name="Tiramisu" data-price="18.90"
                                data-description="Sobremesa italiana com café, queijo mascarpone e cacau"
                                data-image="https://via.placeholder.com/400x200?text=Tiramisu">
                                <img src="https://via.placeholder.com/400x200?text=Tiramisu" alt="Tiramisu"
                                    class="card-img-top">
                                <div class="card-body">
                                    <h5 class="card-title">Tiramisu</h5>
                                    <p class="card-text">Sobremesa italiana com café, queijo mascarpone e cacau</p>
                                    <p class="fw-bold mb-2">R$ 18,90</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="menu-item card" data-bs-toggle="modal" data-bs-target="#productModal"
                                data-name="Sorvete Artesanal" data-price="16.90"
                                data-description="Três bolas de sorvete artesanal com calda e frutas"
                                data-image="https://via.placeholder.com/400x200?text=Sorvete">
                                <img src="https://via.placeholder.com/400x200?text=Sorvete" alt="Sorvete"
                                    class="card-img-top">
                                <div class="card-body">
                                    <h5 class="card-title">Sorvete Artesanal</h5>
                                    <p class="card-text">Três bolas de sorvete artesanal com calda e frutas</p>
                                    <p class="fw-bold mb-2">R$ 16,90</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="bebidas" role="tabpanel" aria-labelledby="bebidas-tab">
                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <div class="menu-item card" data-bs-toggle="modal" data-bs-target="#productModal"
                                data-name="Caipirinha" data-price="16.90"
                                data-description="Clássico coquetel brasileiro com limão, açúcar e cachaça"
                                data-image="https://via.placeholder.com/400x200?text=Caipirinha">
                                <img src="https://via.placeholder.com/400x200?text=Caipirinha" alt="Caipirinha"
                                    class="card-img-top">
                                <div class="card-body">
                                    <h5 class="card-title">Caipirinha</h5>
                                    <p class="card-text">Clássico coquetel brasileiro com limão, açúcar e cachaça</p>
                                    <p class="fw-bold mb-2">R$ 16,90</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="menu-item card" data-bs-toggle="modal" data-bs-target="#productModal"
                                data-name="Suco Natural" data-price="9.90"
                                data-description="Suco de frutas frescas (laranja, abacaxi ou maracujá)"
                                data-image="https://via.placeholder.com/400x200?text=Suco+Natural">
                                <img src="https://via.placeholder.com/400x200?text=Suco+Natural" alt="Suco Natural"
                                    class="card-img-top">
                                <div class="card-body">
                                    <h5 class="card-title">Suco Natural</h5>
                                    <p class="card-text">Suco de frutas frescas (laranja, abacaxi ou maracujá)</p>
                                    <p class="fw-bold mb-2">R$ 9,90</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="menu-item card" data-bs-toggle="modal" data-bs-target="#productModal"
                                data-name="Vinho Tinto" data-price="22.90"
                                data-description="Taça de vinho tinto selecionado pelo sommelier"
                                data-image="https://via.placeholder.com/400x200?text=Vinho+Tinto">
                                <img src="https://via.placeholder.com/400x200?text=Vinho+Tinto" alt="Vinho Tinto"
                                    class="card-img-top">
                                <div class="card-body">
                                    <h5 class="card-title">Vinho Tinto</h5>
                                    <p class="card-text">Taça de vinho tinto selecionado pelo sommelier</p>
                                    <p class="fw-bold mb-2">R$ 22,90</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
                                <input type="number" class="form-control" id="quantity" value="1" min="1">
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
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Continuar Comprando</button>
                    <button type="button" class="btn btn-primary" id="checkout-btn">Finalizar Pedido</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
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
            const price = parseFloat(document.getElementById('productPrice').textContent.replace('R$ ',
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
                        <span>R$ ${(item.price * item.quantity).toFixed(2)}</span>
                        <button class="btn btn-sm btn-danger remove-item" data-index="${index}">
                            <i class="fas fa-trash"></i>
                        </button>
                    `;
                cartItems.appendChild(li);
                total += item.price * item.quantity;
            });
            cartTotal.textContent = `R$ ${total.toFixed(2)}`;
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
            alert('Pedido finalizado! Total: ' + cartTotal.textContent);
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