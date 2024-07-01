<x-self.template title="PM Management System" css="index.css">
    <main class="w-full md:pl-80 pt-24 md:pt-4 pb-24 flex flex-wrap justify-center gap-4 full">
        <x-self.menu-icon route="tasks">
            <i class="bi bi-card-checklist"></i>
            <br class="hidden md:block">
            Task Board
        </x-self.menu-icon>
        <x-self.menu-icon route="notes">
            <i class="bi bi-journal-text"></i>
            <br class="hidden md:block">
            Notes
        </x-self.menu-icon>
        <x-self.menu-icon route="reports">
            <i class="bi bi-journal-medical"></i>
            <br class="hidden md:block">
            Daily Report
        </x-self.menu-icon>
        <x-self.menu-icon route="reports.chart">
            <i class="bi bi-journal-medical"></i>
            <br class="hidden md:block">
            Monthly Report
        </x-self.menu-icon>
    </main>
    @vite(['resources/js/index.js'])
</x-self.template>
