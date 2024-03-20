<x-self.template title="PM Management System" css="index.css">
    <main class="w-full md:pl-80 pt-24 md:pt-4 pb-24 flex flex-col flex-wrap justify-center items-center gap-4 full">
        <h1 class="text-3xl font-bold">User Management</h1>
        <div id="indicator">indicator</div>
        <div id="container" class="flex flex-col w-full max-w-5xl gap-2">
            @foreach($users as $user)
                <div class="flex gap-2 items-center">
                    @if($user->icon)
                        <div class="w-10 h-10 flex justify-center items-center border rounded-full">
                            <img src="{{ asset('storage/' . $user->id . '/' . $user->icon) }}" alt="{{ $user->name }}" class="object-cover rounded-full">
                        </div>
                    @else
                        <div class="w-10 h-10 flex justify-center items-center border rounded-full">
                            <i class="bi bi-person-badge text-2xl"></i>
                        </div>
                    @endif
                    <input data-id="{{ $user->id }}" type="text" class="text-base p-2  flex-1 user" value="{{ $user->name }}">
                    <input data-id="{{ $user->id }}" type="email" class="text-base p-2  flex-1 email" value="{{ $user->email }}">
                    <select data-id="{{ $user->id }}" class="department">
                        <option value="0" class="hidden">Select Department</option>
                        @foreach($departments as $department)
                            <option value="{{ $department->id }}" @if($user->belong_to === $department->id) selected @endif>{{ $department->name }}</option>
                        @endforeach
                    </select>
                    <button data-id="{{ $user->id }}" class="update-user bg-blue-500 text-white p-2 rounded-lg hover:bg-blue-800">Update</button>
                    <button data-id="{{ $user->id }}" class="delete-user bg-red-500 text-white p-2 rounded-lg hover:bg-red-800">Delete</button>
                </div>
            @endforeach
            <button id="createBtn" class="create-user bg-green-500 hover:bg-green-800 text-white p-2 rounded-lg">Create User</button>
        </div>
    </main>
    <div class="hidden ml-6 text-green-500 text-red-500"></div>
    <script>
        window.Laravel = {};
        window.Laravel.csrfToken = @json(csrf_token());
        window.Laravel.users = @json($users);
        window.Laravel.departments = @json($departments);
        console.log(window.Laravel);
    </script>
    @vite(['resources/js/auth/user-list.js'])
</x-self.template>
