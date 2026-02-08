<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chatbot Klinik Bina Usada</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* CSS Tambahan biar chat bisa di-scroll */
        #chat-box {
            height: 400px;
            overflow-y: auto;
            scroll-behavior: smooth;
        }
        /* Hilangkan scrollbar jelek tapi tetap bisa discroll */
        #chat-box::-webkit-scrollbar {
            width: 8px;
        }
        #chat-box::-webkit-scrollbar-thumb {
            background-color: #cbd5e0;
            border-radius: 4px;
        }
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="w-full max-w-md bg-white shadow-2xl rounded-xl overflow-hidden">
        <div class="bg-blue-600 p-4 text-white flex justify-between items-center shadow-md">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-blue-600 font-bold">
                    🤖
                </div>
                <div>
                    <h1 class="font-bold text-lg leading-tight">Asisten Klinik</h1>
                    <span class="text-xs text-blue-100 flex items-center gap-1">
                        <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span> Online
                    </span>
                </div>
            </div>
        </div>

        <div id="chat-box" class="p-4 flex flex-col space-y-3 bg-slate-50">
            <div class="self-start bg-white text-gray-800 p-3 rounded-tr-lg rounded-br-lg rounded-bl-lg shadow-sm border border-gray-100 max-w-[85%]">
                <p class="text-sm">Halo! 👋 Saya asisten virtual Klinik Bina Usada.</p>
                <p class="text-xs text-gray-500 mt-1">Coba tanya: "Stok obat", "Jadwal Dokter", atau "Syarat BPJS".</p>
            </div>
        </div>

        <div class="p-4 bg-white border-t border-gray-100">
            <div class="flex items-center bg-gray-100 rounded-full px-4 py-2">
                <input type="text" id="user-input" 
                    class="flex-1 bg-transparent border-none focus:ring-0 text-sm focus:outline-none" 
                    placeholder="Ketik pesan..." onkeypress="cekEnter(event)">
                
                <button onclick="kirimPesan()" 
                    class="ml-2 text-blue-600 hover:text-blue-800 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                        <path d="M3.478 2.405a.75.75 0 00-.926.94l2.432 7.905H13.5a.75.75 0 010 1.5H4.984l-2.432 7.905a.75.75 0 00.926.94 60.519 60.519 0 0018.445-8.986.75.75 0 000-1.218A60.517 60.517 0 003.478 2.405z" />
                    </svg>
                </button>
            </div>
            <p class="text-center text-[10px] text-gray-400 mt-2">Powered by Laravel 11 & RAG</p>
        </div>
    </div>

    <script>
        const chatBox = document.getElementById('chat-box');
        const userInput = document.getElementById('user-input');

        function cekEnter(e) {
            if (e.key === 'Enter') kirimPesan();
        }

        async function kirimPesan() {
            const pesan = userInput.value.trim();
            if (!pesan) return;

            // 1. Tampilkan Chat User (Kanan/Hijau)
            tambahBalon(pesan, 'user');
            userInput.value = '';

            // 2. Tampilkan Loading (Kiri)
            const loadingId = tambahBalon('Sedang mengetik...', 'bot', true);

            try {
                // 3. Tembak ke API Laravel
                const respon = await fetch('/api/chat', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ message: pesan })
                });

                const data = await respon.json();

                // 4. Ganti loading dengan jawaban asli
                document.getElementById(loadingId).remove();
                tambahBalon(data.reply, 'bot');

            } catch (error) {
                document.getElementById(loadingId).remove();
                tambahBalon("Maaf, koneksi terputus.", 'bot');
            }
        }

        function tambahBalon(teks, pengirim, isLoading = false) {
            const div = document.createElement('div');
            const id = 'msg-' + Date.now();
            div.id = id;

            if (pengirim === 'user') {
                // Style Chat User (Kanan - Biru)
                div.className = "self-end bg-blue-600 text-white p-3 rounded-tl-lg rounded-tr-lg rounded-bl-lg shadow-sm max-w-[85%] text-sm";
            } else {
                // Style Chat Bot (Kiri - Putih)
                div.className = "self-start bg-white text-gray-800 p-3 rounded-tr-lg rounded-br-lg rounded-bl-lg shadow-sm border border-gray-100 max-w-[85%] text-sm";
                if(isLoading) div.classList.add('italic', 'text-gray-400');
            }

            // Ganti enter jadi baris baru
            div.innerHTML = teks.replace(/\n/g, '<br>');
            
            chatBox.appendChild(div);
            chatBox.scrollTop = chatBox.scrollHeight; // Auto scroll
            return id;
        }
    </script>
</body>
</html>