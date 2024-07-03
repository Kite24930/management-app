<x-self.template title="PM Invoice Edit" css="invoices.css">
    <main class="w-full md:pl-80 pt-24 md:pt-4 pb-24 flex flex-col flex-wrap items-center gap-4 relative z-10 full">
        <h1 class="text-3xl text-slate eng-deco">Invoice Edit</h1>
        <div class="w-full md:p-6 p-0 flex flex-col gap-6 items-center justify-center max-w-4xl">
            <div class="w-full">
                <a href="{{ route('invoices') }}" class="px-4 py-2 border rounded-lg text-slate hover:bg-[#626d71] hover:text-white duration-500">← back</a>
            </div>
            @if(session('message'))
                <div class="w-full bg-blue-50 text-blue-600 p-4 rounded-lg text-center">
                    {{ session('message') }}
                </div>
            @endif
            @if(!$invoice->passed_date)
                <form action="{{ route('invoices.passed', $invoice->id) }}" method="POST" class="w-full flex gap-6 items-center">
                    @csrf
                    <div class="border items-center flex gap-4 px-4 py-2 rounded-lg">
                        <label for="passed_date" class="text-xs text-gray-700 uppercase w-24 text-right">passed date</label>
                        <input type="date" id="passed_date" name="passed_name" value="{{ date('Y-m-d') }}" class="rounded-lg border-gray-600">
                        <input type="hidden" id="passed_user_id" name="passed_user_id" value="{{ $active_user->id }}">
                        <label for="passed_user_id">{{ $active_user->name }}</label>
                        <button class="rounded-lg px-4 py-2 border-yellow-600 text-yellow-600 bg-yellow-50 hover:border-yellow-300 hover:text-yellow-50 hover:bg-yellow-300 duration-500">
                            Passed
                        </button>
                    </div>
                </form>
            @endif
            @if(!$invoice->payment_date)
                <form action="{{ route('invoices.payment', $invoice->id) }}" method="POST" class="w-full flex gap-6 items-center">
                    @csrf
                    <div class="border items-center flex gap-4 px-4 py-2 rounded-lg">
                        <label for="payment_date" class="text-xs text-gray-700 uppercase w-24 text-right">payment date</label>
                        <input type="date" id="payment_date" name="payment_date" value="{{ date('Y-m-d') }}" class="rounded-lg border-gray-600">
                        <input type="hidden" id="payment_user_id" name="payment_user_id" value="{{ $active_user->id }}">
                        <label for="payment_user_id">{{ $active_user->name }}</label>
                        <button class="rounded-lg px-4 py-2 border-blue-600 text-blue-600 bg-blue-50 hover:border-blue-300 hover:text-blue-50 hover:bg-blue-300 duration-500">
                            Payment
                        </button>
                    </div>
                </form>
            @endif
            <form action="{{ route('invoices.edit', $invoice->id) }}" method="POST" class="w-full flex flex-col gap-6" enctype="multipart/form-data">
                @csrf
                <div class="flex items-center gap-4">
                    <label for="issue_date" class="text-xs text-gray-700 uppercase w-24 text-right">issue date</label>
                    <input id="issue_date" name="issue_date" type="date" class="rounded-lg border-gray-600" value="{{ $invoice->issue_date }}">
                    @error('issue_date')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex items-center gap-4">
                    <label for="due_date" class="text-xs text-gray-700 uppercase w-24 text-right">due date</label>
                    <input id="due_date" name="due_date" type="date" class="rounded-lg border-gray-600" value="{{ $invoice->due_date }}">
                    @error('due_date')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex items-center gap-4">
                    <label for="issue_user_id" class="text-xs text-gray-700 uppercase w-24 text-right">issue person</label>
                    <select name="issue_user_id" id="issue_user_id" class="rounded-lg border-gray-600">
                        <option value="" class="hidden">selected</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" @if($invoice->issue_user_id === $user->id) selected @endif>{{ $user->name }}</option>
                        @endforeach
                    </select>
                    @error('issue_user_id')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex items-center gap-4">
                    <label for="client_name" class="text-xs text-gray-700 uppercase w-24 text-right">client name</label>
                    <input id="client_name" name="client_name" type="text" class="rounded-lg border-gray-600 w-96" placeholder="client name" value="{{ $invoice->client_name }}">
                    @error('client_name')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex items-center gap-4">
                    <label for="subject" class="text-xs text-gray-700 uppercase w-24 text-right">subject</label>
                    <input id="subject" name="subject" type="text" class="rounded-lg border-gray-600 flex-1" placeholder="subject" value="{{ $invoice->subject }}">
                    @error('subject')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex items-center gap-4">
                    <label for="amount" class="text-xs text-gray-700 uppercase w-24 text-right">amount</label>
                    <input id="amount" name="amount" type="number" min="0" class="rounded-lg border-gray-600 text-right" placeholder="amount" value="{{ $invoice->amount }}">円
                    @error('amount')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex items-center gap-4">
                    <label for="description" class="text-xs text-gray-700 uppercase w-24 text-right">description</label>
                    <textarea name="description" id="description" rows="5" class="flex-1 rounded-lg border-gray-600">{!! nl2br(e($invoice->description)) !!}</textarea>
                    @error('description')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex items-center gap-4">
                    <label for="file" class="text-xs text-gray-700 uppercase w-24 text-right">file</label>
                    <input id="file" name="file" type="file" accept="application/pdf">
                    <div class="text-red-500 text-sm font-medium">変更する場合のみ、ファイルを選択してください。</div>
                    <input type="hidden" id="file_name" name="file_name" value="{{ $invoice->file_name }}">
                    @error('file')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                @if($invoice->passed_date)
                    <div class="flex items-center gap-4">
                        <label for="passed" class="text-xs text-gray-700 uppercase w-24 text-right">passed</label>
                        <div>
                            {{ __($invoice->passed_date.' '.$invoice->passed_user_name) }}
                        </div>
                    </div>
                @endif
                @if($invoice->payment_date)
                    <div class="flex items-center gap-4">
                        <label for="payment" class="text-xs text-gray-700 uppercase w-24 text-right">payment</label>
                        <div>
                            {{ __($invoice->payment_date.' '.$invoice->payment_user_name) }}
                        </div>
                    </div>
                @endif
                <div>
                    <button class="rounded-lg px-4 py-2 border-green-600 text-green-600 bg-green-50 hover:border-green-300 hover:text-green-50 hover:bg-green-300 duration-500">
                        Update Invoice
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
