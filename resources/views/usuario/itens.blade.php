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

@include('usuario.templates.menu', ['menu' => 'item'])
<div class="conteudo">
    <!DOCTYPE html>
    <html lang="pt-BR">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Gerenciador de Categorias e Itens</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.3.12/themes/default/style.min.css" rel="stylesheet">
        <style>
            body {
                background-color: #f8f9fa;
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            }

            .tab-content {
                background-color: #ffffff;
                border: 1px solid #dee2e6;
                border-top: none;
                border-radius: 0 0 0.25rem 0.25rem;
                padding: 20px;
            }

            .nav-tabs .nav-link {
                color: #495057;
            }

            .nav-tabs .nav-link.active {
                font-weight: bold;
            }

            .item-list {
                list-style-type: none;
                padding: 0;
            }

            .item-list li {
                background-color: #f1f3f5;
                border-radius: 0.25rem;
                margin-bottom: 10px;
                padding: 10px;
            }

            .item-image {
                max-width: 100px;
                max-height: 100px;
                object-fit: cover;
                margin-right: 10px;
                cursor: pointer;
            }

            .switch {
                position: relative;
                display: inline-block;
                width: 60px;
                height: 34px;
            }

            .switch input {
                opacity: 0;
                width: 0;
                height: 0;
            }

            .slider {
                position: absolute;
                cursor: pointer;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: #ccc;
                transition: .4s;
                border-radius: 34px;
            }

            .slider:before {
                position: absolute;
                content: "";
                height: 26px;
                width: 26px;
                left: 4px;
                bottom: 4px;
                background-color: white;
                transition: .4s;
                border-radius: 50%;
            }

            input:checked+.slider {
                background-color: #2196F3;
            }

            input:checked+.slider:before {
                transform: translateX(26px);
            }

            #treeView {
                margin-top: 20px;
            }

            .modal-image {
                max-width: 100%;
                max-height: 400px;
                object-fit: contain;
            }
        </style>
    </head>

    <body>
        <div class="container mt-5">
            <h1 class="text-center mb-4">Gerenciador de Categorias e Itens</h1>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="d-flex align-items-center">
                    <label class="switch me-2">
                        <input type="checkbox" id="viewModeSwitch">
                        <span class="slider"></span>
                    </label>
                    <span>Modo pasta</span>
                </div>
                <div>
                    <button id="addCategoryBtn" class="btn btn-primary me-2">
                        <i class="fas fa-plus"></i> Adicionar Categoria
                    </button>
                    <button id="addItemBtn" class="btn btn-success">
                        <i class="fas fa-plus"></i> Adicionar Item
                    </button>
                </div>
            </div>
            <div id="tabView">
                <ul class="nav nav-tabs" id="categoryTabs" role="tablist"></ul>
                <div class="tab-content" id="categoryTabsContent"></div>
            </div>
            <div id="treeView" style="display: none;"></div>
        </div>

        <!-- Modal para adicionar categoria -->
        <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Adicionar Categoria</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addCategoryForm">
                            <div class="mb-3">
                                <label for="categoryName" class="form-label">Nome da Categoria</label>
                                <input type="text" class="form-control" id="categoryName" required>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        <button type="button" class="btn btn-primary" id="saveCategoryBtn">Salvar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal para adicionar item -->
        <div class="modal fade" id="addItemModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Adicionar Item</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addItemForm">
                            <div class="mb-3">
                                <label for="itemCategory" class="form-label">Categoria</label>
                                <select class="form-select" id="itemCategory" required></select>
                            </div>
                            <div class="mb-3">
                                <label for="itemName" class="form-label">Nome do Item</label>
                                <input type="text" class="form-control" id="itemName" required>
                            </div>
                            <div class="mb-3">
                                <label for="itemDescription" class="form-label">Descrição</label>
                                <textarea class="form-control" id="itemDescription" rows="3" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="itemPrice" class="form-label">Preço</label>
                                <input type="number" class="form-control" id="itemPrice" step="0.01" min="0" required>
                            </div>
                            <div class="mb-3">
                                <label for="itemImage" class="form-label">Foto do Item</label>
                                <input type="file" class="form-control" id="itemImage" accept="image/*" required>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        <button type="button" class="btn btn-primary" id="saveItemBtn">Salvar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal para exibir detalhes do item -->
        <div class="modal fade" id="itemDetailsModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="itemDetailsTitle"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="itemCarousel" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <!-- Slides will be dynamically added here -->
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#itemCarousel"
                                data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Anterior</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#itemCarousel"
                                data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Próximo</span>
                            </button>
                        </div>
                        <div class="mt-3">
                            <h6>Categoria: <span id="itemDetailsCategory"></span></h6>
                            <h6>Preço: R$ <span id="itemDetailsPrice"></span></h6>
                            <p id="itemDetailsDescription"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.3.12/jstree.min.js"></script>
        <script>
            $(document).ready(function () {
                let categories = [];
                let items = {};
                let activeCategory = null;

                function updateCategoryTabs() {
                    $('#categoryTabs').empty();
                    $('#categoryTabsContent').empty();
                    $('#itemCategory').empty();

                    categories.forEach((category, index) => {
                        const isActive = category === activeCategory ? 'active' : '';
                        $('#categoryTabs').append(`
                        <li class="nav-item" role="presentation">
                            <button class="nav-link ${isActive}" id="tab-${category}" data-bs-toggle="tab" 
                                    data-bs-target="#content-${category}" type="button" role="tab">
                                ${category}
                            </button>
                        </li>
                    `);

                        $('#categoryTabsContent').append(`
                        <div class="tab-pane fade ${isActive ? 'show active' : ''}" id="content-${category}" role="tabpanel">
                            <ul class="item-list" id="items-${category}"></ul>
                        </div>
                    `);

                        $('#itemCategory').append(`<option value="${category}">${category}</option>`);

                        if (items[category]) {
                            items[category].forEach((item, itemIndex) => {
                                $(`#items-${category}`).append(`
                                <li class="d-flex align-items-start">
                                    <img src="${item.image}" alt="${item.name}" class="item-image" data-category="${category}" data-index="${itemIndex}">
                                    <div>
                                        <strong>${item.name}</strong> - R$ ${item.price.toFixed(2)}
                                        <p>${item.description}</p>
                                    </div>
                                </li>
                            `);
                            });
                        }
                    });

                    $('.nav-link').on('click', function () {
                        activeCategory = $(this).text().trim();
                    });

                    $('.item-image').on('click', function () {
                        const category = $(this).data('category');
                        const index = $(this).data('index');
                        showItemDetails(category, index);
                    });
                }

                function updateTreeView() {
                    const treeData = categories.map(category => {
                        return {
                            text: category,
                            children: items[category] ? items[category].map((item, index) => ({
                                text: `${item.name} - R$ ${item.price.toFixed(2)}`,
                                icon: item.image,
                                data: { category, index }
                            })) : []
                        };
                    });

                    $('#treeView').jstree('destroy');
                    $('#treeView').jstree({
                        'core': {
                            'data': treeData
                        },
                        'plugins': ['types'],
                        'types': {
                            'default': {
                                'icon': 'fas fa-folder'
                            }
                        }
                    }).on('select_node.jstree', function (e, data) {
                        if (data.node.children.length === 0) {
                            const { category, index } = data.node.original.data;
                            showItemDetails(category, index);
                        }
                    });
                }

                function showItemDetails(category, index) {
                    const item = items[category][index];
                    $('#itemDetailsTitle').text(item.name);
                    $('#itemDetailsCategory').text(category);
                    $('#itemDetailsPrice').text(item.price.toFixed(2));
                    $('#itemDetailsDescription').text(item.description);

                    const carouselInner = $('#itemCarousel .carousel-inner');
                    carouselInner.empty();

                    items[category].forEach((carouselItem, carouselIndex) => {
                        const activeClass = carouselIndex === index ? 'active' : '';
                        carouselInner.append(`
                        <div class="carousel-item ${activeClass}">
                            <img src="${carouselItem.image}" class="d-block w-100 modal-image" alt="${carouselItem.name}">
                        </div>
                    `);
                    });

                    $('#itemDetailsModal').modal('show');
                }

                function updateView() {
                    if ($('#viewModeSwitch').is(':checked')) {
                        $('#tabView').hide();
                        $('#treeView').show();
                        updateTreeView();
                    } else {
                        $('#treeView').hide();
                        $('#tabView').show();
                        updateCategoryTabs();
                    }
                }

                $('#viewModeSwitch').change(updateView);

                $('#addCategoryBtn').click(function () {

                    $('#addCategoryModal').modal('show');
                });

                $('#saveCategoryBtn').click(function () {
                    const categoryName = $('#categoryName').val().trim();
                    if (categoryName && !categories.includes(categoryName)) {
                        categories.push(categoryName);
                        items[categoryName] = [];
                        activeCategory = categoryName;
                        updateView();
                        $('#addCategoryModal').modal('hide');
                        $('#categoryName').val('');
                        Swal.fire('Sucesso', 'Categoria adicionada com sucesso!', 'success');
                    } else {
                        Swal.fire('Erro', 'Nome de categoria inválido ou já existe!', 'error');
                    }
                });

                $('#addItemBtn').click(function () {
                    if (categories.length === 0) {
                        Swal.fire('Erro', 'Adicione uma categoria primeiro!', 'error');
                    } else {
                        $('#itemCategory').val(activeCategory);
                        $('#addItemModal').modal('show');
                    }
                });

                $('#saveItemBtn').click(function () {
                    const category = $('#itemCategory').val();
                    const itemName = $('#itemName').val().trim();
                    const itemDescription = $('#itemDescription').val().trim();
                    const itemPrice = parseFloat($('#itemPrice').val());
                    const itemImageFile = $('#itemImage')[0].files[0];

                    if (category && itemName && itemDescription && !isNaN(itemPrice) && itemImageFile) {
                        const reader = new FileReader();
                        reader.onload = function (e) {
                            const newItem = {
                                name: itemName,
                                description: itemDescription,
                                price: itemPrice,
                                image: e.target.result
                            };
                            items[category].push(newItem);
                            updateView();
                            $('#addItemModal').modal('hide');
                            $('#itemName').val('');
                            $('#itemDescription').val('');
                            $('#itemPrice').val('');
                            $('#itemImage').val('');
                            Swal.fire('Sucesso', 'Item adicionado com sucesso!', 'success');
                        };
                        reader.readAsDataURL(itemImageFile);
                    } else {
                        Swal.fire('Erro', 'Preencha todos os campos corretamente!', 'error');
                    }
                });

                updateView();
            });
        </script>
    </body>

    </html>
</div>