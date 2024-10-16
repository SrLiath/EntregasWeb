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

@include('usuario.templates.menu', ['menu' => 'pedidos'])
<div class="conteudo">
    <div class="container mt-5">
        <h1 class="text-center mb-4">Metrica de pedidos</h1>

        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card metric-card bg-primary text-white">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-shopping-cart"></i> Pedidos hoje</h5>
                        <p class="card-text display-4" id="todayOrdersCount">{{$totalHoje}}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card metric-card bg-success text-white">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-check-circle"></i> Pedidos completos</h5>
                        <p class="card-text display-4">{{$completo}}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card metric-card bg-warning text-dark">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-clock"></i> Pedidos em andamento</h5>
                        <p class="card-text display-4">{{$andamento}}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card metric-card bg-danger text-white">
                    <div class="card-body">
                        <h5 class="card-title "><i class="fas fa-clock"></i> Pedidos negados</h5>
                        <p class="card-text display-4">{{$negado}}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 d-flex justify-content-end align-items-center">
            <form action="" class="tm-text-primary">
                Pagina <input type="text" value="{{ $pedidos->currentPage() }}" size="1"
                    class="tm-input-paging tm-text-primary">
                de {{ $pedidos->lastPage() }}
            </form>
        </div>
        <div class="card">
            <div class="card-header">
                <h3><i class="fas fa-list"></i> Pedidos</h3>
            </div>
            <div class="card-body order-list">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Ordem do pedido</th>
                            <th>Nome</th>
                            <th>Valor</th>
                            <th>Data</th>
                            <th>Status</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody id="orderTableBody">
                        @foreach($pedidos as $pedido)
                            <tr>
                                <td>{{$pedido->id_pedido_loja}}</td>
                                <td>{{$pedido->nome_cliente}}</td>
                                <td>{{$pedido->valor}}</td>
                                <td>{{$pedido->data_pedido}}</td>
                                <td>{{$pedido->status}}</td>
                                <td>
                                    @if($pedido->status == 'chamou')
                                        <button class="btn btn-success btn-confirm" data-id="{{$pedido->id}}">
                                            <i class="fas fa-check"></i>
                                        </button>
                                        <button class="btn btn-danger btn-deny" data-id="{{$pedido->id}}">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    @elseif($pedido->status == 'andamento')
                                        <button class="btn btn-success btn-complete" data-id="{{$pedido->id}}">
                                            <i class="fas fa-check-circle"></i> Confirmar Entrega
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    @php
                        $currentPage = $pedidos->currentPage();
                        $lastPage = $pedidos->lastPage();
                        $start = max($currentPage - 2, 1);
                        $end = min($start + 4, $lastPage);

                        if ($end - $start < 4) {
                            $start = max($end - 4, 1);
                    } @endphp @if ($currentPage > 1)
                        <li class="page-item">
                            <a class="page-link" href="{{ $pedidos->url(1) }}" aria-label="First">
                                <span aria-hidden="true">&laquo;&laquo;</span>
                            </a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="{{ $pedidos->previousPageUrl() }}" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                    @endif

                    @for ($i = $start; $i <= $end; $i++)
                        <li class="page-item {{ $i == $currentPage ? 'active' : '' }}">
                            <a class="page-link" href="{{ $pedidos->url($i) }}">{{ $i }}</a>
                        </li>
                    @endfor

                    @if ($currentPage < $lastPage)
                        <li class="page-item">
                            <a class="page-link" href="{{ $pedidos->nextPageUrl() }}" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="{{ $pedidos->url($lastPage) }}" aria-label="Last">
                                <span aria-hidden="true">&raquo;&raquo;</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </nav>

        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            $(document).ready(function () {
                // Ação para confirmar pedido e colocar em progresso
                // Handle pagination clicks
                $('.pagination a').on('click', function (e) {
                    e.preventDefault();
                    var url = $(this).attr('href');
                    loadPage(url);
                });
                $('.btn-confirm').on('click', function () {
                    let id = $(this).data('id');
                    $.ajax({
                        url: `/pedido/confirmar/${id}`,
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (response) {
                            if (response.success) {
                                alert('Pedido confirmado e em progresso.');
                                location
                                    .reload(); // Recarregar a página para atualizar o status
                            }
                        }
                    });
                });

                // Ação para negar o pedido
                $('.btn-deny').on('click', function () {
                    let id = $(this).data('id');
                    $.ajax({
                        url: `/pedido/negar/${id}`,
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (response) {
                            if (response.success) {
                                alert('Pedido negado.');
                                location
                                    .reload(); // Recarregar a página para atualizar o status
                            }
                        }
                    });
                });

                // Ação para completar o pedido
                $('.btn-complete').on('click', function () {
                    let id = $(this).data('id');
                    $.ajax({
                        url: `/pedido/completar/${id}`,
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (response) {
                            if (response.success) {
                                alert('Pedido entregue.');
                                location
                                    .reload(); // Recarregar a página para atualizar o status
                            }
                        }
                    });
                });
            });
        </script>
    </div>