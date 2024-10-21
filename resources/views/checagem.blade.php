<html>
    <head>
      <script src="https://sdk.mercadopago.com/js/v2"></script>
    </head>
    <body>
      <div id="statusScreenBrick_container"></div>
      <script>
        const mp = new MercadoPago('APP_USR-b92a20d0-d3d7-4133-a01a-7005acd288f6', { // Add your public key credential
          locale: 'pt'
        });
        const bricksBuilder = mp.bricks();
        const renderStatusScreenBrick = async (bricksBuilder) => {
          const settings = {
            initialization: {
              paymentId: '{{ $payment_id }}', // Payment identifier, from which the status will be checked
            },
            customization: {
              visual: {
                hideStatusDetails: true,
                hideTransactionDate: true,
                style: {
                  theme: 'flat', // 'default' | 'dark' | 'bootstrap' | 'flat'
                }
              },
              backUrls: {
              }
            },
            callbacks: {
              onReady: () => {
              },
              onError: (error) => {
              },
            },
          };
          window.statusScreenBrickController = await bricksBuilder.create('statusScreen', 'statusScreenBrick_container', settings);
        };
        renderStatusScreenBrick(bricksBuilder);
      </script>
    </body>
    </html>
    







