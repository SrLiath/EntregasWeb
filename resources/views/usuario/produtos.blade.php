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

@include('usuario.templates.menu', ['menu' => 'produto'])
<div class="conteudo">
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Common Gallery with White Modal</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            .gallery {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
                gap: 20px;
                padding: 20px;
            }

            .gallery-item {
                cursor: pointer;
            }

            .gallery-item img {
                width: 100%;
                height: 200px;
                object-fit: cover;
                border-radius: 8px;
            }

            .gallery-item p {
                margin-top: 10px;
                text-align: center;
            }

            .modal-content {
                background-color: white;
                border-radius: 8px;
            }

            .modal-body {
                padding: 0;
                position: relative;
            }

            .modal-body img {
                width: 100%;
                height: auto;
                border-top-left-radius: 8px;
                border-top-right-radius: 8px;
            }

            .modal-nav {
                position: absolute;
                top: 50%;
                transform: translateY(-50%);
                font-size: 2rem;
                color: white;
                background-color: rgba(0, 0, 0, 0.5);
                border: none;
                border-radius: 50%;
                width: 50px;
                height: 50px;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .modal-prev {
                left: 10px;
            }

            .modal-next {
                right: 10px;
            }

            .modal-footer {
                justify-content: space-between;
                padding: 15px;
            }
        </style>
    </head>

    <body>

        <div class="container">
            <h1 class="text-center my-4">Photo Gallery</h1>
            <div class="gallery" id="gallery"></div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-body">
                        <img src="" alt="" id="modalImage">
                        <button class="modal-nav modal-prev">&lt;</button>
                        <button class="modal-nav modal-next">&gt;</button>
                    </div>
                    <div class="modal-footer">
                        <h5 id="modalTitle" class="m-0"></h5>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            const galleryItems = [{
                src: 'https://picsum.photos/id/1018/300/300',
                name: 'Mountain View'
            },
            {
                src: 'https://picsum.photos/id/1015/300/300',
                name: 'River Stream'
            },
            {
                src: 'https://picsum.photos/id/1019/300/300',
                name: 'Misty Forest'
            },
            {
                src: 'https://picsum.photos/id/1039/300/300',
                name: 'Lake Reflection'
            },
            {
                src: 'https://picsum.photos/id/1043/300/300',
                name: 'Autumn Colors'
            },
            {
                src: 'https://picsum.photos/id/1044/300/300',
                name: 'Desert Dunes'
            },
            {
                src: 'https://picsum.photos/id/1045/300/300',
                name: 'Foggy Mountains'
            },
            {
                src: 'https://picsum.photos/id/1049/300/300',
                name: 'Pebble Beach'
            }
            ];

            $(document).ready(function () {
                const gallery = $('#gallery');
                let currentIndex = 0;

                galleryItems.forEach((item, index) => {
                    gallery.append(`
                <div class="gallery-item" data-index="${index}">
                    <img src="${item.src}" alt="${item.name}">
                    <p>${item.name}</p>
                </div>
            `);
                });

                $('.gallery-item').on('click', function () {
                    currentIndex = $(this).data('index');
                    updateModal();
                    $('#imageModal').modal('show');
                });

                $('.modal-prev').on('click', function () {
                    currentIndex = (currentIndex - 1 + galleryItems.length) % galleryItems.length;
                    updateModal();
                });

                $('.modal-next').on('click', function () {
                    currentIndex = (currentIndex + 1) % galleryItems.length;
                    updateModal();
                });

                function updateModal() {
                    const item = galleryItems[currentIndex];
                    $('#modalImage').attr('src', item.src).attr('alt', item.name);
                    $('#modalTitle').text(item.name);
                }
            });
        </script>
    </body>

    </html>
</div>