<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 shadow-sm sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            
            <div class="flex items-center text-gray-800">
                <div class="mr-3 text-3xl leading-none flex items-center"> 
                    @if(request()->routeIs('admin.dashboard'))
                        <i class="fas fa-user-shield text-gray-500"></i> 
                    
                    @elseif(request()->routeIs('user.dashboard'))
                        <i class="fas fa-hospital-user text-red-500"></i> 

                    @elseif(request()->routeIs('dokter.dashboard'))
                        <i class="fas fa-user-md text-blue-500"></i>

                    @elseif(request()->routeIs('admin.obat.*'))
                        <i class="fas fa-capsules text-blue-600"></i> 
                    
                    @elseif(request()->routeIs('admin.dokter.*'))
                        <i class="fas fa-user-doctor text-green-600"></i> 

                    @elseif(request()->routeIs('admin.apoteker.*'))
                        <i class="fas fa-user-nurse text-teal-600"></i> 
                    
                    @elseif(request()->routeIs('admin.pasien.*'))
                        <i class="fas fa-hospital-user text-indigo-600"></i> 
                    
                    @elseif(request()->routeIs('admin.jadwal.*'))
                        <i class="fas fa-calendar-check text-purple-600"></i> 

                    @elseif(request()->routeIs('admin.kunjungan.*'))
                        <i class="fas fa-clipboard-list text-teal-600"></i>

                    @elseif(request()->routeIs('admin.laporan.*'))
                        <i class="fas fa-file-pdf text-red-600"></i>
                    
                    @elseif(request()->routeIs('profile.*'))
                        <i class="fas fa-user-circle text-gray-600"></i> 
                    
                    @else
                        <i class="fas fa-hospital text-gray-400"></i> 
                    @endif
                </div>

                <h2 class="font-bold text-xl leading-tight ml-1">
                    @if(request()->routeIs('admin.dashboard'))
                        Dashboard Admin
                    @elseif(request()->routeIs('dokter.dashboard'))
                        Dashboard Dokter
                    @elseif(request()->routeIs('apoteker.dashboard'))
                        Dashboard Apoteker
                    @elseif(request()->routeIs('user.dashboard'))
                        Dashboard Pasien
                    @elseif(request()->routeIs('admin.obat.*'))
                        Kelola Data Obat
                    @elseif(request()->routeIs('admin.dokter.*'))
                        Kelola Data Dokter
                    @elseif(request()->routeIs('admin.apoteker.*'))
                        Kelola Data Apoteker
                    @elseif(request()->routeIs('admin.pasien.*'))
                        Data Pasien
                    @elseif(request()->routeIs('admin.jadwal.*'))
                        Jadwal Praktek Dokter
                    @elseif(request()->routeIs('admin.kunjungan.*'))
                        Antrean Pasien Hari Ini
                    @elseif(request()->routeIs('admin.laporan.*'))
                        Laporan Kunjungan
                    @elseif(request()->routeIs('profile.*'))
                        Profil Saya
                    @else
                        Klinik Bina Usada
                    @endif
                </h2>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div class="font-bold text-gray-800">{{ Auth::user()->name }}</div>

                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();" class="text-red-600 font-bold">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            
            @if(Auth::user()->role === 'admin')
                <x-responsive-nav-link :href="route('admin.obat.index')" :active="request()->routeIs('admin.obat.*')">Data Obat</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.dokter.index')" :active="request()->routeIs('admin.dokter.*')">Data Dokter</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.apoteker.index')" :active="request()->routeIs('admin.apoteker.*')">Data Apoteker</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.pasien.index')" :active="request()->routeIs('admin.pasien.*')">Data Pasien</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.jadwal.index')" :active="request()->routeIs('admin.jadwal.*')">Jadwal Dokter</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.kunjungan.index')" :active="request()->routeIs('admin.kunjungan.*')">Antrean Pasien</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.laporan.index')" :active="request()->routeIs('admin.laporan.*')">Laporan</x-responsive-nav-link>
            @endif
        </div>

        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();" class="text-red-600 font-bold">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>