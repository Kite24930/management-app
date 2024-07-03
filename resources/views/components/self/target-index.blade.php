<details id="{{ __('target_'.$user->id) }}" class="accordion w-full p-4 shadow flex gap-4 items-center hover:bg-[#ddbc9577] duration-500 rounded-lg">
    <summary class="summary px-4 py-2">
        <div class="flex gap-4 items-center">
            <div class="h-10 w-10 flex items-center justify-center">
                @if($user->icon)
                    <img src="{{ asset('storage/'. $user->id .'/' . $user->icon) }}" alt="{{ $user->name }}" class="object-contain rounded-full">
                @else
                    <img src="{{ asset('storage/note.png') }}" alt="note" class="object-contain">
                @endif
            </div>
            <div class="text-xl font-bold pl-3">{{ $user->name }}</div>
        </div>
    </summary>
    <div class="container">
        <div class="inner">
            @if($user->id === $activeUser->id)
                <button class="px-4 py-2 rounded-lg shadow bg-green-100 bg-opacity-70 hover:bg-green-200 duration-500 text-sm m-4 editBtn" data-user-id="{{ $user->id }}">
                    編集
                </button>
            @endif
            <div id="{{ __('inner_'.$user->id) }}">

            </div>
        </div>
    </div>
</details>
