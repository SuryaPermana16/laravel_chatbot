<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
        <style>
            input::-ms-reveal,
            input::-ms-clear {
                display: none;
            }
        </style>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <main>
                {{ $slot }}
            </main>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            // A. Tampilkan Pop-Up Sukses (Dari Controller)
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'BERHASIL!',
                    text: "{{ session('success') }}",
                    showConfirmButton: false,
                    timer: 2000
                });
            @endif

            // B. Tampilkan Pop-Up Error
            @if(session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'GAGAL!',
                    text: "{{ session('error') }}",
                });
            @endif

            // C. Logika Konfirmasi Hapus (Otomatis cari class 'delete-form')
            document.addEventListener('DOMContentLoaded', function() {
                const deleteForms = document.querySelectorAll('.delete-form');
                
                deleteForms.forEach(form => {
                    form.addEventListener('submit', function(e) {
                        e.preventDefault(); // Tahan dulu
                        
                        Swal.fire({
                            title: 'Yakin mau hapus?',
                            text: "Data yang dihapus tidak bisa dikembalikan!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#3085d6',
                            confirmButtonText: 'Ya, Hapus!',
                            cancelButtonText: 'Batal'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                form.submit(); // Kirim form kalau user klik Ya
                            }
                        });
                    });
                });
            });

            // D. Logika Toggle Password (Mata)
            function togglePassword(inputId, iconId) {
                const passwordInput = document.getElementById(inputId);
                const icon = document.getElementById(iconId);

                if (passwordInput.type === "password") {
                    passwordInput.type = "text";
                    icon.classList.remove("fa-eye");
                    icon.classList.add("fa-eye-slash");
                } else {
                    passwordInput.type = "password";
                    icon.classList.remove("fa-eye-slash");
                    icon.classList.add("fa-eye");
                }
            }
        </script>
    </body>
</html>