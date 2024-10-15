<div class="tm-hero d-flex justify-content-center align-items-center" data-parallax="scroll" data-image-src="img/hero.jpg">
    <div class="container">
        <!-- Banner -->
        <div class="container-fluid p-0">
            <div class="banner">
                <div class="banner-overlay text-center">
                    <div class="container">
                        <img src="/baner.jpg" style="width: 100%" alt="" />
                    </div>
                </div>
            </div>
        </div>

        <form class="tm-search-form row justify-content-center">
            <!-- Estado -->
            <div class="col-12 col-md-2 mb-2">
                <select id="estado" class="form-control" aria-label="Estado">
                    <option value="">Estado</option>
                </select>
            </div>

            <!-- Cidade -->
            <div class="col-12 col-md-2 mb-2">
                <select id="cidade" class="form-control" aria-label="Cidade" disabled>
                    <option value="">Cidade</option>
                </select>
            </div>

            <!-- Bairro como input -->
            <div class="col-12 col-md-2 mb-2">
                <input id="bairro" type="text" class="form-control" aria-label="Bairro" placeholder="Bairro">
            </div>

            <!-- Botão de Confirmar -->
            <div class="col-12 col-md-2 mb-2">
                <button class="btn btn-outline-success tm-search-btn" type="button" id="btn-search">
                    Adicionar
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Função para carregar os estados
        function carregarEstados() {
            $.post('/api/estados')
                .done(function(data) {
                    data.forEach(function(val) {
                        $('#estado').append('<option value="' + val.id_estado + '">' + val.nome +
                            '</option>');
                    });
                })
                .fail(function(xhr, status, error) {
                    console.error('Erro ao carregar estados:', status, error);
                });
        }

        // Função para carregar as cidades com base no estado
        function carregarCidades(estadoId) {
            if (estadoId) {
                $.post('/api/cidades', {
                        estado: estadoId
                    })
                    .done(function(data) {
                        $('#cidade').empty().append('<option value="">Selecione a Cidade</option>');
                        data.forEach(function(val) {
                            $('#cidade').append('<option value="' + val.id_cidade + '">' + val
                                .nome + '</option>');
                        });
                        $('#cidade').prop('disabled', false);
                    })
                    .fail(function(xhr, status, error) {
                        console.error('Erro ao carregar cidades:', status, error);
                    });
            } else {
                $('#cidade').empty().append('<option value="">Selecione a Cidade</option>').prop('disabled',
                    true);
                $('#bairro').prop('disabled', true).val(''); // Desabilita o input de bairro e limpa seu valor
            }
        }

        // Função para habilitar o input de bairro
        function habilitarInputBairro() {
            $('#bairro').prop('disabled', false); // Habilita o input de bairro
        }

        // Carregar os estados ao iniciar
        carregarEstados();

        // Evento para carregar cidades quando o estado for selecionado
        $('#estado').on('change', function() {
            let estadoId = $(this).val();
            carregarCidades(estadoId);
        });

        $('#btn-search').on('click', function() {
            // Obtém os valores selecionados
            let estado = $('#estado').val();
            let cidade = $('#cidade').val();
            let bairro = $('#bairro').val();

            // Validação
            if (!estado || !cidade) {
                Swal.fire({
                    title: 'Erro!',
                    text: 'Informe o estado e a cidade!',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                return; // Para a execução se a validação falhar
            }

        });
        // Evento para habilitar o input de bairro quando a cidade for selecionada
        $('#cidade').on('change', function() {
            let cidadeId = $(this).val();
            if (cidadeId) {
                habilitarInputBairro(); // Habilita o input de bairro se uma cidade for selecionada
            } else {
                $('#bairro').prop('disabled', true).val(''); // Desabilita o input se não houver cidade
            }
        });
    });
</script>
