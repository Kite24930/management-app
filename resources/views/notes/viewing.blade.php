<x-self.template title="PM Notes" css="notes.css">
    <main class="w-full md:pl-80 pt-24 md:pt-4 pb-24 flex flex-col flex-wrap items-center relative z-10 full min-h-screen bg-gray-100">
        <h1 class="text-3xl text-slate font-bold mb-4">{{ __($note_user->name.'のノート') }}</h1>
        <div id="note" class="w-full max-w-3xl !border-none rounded-lg">

        </div>
        <div class="fixed bottom-4 right-4 flex flex-col justify-center items-center gap-6">
            <div class="relative w-full flex justify-center min-w-[8rem]">
                <button id="indexBtn" type="button" class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="m422-232 207-248H469l29-227-185 267h139l-30 208ZM320-80l40-280H160l360-520h80l-40 320h240L400-80h-80Zm151-390Z"/></svg>INDEX
                </button>
                <div id="indexContainer" class="absolute bottom-0 -right-60 bg-gray-600 rounded-lg text-white p-4 flex flex-col gap-4 duration-300 w-40">
                    <div id="indexWrapper" class="text-white flex flex-col gap-4 w-full max-h-[500px] overflow-auto">

                    </div>
                    <button id="closeIndexBtn" type="button" class="flex items-center gap-2 text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="m480-320 160-160-160-160-56 56 64 64H320v80h168l-64 64 56 56Zm0 240q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z"/></svg>CLOSE
                    </button>
                </div>
            </div>
            @if($user->id === (int)$id)
                <a href="{{ route('notes.edit', $id) }}" id="updateBtn" class="md:w-32 md:h-32 w-16 h-16 flex justify-center items-center text-white font-bold text-xl" type="button">EDIT</a>
            @endif
        </div>
    </main>
    <script>
        window.Laravel = {};
        window.Laravel.notes = @json($notes);
        window.Laravel.links = @json($links);
        window.Laravel.user = @json($user);
        window.Laravel.id = @json($id);
        console.log(window.Laravel);
    </script>
    @vite(['resources/js/notes/note-view.js'])
</x-self.template>

