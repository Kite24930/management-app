<x-self.template title="PM Management System" css="tasks.css">
    <main class="w-full md:pl-80 pt-24 md:pt-4 pb-24 flex flex-col flex-wrap items-center gap-4 relative z-10 full">
        <div id="indicator" class="absolute top-4 right-4 flex items-center px-2 h-50 gap-2 border rounded-lg">
            <div id="indicatorIcon">
                <i class="bi bi-arrow-clockwise"></i>
            </div>
            <div id="indicatorText">
                Loading...
            </div>
        </div>
        <input id="loginUser" type="hidden" value="{{ Auth::id() }}">
        <div class="flex justify-center items-center px-6 pb-2 border-b">
            <h1 class="text-2xl font-bold">
                @if($target)
                    {{ $target->title }}
                    <input id="targetId" type="hidden" value="{{ $target->id }}">
                @else
                    @if(isset($target->icon))
                        <x-icons.icon src="{{ $target->icon }}" alt="{{ $target->title }}" class="!w-12 !h-12" />
                    @endif
                    Project M, Inc. Task Management System
                        <input id="targetId" type="hidden" value="0">
                @endif
            </h1>
        </div>
        @if($target)
            <div class="w-full max-w-2xl p-4 rounded-lg border flex flex-col gap-2 *:text-sm">
                <div class="flex md:flex-row flex-col md:items-center md:justify-between gap-2">
                    <div id="current-task" data-id="{{ $target->id }}">親タスク：Mieet Plus</div>
                    <div class="flex items-center">
                        <div id="{{ __('current-priority') }}" data-dropdown-toggle="{{ __('current-priority-list') }}" class="cursor-pointer">
                            優先度：
                            @switch($target->priority)
                                @case(1) <x-icons.highest /> @break
                                @case(2) <x-icons.high /> @break
                                @case(3) <x-icons.middle /> @break
                                @case(4) <x-icons.low /> @break
                                @case(5) <x-icons.lowest /> @break
                            @endswitch
                        </div>
                        <div id="{{ __('current-priority-list') }}" class="hidden">
                            <ul class="flex flex-col gap-2 bg-white pt-4 pb-2 px-2 border rounded">
                                <li class="hover:bg-gray-100 rounded cursor-pointer p-2 current-task-priority" data-id="{{ $target->task_id }}" data-type="1">
                                    <x-icons.highest />
                                </li>
                                <li class="hover:bg-gray-100 rounded cursor-pointer p-2 current-task-priority" data-id="{{ $target->task_id }}" data-type="2">
                                    <x-icons.high />
                                </li>
                                <li class="hover:bg-gray-100 rounded cursor-pointer p-2 current-task-priority" data-id="{{ $target->task_id }}" data-type="3">
                                    <x-icons.middle />
                                </li>
                                <li class="hover:bg-gray-100 rounded cursor-pointer p-2 current-task-priority" data-id="{{ $target->task_id }}" data-type="4">
                                    <x-icons.low />
                                </li>
                                <li class="hover:bg-gray-100 rounded cursor-pointer p-2 current-task-priority" data-id="{{ $target->task_id }}" data-type="5">
                                    <x-icons.lowest />
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <div id="{{ __('type-'.$target->task_id) }}" class="flex items-center">
                            Type：
                            @switch($target->type)
                                @case(1) <x-icons.internal-project /> @break
                                @case(2) <x-icons.orders-receive /> @break
                                @case(3) <x-icons.head-office-order /> @break
                            @endswitch
                        </div>
                    </div>
                </div>
                <div class="flex md:flex-row flex-col md:items-center md:gap-10 gap-2">
                    <div class="flex items-center">
                        主担当者：
                        @if($target->main_person_icon)
                            <x-icons.icon src="{{ $target->main_person_id . '/' . $target->main_person_icon }}" alt="{{ $target->main_person_name }}" class="w-8 h-8" />
                        @else
                            <x-icons.person-circle class="w-6 h-6 text-sm">{{ $target->main_person_name }}</x-icons.person-circle>
                        @endif
                        {{ $target->main_person_name }}
                    </div>
                    <div class="flex items-center">
                        <div id="{{ __('current-status') }}" data-dropdown-toggle="{{ __('current-status-list') }}" class="cursor-pointer">
                            ステータス：
                            @switch($target->status)
                                @case(1) <x-icons.todo /> @break
                                @case(2) <x-icons.progress /> @break
                                @case(3) <x-icons.pending /> @break
                                @case(4) <x-icons.completed /> @break
                                @case(5) <x-icons.other /> @break
                                @case(6) <x-icons.cancel /> @break
                            @endswitch
                        </div>
                        <div id="{{ __('current-status-list') }}" class="hidden">
                            <ul class="flex flex-col gap-2 bg-white pt-4 pb-2 px-2 border rounded">
                                <li class="hover:bg-gray-100 rounded cursor-pointer pt-2 current-task-type" data-id="{{ $target->task_id }}" data-type="0">
                                    <x-icons.todo />
                                </li>
                                <li class="hover:bg-gray-100 rounded cursor-pointer pt-2 current-task-type" data-id="{{ $target->task_id }}" data-type="1">
                                    <x-icons.progress />
                                </li>
                                <li class="hover:bg-gray-100 rounded cursor-pointer pt-2 current-task-type" data-id="{{ $target->task_id }}" data-type="2">
                                    <x-icons.pending />
                                </li>
                                <li class="hover:bg-gray-100 rounded cursor-pointer pt-2 current-task-type" data-id="{{ $target->task_id }}" data-type="3">
                                    <x-icons.completed />
                                </li>
                                <li class="hover:bg-gray-100 rounded cursor-pointer pt-2 current-task-type" data-id="{{ $target->task_id }}" data-type="4">
                                    <x-icons.other />
                                </li>
                                <li class="hover:bg-gray-100 rounded cursor-pointer pt-2 current-task-type" data-id="{{ $target->task_id }}" data-type="5">
                                    <x-icons.cancel />
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="flex md:flex-row flex-col md:items-center md:gap-10 gap-2">
                    <div>開始日：{{ $target->start_date }}</div>
                    <div>終了予定日：{{ $target->end_date }}</div>
                </div>
                <textarea name="current-description" id="current-description" class="hidden">{{ $target->description }}</textarea>
                <div id="current-viewer" class="viewer"></div>
                <div id="current-editor" class="editor hidden"></div>
                <button id="current-editor-register" class="bg-white p-2 border hidden items-center justify-center" data-id="{{ $target->id }}">
                    <i class="bi bi-node-plus-fill text-lg mr-2"></i>
                    register description
                </button>
            </div>
        @endif
        <div class="h-[80dvh] w-full px-4 flex overflow-x-auto whitespace-nowrap">
            <div class="h-full border rounded-lg p-2 flex overflow-x-auto flex-shrink-0 gap-4">
                <div class="w-80 h-full border rounded-lg flex flex-col p-2 bg-yellow-50">
                    <div class="w-full flex justify-between items-center">
                        <x-icons.todo />
                    </div>
                    <ul id="todo" class="w-full flex flex-col mt-4 gap-2 overflow-y-auto">
                        @foreach($todo as $task)
                            <x-self.task-item :task="$task" :users="$users" :departments="$departments" :task_types="$task_types" :members="$members" :comments="$comments" :log="$log" />
                        @endforeach
                        <x-self.task-add target="0" />
                    </ul>
                </div>
                <div class="w-80 h-full border rounded-lg  flex flex-col p-2 bg-red-50">
                    <div class="w-full flex justify-between items-center">
                        <x-icons.progress />
                    </div>
                    <ul id="progress" class="w-full flex flex-col mt-4 gap-2 overflow-y-auto">
                        @foreach($progress as $task)
                            <x-self.task-item :task="$task" :users="$users" :departments="$departments" :task_types="$task_types" :members="$members" :comments="$comments" :log="$log" />
                        @endforeach
                        <x-self.task-add target="1" />
                    </ul>
                </div>
                <div class="w-80 h-full border rounded-lg  flex flex-col p-2 bg-yellow-300">
                    <div class="w-full flex justify-between items-center">
                        <x-icons.pending />
                    </div>
                    <ul id="pending" class="w-full flex flex-col mt-4 gap-2 overflow-y-auto">
                        @foreach($pending as $task)
                            <x-self.task-item :task="$task" :users="$users" :departments="$departments" :task_types="$task_types" :members="$members" :comments="$comments" :log="$log" />
                        @endforeach
                        <x-self.task-add target="2" />
                    </ul>
                </div>
                <div class="w-80 h-full border rounded-lg  flex flex-col p-2 bg-green-50">
                    <div class="w-full flex justify-between items-center">
                        <x-icons.completed />
                    </div>
                    <ul id="completed" class="w-full flex flex-col mt-4 gap-2 overflow-y-auto">
                        @foreach($completed as $task)
                            <x-self.task-item :task="$task" :users="$users" :departments="$departments" :task_types="$task_types" :members="$members" :comments="$comments" :log="$log" />
                        @endforeach
                        <x-self.task-add target="3" />
                    </ul>
                </div>
                <div class="w-80 h-full border rounded-lg  flex flex-col p-2 bg-gray-50">
                    <div class="w-full flex justify-between items-center">
                        <x-icons.other />
                    </div>
                    <ul id="other" class="w-full flex flex-col mt-4 gap-2 overflow-y-auto">
                        @foreach($other as $task)
                            <x-self.task-item :task="$task" :users="$users" :departments="$departments" :task_types="$task_types" :members="$members" :comments="$comments" :log="$log" />
                        @endforeach
                        <x-self.task-add target="4" />
                    </ul>
                </div>
                <div class="w-80 h-full border rounded-lg  flex flex-col p-2 bg-blue-50">
                    <div class="w-full flex justify-between items-center">
                        <x-icons.cancel />
                    </div>
                    <ul id="cancel" class="w-full flex flex-col mt-4 gap-2 overflow-y-auto">
                        @foreach($cancel as $task)
                            <x-self.task-item :task="$task" :users="$users" :departments="$departments" :task_types="$task_types" :members="$members" :comments="$comments" :log="$log" />
                        @endforeach
                        <x-self.task-add target="5" />
                    </ul>
                </div>
            </div>
        </div>
        <div id="modalWrapper" class="bg-black bg-opacity-50 absolute top-0 left-0 border-0 right-0 w-full h-full z-40 hidden justify-center items-center p-10">

        </div>
    </main>
    <script>
        window.Laravel = {};
        window.Laravel.users = @json($users);
        window.Laravel.departments = @json($departments);
        window.Laravel.task_types = @json($task_types);
        window.Laravel.target = @json($target);
        window.Laravel.tasks = @json($tasks);
        window.Laravel.task_list = @json($task_list);
        window.Laravel.members = @json($members);
        window.Laravel.comments = @json($comments);
        window.Laravel.todo = @json($todo);
        window.Laravel.progress = @json($progress);
        window.Laravel.completed = @json($completed);
        window.Laravel.other = @json($other);
        window.Laravel.cancel = @json($cancel);
        window.Laravel.log = @json($log);
        window.Laravel.active_user = @json($active_user);
        console.log(window.Laravel);
    </script>
    @vite(['resources/js/tasks.js'])
</x-self.template>
