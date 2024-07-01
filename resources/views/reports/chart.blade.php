<x-self.template title="PM Monthly Report" css="reports-chart.css">
    <main class="w-full md:pl-80 pt-24 md:pt-4 pb-24 flex flex-col flex-wrap items-center gap-4 relative z-10 full">
        <h1 class="text-3xl text-slate eng-deco">Monthly Report</h1>
        <div class="w-full md:p-6 p-0 flex flex-col items-center justify-center">
            <div class="flex items-center gap-4">
                <label for="targetMonth" class="text-sm font-bold">表示月</label>
                <select id="targetMonth" class="rounded-lg">
                    @foreach($period as $month)
                        <option value="{{ $month }}" @if($month === $this_month) selected @endif>{{ $month }}</option>
                    @endforeach
                </select>
            </div>
            <div class="w-full max-w-3xl">
                <div class="mb-4 border-b border-gray-200">
                    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="styled-tab" data-tabs-toggle="#styled-tab-content" data-tabs-acrive-classes="text-purple-600 hover:text-purple-600 border-purple-600" data-tabs-inacrive-classes="text-gray-500 hover:text-gray-600 border-gray-100 hover:border-gray-300" role="tablist">
                        <li class="me-2" role="presentation">
                            <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300" id="by-task-tab" data-tabs-target="#styled-task" type="button" role="tab" aria-controls="byTask" aria-selected="true">By Task</button>
                        </li>
                        <li>
                            <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300" id="by-user-tab" data-tabs-target="#styled-user" type="button" role="tab" aria-controls="byUser" aria-selected="false">By User</button>
                        </li>
                    </ul>
                </div>
                <div id="styled-tab-content">
                    <div class="hidden p-4 rounded-lg bg-gray-50" id="styled-task" role="tabpanel" aria-labelledby="by-task-tab">
                        by task
                        <canvas id="taskChart" class="h-[500px]">

                        </canvas>
                    </div>
                    <div class="hidden p-4 rounded-lg bg-gray-50" id="styled-user" role="tabpanel" aria-labelledby="by-user-tab">
                        by user
                        <canvas id="userChart" class="h-[500px]">

                        </canvas>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script>
        window.Laravel = {};
        window.Laravel.summary = @json($summary);
        window.Laravel.period = @json($period);
        window.Laravel.tasks = @json($tasks);
        window.Laravel.this_month = @json($this_month);
        window.Laravel.users = @json($users);
        window.Laravel.min_date = @json($min_date);
        window.Laravel.max_date = @json($max_date);
        console.log(window.Laravel);
    </script>
    @vite(['resources/js/reports/reports-chart.js'])
</x-self.template>
