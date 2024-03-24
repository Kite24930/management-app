<a href="{{ route('notes.view', $user->id) }}" class="w-full p-4 shadow flex gap-4 items-center hover:bg-[#ddbc9577] duration-500">
    <div class="h-10 w-10 flex items-center justify-center">
        @if($user->icon)
            <img src="{{ asset('storage/'. $user->id .'/' . $user->icon) }}" alt="{{ $user->name }}" class="object-contain rounded-full">
        @else
            <img src="{{ asset('storage/note.png') }}" alt="note" class="object-contain">
        @endif
    </div>
    <div class="flex gap-4">
        <div class="flex justify-center items-center text-3xl eng-deco">
            {{ __('No.'.$user->id) }}
        </div>
        <div>
            <div class="text-sm eng-deco">Name</div>
            <div class="text-xl font-bold pl-3">{{ $user->name }}</div>
        </div>
    </div>
</a>
