<li class="flex w-full items-center gap-2 px-2 py-2 border-b">
    <div id="{{ __('modal-sub-priority-'.$task->id) }}" data-dropdown-toggle="{{ __('modal-sub-priority-list-'.$task->id) }}" class="cursor-pointer w-20 flex justify-center items-center" data-id="{{ $task->id }}" data-priority="{{ $task->priority }}">
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
            <li class="hover:bg-gray-100 rounded cursor-pointer p-2 modal-sub-priority" data-id="{{ $task->id }}" data-priority="1">
                <x-icons.highest />
            </li>
            <li class="hover:bg-gray-100 rounded cursor-pointer p-2 modal-sub-priority" data-id="{{ $task->id }}" data-priority="2">
                <x-icons.high />
            </li>
            <li class="hover:bg-gray-100 rounded cursor-pointer p-2 modal-sub-priority" data-id="{{ $task->id }}" data-priority="3">
                <x-icons.middle />
            </li>
            <li class="hover:bg-gray-100 rounded cursor-pointer p-2 modal-sub-priority" data-id="{{ $task->id }}" data-priority="4">
                <x-icons.low />
            </li>
            <li class="hover:bg-gray-100 rounded cursor-pointer p-2 modal-sub-priority" data-id="{{ $task->id }}" data-priority="5">
                <x-icons.lowest />
            </li>
        </ul>
    </div>
    <div class="flex-1">
        <div id="{{ __('modal-sub-link-'.$task->id) }}" class="w-full flex items-center justify-between modal-sub-link pl-3">
            <a href="{{ route('tasks', $task->id) }}" class="underline hover:text-blue-800">{{ $task->title }}</a>
            <div class="w-8 h-8 flex justify-center items-center cursor-pointer">
                <i class="bi bi-pencil-square modal-sub-title-edit" data-id="{{ $task->id }}"></i>
            </div>
        </div>
        <input type="text" id="{{ __('modal-sub-title-'.$task->id) }}" class="border-none rounded-lg w-full text-sm py-1 h-8 hidden modal-sub-title" value="{{ $task->title }}" data-id="{{ $task->id }}">
    </div>
    <div id="{{ __('modal-sub-main-'.$task->id) }}" data-dropdown-toggle="{{ __('modal-sub-main-list-'.$task->id) }}" class="cursor-pointer" data-id="{{ $task->id }}">
        @if($task->main_person_id)
            @if($task->main_person_icon)
                <x-icons.icon src="{{ $task->main_person_id.'/'.$task->main_person_icon }}" alt="{{ $task->main_person_name }}" />
            @else
                <x-icons.person-circle class="w-6 h-6 !mr-0">{{ $task->main_person_name }}</x-icons.person-circle>
            @endif
        @else
            <i class="bi bi-person-circle text-2xl"></i>
        @endif
    </div>
    <div id="{{ __('modal-sub-main-list-'.$task->id) }}" class="hidden">
        <ul class="flex flex-col gap-2 bg-white pt-4 p-2 border rounded h-[200px] overflow-y-auto">
            @foreach($users as $user)
                <li class="hover:bg-gray-100 rounded cursor-pointer p-2 modal-sub-person flex items-center" data-id="{{ $task->id }}" data-person="{{ $user->id }}">
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
    <div id="{{ __('modal-sub-status-'.$task->id) }}" class="modal-sub-status cursor-pointer w-28 flex justify-center items-center" data-dropdown-toggle="{{ __('modal-sub-status-list-'.$task->id) }}" data-id="{{ $task->id }}" data-status="{{ $task->status }}">
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
            <li class="hover:bg-gray-100 rounded cursor-pointer p-2 modal-sub-status" data-id="{{ $task->id }}" data-status="0">
                <x-icons.todo />
            </li>
            <li class="hover:bg-gray-100 rounded cursor-pointer p-2 modal-sub-status" data-id="{{ $task->id }}" data-status="1">
                <x-icons.progress />
            </li>
            <li class="hover:bg-gray-100 rounded cursor-pointer p-2 modal-sub-status" data-id="{{ $task->id }}" data-status="2">
                <x-icons.pending />
            </li>
            <li class="hover:bg-gray-100 rounded cursor-pointer p-2 modal-sub-status" data-id="{{ $task->id }}" data-status="3">
                <x-icons.completed />
            </li>
            <li class="hover:bg-gray-100 rounded cursor-pointer p-2 modal-sub-status" data-id="{{ $task->id }}" data-status="4">
                <x-icons.other />
            </li>
            <li class="hover:bg-gray-100 rounded cursor-pointer p-2 modal-sub-status" data-id="{{ $task->id }}" data-status="5">
                <x-icons.cancel />
            </li>
        </ul>
    </div>
</li>
