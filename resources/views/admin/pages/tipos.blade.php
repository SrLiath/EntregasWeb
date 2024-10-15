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
            <tr>
                <td>Categoria A</td>
                <td class="text-center">
                    <button class="btn btn-primary edit-btn" data-bs-toggle="modal" data-bs-target="#editModal"
                        data-name="Categoria A">Editar</button>
                </td>
                <td class="text-center">
                    <button class="btn btn-danger delete-btn" data-name="Categoria A">Excluir</button>
                </td>
            </tr>
            <tr>
                <td>Categoria B</td>
                <td class="text-center">
                    <button class="btn btn-primary edit-btn" data-bs-toggle="modal" data-bs-target="#editModal"
                        data-name="Categoria B">Editar</button>
                </td>
                <td class="text-center">
                    <button class="btn btn-danger delete-btn" data-name="Categoria B">Excluir</button>
                </td>
            </tr>
            <tr>
                <td>Categoria C</td>
                <td class="text-center">
                    <button class="btn btn-primary edit-btn" data-bs-toggle="modal" data-bs-target="#editModal"
                        data-name="Categoria C">Editar</button>
                </td>
                <td class="text-center">
                    <button class="btn btn-danger delete-btn" data-name="Categoria C">Excluir</button>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<!-- Modal de Edição -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Editar Categoria</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="text" class="form-control" id="categoryName" placeholder="Nome da Categoria">
                <div class="category-list">
                    <h6>Categorias Relacionadas:</h6>
                    <ul id="relatedCategories" class="list-group">
                        <li class="list-group-item">Categoria X</li>
                        <li class="list-group-item">Categoria Y</li>
                        <li class="list-group-item">Categoria Z</li>
                    </ul>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="saveChanges">Salvar Alterações</button>
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
                <button type="button" class="btn btn-success" id="addCategory">Adicionar Categoria</button>
            </div>
        </div>
    </div>
</div>

<!-- Incluindo SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        // Quando o botão de editar é clicado
        $('.edit-btn').on('click', function() {
            var name = $(this).data('name');
            $('#categoryName').val(name);
        });

        // Lógica para salvar alterações
        $('#saveChanges').on('click', function() {
            var newName = $('#categoryName').val();
            alert('Categoria salva: ' + newName);
            $('#editModal').modal('hide');
        });

        // Quando o botão de excluir é clicado
        $('.delete-btn').on('click', function() {
            var name = $(this).data('name');
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
                    $(this).closest('tr').remove(); // Remove a linha da tabela
                    Swal.fire(
                        'Excluído!',
                        name + ' foi excluído com sucesso.',
                        'success'
                    );
                }
            });
        });

        // Lógica para adicionar nova categoria
        $('#addCategory').on('click', function() {
            var newCategory = $('#newCategoryName').val();
            if (newCategory) {
                $('tbody').append(`
                    <tr>
                        <td>${newCategory}</td>
                        <td class="text-center">
                            <button class="btn btn-primary edit-btn" data-bs-toggle="modal" data-bs-target="#editModal" data-name="${newCategory}">Editar</button>
                        </td>
                        <td class="text-center">
                            <button class="btn btn-danger delete-btn" data-name="${newCategory}">Excluir</button>
                        </td>
                    </tr>
                `);
                $('#newCategoryName').val(''); // Limpar o campo de entrada
                $('#addModal').modal('hide'); // Fechar o modal
            } else {
                alert('Por favor, insira um nome para a nova categoria.');
            }
        });
    });
</script>
