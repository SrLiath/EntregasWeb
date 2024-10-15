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
        <h1 class="text-center mb-4">Order Metrics Dashboard</h1>

        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card metric-card bg-primary text-white">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-shopping-cart"></i> Today's Orders</h5>
                        <p class="card-text display-4" id="todayOrdersCount">0</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card metric-card bg-success text-white">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-check-circle"></i> Completed Orders</h5>
                        <p class="card-text display-4">12</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card metric-card bg-warning text-dark">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-clock"></i> Pending Orders</h5>
                        <p class="card-text display-4">5</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3><i class="fas fa-list"></i> Recent Orders</h3>
            </div>
            <div class="card-body order-list">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Amount</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody id="orderTableBody">
                        <!-- Order rows will be dynamically added here -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Sample order data
        const orders = [{
            id: 1001,
            customer: "John Doe",
            amount: "$150.00",
            status: "Completed"
        },
        {
            id: 1002,
            customer: "Jane Smith",
            amount: "$89.99",
            status: "Pending"
        },
        {
            id: 1003,
            customer: "Bob Johnson",
            amount: "$299.50",
            status: "Completed"
        },
        {
            id: 1004,
            customer: "Alice Brown",
            amount: "$75.25",
            status: "Pending"
        },
        {
            id: 1005,
            customer: "Charlie Davis",
            amount: "$199.99",
            status: "Completed"
        }
        ];

        // Function to populate the order table
        function populateOrderTable() {
            const tableBody = document.getElementById("orderTableBody");
            orders.forEach(order => {
                const row = `
                    <tr>
                        <td>${order.id}</td>
                        <td>${order.customer}</td>
                        <td>${order.amount}</td>
                        <td><span class="badge bg-${order.status === 'Completed' ? 'success' : 'warning'}">${order.status}</span></td>
                    </tr>
                `;
                tableBody.innerHTML += row;
            });
        }

        // Function to update the today's orders count
        function updateTodayOrdersCount() {
            const countElement = document.getElementById("todayOrdersCount");
            let count = 0;
            const intervalId = setInterval(() => {
                countElement.textContent = count;
                count++;
                if (count > orders.length) {
                    clearInterval(intervalId);
                }
            }, 100);
        }

        // Call functions when the page loads
        window.onload = () => {
            populateOrderTable();
            updateTodayOrdersCount();
        };
    </script>
</div>