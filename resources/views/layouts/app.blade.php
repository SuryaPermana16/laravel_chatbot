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
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-slate-50">
            @include('layouts.navigation')

            <main>
                {{ $slot }}
            </main>
        </div>

        @if(Auth::check() && in_array(Auth::user()->role, ['admin', 'dokter', 'apoteker']))
            
            <div id="chat-button" onclick="toggleChatWindow()" 
                 class="fixed bottom-8 right-8 z-[999999] bg-gradient-to-br from-blue-600 to-indigo-700 text-white px-6 py-4 rounded-full cursor-pointer shadow-2xl shadow-blue-500/40 flex items-center gap-3 border-2 border-white transition-all duration-300 hover:scale-105 active:scale-95 group">
                <div class="relative">
                    <i class="fas fa-robot text-xl"></i>
                    <span class="absolute -top-1 -right-1 w-2.5 h-2.5 bg-green-400 border-2 border-white rounded-full"></span>
                </div>
                <span class="font-black text-xs uppercase tracking-widest">Chat AI</span>
            </div>

            <div id="chat-window" 
                 class="hidden fixed bottom-24 right-8 z-[999999] w-[380px] h-[550px] bg-white rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.15)] border border-white flex-col overflow-hidden transition-all duration-300 transform scale-95 opacity-0">
                
                <div class="bg-gradient-to-r from-blue-700 to-indigo-600 p-5 text-white flex justify-between items-center relative overflow-hidden">
                    <i class="fas fa-heartbeat absolute -right-4 -top-4 text-6xl opacity-10"></i>
                    <div class="flex items-center gap-3 relative z-10">
                        <div class="w-10 h-10 bg-white/20 backdrop-blur-md rounded-xl flex items-center justify-center border border-white/30">
                            <i class="fas fa-user-nurse text-white"></i>
                        </div>
                        <div>
                            <span class="block font-black text-sm tracking-tight leading-tight">Asisten Virtual AI</span>
                            <span class="text-[10px] font-bold text-blue-100 uppercase tracking-tighter opacity-80">Bina Usada Smart Bot</span>
                        </div>
                    </div>
                    <button onclick="toggleChatWindow()" class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center transition">
                        <i class="fas fa-times text-sm"></i>
                    </button>
                </div>

                <div id="chat-messages" class="flex-1 p-5 overflow-y-auto bg-slate-50 flex flex-col gap-4 relative">
                    <div class="absolute inset-0 flex items-center justify-center opacity-[0.02] pointer-events-none">
                        <i class="fas fa-robot text-[150px]"></i>
                    </div>

                    <div class="flex flex-col items-start max-w-[85%] relative z-10 msg-anim">
                        <span class="text-[9px] font-black text-slate-400 ml-1 mb-1 uppercase tracking-widest">Asisten AI</span>
                        <div class="bg-white text-slate-700 p-3.5 rounded-2xl rounded-tl-none shadow-sm border border-slate-100 text-sm leading-relaxed">
                            Halo <b>{{ Auth::user()->name }}</b>! 👋 Ada yang bisa saya bantu terkait operasional klinik hari ini?
                        </div>
                    </div>
                </div>

                <div class="p-5 bg-white border-t border-slate-100">
                    <form onsubmit="kirimPesanChat(event)" class="flex items-center gap-2 bg-slate-100 rounded-2xl p-1.5 border border-transparent focus-within:bg-white focus-within:border-blue-400 focus-within:ring-4 focus-within:ring-blue-50 transition-all">
                        <input type="text" id="chat-input" placeholder="Tanya stok atau jadwal..." 
                               class="flex-1 bg-transparent border-none focus:ring-0 text-sm px-3 py-2 text-slate-700 outline-none font-medium">
                        <button type="submit" class="w-10 h-10 rounded-xl bg-blue-600 hover:bg-indigo-700 text-white flex items-center justify-center transition shadow-lg shadow-blue-200 active:scale-90">
                            <i class="fas fa-paper-plane text-xs"></i>
                        </button>
                    </form>
                    <p class="text-center text-[9px] text-slate-400 mt-3 font-bold uppercase tracking-tighter opacity-60">Powered by RAG AI Technology</p>
                </div>
            </div>

            <script>
                function toggleChatWindow() {
                    const win = document.getElementById('chat-window');
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

                function kirimPesanChat(event) {
                    event.preventDefault();
                    const input = document.getElementById('chat-input');
                    const msg = input.value.trim();
                    if(!msg) return;

                    renderBalon('user', msg);
                    input.value = '';
                    renderBalon('ai', '', true);

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
                        renderBalon('ai', '⚠️ <span class="text-red-500 font-bold">Error:</span> Gagal terhubung ke server AI.');
                    });
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
                                <div class="bg-gradient-to-br from-blue-600 to-indigo-700 text-white p-3.5 rounded-2xl rounded-tr-none shadow-md max-w-[85%] text-sm leading-relaxed border border-blue-500/20">
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
            </script>
        @endif

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            @if(session('success')) Swal.fire({ icon: 'success', title: 'BERHASIL!', text: "{{ session('success') }}", showConfirmButton: false, timer: 2000, customClass: { popup: 'rounded-[2rem]' } }); @endif
            @if(session('error')) Swal.fire({ icon: 'error', title: 'GAGAL!', text: "{{ session('error') }}", customClass: { popup: 'rounded-[2rem]' } }); @endif
            
            document.addEventListener('DOMContentLoaded', function() {
                const deleteForms = document.querySelectorAll('.delete-form');
                deleteForms.forEach(form => {
                    form.addEventListener('submit', function(e) {
                        e.preventDefault();
                        Swal.fire({ 
                            title: 'Yakin hapus?', 
                            text: "Data akan hilang permanen!", 
                            icon: 'warning', 
                            showCancelButton: true, 
                            confirmButtonColor: '#ef4444', 
                            cancelButtonColor: '#64748b', 
                            confirmButtonText: 'Ya, Hapus!',
                            customClass: { popup: 'rounded-[2rem]', confirmButton: 'rounded-xl', cancelButton: 'rounded-xl' }
                        }).then((res) => { if (res.isConfirmed) form.submit(); });
                    });
                });
            });

            function togglePassword(inputId, iconId) {
                const input = document.getElementById(inputId); 
                const icon = document.getElementById(iconId);
                if (input.type === "password") { 
                    input.type = "text"; 
                    icon.classList.replace("fa-eye", "fa-eye-slash"); 
                } else { 
                    input.type = "password"; 
                    icon.classList.replace("fa-eye-slash", "fa-eye"); 
                }
            }
        </script>
    </body>
</html>