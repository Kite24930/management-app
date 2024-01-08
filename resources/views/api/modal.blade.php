<div id="modal" class="w-full md:h-full h-[calc(100%-100px)] max-w-3xl bg-gray-100 rounded-lg p-6 flex flex-col items-start gap-4 overflow-y-auto" data-id="">
    <div class="flex items-center justify-between w-full">
        <div class="text-sm">
            @foreach($parent_task as $index => $task)
                <a href="{{ route('tasks', $task->task_id) }}">{{ $task->title }}</a>
                @if($index < count($parent_task) - 1)
                    <i class="bi bi-chevron-right mx-4"></i>
                @endif
            @endforeach
        </div>
        <button id="modalClose" class="h-10 w-10 flex justify-center items-center rounded border border-gray-600 hover:bg-gray-600 group" type="button">
            <i class="bi bi-x text-lg group group-hover:text-gray-100"></i>
        </button>
    </div>
    <input id="modal-title" class="modal-title rounded-lg border-none text-lg font-bold w-full" type="text" value="{{ $task->title }}">
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
            <input id="modal_start" type="date" class="border-none" @if($task->start_date) value="{{ $task->start_date }}" @endif>
        </div>
        <div class="mx-6 md:block hidden">
            〜
        </div>
        <div>
            終了予定日：
            <input id="modal_end" type="date" class="border-none" @if($task->end_date) value="{{ $task->end_date }}" @endif>
        </div>
    </div>
    <div class="flex items-center md:flex-row flex-col w-full text-sm">
        <div class="flex items-center">
            主担当：
            <div id="modal-main-person" data-dropdown-toggle="modal-main-person-list" class="flex items-center cursor-pointer" data-main-person="{{ $task->main_person_id }}">
                @if($task->main_person_icon)
                    <x-icons.icon src="{{ $task->main_person_id.'/'.$task->main_person_icon }}" alt="{{ $task->main_person_name }}" />
                @else
                    <i class="bi bi-person-circle text-2xl mr-2"></i>
                @endif
                {{ $task->main_person_name }}
            </div>
            <div id="modal-main-person-list" class="hidden">
                <ul class="flex flex-col gap-2 bg-white pt-4 p-2 border rounded h-[200px] overflow-y-auto">
                    @foreach($users as $user)
                        <li class="hover:bg-gray-100 rounded cursor-pointer p-2 task-person flex items-center" data-id="{{ $task->task_id }}" data-type="{{ $user->id }}">
                            @if($user->icon)
                                <x-icons.icon src="{{ $task->main_person_id.'/'.$task->main_person_icon }}" alt="{{ $task->main_person_name }}" />
                            @else
                                <i class="bi bi-person-circle"></i>
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
            <div id="modal-member" data-dropdown-toggle="modal-member-list" class="cursor-pointer flex flex-wrap gap-6">
                @foreach($members as $member)
                    <div class="flex items-center">
                        @if($member->icon)
                            <x-icons.icon src="{{ $member->id.'/'.$member->icon }}" alt="{{ $member->name }}" />
                        @else
                            <i class="bi bi-person-circle text-2xl mr-2"></i>
                        @endif
                        {{ $member->name }}
                    </div>
                @endforeach
            </div>
            <div id="modal-member-list" class="hidden">
                <ul class="flex flex-col gap-2 bg-white pt-4 p-2 border rounded h-[200px] overflow-y-auto">
                    @foreach($users as $user)
                        <li class="hover:bg-gray-100 rounded cursor-pointer p-2 task-person flex items-center" data-id="{{ $task->task_id }}" data-type="{{ $user->id }}">
                            <input id="{{ __('modal-member-'.$user->id) }}" type="checkbox" class="mr-2 rounded modal-member" value="{{ $user->id }}" @if(in_array($user->id, $member_list)) checked @endif>
                            @if($user->icon)
                                <x-icons.icon src="{{ $task->main_person_id.'/'.$task->main_person_icon }}" alt="{{ $task->main_person_name }}" />
                            @else
                                <i class="bi bi-person-circle"></i>
                            @endif
                            {{ $user->name }}
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    <div id="modal-description">
        <textarea id="modal-editor-md" class="hidden">{{ $task->description }}</textarea>
        <div id="modal-editor" class="hidden"></div>
        <div id="modal-viewer"></div>
    </div>
    <div id="modal-progress">
        <input id="modal-sub-all" type="hidden" value="{{ $sub_tasks['all'] }}">
        <input id="modal-sub-todo" type="hidden" value="{{ $sub_tasks['todo'] }}">
        <input id="modal-sub-progress" type="hidden" value="{{ $sub_tasks['progress'] }}">
        <input id="modal-sub-pending" type="hidden" value="{{ $sub_tasks['pending'] }}">
        <input id="modal-sub-completed" type="hidden" value="{{ $sub_tasks['completed'] }}">
        <input id="modal-sub-other" type="hidden" value="{{ $sub_tasks['other'] }}">
        <input id="modal-sub-cancel" type="hidden" value="{{ $sub_tasks['cancel'] }}">
    </div>
    <ul id="modal-subtask" class="text-sm bg-gray-50 border rounded-lg w-full">
        @foreach($sub_tasks['tasks'] as $task)
            <x-self.modal-subtask :task="$task" :users="$users" />
        @endforeach
        <x-self.modal-subtask-add :users="$users" />
    </ul>
    <div id="modal-comments">
        @foreach($comments as $comment)
            <div class="flex justify-start">
                <div id="{{ __('modal-comment-icon-'.$comment->id) }}" data-id="{{ $comment->id }}">
                    @if($comment->icon)
                        <x-icons.icon src="{{ $comment->user_id.'/'.$comment->icon }}" alt="{{ $comment->name }}" />
                    @else
                        <i class="bi bi-person-circle text-2xl mr-2"></i>
                    @endif
                </div>
                <textarea id="{{ __('modal-comment-'.$comment->id) }}" class="hidden">{{ $comment->comment }}</textarea>
                <div id="modal-editor" class="hidden editor" data-id="{{ $comment->id }}"></div>
                <div id="modal-viewer" class="viewer" data-id="{{ $comment->id }}"></div>
            </div>
        @endforeach
    </div>
</div>
