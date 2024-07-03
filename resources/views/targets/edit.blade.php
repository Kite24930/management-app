<x-self.template title="PM Targets Edit" css="targets.css">
    <main class="w-full md:pl-80 pt-24 md:pt-4 pb-24 flex flex-col flex-wrap items-center gap-4 relative z-10 full">
        <h1 class="text-3xl text-slate eng-deco">Monthly Target Edit</h1>
        <div class="w-full md:p-6 p-0 flex flex-col items-center justify-center">
            <div class="flex items-center gap-4">
                <label for="targetMonth" class="text-sm font-bold">表示月</label>
                <select id="targetMonth" class="rounded-lg">
                    @foreach($period as $month)
                        <option value="{{ $month }}" @if($month === $target_month) selected @endif>{{ $month }}</option>
                    @endforeach
                </select>
            </div>
            <button id="registerBtn" class="px-4 py-2 rounded-lg shadow bg-red-100 bg-opacity-70 hover:bg-red-200 duration-500 text-sm m-4" data-user-id="{{ $user->id }}">
                登録
            </button>
            <div id="editor" class="w-full max-w-xl flex flex-col gap-4">

            </div>
        </div>
    </main>
    <script>
        window.Laravel = {};
        window.Laravel.target = @json($target);
        window.Laravel.user = @json($user);
        window.Laravel.csrfToken = @json(csrf_token());
        console.log(window.Laravel);
    </script>
    @vite(['resources/js/targets/targets-edit.js'])
</x-self.template>
