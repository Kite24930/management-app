<x-self.template title="PM Invoice Create" css="invoices.css">
    <main class="w-full md:pl-80 pt-24 md:pt-4 pb-24 flex flex-col flex-wrap items-center gap-4 relative z-10 full">
        <h1 class="text-3xl text-slate eng-deco">Invoice Create</h1>
        <div class="w-full md:p-6 p-0 flex flex-col gap-6 items-center justify-center max-w-4xl">
            @if(session('message'))
                <div class="w-full bg-red-50 text-red-600 p-4 rounded-lg text-center">
                    {{ session('message') }}
                </div>
            @endif
            <form action="{{ route('invoices.create') }}" method="POST" class="w-full flex flex-col gap-6" enctype="multipart/form-data">
                @csrf
                <div class="flex items-center gap-4">
                    <label for="issue_date" class="text-xs text-gray-700 uppercase w-24 text-right">issue date</label>
                    <input id="issue_date" name="issue_date" type="date" class="rounded-lg border-gray-600" value="{{ date('Y-m-d') }}">
                    @error('issue_date')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex items-center gap-4">
                    <label for="due_date" class="text-xs text-gray-700 uppercase w-24 text-right">due date</label>
                    <input id="due_date" name="due_date" type="date" class="rounded-lg border-gray-600" value="{{ date('Y-m-d') }}">
                    @error('due_date')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex items-center gap-4">
                    <label for="issue_user_id" class="text-xs text-gray-700 uppercase w-24 text-right">issue person</label>
                    <select name="issue_user_id" id="issue_user_id" class="rounded-lg border-gray-600">
                        <option value="" class="hidden">selected</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" @if(auth()->user()->id === $user->id) selected @endif>{{ $user->name }}</option>
                        @endforeach
                    </select>
                    @error('issue_user_id')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex items-center gap-4">
                    <label for="client_name" class="text-xs text-gray-700 uppercase w-24 text-right">client name</label>
                    <input id="client_name" name="client_name" type="text" class="rounded-lg border-gray-600 w-96" placeholder="client name">
                    @error('client_name')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex items-center gap-4">
                    <label for="subject" class="text-xs text-gray-700 uppercase w-24 text-right">subject</label>
                    <input id="subject" name="subject" type="text" class="rounded-lg border-gray-600 flex-1" placeholder="subject">
                    @error('subject')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex items-center gap-4">
                    <label for="amount" class="text-xs text-gray-700 uppercase w-24 text-right">amount</label>
                    <input id="amount" name="amount" type="number" min="0" class="rounded-lg border-gray-600 text-right" placeholder="amount">円
                    @error('amount')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex items-center gap-4">
                    <label for="description" class="text-xs text-gray-700 uppercase w-24 text-right">description</label>
                    <textarea name="description" id="description" rows="5" class="flex-1 rounded-lg border-gray-600"></textarea>
                    @error('description')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex items-center gap-4">
                    <label for="file" class="text-xs text-gray-700 uppercase w-24 text-right">file</label>
                    <input id="file" name="file" type="file" accept="application/pdf">
                    <input type="hidden" id="file_name" name="file_name">
                    @error('file')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <button class="rounded-lg px-4 py-2 border-green-600 text-green-600 bg-green-50 hover:border-gray-300 hover:text-green-50 hover:bg-green-300 duration-500">
                        Create Invoice
                    </button>
                </div>
            </form>
        </div>
    </main>
    <script>
        window.Laravel = {};
        window.Laravel.users = @json($users);
        console.log(window.Laravel);
    </script>
    @vite(['resources/js/invoices/invoices-create.js'])
</x-self.template>
