<html>

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.7.1.js"
    integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://sdk.mercadopago.com/js/v2"></script>
</head>

<body>
    <div id="paymentBrick_container">
    </div>
    <script>
                $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        const mp = new MercadoPago('APP_USR-b92a20d0-d3d7-4133-a01a-7005acd288f6', {
            locale: 'pt'
        });
        const bricksBuilder = mp.bricks();
        const renderPaymentBrick = async (bricksBuilder) => {
            const settings = {
                initialization: {
                    /*
                      "amount" é a quantia total a pagar por todos os meios de pagamento com exceção da Conta Mercado Pago e Parcelas sem cartão de crédito, que têm seus valores de processamento determinados no backend através do "preferenceId"
                    */
                    amount: {{$plano->valor}},
                    payer: {
                        firstName: "",
                        lastName: "",
                        email: "",
                    },
                },
                customization: {
                    visual: {
                        style: {
                            theme: "bootstrap",
                        },
                    },
                    paymentMethods: {
                        creditCard: "all",
                        debitCard: "all",
                        atm: "all",
                        wallet_purchase: "all",
                        onboarding_credits: "all",
                        bankTransfer: "all",
                        maxInstallments: 12
                    },
                },
                callbacks: {
                    onReady: () => {
                        /*
                         Callback chamado quando o Brick está pronto.
                         Aqui, você pode ocultar seu site, por exemplo.
                        */
                    },
                    onSubmit: ({
                        selectedPaymentMethod,
                        formData
                    }) => {
                        // callback chamado quando há click no botão de envio de dados
                        return new Promise((resolve, reject) => {
                            fetch("/process_payment", {
                                    method: "POST",
                                    headers: {
                                        "Content-Type": "application/json",
                                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                    },
                                    body: JSON.stringify(formData),
                                })
                                .then((response) => response.json())
                                .then((response) => {
                                    // receber o resultado do pagamento
                                    if(response.status == 'success'){
                                        const currentUrl = window.location.href;
                                        const url = new URL(currentUrl);
                                        const params = new URLSearchParams(url.search);
                                        const userId = params.get('user');

                                        window.location.href = window.location.origin + `/checagem/?payment_id=${response.payment_id}&user=${userId}`
                                    }
                                    resolve();
                                })
                                .catch((error) => {
                                    console.error(error)

                                    // manejar a resposta de erro ao tentar criar um pagamento
                                    reject();
                                });
                        });
                    },
                    onError: (error) => {
                        // callback chamado para todos os casos de erro do Brick
                        console.error(error);
                    },
                },
            };
            window.paymentBrickController = await bricksBuilder.create(
                "payment",
                "paymentBrick_container",
                settings
            );
        };
        renderPaymentBrick(bricksBuilder);
    </script>
</body>

</html>
