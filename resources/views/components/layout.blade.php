<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <link rel="stylesheet" href="/css/style.css">
    
    @livewireStyles

    <title>{{ $appname }}</title>
  </head>
  <body class="bg-light">
    
    <x-navbar :appname="$appname" :menu="$menu" :submenu="$submenu" />

    {{ $slot }}

    <x-footer :$categories :$menu :$submenu />

    <!-- Modal Register -->
    <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0">
                <div class="modal-header border-0 bg-primary text-white">
                    <h5 class="modal-title" id="registerModalLabel">
                        <i class="bi bi-person-plus-fill me-2"></i>
                        Create New Account
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <livewire:auth.register />
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Login -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0">
                <div class="modal-header border-0 bg-primary text-white">
                    <h5 class="modal-title" id="loginModalLabel">
                        <i class="bi bi-box-arrow-in-right me-2"></i>
                        Login to Your Account
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <livewire:auth.login />
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    
    @livewireScripts

    <script>
        // Script untuk menangani penutupan modal
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('close-modal', (data) => {
                const modalElement = document.getElementById(data.modal);
                const modal = bootstrap.Modal.getInstance(modalElement);
                if (modal) {
                    modal.hide();
                }
            });
        });
    </script>
  </body>
</html>