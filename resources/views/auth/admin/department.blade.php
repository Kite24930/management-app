<x-self.template title="PM Management System" css="index.css">
    <main class="w-full md:pl-80 pt-24 md:pt-4 pb-24 flex flex-col flex-wrap justify-center items-center gap-4 full">
        <h1 class="text-4xl font-bold">Department</h1>
        <div id="indicator">indicator</div>
        <div class="flex flex-col w-full max-w-md gap-2">
            @foreach($departments as $department)
                @if($department->parent_department === 0)
                    <div id="{{ __('department-' . $department->id) }}" class="flex flex-col justify-between items-center w-full gap-2">
                        <div class="flex w-full items-center text-xl">
                            <i class="bi bi-building mr-2"></i>
                            <input data-id="{{ $department->id }}" data-parent="0" type="text" class="text-base p-2 border-none rounded-lg flex-1 department" value="{{ $department->name }}">
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </main>
    <div class="hidden ml-6 text-green-500 text-red-500"></div>
    <script>
        window.Laravel = {};
        window.Laravel.csrfToken = @json(csrf_token());
        window.Laravel.departments = @json($departments);
        console.log(window.Laravel);
    </script>
    @vite(['resources/js/auth/department.js'])
</x-self.template>
