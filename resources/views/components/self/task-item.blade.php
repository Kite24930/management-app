<li class="bg-white rounded-lg border p-2 flex flex-col gap-2 *:text-sm task-item" data-id="{{ $task->task_id }}">
    <div class="!text-lg font-bold flex items-center justify-between">
        <input type="text" value="{{ $task->title }}" class="border-none rounded task-title flex-1" data-id="{{ $task->task_id }}">
        <button class="w-8 h-8 edit-btn" type="button" data-id="{{ $task->task_id }}">
            <i class="bi bi-three-dots"></i>
        </button>
    </div>
    <div class="flex items-center justify-between">
        <div id="{{ __('type-'.$task->task_id) }}" data-dropdown-toggle="{{ __('type-list-'.$task->task_id) }}" class="cursor-pointer" data-type="{{ $task->type }}">
            @switch($task->type)
                @case(1) <x-icons.internal-project /> @break
                @case(2) <x-icons.orders-receive /> @break
                @case(3) <x-icons.head-office-order /> @break
            @endswitch
        </div>
        <div id="{{ __('type-list-'.$task->task_id) }}" class="hidden">
            <ul class="flex flex-col gap-2 bg-white pt-4 pb-2 px-2 border rounded">
                <li class="hover:bg-gray-100 rounded cursor-pointer pt-2 task-type" data-id="{{ $task->task_id }}" data-type="1">
                    <x-icons.internal-project />
                </li>
                <li class="hover:bg-gray-100 rounded cursor-pointer pt-2 task-type" data-id="{{ $task->task_id }}" data-type="2">
                    <x-icons.orders-receive />
                </li>
                <li class="hover:bg-gray-100 rounded cursor-pointer pt-2 task-type" data-id="{{ $task->task_id }}" data-type="3">
                    <x-icons.head-office-order />
                </li>
            </ul>
        </div>
        <div id="{{ __('priority-'.$task->task_id) }}" data-dropdown-toggle="{{ __('priority-list-'.$task->task_id) }}" class="cursor-pointer" data-priority="{{ $task->priority }}">
            @switch($task->priority)
                @case(1) <x-icons.highest /> @break
                @case(2) <x-icons.high /> @break
                @case(3) <x-icons.middle /> @break
                @case(4) <x-icons.low /> @break
                @case(5) <x-icons.lowest /> @break
            @endswitch
        </div>
        <div id="{{ __('priority-list-'.$task->task_id) }}" class="hidden">
            <ul class="flex flex-col gap-2 bg-white p-2 border rounded">
                <li class="hover:bg-gray-100 rounded cursor-pointer p-2 task-priority" data-id="{{ $task->task_id }}" data-type="1">
                    <x-icons.highest />
                </li>
                <li class="hover:bg-gray-100 rounded cursor-pointer p-2 task-priority" data-id="{{ $task->task_id }}" data-type="2">
                    <x-icons.high />
                </li>
                <li class="hover:bg-gray-100 rounded cursor-pointer p-2 task-priority" data-id="{{ $task->task_id }}" data-type="3">
                    <x-icons.middle />
                </li>
                <li class="hover:bg-gray-100 rounded cursor-pointer p-2 task-priority" data-id="{{ $task->task_id }}" data-type="4">
                    <x-icons.low />
                </li>
                <li class="hover:bg-gray-100 rounded cursor-pointer p-2 task-priority" data-id="{{ $task->task_id }}" data-type="5">
                    <x-icons.lowest />
                </li>
            </ul>
        </div>
    </div>
    <div class="flex items-center pl-2">
        <div id="{{ __('main-person-'.$task->task_id) }}" data-dropdown-toggle="{{ __('person-list-'.$task->task_id) }}" class="cursor-pointer flex items-center" data-type="{{ $task->main_person_id }}">
            @if($task->main_person_id)
                @if($task->main_person_icon)
                    <x-icons.icon src="{{ $task->main_person_id.'/'.$task->main_person_icon }}" alt="{{ $task->main_person_name }}" class="w-8 h-8" />
                @else
                    <x-icons.person-circle class="w-8 h-8 text-lg">{{ $task->main_person_name }}</x-icons.person-circle>
                @endif
                {{ $task->main_person_name }}
            @else
                <i class="bi bi-person-circle text-gray-400 text-3xl mr-2"></i>
            @endif
        </div>
        <div id="{{ __('person-list-'.$task->task_id) }}" class="hidden">
            <ul class="flex flex-col gap-2 bg-white pt-4 p-2 border rounded h-[200px] overflow-y-auto">
                @foreach($users as $user)
                    <li class="hover:bg-gray-100 rounded cursor-pointer p-2 task-person flex items-center" data-id="{{ $task->task_id }}" data-type="{{ $user->id }}">
                        @if($user->icon)
{{--                            <x-icons.icon src="{{ $user->id.'/'.$user->icon }}" alt="{{ $user->name }}" class="w-6 h-6" />--}}
                            <x-icons.icon src="{{ $user->id.'/'.$user->icon }}" alt="{{ $user->name }}" class="" />
                        @else
                            <x-icons.person-circle class="w-6 h-6 text-sm">{{ $user->name }}</x-icons.person-circle>
                        @endif
                        {{ $user->name }}
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="justify-center items-center @if(!$task->start_date && !$task->end_date) hidden @else flex @endif">
        <input type="date" value="{{ $task->start_date }}" class="border-none w-full rounded start_date text-xs" data-id="{{ $task->task_id }}">
        〜
        <input type="date" value="{{ $task->end_date }}" class="border-none w-full rounded end_date text-xs" data-id="{{ $task->task_id }}">
    </div>
</li>
