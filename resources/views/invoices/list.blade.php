<x-self.template title="PM Invoice List" css="invoices.css">
    <main class="w-full md:pl-80 pt-24 md:pt-4 pb-24 flex flex-col flex-wrap items-center gap-4 relative z-10 full">
        <h1 class="text-3xl text-slate eng-deco">Invoice List</h1>
        <div class="w-full md:p-6 p-0 flex flex-col gap-6 items-center justify-center">
            @if(session('message'))
                <div class="w-full bg-green-50 text-green-600 p-4 rounded-lg text-center">
                    {{ session('message') }}
                </div>
            @endif
            <div>
                <a href="{{ route('invoices.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Create New Invoice
                </a>
            </div>
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg w-full max-w-4xl">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="px-4 py-3 whitespace-nowrap">
                                Issue Date
                            </th>
                            <th scope="col" class="px-4 py-3 whitespace-nowrap">
                                Due Date
                            </th>
                            <th scope="col" class="px-4 py-3 whitespace-nowrap">
                                Issue Person
                            </th>
                            <th scope="col" class="px-4 py-3 whitespace-nowrap">
                                Client
                            </th>
                            <th scope="col" class="px-4 py-3 whitespace-nowrap">
                                Subject
                            </th>
                            <th scope="col" class="px-4 py-3 whitespace-nowrap">
                                Amount
                            </th>
                            <th scope="col" class="px-4 py-3 whitespace-nowrap">
                                File
                            </th>
                            <th scope="col" class="px-4 py-3 whitespace-nowrap">
                                Passed Date
                            </th>
                            <th scope="col" class="px-4 py-3 whitespace-nowrap">
                                Passed Person
                            </th>
                            <th scope="col" class="px-4 py-3 whitespace-nowrap">
                                Payment Date
                            </th>
                            <th scope="col" class="px-4 py-3 whitespace-nowrap">
                                Payment Person
                            </th>
                            <th scope="col" class="px-4 py-3 whitespace-nowrap">
                                Edit
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($invoices as $invoice)
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <th scope="row" class="px-4 py-4 whitespace-nowrap">
                                    {{ $invoice->issue_date }}
                                </th>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    {{ $invoice->due_date }}
                                </td>
                                <td class="px-4 py-4 flex items-center gap-2 whitespace-nowrap">
                                    <div class="h-6 w-6 flex items-center justify-center">
                                        @if($invoice->issue_user_icon)
                                            <img src="{{ asset('storage/'. $invoice->issue_user_id .'/' . $invoice->issue_user_icon) }}" alt="{{ $invoice->issue_user_name }}" class="object-contain rounded-full">
                                        @else
                                            <img src="{{ asset('storage/note.png') }}" alt="note" class="object-contain">
                                        @endif
                                    </div>
                                    {{ $invoice->issue_user_name }}
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    {{ $invoice->client_name }}
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    {{ $invoice->subject }}
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    {{ $invoice->amount }}
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <a href="{{ asset('storage/invoices/'.$invoice->file_name) }}" class="underline hover:text-blue-800">
                                        {{ $invoice->file_name }}
                                    </a>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    @if($invoice->passed_date)
                                        {{ $invoice->passed_date }}
                                    @else
                                        Not Passed
                                    @endif
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    @if($invoice->passed_person)
                                        {{ $invoice->passed_person }}
                                    @else
                                        Not Passed
                                    @endif
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    @if($invoice->payment_date)
                                        {{ $invoice->payment_date }}
                                    @else
                                        Not Paid
                                    @endif
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    @if($invoice->payment_person)
                                        {{ $invoice->payment_person }}
                                    @else
                                        Not Paid
                                    @endif
                                </td>
                                <td class="px-4 py-4 text-right whitespace-nowrap">
                                    <a href="{{ route('invoices.edit', $invoice->id) }}" class="font-medium text-blue-600 hover:underline">Edit</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </main>
    <script>
        window.Laravel = {};
        window.Laravel.invoices = @json($invoices);
        console.log(window.Laravel);
    </script>
    @vite(['resources/js/invoices/invoices.js'])
</x-self.template>
