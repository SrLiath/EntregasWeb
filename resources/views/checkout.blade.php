<html>

<head>
    <script src="https://sdk.mercadopago.com/js/v2"></script>
</head>

<body>
    <div id="paymentBrick_container">
    </div>
    <script>
        const mp = new MercadoPago('TEST-a0cc1222-7b79-4565-a855-5eecb40e7af1', {
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
                                    },
                                    body: JSON.stringify(formData),
                                })
                                .then((response) => response.json())
                                .then((response) => {
                                    // receber o resultado do pagamento
                                    resolve();
                                })
                                .catch((error) => {
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
