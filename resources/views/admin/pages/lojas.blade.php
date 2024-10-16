<div class="container mt-5">
    <h2>Tabela de Dados</h2>

    <!-- Botão para Criar Loja -->
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createStoreModal">
        Criar Loja
    </button>

    <!-- Modal para Criar Loja -->
    <div class="modal fade" id="createStoreModal" tabindex="-1" aria-labelledby="createStoreModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createStoreModalLabel">Criar Nova Loja</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    <form id="createStoreForm">
                        <div class="mb-3">
                            <label for="storeName" class="form-label">Nome da Loja</label>
                            <input type="text" class="form-control" id="storeName" required>
                        </div>
                        <div class="mb-3">
                            <label for="openingTime" class="form-label">Horário de Abertura</label>
                            <input type="time" class="form-control" id="openingTime" required>
                        </div>
                        <div class="mb-3">
                            <label for="closingTime" class="form-label">Horário de Fechamento</label>
                            <input type="time" class="form-control" id="closingTime" required>
                        </div>
                        <div class="mb-3">
                            <label for="storeType" class="form-label">ID Tipo</label>
                            <input type="number" class="form-control" id="storeType" required>
                        </div>
                        <div class="mb-3">
                            <label for="storeCategory" class="form-label">ID Categoria</label>
                            <input type="number" class="form-control" id="storeCategory" required>
                        </div>
                        <div class="mb-3">
                            <label for="states" class="form-label">Estados Atendidos</label>
                            <textarea class="form-control" id="states" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="cities" class="form-label">Cidades Atendidas</label>
                            <textarea class="form-control" id="cities" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="neighborhoods" class="form-label">Bairros Atendidos</label>
                            <textarea class="form-control" id="neighborhoods" rows="3"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-primary" form="createStoreForm">Salvar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros -->
    <div class="mb-3">
        <input type="text" id="searchInput" class="form-control" placeholder="Pesquisar...">
    </div>

    <table class="table table-bordered table-striped" id="dataTable">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Horário Início</th>
                <th>Horário Fim</th>
                <th>ID Tipo</th>
                <th>ID Categoria</th>
                <th>Estados Atendidos</th>
                <th>Cidades Atendidas</th>
                <th>Bairros Atendidos</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($lojas as $loja)
                <tr>
                    <td>{{$loja->nome}}</td>
                    <td>{{$loja->horario_inicio}}</td>
                    <td>{{$loja->horario_fim}}</td>
                    <td>{{$loja->tipo->tipo}}</td>
                    <td>{{$loja->categoria->categoria}}</td>
                    <td>Estado 1, Estado 2</td>
                    <td>Cidade 1, Cidade 2</td>
                    <td>Bairro 1, Bairro 2</td>
                    <td>
                        <button class="btn btn-warning btn-sm">Alterar</button>
                        <button class="btn btn-danger btn-sm">Eliminar</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="no-results" id="noResults" style="display: none;">
        <p class="text-center">Nenhum resultado encontrado.</p>
    </div>
</div>

<script>
    // Script para filtragem
    document.getElementById('searchInput').addEventListener('keyup', function () {
        const filter = this.value.toLowerCase();
        const rows = document.querySelectorAll('#dataTable tbody tr');
        let hasResults = false;

        rows.forEach(row => {
            const cells = row.getElementsByTagName('td');
            let rowContainsFilterText = false;

            for (let i = 0; i < cells.length - 1; i++) { // Ignora a última coluna (Ações)
                const cell = cells[i].textContent.toLowerCase();
                if (cell.indexOf(filter) > -1) {
                    rowContainsFilterText = true;
                    break;
                }
            }

            if (rowContainsFilterText) {
                row.style.display = '';
                hasResults = true;
            } else {
                row.style.display = 'none';
            }
        });

        // Mostra ou oculta a mensagem "Nenhum resultado encontrado."
        document.getElementById('noResults').style.display = hasResults ? 'none' : 'block';
    });
</script>