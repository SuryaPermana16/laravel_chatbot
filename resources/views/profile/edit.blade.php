<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fas fa-user-circle mr-2 text-indigo-600"></i> {{ __('Profil Saya') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @php
                $role = Auth::user()->role ?? 'pasien';
                $dashboardRoute = match($role) {
                    'admin' => 'admin.dashboard',
                    'dokter' => 'dokter.dashboard',
                    'apoteker' => 'apoteker.dashboard',
                    default => 'dashboard' 
                };
            @endphp

            <div class="mb-2">
                <a href="{{ route($dashboardRoute) }}" class="inline-flex items-center text-sm text-gray-500 hover:text-indigo-600 font-bold transition group">
                    <i class="fas fa-arrow-left mr-2 transition-transform group-hover:-translate-x-1"></i> Kembali ke Dashboard
                </a>
            </div>

            <div class="bg-white p-6 sm:p-8 shadow-[0_8px_30px_rgb(0,0,0,0.04)] sm:rounded-[2rem] flex flex-col sm:flex-row items-start sm:items-center gap-5 border border-gray-100 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-64 h-full bg-gradient-to-l from-indigo-50/50 to-transparent pointer-events-none"></div>
                <div class="bg-indigo-50 p-4 rounded-2xl text-indigo-600 shadow-inner relative z-10">
                    <i class="fas fa-user-cog text-3xl"></i>
                </div>
                <div class="relative z-10">
                    <h2 class="text-2xl font-black text-gray-900 uppercase tracking-tight">Pengaturan Akun</h2>
                    <p class="text-sm text-gray-500 font-medium mt-1">Kelola informasi profil lengkap dan keamanan akunmu di sini.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <div class="p-6 sm:p-8 bg-white shadow-[0_8px_30px_rgb(0,0,0,0.04)] sm:rounded-[2rem] border border-gray-100">
                    <div class="flex items-center mb-6 text-indigo-600 border-b border-gray-100 pb-4">
                        <div class="w-10 h-10 bg-indigo-50 rounded-xl flex items-center justify-center mr-3">
                            <i class="fas fa-id-card text-lg"></i>
                        </div>
                        <h3 class="font-black text-lg text-gray-800 uppercase tracking-wide">Informasi Data Diri</h3>
                    </div>
                    
                    <div class="max-w-xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <div class="p-6 sm:p-8 bg-white shadow-[0_8px_30px_rgb(0,0,0,0.04)] sm:rounded-[2rem] border border-gray-100">
                    <div class="flex items-center mb-6 text-emerald-600 border-b border-gray-100 pb-4">
                        <div class="w-10 h-10 bg-emerald-50 rounded-xl flex items-center justify-center mr-3">
                            <i class="fas fa-key text-lg"></i>
                        </div>
                        <h3 class="font-black text-lg text-gray-800 uppercase tracking-wide">Ganti Password</h3>
                    </div>

                    <div class="max-w-xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

            </div>

            <div class="p-6 sm:p-8 bg-white shadow-[0_8px_30px_rgb(0,0,0,0.04)] sm:rounded-[2rem] border border-red-100">
                <div class="flex items-center mb-6 text-red-500 border-b border-red-50 pb-4">
                    <div class="w-10 h-10 bg-red-50 rounded-xl flex items-center justify-center mr-3">
                        <i class="fas fa-exclamation-triangle text-lg"></i>
                    </div>
                    <h3 class="font-black text-lg text-gray-800 uppercase tracking-wide">Zona Bahaya</h3>
                </div>
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </div>
</x-app-layout>