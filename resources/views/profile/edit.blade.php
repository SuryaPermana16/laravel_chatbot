<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="bg-white p-6 shadow-sm sm:rounded-lg flex items-center gap-4 border-l-4 border-blue-500">
                <div class="bg-blue-100 p-3 rounded-full text-blue-600">
                    <i class="fas fa-user-cog text-2xl"></i>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-gray-900">Pengaturan Akun</h2>
                    <p class="text-sm text-gray-600">Kelola informasi profil lengkap dan keamanan akunmu di sini.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <div class="p-4 sm:p-8 bg-white shadow-sm sm:rounded-lg">
                    <div class="flex items-center mb-4 text-blue-700">
                        <i class="fas fa-id-card mr-2"></i>
                        <h3 class="font-bold">Informasi Data Diri</h3>
                    </div>
                    
                    <div class="max-w-xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <div class="p-4 sm:p-8 bg-white shadow-sm sm:rounded-lg">
                    <div class="flex items-center mb-4 text-green-700">
                        <i class="fas fa-key mr-2"></i>
                        <h3 class="font-bold">Ganti Password</h3>
                    </div>

                    <div class="max-w-xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

            </div>

            <div class="p-4 sm:p-8 bg-white shadow-sm sm:rounded-lg border border-red-100">
                <div class="flex items-center mb-4 text-red-600">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    <h3 class="font-bold">Zona Bahaya</h3>
                </div>
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </div>
</x-app-layout>