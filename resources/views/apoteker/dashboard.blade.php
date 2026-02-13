<x-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div id="minimizedIndicator" style="position: fixed; bottom: 40px; right: 40px; z-index: 2147483647; display: none;">
        <button onclick="restoreModal()" class="group bg-blue-700 hover:bg-blue-800 text-white px-6 py-4 rounded-full shadow-2xl flex items-center border-4 border-white transition-all transform hover:scale-110">
            <div class="bg-blue-900 bg-opacity-50 p-2 rounded-full mr-3 animate-pulse">
                <i class="fas fa-file-invoice-dollar text-xl"></i>
            </div>
            <div class="text-left leading-tight">
                <span class="block text-[10px] uppercase font-bold text-blue-200 tracking-wider">Transaksi Tertunda</span>
                <span class="block text-sm font-black tracking-wide">LANJUTKAN BAYAR</span>
            </div>
        </button>
    </div>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8 border border-gray-100">
                <div class="p-6 text-gray-900 flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">Halo, {{ Auth::user()->name }}! 👋</h3>
                        <p class="text-gray-500 text-sm mt-1">Selamat bertugas di Farmasi Klinik Bina Usada.</p>
                    </div>
                    <div class="text-sm font-bold text-blue-600 bg-blue-50 px-4 py-2 rounded-lg border border-blue-100 flex items-center shadow-sm">
                        <i class="far fa-calendar-alt mr-2"></i>
                        {{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y') }}
                    </div>
                </div>
            </div>

            <div class="mb-8">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-bold text-xl text-gray-800 flex items-center">
                        <i class="fas fa-boxes mr-2 text-blue-600"></i> Informasi Stok & Harga Obat
                    </h3>
                    <a href="{{ route('apoteker.obat.index') }}" class="text-sm text-blue-600 hover:text-blue-800 font-bold hover:underline">
                        Lihat Semua Obat <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
                    <div class="overflow-x-auto max-h-64"> 
                        <table class="min-w-full table-auto relative">
                            <thead class="bg-gray-100 sticky top-0 z-10">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Nama Obat</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Harga</th>
                                    <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Stok</th>
                                    <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Update Cepat</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 bg-white">
                                @forelse($obats as $obat)
                                <tr class="hover:bg-blue-50/30 transition">
                                    <td class="px-6 py-3">
                                        <div class="font-bold text-gray-800 text-sm">{{ $obat->nama_obat }}</div>
                                        <div class="text-[10px] text-gray-400 uppercase">{{ $obat->jenis_obat }}</div>
                                    </td>
                                    <td class="px-6 py-3">
                                        <span class="text-green-600 font-bold text-sm bg-green-50 px-2 py-1 rounded border border-green-100">
                                            Rp {{ number_format($obat->harga, 0, ',', '.') }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-3 text-center">
                                        @if($obat->stok <= 5)
                                            <span class="text-red-600 font-bold text-sm animate-pulse bg-red-50 px-2 py-1 rounded">{{ $obat->stok }}</span>
                                        @else
                                            <span class="text-gray-700 font-bold text-sm">{{ $obat->stok }}</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-3 text-center">
                                        <form action="{{ route('apoteker.obat.updateStok', $obat->id) }}" method="POST" class="flex justify-center items-center gap-2">
                                            @csrf
                                            @method('PATCH')
                                            <input type="number" name="stok" value="{{ $obat->stok }}" 
                                                class="w-16 text-center text-xs border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500 py-1" required>
                                            <button type="submit" class="text-blue-500 hover:text-blue-700 hover:scale-110 transition transform p-1" title="Simpan Perubahan">
                                                <i class="fas fa-save text-lg"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center text-gray-400 italic">Belum ada data obat.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="mb-12">
                <div class="flex justify-between items-end mb-4">
                    <h3 class="font-bold text-xl text-gray-800 flex items-center">
                        <i class="fas fa-cash-register mr-2 text-blue-600"></i> Antrean Kasir & Resep
                    </h3>
                    <span class="bg-blue-600 text-white text-xs font-bold px-3 py-1 rounded-full shadow-sm">
                        {{ $antreanObat->count() }} Menunggu
                    </span>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto">
                            <thead class="bg-gray-50 border-b border-gray-100">
                                <tr>
                                    <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase">No</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">Pasien</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">Resep Dokter</th>
                                    <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 bg-white">
                                @forelse($antreanObat as $item)
                                <tr class="hover:bg-blue-50/30 transition">
                                    <td class="px-6 py-4 text-center font-bold text-blue-600">{{ $item->no_antrian }}</td>
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-gray-900">{{ $item->pasien->nama_lengkap }}</div>
                                        <div class="text-xs text-gray-500">Dr. {{ $item->dokter->nama_lengkap }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-600 bg-gray-50 p-3 rounded-xl border border-gray-100 italic min-w-[200px]">
                                            {!! nl2br(e($item->resep_obat)) !!}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <button onclick="openModal('{{ $item->id }}', '{{ $item->pasien->nama_lengkap }}', {{ $item->dokter->harga_jasa }})" 
                                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-bold text-xs uppercase shadow-md hover:shadow-lg transition transform active:scale-95">
                                            <i class="fas fa-cart-plus mr-1"></i> Proses Bayar
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-20 text-center opacity-50">
                                        <i class="fas fa-check-circle text-4xl text-gray-300 mb-2"></i>
                                        <p>Semua antrean selesai.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="mb-6">
                <div class="flex justify-between items-end mb-4">
                    <h3 class="font-bold text-xl text-gray-800 flex items-center">
                        <i class="fas fa-history mr-2 text-green-600"></i> Riwayat Transaksi Terakhir
                    </h3>
                    <span class="text-xs text-gray-500 italic">5 Transaksi Terbaru</span>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto">
                            <thead class="bg-gray-50 border-b border-gray-100">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">Waktu</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">Pasien</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">Rincian Biaya</th>
                                    <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase">Total Bayar</th>
                                    <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 bg-white">
                                @if(isset($riwayatTransaksi) && $riwayatTransaksi->count() > 0)
                                    @foreach($riwayatTransaksi as $riwayat)
                                    <tr class="hover:bg-green-50/30 transition duration-150">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <div class="flex items-center">
                                                <i class="far fa-clock mr-2 text-green-400"></i>
                                                {{ \Carbon\Carbon::parse($riwayat->updated_at)->format('H:i') }} WIB
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="font-bold text-gray-900">{{ $riwayat->pasien->nama_lengkap }}</div>
                                            <div class="text-xs text-gray-500">Dr. {{ $riwayat->dokter->nama_lengkap }}</div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-600">
                                            <div class="flex flex-col gap-1">
                                                <span class="text-xs bg-blue-50 text-blue-700 px-2 py-0.5 rounded w-fit">
                                                    Jasa: Rp {{ number_format($riwayat->biaya_jasa_dokter, 0, ',', '.') }}
                                                </span>
                                                <span class="text-xs bg-orange-50 text-orange-700 px-2 py-0.5 rounded w-fit">
                                                    Obat: Rp {{ number_format($riwayat->biaya_obat, 0, ',', '.') }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="font-black text-green-600 text-lg">
                                                Rp {{ number_format($riwayat->total_bayar, 0, ',', '.') }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="inline-flex items-center bg-green-100 text-green-800 text-xs font-bold px-3 py-1 rounded-full border border-green-200 uppercase tracking-wide">
                                                <i class="fas fa-check-circle mr-1.5"></i> Lunas
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5" class="px-6 py-12 text-center">
                                            <div class="flex flex-col items-center justify-center opacity-50">
                                                <i class="fas fa-receipt text-4xl text-gray-300 mb-3"></i>
                                                <p class="text-gray-500 font-medium text-sm">Belum ada transaksi hari ini.</p>
                                            </div>
                                        </td>
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
            <div class="fixed inset-0 bg-gray-900 bg-opacity-80 transition-opacity"></div>

            <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full relative" style="z-index: 9001;">
                
                <div class="bg-blue-600 px-6 py-4 flex justify-between items-center">
                    <h3 class="text-lg leading-6 font-bold text-white"><i class="fas fa-cash-register mr-2"></i> Kasir Apotek</h3>
                    
                    <div class="flex items-center space-x-3">
                        <button onclick="minimizeModal()" type="button" class="text-blue-200 hover:text-white transition p-1 hover:bg-blue-700 rounded" title="Minimize (Cek Resep)">
                            <i class="fas fa-window-minimize relative bottom-1"></i>
                        </button>
                        
                        <button onclick="closeModal()" type="button" class="text-blue-200 hover:text-white transition p-1 hover:bg-blue-700 rounded" title="Batal Transaksi">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>
                </div>

                <form id="paymentForm" method="POST" action="">
                    @csrf
                    @method('PATCH')
                    
                    <div class="p-6 bg-gray-50">
                        <div class="flex justify-between mb-4 border-b pb-4">
                            <div><p class="text-xs text-gray-500 uppercase font-bold">Pasien</p><p class="text-lg font-bold text-gray-800" id="modalPasienName">-</p></div>
                            <div class="text-right"><p class="text-xs text-gray-500 uppercase font-bold">Jasa Dokter</p><p class="text-lg font-bold text-blue-600">Rp <span id="modalJasaDokter">0</span></p></div>
                        </div>

                        <div class="mb-4 relative">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Cari & Tambah Obat</label>
                            <div class="flex gap-2">
                                <div class="relative flex-1">
                                    <input type="text" id="searchObat" 
                                           class="w-full px-4 rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                                           placeholder="Ketik nama obat..." 
                                           autocomplete="off"
                                           onkeyup="filterObat()">
                                    
                                    <div id="obatDropdownList" class="hidden absolute z-10 w-full bg-white border border-gray-200 mt-1 rounded-lg shadow-xl max-h-48 overflow-y-auto">
                                        @foreach($obats as $obat)
                                            <div class="obat-option px-4 py-3 hover:bg-blue-50 cursor-pointer border-b border-gray-50 transition"
                                                 onclick="selectObat('{{ $obat->id }}', '{{ addslashes($obat->nama_obat) }}', '{{ $obat->harga }}', '{{ $obat->stok }}')"
                                                 data-nama="{{ strtolower($obat->nama_obat) }}">
                                                <div class="flex justify-between">
                                                    <span class="font-bold text-gray-800">{{ $obat->nama_obat }}</span>
                                                    <span class="text-xs font-bold text-blue-600 bg-blue-50 px-2 py-0.5 rounded">Stok: {{ $obat->stok }}</span>
                                                </div>
                                                <div class="text-xs text-gray-500">Rp {{ number_format($obat->harga, 0, ',', '.') }}</div>
                                            </div>
                                        @endforeach
                                        <div id="noObatFound" class="hidden px-4 py-3 text-sm text-gray-500 text-center italic">Obat tidak ditemukan</div>
                                    </div>
                                </div>

                                <input type="number" id="inputQty" class="w-20 rounded-lg border-gray-300 shadow-sm text-center" placeholder="Jml" min="1" value="1">
                                
                                <button type="button" onclick="addObatToTable()" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg font-bold shadow-sm flex items-center">
                                    <i class="fas fa-plus mr-1"></i> Add
                                </button>
                            </div>
                        </div>

                        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden mb-4 shadow-sm">
                            <table class="min-w-full text-sm">
                                <thead class="bg-gray-100">
                                    <tr><th class="px-4 py-2 text-left">Obat</th><th class="px-4 py-2 text-center">Qty</th><th class="px-4 py-2 text-right">Subtotal</th><th class="px-4 py-2 text-center">Hapus</th></tr>
                                </thead>
                                <tbody id="cartTableBody"></tbody>
                            </table>
                            <div id="emptyCartMessage" class="p-6 text-center text-gray-400 text-xs italic flex flex-col items-center">
                                <i class="fas fa-basket-shopping text-2xl mb-2 text-gray-300"></i>
                                Belum ada obat dipilih.
                            </div>
                        </div>

                        <div class="flex justify-between items-center bg-blue-50 p-4 rounded-xl border border-blue-100">
                            <span class="text-blue-800 font-bold uppercase text-sm">Total Bayar</span>
                            <span class="text-2xl font-black text-blue-700">Rp <span id="grandTotal">0</span></span>
                        </div>
                    </div>

                    <div class="px-6 py-4 bg-gray-100 text-right flex justify-end gap-3 rounded-b-2xl">
                        <button type="button" onclick="closeModal()" class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-gray-700 font-bold text-sm hover:bg-gray-50">Batal</button>
                        <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-bold text-sm shadow-md">
                            <i class="fas fa-save mr-2"></i> Simpan Transaksi
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

            if (!selectedObatTemp) { Swal.fire('Pilih Obat Dulu', 'Cari obat dulu', 'warning'); return; }
            if (qty > selectedObatTemp.stok) { Swal.fire('Stok Kurang!', 'Sisa: ' + selectedObatTemp.stok, 'error'); return; }

            const existingItem = cart.find(item => item.id === selectedObatTemp.id);
            if (existingItem) {
                if (existingItem.qty + qty > selectedObatTemp.stok) { Swal.fire('Stok Kurang!', 'Melebihi stok.', 'error'); return; }
                existingItem.qty += qty;
                existingItem.subtotal = existingItem.qty * selectedObatTemp.harga;
            } else {
                cart.push({ id: selectedObatTemp.id, nama: selectedObatTemp.nama, harga: selectedObatTemp.harga, qty: qty, subtotal: qty * selectedObatTemp.harga });
            }
            renderCart(); updateGrandTotal();
            document.getElementById('searchObat').value = "";
            document.getElementById('inputQty').value = 1;
            selectedObatTemp = null; 
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
                        <tr class="border-b">
                            <td class="px-4 py-2 font-bold text-gray-700">${item.nama}<input type="hidden" name="obat_id[]" value="${item.id}"></td>
                            <td class="px-4 py-2 text-center bg-gray-50 rounded font-bold">${item.qty}<input type="hidden" name="jumlah[]" value="${item.qty}"></td>
                            <td class="px-4 py-2 text-right font-mono text-blue-600">Rp ${new Intl.NumberFormat('id-ID').format(item.subtotal)}</td>
                            <td class="px-4 py-2 text-center"><button type="button" onclick="removeObat(${index})" class="text-red-500 hover:text-red-700"><i class="fas fa-trash"></i></button></td>
                        </tr>`;
                });
            }
        }

        function updateGrandTotal() {
            let totalObat = cart.reduce((sum, item) => sum + item.subtotal, 0);
            document.getElementById('grandTotal').innerText = new Intl.NumberFormat('id-ID').format(totalObat + jasaDokterValue);
        }

        @if(session('success')) Swal.fire({ icon: 'success', title: 'Berhasil!', text: '{{ session('success') }}', showConfirmButton: false, timer: 3000 }); @endif
        @if(session('error')) Swal.fire({ icon: 'error', title: 'Gagal!', text: '{{ session('error') }}' }); @endif
        
        document.addEventListener('click', function(event) {
            const isClickInside = document.getElementById('searchObat').contains(event.target);
            if (!isClickInside) { document.getElementById('obatDropdownList').classList.add('hidden'); }
        });
    </script>
</x-app-layout>