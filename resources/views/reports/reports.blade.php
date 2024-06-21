<x-self.template title="PM Daily Report" css="reports.css">
    <main class="w-full md:pl-80 pt-24 md:pt-4 pb-24 flex flex-col flex-wrap items-center gap-4 relative z-10 full">
        <h1 class="text-3xl text-slate eng-deco">Daily Report</h1>
        <div class="w-full md:p-6 p-0">
            <div class="flex justify-end mb-4">
                <a href="{{ route('reports.add') }}" class="px-4 py-2 rounded-lg shadow bg-green-100 bg-opacity-70 hover:bg-[#ddbc9577] duration-500 text-xl">New Report</a>
            </div>
            <div class="flex justify-between mb-2 border-b pb-2">
                <x-secondary-button id="previousMonth">←</x-secondary-button>
                <div id="month" class="text-2xl eng-deco">{{ date('Y M') }}</div>
                <x-secondary-button id="nextMonth">→</x-secondary-button>
            </div>
            <div class="w-full overflow-x-auto">
                <div id="calendar" class="w-full md:h-[600px] h-[1000px] md:min-w-full min-w-[200dvw]">

                </div>
            </div>
        </div>
    </main>
    <script>
        window.Laravel = {};
        window.Laravel.users = @json($users);
        window.Laravel.reports = @json($reports);
        window.Laravel.month = '{{ date('Y-m') }}';
        console.log(window.Laravel);
    </script>
    @vite(['resources/js/reports/reports.js'])
</x-self.template>
