<x-self.template title="PM Notes" css="notes.css">
    <main class="w-full md:pl-80 pt-24 md:pt-4 pb-24 flex flex-col flex-wrap items-center relative z-10 full min-h-screen">
        <h1 class="text-3xl text-slate font-bold mb-4">{{ __($user->name.'のノート') }}</h1>
        <div id="note" class="w-full max-w-2xl !border-none">

        </div>
        <a href="{{ route('notes.edit', $id) }}" id="updateBtn" class="w-32 h-32 flex justify-center items-center text-white font-bold text-xl absolute bottom-4 right-4" type="button">EDIT</a>
    </main>
    <script>
        window.Laravel = {};
        window.Laravel.notes = @json($notes);
        console.log(window.Laravel);
    </script>
    @vite(['resources/js/notes/note-view.js'])
</x-self.template>

