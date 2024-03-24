<x-self.template title="PM Notes" css="notes.css">
    <main class="w-full md:pl-80 pt-24 md:pt-4 pb-24 flex flex-col flex-wrap items-center gap-4 relative z-10 full">
        <h1 class="text-3xl text-slate eng-deco">Whose notes would you like to see?</h1>
        <div class="w-full max-w-md p-4 flex flex-col gap-4">
            @foreach($users as $user)
                <x-self.note-index :user="$user" />
            @endforeach
        </div>
    </main>
    <script>
        window.Laravel = {};
        window.Laravel.users = @json($users);
        console.log(window.Laravel);
    </script>
    @vite(['resources/js/notes.js'])
</x-self.template>
