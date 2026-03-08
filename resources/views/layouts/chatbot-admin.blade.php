<div id="chat-button" onclick="toggleChatWindow()" 
     class="fixed bottom-8 right-8 z-[9999] bg-gradient-to-br from-blue-600 to-indigo-700 text-white px-6 py-4 rounded-full cursor-pointer shadow-2xl shadow-blue-500/40 flex items-center gap-3 border-2 border-white transition-all duration-300 hover:scale-105 active:scale-95 group">
    <div class="relative">
        <i class="fas fa-robot text-xl"></i>
        <span class="absolute -top-1 -right-1 w-2.5 h-2.5 bg-green-400 border-2 border-white rounded-full"></span>
    </div>
    <span class="font-black text-xs uppercase tracking-widest">Chat AI (Staff)</span>
</div>

<div id="chat-window" class="hidden fixed bottom-24 right-8 z-[9999] w-[380px] h-[550px] bg-white rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.15)] border border-white flex flex-col overflow-hidden transition-all duration-300 transform scale-95 opacity-0">
    <div class="bg-gradient-to-r from-blue-700 to-indigo-600 p-5 text-white flex justify-between items-center">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-white/20 backdrop-blur-md rounded-xl flex items-center justify-center border border-white/30"><i class="fas fa-user-nurse"></i></div>
            <div>
                <span class="block font-black text-sm tracking-tight leading-tight">Asisten AI Staff</span>
                <span class="text-[10px] font-bold text-blue-100 uppercase tracking-tighter opacity-80">Full Access RAG System</span>
            </div>
        </div>
        <button onclick="toggleChatWindow()" class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center"><i class="fas fa-times"></i></button>
    </div>
    <div id="chat-messages" class="flex-1 p-5 overflow-y-auto bg-slate-50 flex flex-col gap-4">
        <div class="flex flex-col items-start max-w-[85%] msg-anim">
            <span class="text-[9px] font-black text-slate-400 ml-1 mb-1 uppercase tracking-widest">Asisten AI</span>
            <div class="bg-white text-slate-700 p-3.5 rounded-2xl rounded-tl-none shadow-sm border border-slate-100 text-sm leading-relaxed">
                Halo <b>{{ Auth::user()->name }}</b>! 👋 Ada data operasional atau stok obat yang ingin Anda cek?
            </div>
        </div>
    </div>
    <div class="p-5 bg-white border-t border-slate-100">
        <form onsubmit="kirimChatAdmin(event)" class="flex items-center gap-2 bg-slate-100 rounded-2xl p-1.5 focus-within:bg-white focus-within:border-blue-400 transition-all">
            <input type="text" id="admin-input" placeholder="Tanya stok, pendapatan, atau data..." class="flex-1 bg-transparent border-none focus:ring-0 text-sm px-3 py-2 text-slate-700 outline-none font-medium" autocomplete="off" required>
            <button type="submit" class="w-10 h-10 rounded-xl bg-blue-600 text-white flex items-center justify-center shadow-lg"><i class="fas fa-paper-plane text-xs"></i></button>
        </form>
    </div>
</div>

<script>
    function kirimChatAdmin(event) {
        event.preventDefault();
        const input = document.getElementById('admin-input');
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
        .then(data => { hapusLoading(); renderBalon('ai', data.reply); })
        .catch(e => { hapusLoading(); renderBalon('ai', '⚠️ Error server.'); });
    }
</script>