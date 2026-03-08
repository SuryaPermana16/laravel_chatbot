<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            /* Custom Scrollbar for Chat */
            #chat-messages::-webkit-scrollbar { width: 4px; }
            #chat-messages::-webkit-scrollbar-track { background: transparent; }
            #chat-messages::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
            
            /* Animasi Masuk Pesan */
            .msg-anim { animation: fadeInUp 0.3s ease-out forwards; }
            @keyframes fadeInUp {
                from { opacity: 0; transform: translateY(8px); }
                to { opacity: 1; transform: translateY(0); }
            }

            /* Animasi Mengetik (Dots) */
            .typing-dot { width: 4px; height: 4px; background: #94a3b8; border-radius: 50%; display: inline-block; animation: typingBounce 1.4s infinite ease-in-out both; }
            .typing-dot:nth-child(1) { animation-delay: -0.32s; }
            .typing-dot:nth-child(2) { animation-delay: -0.16s; }
            @keyframes typingBounce { 0%, 80%, 100% { transform: scale(0); } 40% { transform: scale(1); } }

            input::-ms-reveal, input::-ms-clear { display: none; }
        </style>
    </head>
    <body class="font-sans antialiased text-slate-900 bg-slate-50">
        <div class="min-h-screen">
            @include('layouts.navigation')

            <main>
                {{ $slot }}
            </main>
        </div>

        @if(Auth::check())
            @if(in_array(Auth::user()->role, ['admin', 'dokter', 'apoteker']))
                @include('layouts.chatbot-admin')
            @else
                @include('layouts.chatbot-user')
            @endif
        @endif

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        @if(session('login_success'))
        <script>
            const Toast = Swal.mixin({
                toast: true, position: 'top-end', showConfirmButton: false, timer: 4000, timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });
            Toast.fire({ icon: 'success', title: "{{ session('login_success') }}" });
        </script>
        @endif

        @if(session('success')) 
        <script>
            Swal.fire({ icon: 'success', title: 'BERHASIL!', text: "{{ session('success') }}", showConfirmButton: false, timer: 2500, customClass: { popup: 'rounded-[2rem]' } }); 
        </script>
        @endif

        @if(session('error')) 
        <script>
            Swal.fire({ icon: 'error', title: 'GAGAL!', text: "{{ session('error') }}", customClass: { popup: 'rounded-[2rem]' } }); 
        </script>
        @endif

        <script>
            /** 1. FUNGSI GLOBAL CHATBOT (Digunakan oleh Admin & User Partial) **/
            function toggleChatWindow() {
                const win = document.getElementById('chat-window');
                if (!win) return;
                if (win.classList.contains('hidden')) {
                    win.classList.remove('hidden');
                    setTimeout(() => {
                        win.classList.remove('scale-95', 'opacity-0');
                        win.classList.add('scale-100', 'opacity-100', 'flex');
                    }, 10);
                } else {
                    win.classList.add('scale-95', 'opacity-0');
                    setTimeout(() => {
                        win.classList.add('hidden');
                        win.classList.remove('flex', 'scale-100', 'opacity-100');
                    }, 300);
                }
            }

            function renderBalon(sender, text, isLoad = false) {
                const container = document.getElementById('chat-messages');
                const divWrap = document.createElement('div');
                
                if(isLoad) {
                    divWrap.id = 'chat-loading';
                    divWrap.className = "flex flex-col items-start msg-anim";
                    divWrap.innerHTML = `
                        <div class="bg-white p-4 rounded-2xl rounded-tl-none shadow-sm border border-slate-100 flex gap-1">
                            <span class="typing-dot"></span><span class="typing-dot"></span><span class="typing-dot"></span>
                        </div>`;
                } else {
                    if (sender === 'user') {
                        divWrap.className = "flex flex-col items-end msg-anim";
                        divWrap.innerHTML = `
                            <div class="bg-slate-800 text-white p-3.5 rounded-2xl rounded-tr-none shadow-md max-w-[85%] text-sm leading-relaxed border border-slate-700">
                                ${text.replace(/\n/g, '<br>')}
                            </div>`;
                    } else {
                        divWrap.className = "flex flex-col items-start msg-anim";
                        divWrap.innerHTML = `
                            <span class="text-[9px] font-black text-slate-400 ml-1 mb-1 uppercase tracking-widest">Asisten AI</span>
                            <div class="bg-white text-slate-700 p-3.5 rounded-2xl rounded-tl-none shadow-sm border border-slate-100 max-w-[85%] text-sm leading-relaxed">
                                ${text.replace(/\n/g, '<br>')}
                            </div>`;
                    }
                }
                container.appendChild(divWrap);
                container.scrollTop = container.scrollHeight;
            }

            function hapusLoading() {
                const el = document.getElementById('chat-loading');
                if(el) el.remove();
            }

            /** 2. KONFIRMASI HAPUS DATA **/
            document.addEventListener('DOMContentLoaded', function() {
                const deleteForms = document.querySelectorAll('.delete-form');
                deleteForms.forEach(form => {
                    form.addEventListener('submit', function(e) {
                        e.preventDefault();
                        Swal.fire({ 
                            title: 'Yakin ingin menghapus?', text: "Data yang dihapus tidak bisa dikembalikan!", icon: 'warning', 
                            showCancelButton: true, confirmButtonColor: '#2563eb', cancelButtonColor: '#64748b', 
                            confirmButtonText: 'Ya, Hapus!', cancelButtonText: 'Batal',
                            customClass: { popup: 'rounded-[2rem]', confirmButton: 'rounded-xl font-bold', cancelButton: 'rounded-xl font-bold' }
                        }).then((res) => { if (res.isConfirmed) form.submit(); });
                    });
                });
            });

            /** 3. PASSWORD TOGGLE **/
            function togglePassword(inputId, iconId) {
                const input = document.getElementById(inputId); 
                const icon = document.getElementById(iconId);
                if (input.type === "password") { 
                    input.type = "text"; icon.classList.replace("fa-eye", "fa-eye-slash"); 
                } else { 
                    input.type = "password"; icon.classList.replace("fa-eye-slash", "fa-eye"); 
                }
            }
        </script>
    </body>
</html>