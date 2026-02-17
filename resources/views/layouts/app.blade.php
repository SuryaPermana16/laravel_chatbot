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
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            #chat-messages::-webkit-scrollbar { width: 5px; }
            #chat-messages::-webkit-scrollbar-thumb { background: #888; border-radius: 5px; }
            input::-ms-reveal, input::-ms-clear { display: none; }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')
            <main>{{ $slot }}</main>
        </div>

        @if(Auth::check() && in_array(Auth::user()->role, ['admin', 'dokter', 'apoteker']))
            
            <div id="chat-button" onclick="toggleChatWindow()" 
                 style="position: fixed; bottom: 30px; right: 30px; z-index: 999999; background-color: #2563eb; color: white; padding: 15px 20px; border-radius: 50px; cursor: pointer; box-shadow: 0 4px 15px rgba(0,0,0,0.3); display: flex; align-items: center; gap: 10px; border: 2px solid white;">
                <span style="font-weight: bold; font-family: sans-serif;">CHAT AI</span>
                <i class="fas fa-robot" style="font-size: 20px;"></i>
            </div>

            <div id="chat-window" 
                 style="display: none; position: fixed; bottom: 95px; right: 30px; z-index: 999999; width: 350px; height: 500px; background-color: white; border-radius: 15px; box-shadow: 0 5px 25px rgba(0,0,0,0.2); border: 1px solid #ddd; overflow: hidden; flex-direction: column;">
                
                <div style="background-color: #2563eb; color: white; padding: 15px; display: flex; justify-content: space-between; align-items: center;">
                    <span style="font-weight: bold;">Asisten AI Klinik</span>
                    <button onclick="toggleChatWindow()" style="background: none; border: none; color: white; cursor: pointer; font-size: 18px;"><i class="fas fa-times"></i></button>
                </div>

                <div id="chat-messages" style="flex: 1; padding: 15px; overflow-y: auto; background-color: #f9fafb; display: flex; flex-direction: column; gap: 10px;">
                    <div style="align-self: flex-start; background-color: white; padding: 10px; border-radius: 10px 10px 10px 0; border: 1px solid #eee; font-size: 13px;">
                        Halo <b>{{ Auth::user()->name }}</b>! Ada yang bisa saya bantu?
                    </div>
                </div>

                <div style="padding: 15px; background-color: white; border-top: 1px solid #eee;">
                    <form onsubmit="kirimPesanChat(event)" style="display: flex; gap: 10px;">
                        <input type="text" id="chat-input" placeholder="Tanya stok atau jadwal..." style="flex: 1; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 13px; outline: none;">
                        <button type="submit" style="background-color: #2563eb; color: white; border: none; padding: 10px 15px; border-radius: 8px; cursor: pointer;">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </form>
                </div>
            </div>

            <script>
                function toggleChatWindow() {
                    const win = document.getElementById('chat-window');
                    win.style.display = (win.style.display === 'none' || win.style.display === '') ? 'flex' : 'none';
                }

                function kirimPesanChat(event) {
                    event.preventDefault();
                    const input = document.getElementById('chat-input');
                    const msg = input.value.trim();
                    if(!msg) return;

                    renderBalon('user', msg);
                    input.value = '';
                    renderBalon('ai', 'Sedang mengetik...', true);

                    fetch("{{ route('chatbot.send') }}", {
                        method: "POST",
                        headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": "{{ csrf_token() }}" },
                        body: JSON.stringify({ message: msg })
                    })
                    .then(res => res.json())
                    .then(data => {
                        hapusLoading();
                        renderBalon('ai', data.reply);
                    })
                    .catch(e => {
                        hapusLoading();
                        renderBalon('ai', '⚠️ Error: Gagal terhubung ke server.');
                    });
                }

                function renderBalon(sender, text, isLoad = false) {
                    const container = document.getElementById('chat-messages');
                    const div = document.createElement('div');
                    if(isLoad) div.id = 'chat-loading';
                    
                    div.style.cssText = sender === 'user' 
                        ? "align-self: flex-end; background-color: #2563eb; color: white; padding: 10px; border-radius: 10px 10px 0 10px; max-width: 85%; font-size: 13px;"
                        : "align-self: flex-start; background-color: white; color: #333; padding: 10px; border-radius: 10px 10px 10px 0; border: 1px solid #eee; max-width: 85%; font-size: 13px;";
                    
                    div.innerHTML = text;
                    container.appendChild(div);
                    container.scrollTop = container.scrollHeight;
                }

                function hapusLoading() {
                    const el = document.getElementById('chat-loading');
                    if(el) el.remove();
                }
            </script>
        @endif

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            @if(session('success')) Swal.fire({ icon: 'success', title: 'BERHASIL!', text: "{{ session('success') }}", showConfirmButton: false, timer: 2000 }); @endif
            @if(session('error')) Swal.fire({ icon: 'error', title: 'GAGAL!', text: "{{ session('error') }}" }); @endif
            
            document.addEventListener('DOMContentLoaded', function() {
                const deleteForms = document.querySelectorAll('.delete-form');
                deleteForms.forEach(form => {
                    form.addEventListener('submit', function(e) {
                        e.preventDefault();
                        Swal.fire({ title: 'Yakin hapus?', text: "Data hilang permanen!", icon: 'warning', showCancelButton: true, confirmButtonColor: '#d33', cancelButtonColor: '#3085d6', confirmButtonText: 'Ya, Hapus!'
                        }).then((res) => { if (res.isConfirmed) form.submit(); });
                    });
                });
            });

            function togglePassword(inputId, iconId) {
                const input = document.getElementById(inputId); const icon = document.getElementById(iconId);
                if (input.type === "password") { input.type = "text"; icon.classList.remove("fa-eye"); icon.classList.add("fa-eye-slash"); } 
                else { input.type = "password"; icon.classList.remove("fa-eye-slash"); icon.classList.add("fa-eye"); }
            }
        </script>
    </body>
</html>