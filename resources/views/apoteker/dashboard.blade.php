<x-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div id="minimizedIndicator" class="fixed bottom-8 left-8 z-[2147483647] hidden">
        <button onclick="restoreModal()" class="group bg-teal-600 hover:bg-teal-700 text-white px-6 py-4 rounded-full shadow-2xl flex items-center border-4 border-white transition-all transform hover:scale-105 hover:-translate-y-2">
            <div class="bg-teal-800 bg-opacity-50 w-10 h-10 rounded-full mr-3 flex items-center justify-center animate-pulse">
                <i class="fas fa-file-invoice-dollar text-xl"></i>
            </div>
            <div class="text-left leading-tight">
                <span class="block text-[10px] uppercase font-bold text-teal-200 tracking-wider">Transaksi Aktif</span>
                <span class="block text-sm font-black tracking-wide">LANJUTKAN BAYAR</span>
            </div>
        </button>
    </div>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <div class="bg-gradient-to-r from-teal-600 to-emerald-500 rounded-[2rem] p-8 md:p-10 shadow-lg shadow-teal-200 relative overflow-hidden text-white">
                <div class="absolute -right-10 -top-10 opacity-20 pointer-events-none">
                    <i class="fas fa-pills text-9xl"></i>
                </div>
                
                <div class="flex flex-col md:flex-row md:justify-between md:items-center relative z-10 gap-6">
                    <div>
                        <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-white/20 text-teal-50 text-xs font-bold rounded-full uppercase tracking-wider mb-4 border border-white/20 backdrop-blur-sm">
                            <span class="w-2 h-2 rounded-full bg-white animate-pulse"></span> Unit Farmasi & Kasir
                        </div>
                        <h2 class="text-3xl md:text-4xl font-extrabold mb-2 tracking-tight">Halo, {{ Auth::user()->name }}! 👋</h2>
                        <p class="text-teal-50 font-medium text-base">Selamat bertugas memantau stok obat dan melayani transaksi pasien.</p>
                    </div>
                    <div class="flex flex-col items-start md:items-end gap-2">
                        <div class="text-sm text-teal-50 bg-white/10 backdrop-blur-md border border-white/20 px-6 py-4 rounded-2xl font-bold shadow-sm flex items-center gap-3 w-fit">
                            <i class="far fa-calendar-check text-2xl"></i> 
                            <div>
                                <div class="text-[10px] text-teal-100 uppercase tracking-wider">Hari Ini</div>
                                <span>{{ now()->translatedFormat('l, d F Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 gap-4">
                    <h3 class="font-extrabold text-xl text-gray-900 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center text-lg">
                            <i class="fas fa-boxes"></i>
                        </div>
                        Papan Stok & Harga Obat
                    </h3>
                    <a href="{{ route('apoteker.obat.index') }}" class="inline-flex items-center text-sm text-teal-600 hover:text-teal-800 font-bold bg-teal-50 hover:bg-teal-100 px-4 py-2 rounded-lg transition">
                        Kelola Katalog Penuh <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>

                <div class="bg-white overflow-hidden shadow-[0_8px_30px_rgb(0,0,0,0.04)] sm:rounded-[2rem] border border-gray-100">
                    <div class="overflow-x-auto max-h-64 scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-transparent"> 
                        <table class="min-w-full table-auto relative">
                            <thead class="bg-gray-50/90 backdrop-blur-sm sticky top-0 z-10 border-b border-gray-100">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Nama Obat</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Harga Satuan</th>
                                    <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Sisa Stok</th>
                                    <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Update Cepat</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50 bg-white">
                                @forelse($obats as $obat)
                                <tr class="hover:bg-teal-50/30 transition duration-150 group">
                                    <td class="px-6 py-3">
                                        <div class="font-bold text-gray-800 text-sm">{{ $obat->nama_obat }}</div>
                                        <div class="text-[10px] text-gray-400 font-bold tracking-wider uppercase mt-0.5">{{ $obat->jenis_obat ?? $obat->satuan }}</div>
                                    </td>
                                    <td class="px-6 py-3">
                                        <span class="text-emerald-700 font-bold text-sm bg-emerald-50 px-2.5 py-1 rounded border border-emerald-100">
                                            Rp {{ number_format($obat->harga, 0, ',', '.') }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-3 text-center">
                                        @if($obat->stok <= 10)
                                            <span class="inline-block text-red-600 font-extrabold text-sm bg-red-50 border border-red-200 px-3 py-1 rounded-lg animate-pulse" title="Stok Kritis!">{{ $obat->stok }}</span>
                                        @else
                                            <span class="inline-block text-gray-700 font-bold text-sm bg-gray-50 border border-gray-200 px-3 py-1 rounded-lg">{{ $obat->stok }}</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-3 text-center">
                                        <form action="{{ route('apoteker.obat.updateStok', $obat->id) }}" method="POST" class="flex justify-center items-center gap-2 opacity-100 sm:opacity-50 group-hover:opacity-100 transition-opacity">
                                            @csrf
                                            @method('PATCH')
                                            <input type="number" name="stok" value="{{ $obat->stok }}" 
                                                class="w-16 text-center text-sm font-bold border-gray-300 rounded-lg shadow-sm focus:ring-teal-500 focus:border-teal-500 py-1.5 outline-none" required>
                                            <button type="submit" class="bg-teal-100 text-teal-600 hover:bg-teal-600 hover:text-white transition rounded-lg p-2" title="Simpan Perubahan Stok">
                                                <i class="fas fa-save"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-10 text-center text-gray-400 italic">Belum ada data obat di inventaris.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div>
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 gap-4">
                    <h3 class="font-extrabold text-xl text-gray-900 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-lg">
                            <i class="fas fa-cash-register"></i>
                        </div>
                        Antrean Tebus Resep & Kasir
                    </h3>
                    <span class="bg-blue-600 text-white text-xs font-bold px-4 py-1.5 rounded-full shadow-md uppercase tracking-wider flex items-center">
                        <span class="w-2 h-2 bg-white rounded-full mr-2 animate-pulse"></span> {{ $antreanObat->count() }} Menunggu
                    </span>
                </div>

                <div class="bg-white overflow-hidden shadow-[0_8px_30px_rgb(0,0,0,0.04)] sm:rounded-[2rem] border border-gray-100">
                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto">
                            <thead class="bg-gray-50 border-b border-gray-100">
                                <tr>
                                    <th class="px-8 py-5 text-center text-xs font-bold text-gray-500 uppercase tracking-wider w-24">No</th>
                                    <th class="px-8 py-5 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Info Pasien & Dokter</th>
                                    <th class="px-8 py-5 text-left text-xs font-bold text-gray-500 uppercase tracking-wider w-1/2">Catatan Resep Obat</th>
                                    <th class="px-8 py-5 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi Kasir</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 bg-white">
                                @forelse($antreanObat as $item)
                                <tr class="hover:bg-blue-50/30 transition duration-200">
                                    <td class="px-8 py-5 text-center">
                                        <span class="inline-block bg-gray-900 text-white font-extrabold text-base px-4 py-2 rounded-xl shadow-sm whitespace-nowrap">
                                            {{ $item->no_antrian }}
                                        </span>
                                    </td>
                                    <td class="px-8 py-5">
                                        <div class="font-bold text-gray-900 text-base mb-1">{{ $item->pasien->nama_lengkap }}</div>
                                        <div class="text-xs font-medium text-gray-500 flex items-center gap-2">
                                            <span class="bg-gray-100 px-2 py-0.5 rounded border border-gray-200"><i class="fas fa-user-md mr-1 text-gray-400"></i>Dr. {{ $item->dokter->nama_lengkap }}</span>
                                        </div>
                                    </td>
                                    <td class="px-8 py-5">
                                        <div class="text-sm text-gray-700 bg-yellow-50/50 p-4 rounded-xl border border-yellow-100 leading-relaxed font-medium">
                                            @if($item->resep_obat)
                                                {!! nl2br(e($item->resep_obat)) !!}
                                            @else
                                                <span class="italic text-gray-400">Tidak ada resep obat (hanya bayar jasa).</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-8 py-5 text-center">
                                        <button onclick="openModal('{{ $item->id }}', '{{ $item->pasien->nama_lengkap }}', {{ $item->dokter->harga_jasa }})" 
                                            class="inline-flex items-center justify-center gap-2 bg-blue-600 text-white px-5 py-3 rounded-xl font-bold text-xs uppercase tracking-wider hover:bg-blue-700 transition shadow-lg shadow-blue-200 transform hover:-translate-y-0.5 whitespace-nowrap">
                                            <i class="fas fa-cart-plus text-sm"></i> Proses Bayar
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-8 py-20 text-center text-gray-400">
                                        <div class="flex flex-col items-center justify-center">
                                            <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center text-gray-300 text-3xl mb-4">
                                                <i class="fas fa-check-double"></i>
                                            </div>
                                            <h4 class="font-bold text-gray-500 text-lg mb-1">Kasir Kosong</h4>
                                            <p class="text-gray-400 text-sm">Tidak ada antrean pembayaran atau resep saat ini.</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div>
                <div class="flex justify-between items-end mb-4">
                    <h3 class="font-extrabold text-xl text-gray-900 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg">
                            <i class="fas fa-history"></i>
                        </div>
                        Riwayat Transaksi Terakhir
                    </h3>
                    <span class="text-xs font-bold text-gray-500 bg-gray-100 px-3 py-1.5 rounded-lg border border-gray-200">5 Transaksi Terbaru</span>
                </div>

                <div class="bg-white overflow-hidden shadow-[0_8px_30px_rgb(0,0,0,0.04)] sm:rounded-[2rem] border border-gray-100">
                    <div class="overflow-x-auto p-0">
                        <table class="min-w-full table-auto text-left">
                            <thead class="bg-gray-50 border-b border-gray-100">
                                <tr>
                                    <th class="px-8 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Waktu</th>
                                    <th class="px-8 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Info Pasien</th>
                                    <th class="px-8 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Rincian Biaya</th>
                                    <th class="px-8 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Total Bayar</th>
                                    <th class="px-8 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50 bg-white">
                                @if(isset($riwayatTransaksi) && $riwayatTransaksi->count() > 0)
                                    @foreach($riwayatTransaksi as $riwayat)
                                    <tr class="hover:bg-slate-50 transition duration-150">
                                        <td class="px-8 py-5 whitespace-nowrap text-sm">
                                            <span class="inline-flex items-center font-bold text-gray-600 bg-gray-100 px-2.5 py-1 rounded-md border border-gray-200">
                                                <i class="far fa-clock mr-1.5 text-gray-400"></i> {{ \Carbon\Carbon::parse($riwayat->updated_at)->format('H:i') }} WIB
                                            </span>
                                        </td>
                                        <td class="px-8 py-5">
                                            <div class="font-bold text-gray-900">{{ $riwayat->pasien->nama_lengkap }}</div>
                                            <div class="text-xs font-medium text-gray-500 mt-0.5">Dr. {{ $riwayat->dokter->nama_lengkap }}</div>
                                        </td>
                                        <td class="px-8 py-5">
                                            <div class="flex flex-col gap-1.5">
                                                <span class="text-[11px] font-bold bg-blue-50 text-blue-700 border border-blue-100 px-2 py-0.5 rounded-md w-fit uppercase tracking-wider">
                                                    Jasa: Rp {{ number_format($riwayat->biaya_jasa_dokter, 0, ',', '.') }}
                                                </span>
                                                <span class="text-[11px] font-bold bg-amber-50 text-amber-700 border border-amber-100 px-2 py-0.5 rounded-md w-fit uppercase tracking-wider">
                                                    Obat: Rp {{ number_format($riwayat->biaya_obat, 0, ',', '.') }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="px-8 py-5 text-right">
                                            <span class="font-black text-gray-900 text-lg">
                                                Rp {{ number_format($riwayat->total_bayar, 0, ',', '.') }}
                                            </span>
                                        </td>
                                        <td class="px-8 py-5 text-center">
                                            <span class="inline-flex items-center bg-emerald-50 text-emerald-600 text-xs font-bold px-3 py-1 rounded-full border border-emerald-200 uppercase tracking-wide">
                                                <i class="fas fa-check mr-1.5"></i> Lunas
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5" class="px-8 py-12 text-center text-gray-400 italic">Belum ada transaksi selesai hari ini.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div id="paymentModal" class="fixed inset-0 hidden overflow-y-auto" style="z-index: 9000;" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-slate-900 bg-opacity-70 backdrop-blur-sm transition-opacity" onclick="minimizeModal()"></div>

            <div class="inline-block align-bottom bg-white rounded-[2rem] text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl sm:w-full relative border border-gray-100" style="z-index: 9001;">
                
                <div class="bg-gradient-to-r from-blue-700 to-blue-600 px-8 py-5 flex justify-between items-center">
                    <h3 class="text-xl font-extrabold text-white flex items-center tracking-wide">
                        <i class="fas fa-cash-register mr-3 opacity-80"></i> Mesin Kasir Apotek
                    </h3>
                    <div class="flex items-center space-x-2">
                        <button onclick="minimizeModal()" type="button" class="text-blue-100 hover:text-white transition w-8 h-8 flex items-center justify-center bg-blue-800/50 hover:bg-blue-800 rounded-full" title="Minimize (Sembunyikan Sementara)">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button onclick="closeModal()" type="button" class="text-red-200 hover:text-white transition w-8 h-8 flex items-center justify-center bg-red-900/30 hover:bg-red-500 rounded-full" title="Batal Transaksi">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>

                <form id="paymentForm" method="POST" action="">
                    @csrf
                    @method('PATCH')
                    
                    <div class="p-8 bg-white">
                        <div class="flex justify-between items-center mb-6 bg-slate-50 p-5 rounded-2xl border border-gray-100">
                            <div>
                                <p class="text-[10px] text-gray-500 uppercase font-bold tracking-wider mb-1">Nama Pasien</p>
                                <p class="text-xl font-extrabold text-gray-900" id="modalPasienName">-</p>
                            </div>
                            <div class="text-right">
                                <p class="text-[10px] text-gray-500 uppercase font-bold tracking-wider mb-1">Biaya Jasa Dokter</p>
                                <p class="text-xl font-black text-blue-600">Rp <span id="modalJasaDokter">0</span></p>
                            </div>
                        </div>

                        <div class="mb-6 relative bg-white border border-gray-200 p-5 rounded-2xl shadow-sm">
                            <label class="block text-sm font-bold text-gray-800 mb-3"><i class="fas fa-search mr-2 text-gray-400"></i> Cari & Masukkan Obat</label>
                            <div class="flex flex-col sm:flex-row gap-3">
                                <div class="relative flex-1">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-pills text-gray-400"></i>
                                    </div>
                                    <input type="text" id="searchObat" 
                                           class="w-full pl-10 pr-4 py-3 rounded-xl border-gray-200 bg-slate-50 focus:bg-white shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 outline-none transition" 
                                           placeholder="Ketik nama obat di sini..." autocomplete="off" onkeyup="filterObat()">
                                    
                                    <div id="obatDropdownList" class="hidden absolute z-20 w-full bg-white border border-gray-200 mt-2 rounded-xl shadow-2xl max-h-56 overflow-y-auto">
                                        @foreach($obats as $obat)
                                            <div class="obat-option px-5 py-3 hover:bg-blue-50 cursor-pointer border-b border-gray-50 transition"
                                                 onclick="selectObat('{{ $obat->id }}', '{{ addslashes($obat->nama_obat) }}', '{{ $obat->harga }}', '{{ $obat->stok }}')"
                                                 data-nama="{{ strtolower($obat->nama_obat) }}">
                                                <div class="flex justify-between items-center mb-1">
                                                    <span class="font-bold text-gray-800">{{ $obat->nama_obat }}</span>
                                                    <span class="text-[10px] font-bold text-blue-600 bg-blue-50 px-2 py-0.5 rounded border border-blue-100 uppercase">Sisa: {{ $obat->stok }}</span>
                                                </div>
                                                <div class="text-sm font-medium text-gray-500">Rp {{ number_format($obat->harga, 0, ',', '.') }} / {{ $obat->satuan ?? 'pcs' }}</div>
                                            </div>
                                        @endforeach
                                        <div id="noObatFound" class="hidden px-5 py-4 text-sm text-gray-500 text-center italic bg-gray-50">Tidak ada obat yang cocok.</div>
                                    </div>
                                </div>

                                <div class="flex gap-3">
                                    <input type="number" id="inputQty" class="w-20 py-3 rounded-xl border-gray-200 bg-slate-50 text-center font-bold text-gray-700 shadow-sm focus:border-blue-500 outline-none" placeholder="Qty" min="1" value="1">
                                    <button type="button" onclick="addObatToTable()" class="bg-gray-900 hover:bg-black text-white px-5 py-3 rounded-xl font-bold shadow-md transition flex items-center justify-center gap-2">
                                        <i class="fas fa-plus"></i> <span class="hidden sm:inline">Add</span>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden mb-6 shadow-sm">
                            <table class="min-w-full text-left">
                                <thead class="bg-gray-50 border-b border-gray-200">
                                    <tr>
                                        <th class="px-5 py-3 text-xs font-bold text-gray-500 uppercase">Daftar Obat Dibeli</th>
                                        <th class="px-5 py-3 text-center text-xs font-bold text-gray-500 uppercase">Qty</th>
                                        <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase">Subtotal</th>
                                        <th class="px-5 py-3 text-center text-xs font-bold text-gray-500 uppercase"><i class="fas fa-trash-alt"></i></th>
                                    </tr>
                                </thead>
                                <tbody id="cartTableBody" class="divide-y divide-gray-100"></tbody>
                            </table>
                            <div id="emptyCartMessage" class="p-8 text-center text-gray-400 flex flex-col items-center">
                                <i class="fas fa-shopping-basket text-4xl mb-3 text-gray-200"></i>
                                <span class="font-medium text-sm">Keranjang obat masih kosong.</span>
                            </div>
                        </div>

                        <div class="flex justify-between items-center bg-emerald-50 p-6 rounded-2xl border border-emerald-200">
                            <div>
                                <span class="block text-emerald-800 font-extrabold uppercase tracking-wider text-sm">Grand Total Bayar</span>
                                <span class="block text-xs text-emerald-600 mt-1">Jasa Dokter + Total Obat</span>
                            </div>
                            <span class="text-4xl font-black text-emerald-700">Rp <span id="grandTotal">0</span></span>
                        </div>
                    </div>

                    <div class="px-8 py-5 bg-gray-50 border-t border-gray-200 text-right flex justify-end gap-3 rounded-b-[2rem]">
                        <button type="button" onclick="closeModal()" class="px-6 py-3 bg-white border border-gray-300 hover:bg-gray-100 text-gray-700 rounded-xl font-bold transition">Batal</button>
                        <button type="submit" class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold shadow-lg shadow-blue-200 transition transform hover:-translate-y-0.5 flex items-center gap-2">
                            <i class="fas fa-check-circle"></i> Selesaikan Transaksi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        let cart = [];
        let jasaDokterValue = 0;
        let selectedObatTemp = null; 

        function openModal(id, namaPasien, jasaDokter) {
            cart = []; renderCart();
            document.getElementById('searchObat').value = "";
            document.getElementById('inputQty').value = 1;
            selectedObatTemp = null;
            
            jasaDokterValue = jasaDokter;
            document.getElementById('modalPasienName').innerText = namaPasien;
            document.getElementById('modalJasaDokter').innerText = new Intl.NumberFormat('id-ID').format(jasaDokter);
            document.getElementById('paymentForm').action = "/apoteker/dashboard/" + id + "/selesai";
            updateGrandTotal();
            
            document.getElementById('minimizedIndicator').style.display = 'none';
            document.getElementById('paymentModal').classList.remove('hidden');
        }

        function closeModal() { 
            document.getElementById('paymentModal').classList.add('hidden');
            document.getElementById('minimizedIndicator').style.display = 'none';
        }

        function minimizeModal() {
            document.getElementById('paymentModal').classList.add('hidden');
            document.getElementById('minimizedIndicator').style.display = 'block'; 
        }

        function restoreModal() {
            document.getElementById('paymentModal').classList.remove('hidden');
            document.getElementById('minimizedIndicator').style.display = 'none';
        }

        function filterObat() {
            const input = document.getElementById('searchObat').value.toLowerCase();
            const dropdown = document.getElementById('obatDropdownList');
            const options = dropdown.getElementsByClassName('obat-option');
            const noFound = document.getElementById('noObatFound');
            let hasResult = false;

            if(input.length > 0) { dropdown.classList.remove('hidden'); } else { dropdown.classList.add('hidden'); }

            for (let i = 0; i < options.length; i++) {
                const nama = options[i].getAttribute('data-nama');
                if (nama.includes(input)) { options[i].style.display = ""; hasResult = true; } 
                else { options[i].style.display = "none"; }
            }
            if(!hasResult) { noFound.classList.remove('hidden'); } else { noFound.classList.add('hidden'); }
        }

        function selectObat(id, nama, harga, stok) {
            document.getElementById('searchObat').value = nama;
            document.getElementById('obatDropdownList').classList.add('hidden');
            selectedObatTemp = { id: id, nama: nama, harga: parseInt(harga), stok: parseInt(stok) };
        }

        function addObatToTable() {
            const qtyInput = document.getElementById('inputQty');
            const qty = parseInt(qtyInput.value);

            if (!selectedObatTemp) { Swal.fire('Pilih Obat', 'Silakan cari dan klik obat dari dropdown terlebih dahulu.', 'warning'); return; }
            if (qty > selectedObatTemp.stok) { Swal.fire('Stok Tidak Cukup!', 'Sisa stok ' + selectedObatTemp.nama + ' hanya ' + selectedObatTemp.stok, 'error'); return; }

            const existingItem = cart.find(item => item.id === selectedObatTemp.id);
            if (existingItem) {
                if (existingItem.qty + qty > selectedObatTemp.stok) { Swal.fire('Stok Tidak Cukup!', 'Total obat ini di keranjang melebihi stok yang ada.', 'error'); return; }
                existingItem.qty += qty;
                existingItem.subtotal = existingItem.qty * selectedObatTemp.harga;
            } else {
                cart.push({ id: selectedObatTemp.id, nama: selectedObatTemp.nama, harga: selectedObatTemp.harga, qty: qty, subtotal: qty * selectedObatTemp.harga });
            }
            renderCart(); updateGrandTotal();
            
            // Reset input
            document.getElementById('searchObat').value = "";
            document.getElementById('inputQty').value = 1;
            selectedObatTemp = null; 
            document.getElementById('searchObat').focus();
        }

        function removeObat(index) { cart.splice(index, 1); renderCart(); updateGrandTotal(); }

        function renderCart() {
            const tbody = document.getElementById('cartTableBody');
            const emptyMsg = document.getElementById('emptyCartMessage');
            tbody.innerHTML = '';

            if (cart.length === 0) { emptyMsg.classList.remove('hidden'); } 
            else {
                emptyMsg.classList.add('hidden');
                cart.forEach((item, index) => {
                    tbody.innerHTML += `
                        <tr class="hover:bg-slate-50">
                            <td class="px-5 py-3 font-bold text-gray-800 text-sm">${item.nama}<input type="hidden" name="obat_id[]" value="${item.id}"></td>
                            <td class="px-5 py-3 text-center">
                                <span class="bg-slate-100 px-3 py-1 rounded-lg font-bold text-sm border border-slate-200">${item.qty}</span>
                                <input type="hidden" name="jumlah[]" value="${item.qty}">
                            </td>
                            <td class="px-5 py-3 text-right font-mono text-gray-700 font-medium">Rp ${new Intl.NumberFormat('id-ID').format(item.subtotal)}</td>
                            <td class="px-5 py-3 text-center">
                                <button type="button" onclick="removeObat(${index})" class="text-red-400 hover:text-red-600 bg-red-50 hover:bg-red-100 w-8 h-8 rounded-full transition flex items-center justify-center mx-auto">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </td>
                        </tr>`;
                });
            }
        }

        function updateGrandTotal() {
            let totalObat = cart.reduce((sum, item) => sum + item.subtotal, 0);
            document.getElementById('grandTotal').innerText = new Intl.NumberFormat('id-ID').format(totalObat + jasaDokterValue);
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const isClickInside = document.getElementById('searchObat').contains(event.target);
            if (!isClickInside) { document.getElementById('obatDropdownList').classList.add('hidden'); }
        });
    </script>
</x-app-layout>