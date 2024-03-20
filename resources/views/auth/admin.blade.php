<x-self.template title="PM Management System" css="index.css">
    <main class="w-full md:pl-80 pt-24 md:pt-4 pb-24 flex flex-wrap justify-center gap-4 full">
        <x-self.menu-icon route="admin.department">
            <i class="bi bi-building-gear"></i>
            <br>
            Department
        </x-self.menu-icon>
        <x-self.menu-icon route="admin.users.list">
            <i class="bi bi-people-fill"></i>
            <br>
            Users List
        </x-self.menu-icon>
    </main>
    @vite(['resources/js/index.js'])
</x-self.template>
