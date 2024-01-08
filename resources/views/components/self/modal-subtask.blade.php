<li class="flex w-full items-center gap-6 px-2">
    <div id="{{ __('modal-sub-priority-'.$task->id) }}" data-dropdown-toggle="{{ __('modal-sub-priority-list-'.$task->id) }}" class="cursor-pointer" data-id="{{ $task->id }}" data-priority="@switch($task->priority) @case(1)1@break @case(2)2@break @case(3)3@break @case(4)4@break @case(5)5@break @endswitch">
        @switch($task->priority)
            @case(1) <x-icons.highest /> @break
            @case(2) <x-icons.high /> @break
            @case(3) <x-icons.middle /> @break
            @case(4) <x-icons.low /> @break
            @case(5) <x-icons.lowest /> @break
        @endswitch
    </div>
    <div id="{{ __('modal-sub-priority-list-'.$task->id) }}" class="hidden">
        <ul class="flex flex-col gap-2 bg-white p-2 border rounded">
            <li class="hover:bg-gray-100 rounded cursor-pointer p-2 modal-sub-priority" data-id="{{ $task->id }}" data-type="1">
                <x-icons.highest />
            </li>
            <li class="hover:bg-gray-100 rounded cursor-pointer p-2 modal-sub-priority" data-id="{{ $task->id }}" data-type="2">
                <x-icons.high />
            </li>
            <li class="hover:bg-gray-100 rounded cursor-pointer p-2 modal-sub-priority" data-id="{{ $task->id }}" data-type="3">
                <x-icons.middle />
            </li>
            <li class="hover:bg-gray-100 rounded cursor-pointer p-2 modal-sub-priority" data-id="{{ $task->id }}" data-type="4">
                <x-icons.low />
            </li>
            <li class="hover:bg-gray-100 rounded cursor-pointer p-2 modal-sub-priority" data-id="{{ $task->id }}" data-type="5">
                <x-icons.lowest />
            </li>
        </ul>
    </div>
    <div class="flex-1">
        <a href="{{ route('tasks', $task->id) }}">{{ $task->name }}</a>
        <input type="text" id="{{ __('modal-sub-title-'.$task->id) }}" class="border-none rounded-lg hidden w-full" value="{{ $task->name }}">
    </div>
    <div id="{{ __('modal-title-edit-'.$task->id) }}" class="w-8 h-8 modal-title-edit cursor-pointer flex items-center justify-center" data-id="{{ $task->id }}">
        <i class="bi bi-pencil-square text-gray-400"></i>
    </div>
    <div id="{{ __('modal-sub-main-'.$task->id) }}" data-dropdown-toggle="{{ __('modal-sub-main-list-'.$task->id) }}" class="cursor-pointer" data-id="{{ $task->id }}">
        @if($task->main_person_icon)
            <x-icons.icon src="{{ $task->main_person_id.'/'.$task->main_person_icon }}" alt="{{ $task->main_person_name }}" />
        @else
            <i class="bi bi-person-circle text-2xl mr-2"></i>
        @endif
        {{ $task->main_person_name }}
    </div>
    <div id="{{ __('modal-sub-main-list-'.$task->id) }}" class="hidden">
        <ul class="flex flex-col gap-2 bg-white pt-4 p-2 border rounded h-[200px] overflow-y-auto">
            @foreach($users as $user)
                <li class="hover:bg-gray-100 rounded cursor-pointer p-2 modal-sub-person flex items-center" data-id="{{ $task->task_id }}" data-type="{{ $user->id }}">
                    @if($user->icon)
                        <x-icons.icon src="{{ $user->id.'/'.$user->icon }}" alt="{{ $user->name }}" />
                    @else
                        <i class="bi bi-person-circle"></i>
                    @endif
                    {{ $user->name }}
                </li>
            @endforeach
        </ul>
    </div>
    <div id="{{ __('modal-sub-status-'.$task->id) }}" class="modal-sub-status cursor-pointer" data-dropdown-toggle="{{ __('modal-sub-status-list-'.$task->id) }}" data-id="{{ $task->id }}" data-status="@switch($task->status) @case(0)0@break @case(1)1@break @case(2)2@break @case(3)3@break @case(4)4@break @case(5)5@break @endswitch">
        @switch($task->status)
            @case(0) <x-icons.todo /> @break
            @case(1) <x-icons.progress /> @break
            @case(2) <x-icons.pending /> @break
            @case(3) <x-icons.completed /> @break
            @case(4) <x-icons.other /> @break
            @case(5) <x-icons.cancel /> @break
        @endswitch
    </div>
    <div id="{{ __('modal-sub-status-list-'.$task->id) }}" class="hidden">
        <ul class="flex flex-col gap-2 bg-white pt-4 pb-2 px-2 border rounded">
            <li class="hover:bg-gray-100 rounded cursor-pointer p-2 modal-status" data-id="{{ $task->id }}" data-type="0">
                <x-icons.todo />
            </li>
            <li class="hover:bg-gray-100 rounded cursor-pointer p-2 modal-status" data-id="{{ $task->id }}" data-type="1">
                <x-icons.progress />
            </li>
            <li class="hover:bg-gray-100 rounded cursor-pointer p-2 modal-status" data-id="{{ $task->id }}" data-type="2">
                <x-icons.pending />
            </li>
            <li class="hover:bg-gray-100 rounded cursor-pointer p-2 modal-status" data-id="{{ $task->id }}" data-type="3">
                <x-icons.completed />
            </li>
            <li class="hover:bg-gray-100 rounded cursor-pointer p-2 modal-status" data-id="{{ $task->id }}" data-type="4">
                <x-icons.other />
            </li>
            <li class="hover:bg-gray-100 rounded cursor-pointer p-2 modal-status" data-id="{{ $task->id }}" data-type="5">
                <x-icons.cancel />
            </li>
        </ul>
    </div>
</li>
