<x-self.template title="PM Daily Report" css="reports.css">
    <main class="w-full md:pl-80 pt-24 md:pt-4 pb-24 flex flex-col flex-wrap items-center gap-4 relative z-10 full">
        <h1 class="text-3xl text-slate eng-deco">Daily Report</h1>
        <h2 class="text-2xl font-bold text-slate">New Report</h2>
        @if($errors->any())
            <div class="w-full max-w-4xl p-6 bg-red-100 bg-opacity-70 text-red-900 rounded-lg">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="w-full max-w-4xl p-6">
            <form action="{{ route('reports.add') }}" method="POST" class="w-full flex flex-col gap-4">
                @csrf
                <div class="flex gap-2 items-center">
                    <label for="date" class="text-xs text-slate w-24">Report Date -</label>
                    <input type="date" name="date" id="date" class="p-2 border border-slate rounded-lg" value="{{ date('Y-m-d') }}" required>
                </div>
                <div class="flex gap-2 items-center">
                    <div class="text-xs text-slate w-24">Reporter -</div>
                    @if($user->icon)
                        <img src="{{ asset('storage/'. $user->id .'/' . $user->icon) }}" alt="{{ $user->name }}" class="h-8 w-8 object-contain rounded-full">
                    @else
                        <i class="bi bi-person-circle text-gray-400 text-3xl"></i>
                    @endif
                    <div>{{ $user->name }}</div>
                </div>
                <div id="reportWrapper" class="flex flex-col gap-2">
                    <label class="text-xs text-slate">Report</label>
                    <x-self.report-task :tasks="$tasks" :num="0"/>
                </div>
                <div class="flex justify-end">
                    <button id="taskAddBtn" type="button" class="px-4 py-2 rounded-lg shadow bg-gray-100 bg-opacity-70 hover:bg-gray-200 duration-500 text-xs">Add</button>
                </div>
                <div>
                    <label for="announcement" class="text-xs text-slate w-24">Announcement</label>
                    <div id="announcement" class="border rounded-lg">

                    </div>
                </div>
                <div class="flex justify-end">
                    <button id="saveBtn" type="button" class="px-4 py-2 rounded-lg shadow bg-green-100 bg-opacity-70 hover:bg-green-200 duration-500 text-xl">Save</button>
                </div>
            </form>
        </div>
    </main>
    <script>
        window.Laravel = {};
        window.Laravel.user = @json($user);
        window.Laravel.tasks = @json($tasks);
        window.Laravel.csrfToken = "{{ csrf_token() }}";
        window.Laravel.taskAddUrl = "{{ route('reports.task.components') }}";
        window.Laravel.saveUrl = "{{ route('reports.add') }}";
        console.log(window.Laravel);
    </script>
    @vite(['resources/js/reports/reports-add.js'])
</x-self.template>
