<div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
    <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
        {{ __('Dashboard') }}
    </x-nav-link>

    <x-nav-link :href="route('admin.obat.index')" :active="request()->routeIs('admin.obat.*')">
        {{ __('Data Obat') }}
    </x-nav-link>

    <x-nav-link :href="route('admin.dokter.index')" :active="request()->routeIs('admin.dokter.*')">
        {{ __('Data Dokter') }}
    </x-nav-link>

    <x-nav-link :href="route('admin.pasien.index')" :active="request()->routeIs('admin.pasien.*')">
    {{ __('Data Pasien') }}
</x-nav-link>
</div>