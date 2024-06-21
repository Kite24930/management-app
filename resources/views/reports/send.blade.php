<x-self.template title="PM Daily Report" css="reports.css">
    <main class="w-full md:pl-80 pt-24 md:pt-4 pb-24 flex flex-col flex-wrap items-center gap-4 relative z-10 full">
        <h1 class="text-3xl text-slate eng-deco">Daily Report</h1>
        <div class="w-full max-w-4xl p-6 flex flex-col gap-6">
            <div class="w-full">
                <a href="{{ route('reports') }}" class="px-4 py-2 border rounded-lg text-slate hover:bg-[#626d71] hover:text-white duration-500">Daily Reports</a>
            </div>
            <div class="flex gap-2 items-center justify-between">
                <div class="flex gap-2 items-center">
                    <label class="text-xs text-slate w-24">Report Date</label>
                    <div class="font-bold text-xl px-2 border-b border-blue-950">{{ $report->date }}</div>
                </div>
            </div>
            <div class="flex gap-2 items-center">
                <label class="text-xs text-slate w-24">Reporter</label>
                <div class="flex items-center gap-2 border-b border-blue-950 pb-1 px-2">
                    @if($user->icon)
                        <img src="{{ asset('storage/'. $user->id .'/' . $user->icon) }}" alt="{{ $user->name }}" class="h-8 w-8 object-contain rounded-full">
                    @else
                        <i class="bi bi-person-circle text-gray-400 text-3xl"></i>
                    @endif
                    <div>{{ $user->name }}</div>
                </div>
            </div>
            <div class="flex gap-2 flex-col">
                <label class="text-xs text-slate">Report</label>
                <div class="flex flex-col gap-6">
                    @foreach($tasks as $task)
                        <div class="flex flex-col gap-2 justify-center mx-4">
                            <div class="border-b border-blue-950 w-full px-2 flex justify-between md:flex-row flex-col gap-2">
                                <div class="font-bold text-xl flex gap-2 items-end">
                                    {{ $task->task_title }}
                                    <span class="font-normal text-sm">{{ __('['.$task->hours.'h]') }}</span>
                                </div>
                                <div class="text-right"><span class="text-xs text-slate mr-2">Progress</span>{{ __($task->progress.'%') }}</div>
                            </div>
                            <div class="border rounded-lg">
                                <div class="p-2 bg-gray-300 text-white text-xs rounded-t-lg">Detail</div>
                                <div id="{{ __('detail_'.$task->task_id) }}"></div>
                            </div>
                            <div class="border rounded-lg">
                                <div class="p-2 bg-gray-300 text-white text-xs rounded-t-lg">Problem</div>
                                <div id="{{ __('problem_'.$task->task_id) }}"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="flex flex-col gap-2 justify-center">
                <label class="text-xs text-slate w-24">Announcement</label>
                <div id="announcement" class="border rounded-lg mx-4">

                </div>
            </div>
            <div class="flex gap-4 justify-end">
                @foreach($confirm as $c)
                    <div class="relative rotate-12">
                        <img src="{{ asset('/storage/mimashita.png') }}" alt="見ました" class="w-24">
                        <div class="w-24 text-center text-[#ff0064] text-xs">
                            {{ date('y-m-d', strtotime($c->created_at)) }}
                            <br>
                            {{ date('H:i', strtotime($c->created_at)) }}
                        </div>
                        <div class="text-[#ff0064] font-bold text-center text-lg w-24 top-3 absolute" style="font-family: 'Hiragino Maru Gothic ProN'">{{ explode(' ', $c->user_name)[0] }}</div>
                    </div>
                @endforeach
            </div>
            @if($confirm_check && $report->user_id !== $user->id)
                <div class="flex justify-end">
                    <a href="{{ route('reports.confirm', $report->id) }}" class="px-4 py-2 rounded-lg shadow bg-[#ffd5e6] bg-opacity-70 hover:bg-[#ff94be] duration-500 text-xl">
                        Confirm
                    </a>
                </div>
            @endif
        </div>
    </main>
    <script>
        window.Laravel = {};
        window.Laravel.report = @json($report);
        window.Laravel.user = @json($user);
        window.Laravel.tasks = @json($tasks);
        window.Laravel.confirm = @json($confirm);
        window.Laravel.redirectUrl = "{{ route('reports.view', $report->id) }}";
        window.Laravel.sendUrl = "{{ route('reports.send', $report->id) }}";
        window.Laravel.csrfToken = "{{ csrf_token() }}";
        console.log(window.Laravel);
    </script>
    @vite(['resources/js/reports/reports-send.js'])
</x-self.template>
