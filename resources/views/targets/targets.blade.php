<x-self.template title="PM Targets" css="targets.css">
    <main class="w-full md:pl-80 pt-24 md:pt-4 pb-24 flex flex-col flex-wrap items-center gap-4 relative z-10 full">
        <h1 class="text-3xl text-slate eng-deco">Monthly Target</h1>
        <div class="w-full md:p-6 p-0 flex flex-col items-center justify-center">
            <div class="flex items-center gap-4 mb-4">
                <label for="targetMonth" class="text-sm font-bold">表示月</label>
                <select id="targetMonth" class="rounded-lg">
                    @foreach($period as $month)
                        <option value="{{ $month }}" @if($month === $this_month) selected @endif>{{ $month }}</option>
                    @endforeach
                </select>
            </div>
            <div class="w-full max-w-3xl flex flex-col gap-4">
                @foreach($users as $user)
                    <x-self.target-index :user="$user" :activeUser="$active_user" />
                @endforeach
            </div>
        </div>
    </main>
    <script>
        window.Laravel = {};
        window.Laravel.targets = @json($targets);
        window.Laravel.users = @json($users);
        window.Laravel.activeUser = @json($active_user);
        window.Laravel.period = @json($period);
        console.log(window.Laravel);
    </script>
    @vite(['resources/js/targets/targets.js'])
</x-self.template>
