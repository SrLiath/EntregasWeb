<div class="container">
    <h2 class="mt-4">Tipos e categorias cadastradas</h2>

    <!-- Botão para adicionar nova categoria -->
    <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addModal">+ Adicionar Tipo</button>

    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Tipo</th>
                <th class="text-center">Ações - Editar</th>
                <th class="text-center">Ações - Excluir</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tipos as $tipo)
                <tr>
                    <td>{{ $tipo->tipo }}</td>
                    <td class="text-center">
                        <button class="btn btn-primary edit-btn" data-bs-toggle="modal" data-bs-target="#editModal"
                            data-id="{{ $tipo->id }}" data-name="Categoria A">Editar</button>
                    </td>
                    <td class="text-center">
                        <button class="btn btn-danger delete-btn" data-id="{{ $tipo->id }}"
                            data-name="Categoria A">Excluir</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal de Edição -->
<!-- Modal Principal de Categorias -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="categoriesModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="categoriesModalLabel">Gerenciar Categorias</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal"
                    data-bs-target="#addCategoryModal">
                    Adicionar Categoria
                </button>
                <ul class="list-group" id="categoryList">

                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Adicionar Nova Categoria -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCategoryModalLabel">Adicionar Nova Categoria</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="text" class="form-control" id="newCategoryNameaaa" placeholder="Nome da Nova Categoria">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="saveNewCategory">Salvar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Adição -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Adicionar Nova Categoria</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="text" class="form-control" id="newCategoryName" placeholder="Nome da Nova Categoria">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-success" id="addCategoryBtn">Adicionar Categoria</button>
            </div>
        </div>
    </div>
</div>

