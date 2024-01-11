<div id="modal" class="w-full md:h-full h-[calc(100%-100px)] max-w-3xl bg-gray-100 rounded-lg px-6 pb-6 flex flex-col items-start gap-4 overflow-y-auto relative" data-id="{{ $task->id }}">
    <div class="w-full bg-gray-100 flex flex-col items-start gap-4 sticky top-0 pt-6 z-50">
        <div class="flex items-center justify-between w-full gap-4">
            <div class="text-sm flex-1">
                @foreach($parent_task as $index => $task)
                    <a href="{{ route('tasks', $task->task_id) }}">{{ $task->title }}</a>
                    @if($index < count($parent_task) - 1)
                        <i class="bi bi-chevron-right mx-4"></i>
                    @endif
                @endforeach
            </div>
            <div id="modal-menu" data-dropdown-toggle="modal-menu-list" class="h-10 w-10 flex justify-center items-center rounded border border-gray-600 hover:bg-gray-600 group cursor-pointer">
                <i class="bi bi-three-dots text-lg group-hover:text-gray-100"></i>
            </div>
            <div id="modal-menu-list" class="hidden">
                <ul class="flex flex-col gap-2 bg-white p-2 border rounded">
                    <li class="hover:bg-gray-100 rounded cursor-pointer p-2 modal-menu">
                        <a href="{{ route('tasks', $task->id) }}">
                            <i class="bi bi-kanban mr-2"></i>
                            タスクリストを開く
                        </a>
                    </li>
                    <li class="hover:bg-gray-100 rounded cursor-pointer p-2 modal-menu *:text-red-700 text-red-700" data-id="{{ $task->id }}">
                        <i class="bi bi-trash mr-2"></i>
                        削除
                    </li>
                </ul>
            </div>
            <button id="modalClose" class="h-10 w-10 flex justify-center items-center rounded border border-gray-600 hover:bg-gray-600 group" type="button">
                <i class="bi bi-x text-lg group-hover:text-gray-100"></i>
            </button>
        </div>
        <input id="modal-title" class="modal-title rounded-lg border-none text-lg font-bold w-full" type="text" value="{{ $task->title }}">
        <hr class="w-full">
    </div>
    <div class="flex md:items-center items-start w-full md:flex-row flex-col md:gap-0 gap-6 md:justify-evenly">
        <div class="text-sm">
            優先度：
            <div class="inline-flex items-center">
                <div id="modal-priority" data-dropdown-toggle="modal-priority-list" class="cursor-pointer" data-priority="{{ $task->priority }}">
                    @switch($task->priority)
                        @case(1) <x-icons.highest /> @break
                        @case(2) <x-icons.high /> @break
                        @case(3) <x-icons.middle /> @break
                        @case(4) <x-icons.low /> @break
                        @case(5) <x-icons.lowest /> @break
                    @endswitch
                </div>
                <div id="modal-priority-list" class="hidden">
                    <ul class="flex flex-col gap-2 bg-white p-2 border rounded">
                        <li class="hover:bg-gray-100 rounded cursor-pointer p-2 modal-priority" data-priority="1">
                            <x-icons.highest />
                        </li>
                        <li class="hover:bg-gray-100 rounded cursor-pointer p-2 modal-priority" data-priority="2">
                            <x-icons.high />
                        </li>
                        <li class="hover:bg-gray-100 rounded cursor-pointer p-2 modal-priority" data-priority="3">
                            <x-icons.middle />
                        </li>
                        <li class="hover:bg-gray-100 rounded cursor-pointer p-2 modal-priority" data-priority="4">
                            <x-icons.low />
                        </li>
                        <li class="hover:bg-gray-100 rounded cursor-pointer p-2 modal-priority" data-priority="5">
                            <x-icons.lowest />
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="text-sm">
            ステータス：
            <div class="inline-flex items-center">
                <div id="modal-status" data-dropdown-toggle="modal-status-list" class="cursor-pointer" data-status="{{ $task->status }}">
                    @switch($task->status)
                        @case(0) <x-icons.todo /> @break
                        @case(1) <x-icons.progress /> @break
                        @case(2) <x-icons.pending /> @break
                        @case(3) <x-icons.completed /> @break
                        @case(4) <x-icons.other /> @break
                        @case(5) <x-icons.cancel /> @break
                    @endswitch
                </div>
                <div id="modal-status-list" class="hidden">
                    <ul class="flex flex-col gap-2 bg-white pt-4 pb-2 px-2 border rounded">
                        <li class="hover:bg-gray-100 rounded cursor-pointer p-2 modal-status" data-status="0">
                            <x-icons.todo />
                        </li>
                        <li class="hover:bg-gray-100 rounded cursor-pointer p-2 modal-status" data-status="1">
                            <x-icons.progress />
                        </li>
                        <li class="hover:bg-gray-100 rounded cursor-pointer p-2 modal-status" data-status="2">
                            <x-icons.pending />
                        </li>
                        <li class="hover:bg-gray-100 rounded cursor-pointer p-2 modal-status" data-status="3">
                            <x-icons.completed />
                        </li>
                        <li class="hover:bg-gray-100 rounded cursor-pointer p-2 modal-status" data-status="4">
                            <x-icons.other />
                        </li>
                        <li class="hover:bg-gray-100 rounded cursor-pointer p-2 modal-status" data-status="5">
                            <x-icons.cancel />
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div>
            <div class="inline-flex items-center">
                <div id="modal-type" data-dropdown-toggle="modal-type-list" class="cursor-pointer" data-type="{{ $task->type }}">
                    @switch($task->type)
                        @case(1) <x-icons.internal-project /> @break
                        @case(2) <x-icons.orders-receive /> @break
                        @case(3) <x-icons.head-office-order /> @break
                    @endswitch
                </div>
                <div id="modal-type-list" class="hidden">
                    <ul class="flex flex-col gap-2 bg-white pt-4 pb-2 px-2 border rounded">
                        <li class="hover:bg-gray-100 rounded cursor-pointer pt-2 modal-type" data-type="1">
                            <x-icons.internal-project />
                        </li>
                        <li class="hover:bg-gray-100 rounded cursor-pointer pt-2 modal-type" data-type="2">
                            <x-icons.orders-receive />
                        </li>
                        <li class="hover:bg-gray-100 rounded cursor-pointer pt-2 modal-type" data-type="3">
                            <x-icons.head-office-order />
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="flex items-center md:flex-row flex-col md:justify-evenly w-full text-sm">
        <div>
            開始日：
            <input id="modal-start-date" type="date" class="border-none" @if($task->start_date) value="{{ $task->start_date }}" @endif data-id="{{ $task->id }}">
            <i id="modal-start-date-clear" class="bi bi-x-octagon-fill ml-2 text-lg cursor-pointer"></i>
        </div>
        <div class="mx-6 md:block hidden">
            〜
        </div>
        <div>
            終了予定日：
            <input id="modal-end-date" type="date" class="border-none" @if($task->end_date) value="{{ $task->end_date }}" @endif data-id="{{ $task->id }}">
            <i id="modal-end-date-clear" class="bi bi-x-octagon-fill ml-2 text-lg cursor-pointer"></i>
        </div>
    </div>
    <div class="flex items-center md:flex-row flex-col w-full text-sm">
        <div class="flex items-center">
            主担当：
            <div id="modal-main-person" data-dropdown-toggle="modal-main-person-list" class="flex items-center cursor-pointer" data-main-person="{{ $task->main_person_id }}">
                @if($task->main_person_id)
                    @if($task->main_person_icon)
                        <x-icons.icon src="{{ $task->main_person_id.'/'.$task->main_person_icon }}" alt="{{ $task->main_person_name }}" />
                    @else
                        <x-icons.person-circle class="w-8 h-8 text-lg">{{ $task->main_person_name }}</x-icons.person-circle>
                    @endif
                    {{ $task->main_person_name }}
                @else
                    <i class="bi bi-person-circle text-gray-400 text-3xl mr-2"></i>
                @endif
            </div>
            <div id="modal-main-person-list" class="hidden">
                <ul class="flex flex-col gap-2 bg-white pt-4 p-2 border rounded h-[200px] overflow-y-auto">
                    @foreach($users as $user)
                        <li class="hover:bg-gray-100 rounded cursor-pointer p-2 modal-main-person flex items-center" data-id="{{ $task->task_id }}" data-person="{{ $user->id }}">
                            @if($user->icon)
                                <x-icons.icon src="{{ $user->id.'/'.$user->icon }}" alt="{{ $user->name }}" />
                            @else
                                <x-icons.person-circle class="w-6 h-6 text-sm">{{ $user->name }}</x-icons.person-circle>
                            @endif
                            {{ $user->name }}
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    <div>
        <div class="flex items-center text-sm w-full">
            担当者：
            <div id="modal-member" data-dropdown-toggle="modal-member-list" class="cursor-pointer flex flex-wrap">
                @foreach($members as $member)
                    @if($member->is_main_person === 0)
                        <div class="flex items-center">
                            @if($member->icon)
                                <x-icons.icon src="{{ $member->id.'/'.$member->icon }}" alt="{{ $member->name }}" />
                            @else
                                <x-icons.person-circle class="w-8 h-8 text-lg">{{ $member->name }}</x-icons.person-circle>
                            @endif
{{--                            {{ $member->name }}--}}
                        </div>
                    @endif
                @endforeach
            </div>
            <div id="modal-member-list" class="hidden">
                <ul class="flex flex-col gap-2 bg-white pt-4 p-2 border rounded h-[200px] overflow-y-auto">
                    @foreach($users as $user)
                        <li class="hover:bg-gray-100 rounded cursor-pointer p-2 task-person flex items-center" data-id="{{ $task->task_id }}" data-type="{{ $user->id }}">
                            <input id="{{ __('modal-member-'.$user->id) }}" type="checkbox" class="mr-2 rounded modal-member" value="{{ $user->id }}" @if(in_array($user->id, $member_list)) checked @endif>
                            @if($user->icon)
                                <x-icons.icon src="{{ $user->id.'/'.$user->icon }}" alt="{{ $user->name }}" />
                            @else
                                <x-icons.person-circle class="w-6 h-6 text-sm">{{ $user->name }}</x-icons.person-circle>
                            @endif
                            {{ $user->name }}
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    <div id="modal-description" class="w-full">
        <textarea id="modal-editor-md" class="hidden">{{ $task->description }}</textarea>
        <div id="modal-editor" class="hidden mb-2"></div>
        <div id="modal-viewer" class="bg-white p-4 rounded-lg mb-2"></div>
        <button id="modal-editor-open" class="bg-white p-2 border flex items-center justify-center">
            <i class="bi bi-pencil-square text-lg mr-2"></i>
            edit description
        </button>
        <button id="modal-editor-register" class="bg-white p-2 border hidden items-center justify-center" data-id="{{ $task->id }}">
            <i class="bi bi-node-plus-fill text-lg mr-2"></i>
            register description
        </button>
    </div>
    <div id="modal-progress" class="w-full">
        <input id="modal-sub-all" type="hidden" value="{{ $sub_tasks['all'] }}">
        <input id="modal-sub-todo" type="hidden" value="{{ $sub_tasks['todo'] }}">
        <input id="modal-sub-progress" type="hidden" value="{{ $sub_tasks['progress'] }}">
        <input id="modal-sub-pending" type="hidden" value="{{ $sub_tasks['pending'] }}">
        <input id="modal-sub-completed" type="hidden" value="{{ $sub_tasks['completed'] }}">
        <input id="modal-sub-other" type="hidden" value="{{ $sub_tasks['other'] }}">
        <input id="modal-sub-cancel" type="hidden" value="{{ $sub_tasks['cancel'] }}">
        <div class="w-full flex p-0 m-0 border border-gray-300 rounded-full overflow-hidden">
            <button id="modal-todo-bar" data-tooltip-target="modal-todo-tooltip" type="button" class="bg-yellow-50 h-4 border-r flex justify-center items-center text-xs" style="width:33.3%">ToDo</button>
            <div id="modal-todo-tooltip" role="tooltip" class="absolute z-50 invisible inline-block px-3 py-2 text-sm text-white transition-opacity duration-300 bg-gray-700 shadow-sm opacity-0 tooltip rounded-lg">
                <span id="modal-todo-ratio" class="text-gray-300">3/10(33.3%)</span>
                <div class="tooltip-arrow" data-popper-arrow></div>
            </div>
            <button id="modal-progress-bar" data-tooltip-target="modal-progress-tooltip" type="button" class="bg-red-50 h-4 border-r flex justify-center items-center text-xs" style="width:20%">Progress</button>
            <div id="modal-progress-tooltip" role="tooltip" class="absolute z-50 invisible inline-block px-3 py-2 text-sm text-white transition-opacity duration-300 bg-gray-700 shadow-sm opacity-0 tooltip rounded-lg">
                <span id="modal-progress-ratio" class="text-gray-300">2/10(20.0%)</span>
                <div class="tooltip-arrow" data-popper-arrow></div>
            </div>
            <button id="modal-pending-bar" data-tooltip-target="modal-pending-tooltip" type="button" class="bg-yellow-300 h-4 border-r flex justify-center items-center text-xs" style="width:33.3%">Pending</button>
            <div id="modal-pending-tooltip" role="tooltip" class="absolute z-50 invisible inline-block px-3 py-2 text-sm text-white transition-opacity duration-300 bg-gray-700 shadow-sm opacity-0 tooltip rounded-lg">
                <span id="modal-pending-ratio" class="text-gray-300">3/10(33.3%)</span>
                <div class="tooltip-arrow" data-popper-arrow></div>
            </div>
            <button id="modal-completed-bar" data-tooltip-target="modal-completed-tooltip" type="button" class="bg-green-50 rounded-l-full h-4 border-r flex justify-center items-center text-xs" style="width:10%">Completed</button>
            <div id="modal-completed-tooltip" role="tooltip" class="absolute z-50 invisible inline-block px-3 py-2 text-sm text-white transition-opacity duration-300 bg-gray-700 shadow-sm opacity-0 tooltip rounded-lg">
                <span id="modal-completed-ratio" class="text-gray-300">1/10(10%)</span>
                <div class="tooltip-arrow" data-popper-arrow></div>
            </div>
            <button id="modal-other-bar" data-tooltip-target="modal-other-tooltip" type="button" class="bg-gray-50 h-4 border-r flex justify-center items-center text-xs" style="width:10%">Other</button>
            <div id="modal-other-tooltip" role="tooltip" class="absolute z-50 invisible inline-block px-3 py-2 text-sm text-white transition-opacity duration-300 bg-gray-700 shadow-sm opacity-0 tooltip rounded-lg">
                <span id="modal-other-ratio" class="text-gray-300">1/10(10%)</span>
                <div class="tooltip-arrow" data-popper-arrow></div>
            </div>
            <button id="modal-cancel-bar" data-tooltip-target="modal-cancel-tooltip" type="button" class="bg-blue-50 rounded-r-full h-4 flex justify-center items-center text-xs" style="width:10%">Cancel</button>
            <div id="modal-cancel-tooltip" role="tooltip" class="absolute z-50 invisible inline-block px-3 py-2 text-sm text-white transition-opacity duration-300 bg-gray-700 shadow-sm opacity-0 tooltip rounded-lg">
                <span id="modal-cancel-ratio" class="text-gray-300">1/10(10%)</span>
                <div class="tooltip-arrow" data-popper-arrow></div>
            </div>
        </div>
    </div>
    <ul id="modal-subtask" class="text-sm bg-gray-50 border rounded-lg w-full" data-id="{{ $task->id }}">
        @foreach($sub_tasks['tasks'] as $task)
            <x-self.modal-subtask :task="$task" :users="$users" />
        @endforeach
        <x-self.modal-subtask-add :users="$users" />
    </ul>
    <hr class="w-full">
    <div class="bg-white p-2 rounded-lg w-full flex flex-col">
        <x-self.modal-comment-add :user="$active_user" />
    </div>
    <div id="modal-comment" class="bg-white p-2 rounded-lg w-full flex flex-col gap-2">
        @foreach($comments as $comment)
            <x-self.modal-comment :comment="$comment" :user="$active_user" />
        @endforeach
    </div>
</div>
