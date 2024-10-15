<style>
    .plans-container {
        display: flex;
        justify-content: center;
        margin: 20px 0;
        flex-wrap: wrap;
    }

    .plan {
        background-color: rgba(255, 255, 255, 0.9);
        border-radius: 15px;
        margin: 10px;
        padding: 20px;
        text-align: center;
        width: 30%;
        /* Ajuste para telas grandes */
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        transition: transform 0.2s, border 0.2s;
        cursor: pointer;
    }

    .plan:hover {
        transform: scale(1.05);
    }

    .plan.selected {
        border: 3px solid navy;
        transform: scale(1.1);
    }

    .plan h2 {
        font-size: 36px;
        margin: 10px 0;
    }

    .plan p {
        font-size: 14px;
    }

    /* Estilos responsivos */
    @media (max-width: 768px) {
        .plan {
            width: 45%;
            /* Ajusta para telas médias */
        }
    }

    @media (max-width: 480px) {
        .plan {
            width: 90%;
            /* Ajusta para telas pequenas */
        }

        .plan h2 {
            font-size: 28px;
            /* Reduz o tamanho do texto em telas pequenas */
        }

        .plan p {
            font-size: 12px;
            /* Reduz o tamanho do texto em telas pequenas */
        }
    }
</style>
<br>
<div class="plans-container">
    <div class="plan selected" onclick="selectPlan(this, 'Plano Brasil')">
        <h2>Plano Brasil</h2>
        <p>1 banner no Brasil (index) e em todos os estados<br>+ resultado da busca <br>+ página do
            anunciante</p>
    </div>
    <div class="plan" onclick="selectPlan(this, 'Plano Estadual')">
        <h2>Plano Estadual</h2>
        <p>1 banner no estado<br>+ resultado da busca <br>+ página do anunciante</p>
    </div>
    <div class="plan" onclick="selectPlan(this, 'Plano Busca')">
        <h2>Plano Busca</h2>
        <p>+ página do anunciante</p>
    </div>

    <div class="container mt-5">
        <div class="row">
            <div class="col">
                <label for="planoBrasil">Plano Brasil</label>
                <input type="text" class="form-control" id="planoBrasil" placeholder="Digite o Plano Brasil">
            </div>
            <div class="col">
                <label for="planoEstadual">Plano Estadual</label>
                <input type="text" class="form-control" id="planoEstadual" placeholder="Digite o Plano Estadual">
            </div>
            <div class="col">
                <label for="planoBusca">Plano Busca</label>
                <input type="text" class="form-control" id="planoBusca" placeholder="Digite o Plano Busca">
            </div>
        </div>
        <div class="row mt-3">
            <div class="col">
                <button class="btn btn-success">Atualizar</button>
            </div>
        </div>
    </div>
</div>