<!-- Incluindo SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function () {
        var botaoedit
        $('.edit-btn').on('click', function () {
            var tipoId = $(this).data('id'); // Captura o ID do tipo
            botaoedit = tipoId
            // Faz a requisição AJAX para buscar as categorias associadas
            $.ajax({
                url: '/tipos/categorias', // URL da rota POST
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}', // Token CSRF do Laravel
                    id_tipo: tipoId // Envia o ID do tipo
                },
                success: function (response) {
                    // Limpa a lista de categorias no modal
                    $('#categoryList').empty();

                    // Itera sobre as categorias retornadas e adiciona à lista
                    response.forEach(function (categoria) {
                        $('#categoryList').append(`
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            ${categoria.categoria}
                            <button class="btn btn-danger btn-sm delete-category-btn" data-id="${categoria.id}">Deletar</button>
                        </li>
                    `);
                    });

                    // Abre o modal após carregar as categorias
                    $('#editModal').modal('show');
                },
                error: function (xhr) {
                    // Exibe erro no console
                    console.error('Erro ao buscar categorias:', xhr.responseText);
                }
            });
        });

        // Lógica para salvar alterações
        $('#saveChanges').on('click', function () {
            var newName = $('#categoryName').val();
            $('#editModal').modal('hide');
        });

        // Quando o botão de excluir é clicado
        $('.delete-btn').on('click', function () {
            var id = $(this).data('id'); // Pega o ID da categoria
            var row = $(this).closest('tr'); // A linha da tabela para remover depois
            var name = $(this).data('name'); // Nome da categoria

            // Exibe o alerta de confirmação usando SweetAlert
            Swal.fire({
                title: 'Você tem certeza?',
                text: "Você não poderá reverter isso!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sim, excluir!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Faz a requisição AJAX para deletar a categoria
                    $.ajax({
                        url: '/tipos/' + id,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}' // Necessário para o Laravel CSRF
                        },
                        success: function (response) {
                            // Se o delete for bem-sucedido, remove a linha da tabela
                            row.remove();

                            // Exibe a mensagem de sucesso
                            Swal.fire(
                                'Excluído!',
                                name + ' foi excluído com sucesso.',
                                'success'
                            );
                        },
                        error: function (xhr) {
                            // Tratamento de erro
                            alert('Ocorreu um erro ao excluir a categoria.');
                            console.error('Erro ao excluir categoria:');
                            console.error('Status: ' + xhr.status); // Status HTTP
                            console.error('Texto do Status: ' + xhr
                                .statusText); // Texto de erro
                            console.error('Resposta do Servidor: ' + xhr
                                .responseText); // Detalhes da resposta
                        }
                    });
                }
            });
        });

        $('#addCategory').click(function () {
            // Captura o nome da nova categoria
            var newCategoryName = $('#newCategoryName').val();

            // Verifica se o campo não está vazio
            if (newCategoryName.trim() === '') {
                alert('Por favor, insira o nome da categoria.');
                return;
            }

            // Faz a requisição AJAX para a rota de criação
            $.ajax({
                url: '/tipos',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    tipo: newCategoryName
                },
                success: function (response) {
                    alert('Categoria adicionada com sucesso!');
                    $('#addModal').modal('hide');
                    $('#newCategoryName').val('');
                    $('table tbody').append(`
                        <tr>
                            <td>${response.data.tipo}</td>
                            <td class="text-center">
                                <button class="btn btn-primary edit-btn" data-bs-toggle="modal" data-bs-target="#editModal" data-id="${response.data.id}" data-name="${response.data.tipo}">Editar</button>
                            </td>
                            <td class="text-center">
                                <button class="btn btn-danger delete-btn" data-id="${response.data.id}" data-name="${response.data.tipo}">Excluir</button>
                            </td>
                        </tr>
                    `);
                },
                error: function (xhr) {
                    alert('Ocorreu um erro ao adicionar a categoria.');
                    console.error('Erro ao adicionar categoria:');
                    console.error('Status: ' + xhr.status); // Status HTTP (ex: 404, 500)
                    console.error('Texto do Status: ' + xhr
                        .statusText
                    ); // Texto da resposta (ex: Not Found, Internal Server Error)
                    console.error('Resposta do Servidor: ' + xhr
                        .responseText
                    ); // Resposta completa do servidor (ex: mensagem detalhada do erro)

                }
            });
        });

        $('#saveNewCategory').on('click', function () {
            var novaCategoria = $('#newCategoryNameaaa').val();

            if (novaCategoria.trim() === '') {
                alert('Por favor, insira o nome da categoria.');
                return;
            }

            $.ajax({
                url: '/tipos/categorias/add',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id_tipo: botaoedit,
                    categoria: novaCategoria
                },
                success: function (response) {
                    $('#categoryList').append(`
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        ${response.categoria}
                        <button class="btn btn-danger btn-sm delete-category-btn" data-id="${response.id}">Deletar</button>
                    </li>
                `);

                    $('#newCategoryNameaaa').val('');

                    // Exibe mensagem de sucesso
                    alert('Categoria adicionada com sucesso!');
                },
                error: function (xhr) {
                    // Exibe erro no console
                    console.error('Erro ao adicionar categoria:', xhr.responseText);
                }
            });
        });
        $(document).on('click', '.delete-category-btn', function () {
            var categoryId = $(this).data('id'); // Get the ID of the category
            var listItem = $(this).closest('li'); // Get the list item for the category

            // Show confirmation dialog using SweetAlert
            Swal.fire({
                title: 'Você tem certeza?',
                text: "Você não poderá reverter isso!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sim, excluir!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Make AJAX request to delete the category
                    $.ajax({
                        url: '/tipos/categorias/' + categoryId,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}' // CSRF token for security
                        },
                        success: function (response) {
                            // Remove the category from the list
                            listItem.remove();

                            // Show success message
                            Swal.fire(
                                'Deletado!',
                                response.message,
                                'success'
                            );
                        },
                        error: function (xhr) {
                            // Handle error
                            Swal.fire(
                                'Erro!',
                                'Ocorreu um erro ao deletar a categoria.',
                                'error'
                            );
                            console.error('Erro ao deletar categoria:', xhr
                                .responseText);
                        }
                    });
                }
            });
        });
    });
</script>