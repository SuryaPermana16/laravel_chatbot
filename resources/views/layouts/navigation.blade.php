<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 shadow-sm sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20 items-center">
            
            <div class="flex items-center gap-6">
                <div class="shrink-0 flex items-center pr-6 border-r border-gray-100 hidden sm:flex">
                    <a href="{{ url('/') }}" class="flex items-center gap-2 hover:opacity-80 transition">
                        <i class="fas fa-heartbeat text-3xl text-blue-600"></i>
                        <span class="font-extrabold text-xl tracking-tight text-gray-900">Klinik<span class="text-blue-600">Bina Usada</span></span>
                    </a>
                </div>

                <div class="flex items-center text-gray-800">
                    <div class="mr-3 text-2xl leading-none flex items-center"> 
                        @if(request()->routeIs('admin.dashboard'))
                            <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center"><i class="fas fa-home"></i></div>
                        
                        @elseif(request()->routeIs('user.dashboard'))
                            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center"><i class="fas fa-hospital-user"></i></div>
                        @elseif(request()->routeIs('user.daftar*'))
                            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center"><i class="fas fa-calendar-plus"></i></div>

                        @elseif(request()->routeIs('dokter.dashboard'))
                            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center"><i class="fas fa-user-md"></i></div>
                        @elseif(request()->routeIs('dokter.periksa*'))
                            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center"><i class="fas fa-stethoscope"></i></div>

                        @elseif(request()->routeIs('apoteker.dashboard'))
                            <div class="w-10 h-10 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center"><i class="fas fa-user-nurse"></i></div>
                        
                        @elseif(request()->routeIs('admin.kelola-admin.*'))
                            <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center"><i class="fas fa-user-shield"></i></div>
                        @elseif(request()->routeIs('admin.obat.*') || request()->routeIs('apoteker.obat.*'))
                            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center"><i class="fas fa-capsules"></i></div>
                        @elseif(request()->routeIs('admin.dokter.*'))
                            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center"><i class="fas fa-user-doctor"></i></div>
                        @elseif(request()->routeIs('admin.apoteker.*'))
                            <div class="w-10 h-10 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center"><i class="fas fa-user-nurse"></i></div>
                        @elseif(request()->routeIs('admin.pasien.*'))
                            <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center"><i class="fas fa-hospital-user"></i></div>
                        @elseif(request()->routeIs('admin.jadwal.*'))
                            <div class="w-10 h-10 rounded-xl bg-fuchsia-50 text-fuchsia-600 flex items-center justify-center"><i class="far fa-calendar-check"></i></div>
                        @elseif(request()->routeIs('admin.kunjungan.*'))
                            <div class="w-10 h-10 rounded-xl bg-pink-50 text-pink-600 flex items-center justify-center"><i class="fas fa-clipboard-list"></i></div>
                        @elseif(request()->routeIs('admin.laporan.*'))
                            <div class="w-10 h-10 rounded-xl bg-red-50 text-red-600 flex items-center justify-center"><i class="fas fa-file-pdf"></i></div>
                        
                        @elseif(request()->routeIs('profile.*'))
                            <div class="w-10 h-10 rounded-xl bg-gray-100 text-gray-600 flex items-center justify-center"><i class="fas fa-user-cog"></i></div>
                        @else
                            <div class="w-10 h-10 rounded-xl bg-gray-100 text-gray-400 flex items-center justify-center"><i class="fas fa-hospital"></i></div>
                        @endif
                    </div>

                    <h2 class="font-extrabold text-xl leading-tight tracking-tight text-gray-900 hidden sm:block">
                        @if(request()->routeIs('admin.dashboard')) Administrator
                        
                        @elseif(request()->routeIs('user.dashboard')) Portal Pasien
                        @elseif(request()->routeIs('user.daftar*')) Buat Janji Temu
                        
                        @elseif(request()->routeIs('dokter.dashboard')) Panel Dokter
                        @elseif(request()->routeIs('dokter.periksa*')) Pemeriksaan Pasien
                        
                        @elseif(request()->routeIs('apoteker.dashboard')) Panel Apoteker
                        
                        @elseif(request()->routeIs('admin.kelola-admin.*')) Kelola Akun Admin
                        @elseif(request()->routeIs('admin.obat.*') || request()->routeIs('apoteker.obat.*')) Kelola Data Obat
                        @elseif(request()->routeIs('admin.dokter.*')) Kelola Data Dokter
                        @elseif(request()->routeIs('admin.apoteker.*')) Kelola Data Apoteker
                        @elseif(request()->routeIs('admin.pasien.*')) Data Rekam Medis
                        @elseif(request()->routeIs('admin.jadwal.*')) Jadwal Praktek
                        @elseif(request()->routeIs('admin.kunjungan.*')) Antrean Hari Ini
                        @elseif(request()->routeIs('admin.laporan.*')) Laporan Kunjungan
                        
                        @elseif(request()->routeIs('profile.*')) Profil Saya
                        @else Klinik Bina Usada
                        @endif
                    </h2>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center pl-1 pr-3 py-1.5 border border-gray-200 text-sm leading-4 font-bold rounded-full text-gray-700 bg-white hover:text-blue-600 hover:border-blue-200 focus:outline-none transition ease-in-out duration-150 shadow-sm">
                            <div class="w-7 h-7 bg-blue-600 text-white rounded-full flex items-center justify-center mr-2 shadow-inner">
                                <i class="fas fa-user text-xs"></i>
                            </div>
                            <div class="max-w-[120px] truncate">{{ Auth::user()->name }}</div>
                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')" class="font-semibold text-gray-700 hover:text-blue-600">
                            <i class="fas fa-user-cog mr-2 w-4"></i> {{ __('Profil Akun') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();" class="font-semibold text-red-600 hover:text-red-800 border-t border-gray-100 mt-1 pt-1">
                                <i class="fas fa-sign-out-alt mr-2 w-4"></i> {{ __('Keluar Sistem') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-xl text-gray-400 hover:text-gray-600 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-600 transition duration-150 ease-in-out border border-transparent hover:border-gray-200">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white border-b border-gray-200 shadow-xl absolute w-full">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="font-bold text-blue-600">
                <i class="fas fa-home mr-2 w-4"></i> {{ __('Dashboard') }}
            </x-responsive-nav-link>
            
            @if(Auth::user()->role === 'admin')
                <x-responsive-nav-link :href="route('admin.obat.index')" :active="request()->routeIs('admin.obat.*')"><i class="fas fa-capsules mr-2 w-4 text-blue-500"></i> Kelola Obat</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.dokter.index')" :active="request()->routeIs('admin.dokter.*')"><i class="fas fa-user-doctor mr-2 w-4 text-emerald-500"></i> Kelola Dokter</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.apoteker.index')" :active="request()->routeIs('admin.apoteker.*')"><i class="fas fa-user-nurse mr-2 w-4 text-teal-500"></i> Kelola Apoteker</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.pasien.index')" :active="request()->routeIs('admin.pasien.*')"><i class="fas fa-hospital-user mr-2 w-4 text-indigo-500"></i> Data Pasien</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.jadwal.index')" :active="request()->routeIs('admin.jadwal.*')"><i class="far fa-calendar-check mr-2 w-4 text-fuchsia-500"></i> Jadwal Praktek</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.kunjungan.index')" :active="request()->routeIs('admin.kunjungan.*')"><i class="fas fa-clipboard-list mr-2 w-4 text-pink-500"></i> Antrean Pasien</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.laporan.index')" :active="request()->routeIs('admin.laporan.*')"><i class="fas fa-file-pdf mr-2 w-4 text-red-500"></i> Laporan Transaksi</x-responsive-nav-link>
            @endif
        </div>

        <div class="pt-4 pb-4 border-t border-gray-100 bg-slate-50">
            <div class="px-4 flex items-center gap-3">
                <div class="w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold shadow-md">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div>
                    <div class="font-bold text-base text-gray-900">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-4 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" class="font-semibold text-gray-700">
                    <i class="fas fa-user-cog mr-2 w-4"></i> {{ __('Pengaturan Profil') }}
                </x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();" class="font-bold text-red-600">
                        <i class="fas fa-sign-out-alt mr-2 w-4"></i> {{ __('Keluar Sistem') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>