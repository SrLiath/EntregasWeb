<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
        </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
        </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<body>

    @include('usuario.templates.menu', ['menu' => 'suporte'])
    <div class="conteudo">

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Suporte DiskEntregas</title>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
        <style>
            body,
            html {
                overflow-x: hidden;
                margin: 0;
                padding: 0;
                font-family: 'Poppins', sans-serif;
                height: 100vh;
                width: 100vw;
                display: flex;
                justify-content: center;
                align-items: center;
                background: transparent;
            }

            .container {
                background-color: rgba(255, 255, 255, 0.95);
                border-radius: 20px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
                padding: 3rem;
                max-width: 800px;
                width: 90%;
                margin: auto;
            }

            h1 {
                color: #2c3e50;
                font-size: 2.5rem;
                margin-bottom: 1.5rem;
                text-align: center;
                font-weight: 600;
            }

            .support-options {
                display: flex;
                justify-content: space-around;
                margin-top: 2rem;
            }

            .support-option {
                text-align: center;
                padding: 1.5rem;
                border-radius: 15px;
                transition: all 0.3s ease;
                cursor: pointer;
            }

            .support-option:hover {
                transform: translateY(-5px);
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            }

            .support-icon {
                font-size: 3rem;
                margin-bottom: 1rem;
            }

            .email-icon {
                color: #3498db;
            }

            .whatsapp-icon {
                color: #25D366;
            }

            .support-text {
                color: #34495e;
                font-size: 1.1rem;
                font-weight: 300;
            }

            .support-contact {
                margin-top: 0.5rem;
                font-weight: 400;
                color: #2c3e50;
            }

            .background-gradient {
                position: absolute;
                top: 0;
                left: -50%;
                width: 300vw;
                height: 100vh;
                background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
                z-index: -1;
            }
        </style>
        </head>

        <div class="background-gradient"></div>
        <div class="container">
            <h1>Precisa de ajuda?</h1>
            <div class="support-options">
                <div class="support-option" id="email-option">
                    <i class="fas fa-envelope support-icon email-icon"></i>
                    <div class="support-text">Envie-nos um e-mail</div>
                    <div class="support-contact">anuncios@diskentregas.com</div>
                </div>
                <div class="support-option" id="whatsapp-option">
                    <i class="fab fa-whatsapp support-icon whatsapp-icon"></i>
                    <div class="support-text">Fale conosco no WhatsApp</div>
                    <div class="support-contact">+55 27 99829-3232</div>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function () {
                $('#email-option').on('click', function () {
                    window.location.href = 'mailto:anuncios@diskentregas.com';
                });

                $('#whatsapp-option').on('click', function () {
                    var phoneNumber = '5527998293232';
                    var message = encodeURIComponent('Olá, sou do diskentregas e preciso de ajuda');
                    var whatsappUrl = 'https://api.whatsapp.com/send?phone=' + phoneNumber + '&text=' +
                        message;
                    window.open(whatsappUrl, '_blank');
                });
            });
        </script>

    </div>
</body>

</html>