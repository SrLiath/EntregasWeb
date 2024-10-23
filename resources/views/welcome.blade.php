@include('template.menu')
        <div class="row tm-mb-90 tm-gallery" >
            @if ($lojas->isEmpty())
                <div class="col-12 mb-5 text-center">
                    <div
                        style="border: 1px dotted cyan; background-color: lightgray; padding: 20px; border-radius: 5px; margin-left:30%; margin-right: 30%">
                        <span style="font-size: 50px;">😞</span>
                        <div>Sem lojas disponíveis</div>
                    </div>
                </div>
            @else
                <style>
                 @media (max-width: 991px) {
                    .card{
                       margin-bottom: 50px;
                    }
                }
                    .product-grid {
                        display: grid;
                        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
                        gap: 20px;
                    }

                    .product-card {
                        background-color: #ffffff;
                        border-radius: 8px;
                        overflow: hidden;
                        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                        transition: transform 0.3s ease;
                    }

                    .product-card:hover {
                        transform: translateY(-5px);
                    }

                    .product-name {
                        background-color: #3498db;
                        color: #ffffff;
                        padding: 10px;
                        text-align: center;
                        font-size: 18px;
                        font-weight: bold;
                    }

                    .product-image {
                        width: 100%;
                        height: 200px;
                        object-fit: cover;
                    }

                    .product-details {
                        padding: 15px;
                        display: flex;
                        justify-content: space-between;
                        align-items: center;
                        background-color: #ecf0f1;
                    }

                    .product-price {
                        font-size: 18px;
                        font-weight: bold;
                        color: #2c3e50;
                    }

                    .view-more {
                        background-color: #2ecc71;
                        color: #ffffff;
                        border: none;
                        padding: 8px 15px;
                        border-radius: 4px;
                        cursor: pointer;
                        transition: background-color 0.3s ease;
                    }

                    .view-more:hover {
                        background-color: #27ae60;
                    }
                                    .card {
                                        height: 250px;
                                        display: flex;
                                        flex-direction: column;
                                    }
                                    .card-header {
                                        height: 50px;
                                    }
                                    .card a {
                                        color: white;
                                        display: flex;
                                        flex-direction: column;
                                    }
                                    .icone{
                                        z-index: 999;
                                    }
                                    .card-img{
                                        height: 250px;
                                    }
                                </style>
         @php
    // Obtém o dia da semana atual (1 = seg, 2 = ter, ..., 7 = dom)
    $diaSemanaAtual = \Carbon\Carbon::now()->dayOfWeekIso; 

    // Obtém o horário atual
    $horaAtual = \Carbon\Carbon::now();

    // Chama uma API gratuita para verificar se hoje é feriado
    $feriado = false; // Inicialmente assume que não é feriado

    // URL de exemplo de uma API de feriados
    $apiUrl = 'https://api.calendario.com.br/?json=true&ano=' . now()->year . '&estado=SP&cidade=Sao_Paulo&token=YOUR_API_KEY';
    try {
        $response = Http::get($apiUrl);
        $feriados = json_decode($response->body(), true);
        foreach ($feriados as $f) {
            if (\Carbon\Carbon::parse($f['date'])->isToday()) {
                $feriado = true;
                break;
            }
        }
    } catch (\Exception $e) {
        // Trate a exceção
    }
@endphp
@foreach ($lojas as $loja)
@php
    $diasFuncionamento = is_array($loja->dia) ? $loja->dia : [];

    // Obter a hora atual como objeto Carbon
    $horaAtual = \Carbon\Carbon::now();

    // Cria objetos Carbon para os horários de início e fim
    $horarioInicio = \Carbon\Carbon::createFromFormat('H:i:s', $loja->horario_inicio);
    $horarioFim = \Carbon\Carbon::createFromFormat('H:i:s', $loja->horario_fim);

    // Verifica se a hora atual está dentro do horário de funcionamento
    $estaAberta = ($horaAtual->greaterThanOrEqualTo($horarioInicio) && $horaAtual->lessThanOrEqualTo($horarioFim));
@endphp

<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12 mb-5">
    <div class="card border-0 shadow-sm" style="background-color: #008585; color: white;">
        <a href="/{{ $loja->url }}">
            <div class="card-header text-center" style="background-color: #006f6f; border-bottom: none;">
                <h5 class="mb-0">{{$loja->nome }}</h5>
            </div>
            <img src="{{ asset($loja->imagem) }}" alt="Image" class="img-fluid card-img">
            <div class="status-loja" style="padding: 10px; background-color: #006f6f;">
                <div class="icone d-flex justify-content-center">
                    @if($estaAberta)
                        <span style="color: white;">Aberto</span>
                    @else
                        <span style="color: white;">Fechado</span>
                    @endif
                </div>
            </div>
        </a>
    </div>
</div>

@endforeach

            @endif
        </div> <!-- row -->

        <div class="row tm-mb-90">
            <div class="col-12 d-flex justify-content-between align-items-center tm-paging-col">
                <a href="{{ $lojas->previousPageUrl() }}"
                    class="btn btn-primary tm-btn-prev mb-2 {{ $lojas->onFirstPage() ? 'disabled' : '' }}">Anterior</a>
                <div class="tm-paging d-flex">
                    @php
                        $currentPage = $lojas->currentPage();
                        $lastPage = $lojas->lastPage();
                        $startPage = max(1, $currentPage - 2); // Determina a primeira página a ser exibida
                        $endPage = min($lastPage, $currentPage + 2); // Determina a última página a ser exibida

                        // Se a página atual for 1 ou 2, exibe até 5 páginas
                        if ($currentPage <= 2) {
                            $endPage = min($lastPage, 5);
                        }
                        if ($currentPage >= $lastPage - 1) {
                            $startPage = max(1, $lastPage - 4);
                        }
                    @endphp

                    @for ($i = $startPage; $i <= $endPage; $i++)
                        <a href="{{ $lojas->url($i) }}"
                            class="tm-paging-link {{ request()->get('page') == $i || (request()->get('page') == null && $i == 1) ? 'active' : '' }}">
                            {{ $i }}
                        </a>
                    @endfor


                </div>
                <a href="{{ $lojas->nextPageUrl() }}"
                    class="btn btn-primary tm-btn-next {{ $lojas->hasMorePages() ? '' : 'disabled' }}">Proxima</a>
            </div>
        </div>
    </div>
    @include('template.footer')
</body>


</html>
