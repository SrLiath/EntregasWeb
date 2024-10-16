<style>
    .plan {
        transition: transform 0.2s, box-shadow 0.2s;
        cursor: pointer;
    }

    .plan:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }
</style>
<div class="container mt-5">
    <div class="row row-cols-1 row-cols-md-3 g-4">
        @foreach($planos as $plano)
            <div class="col">
                <div class="card h-100 plan" data-bs-toggle="modal" data-bs-target="#editarsmodal"
                    data-id="{{ $plano->id }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $plano->nome }}</h5>
                        <h6 class="card-subtitle mb-2 text-muted">{{ $plano->valor }}R$</h6>
                        <p class="card-text">{!! $plano->descricao !!}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="editarsmodal" tabindex="-1" aria-labelledby="editarsmodalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editarsmodalLabel">Editar Plano</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editForm">
                    <input type="hidden" id="planId">
                    <div class="mb-3">
                        <label for="planName" class="form-label">Nome do Plano</label>
                        <input type="text" class="form-control" id="planName" required>
                    </div>
                    <div class="mb-3">
                        <label for="planValue" class="form-label">Valor</label>
                        <input type="number" class="form-control" id="planValue" required>
                    </div>
                    <div class="mb-3">
                        <label for="planDescription" class="form-label">Descrição</label>
                        <textarea class="form-control" id="planDescription" rows="3" required></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal" id="saveChangesPlan">Salvar
                    Alterações</button>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap 5 JS Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const editarsmodal = new bootstrap.Modal(document.getElementById('editarsmodal'));
        const plans = document.querySelectorAll('.plan');
        const editForm = document.getElementById('editForm');
        const saveChangesPlanBtn = document.getElementById('saveChangesPlan');

        plans.forEach(plan => {
            plan.addEventListener('click', function () {
                const planId = this.getAttribute('data-id');
                const planName = this.querySelector('.card-title').textContent;
                const planValue = parseFloat(this.querySelector('.card-subtitle').textContent
                    .replace('R$', '').trim());
                const planDescription = this.querySelector('.card-text').innerHTML;

                document.getElementById('planId').value = planId;
                document.getElementById('planName').value = planName;
                document.getElementById('planValue').value = planValue;
                document.getElementById('planDescription').value = planDescription;
            });
        });

        saveChangesPlanBtn.addEventListener('click', function () {
            const planId = document.getElementById('planId').value;
            const planName = document.getElementById('planName').value;
            const planValue = document.getElementById('planValue').value;
            const planDescription = document.getElementById('planDescription').value;

            // Atualizar o plano na página
            const plan = document.querySelector(`.plan[data-id="${planId}"]`);
            $.ajax({
                url: `/api/planos/${planId}`, // Ajuste para a URL correta da sua API
                type: 'PUT',
                contentType: 'application/json',
                data: JSON.stringify({
                    nome: planName,
                    valor: planValue,
                    descricao: planDescription
                }),
                success: function (response) {
                    // Atualizar o plano na página
                    const plan = document.querySelector(`.plan[data-id="${planId}"]`);
                    plan.querySelector('.card-title').textContent = response.plano.nome;
                    plan.querySelector('.card-subtitle').textContent = response.plano.valor +
                        "R$";
                    plan.querySelector('.card-text').innerHTML = response.plano.descricao;

                    // Fechar o modal
                    editarsmodal.hide();
                },
                error: function (xhr) {
                    alert('Erro ao atualizar o plano: ' + xhr.responseJSON.message);
                }
            });

            // Fechar o modal
            editarsmodal.hide();
        });
    });
</script>