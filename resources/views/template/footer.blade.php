
<style>
    .linha {
        display: none;
    }

    @media (max-width: 767px) {

        .linha {
            display: flex;
            width: 70%;
            height: 0.5px;
            background-color: #008585;
            margin: -20px auto 20px;
        }
    }
</style>
<footer class="tm-bg-gray pt-5 pb-0 tm-text-gray tm-footer w-100">
    <div class=" tm-container-fullscreen">
        <!-- Primeira linha com 3 colunas -->
        <div class="row text-center">
            <!-- Primeira coluna -->
            <div class="col-lg-4 col-md-6 col-12 px-5 mb-5">
                <p>
                    PRODUTOS, SERVIÇOS E ALIMENTOS QUE CHEGAM ATÉ VOCÊ.
                    <br>
                    PARTICIPE VOCÊ TAMBÉM!
                </p>
            </div>
            <div class="linha"></div>
            <!-- Segunda coluna com barra à esquerda -->
            <div class="col-lg-4 col-md-6 col-12 px-5 mb-5" style="border-left: 1px solid #ccc;">
                <ul class="tm-footer-links list-unstyled pl-0">
                    <li><a href="/cadastre">CONTRATE</a></li>
                    <li><a href="/sobre">SOBRE NÓS</a></li>
                    <li><a href="/contato">CONTATO</a></li>
                </ul>
            </div>
            <div class="linha"></div>

            <!-- Terceira coluna com barra à esquerda -->
            <div class="col-lg-4 col-md-12 col-12 px-5 mb-5" style="border-left: 1px solid #ccc;">
                <p>
                    ENTRE EM CONTATO:
                    <br>
                    suporte@diskentregas.com
                </p>
            </div>
        </div>

        <!-- Texto <h3> abaixo das colunas -->
        <div class="row">
            <div class="col-12 d-flex justify-content-center align-items-center"
                style="background-color: #008585; color: white; width: 100%; ">
                <h3 class="tm-text-primary mb-2 mt-2 tm-footer-title text-align-center" style="color: white;">
                    DISK ENTREGAS | PORTAL OFICIAL ®
                </h3>
            </div>
        </div>

    </div>
</footer>
<script>
        $(window).on("load", function() {
            $('body').addClass('loaded');
        });
</script>