<li class="bg-white rounded-lg border p-2 flex flex-col gap-2 *:text-sm add-task" data-id="{{ $target }}" data-status="{{ $status }}">
    <div class="!text-lg font-bold">
        <input type="text" value="" class="border-none w-full rounded task-title" data-id="{{ $target }}">
    </div>
    <div class="flex items-center justify-between">
        <div id="{{ __('type-'.$target) }}" data-dropdown-toggle="{{ __('type-list-'.$target) }}" class="cursor-pointer" data-type="1">
            <x-icons.internal-project />
        </div>
        <div id="{{ __('type-list-'.$target) }}" class="hidden">
            <ul class="flex flex-col gap-2 bg-white pt-4 pb-2 px-2 border rounded">
                <li class="hover:bg-gray-100 rounded cursor-pointer pt-2 task-type" data-id="{{ $target }}" data-type="1">
                    <x-icons.internal-project />
                </li>
                <li class="hover:bg-gray-100 rounded cursor-pointer pt-2 task-type" data-id="{{ $target }}" data-type="2">
                    <x-icons.orders-receive />
                </li>
                <li class="hover:bg-gray-100 rounded cursor-pointer pt-2 task-type" data-id="{{ $target }}" data-type="3">
                    <x-icons.head-office-order />
                </li>
            </ul>
        </div>
        <div id="{{ __('priority-'.$target) }}" data-dropdown-toggle="{{ __('priority-list-'.$target) }}" class="cursor-pointer" data-priority="3" data-id="{{ $target }}">
            <x-icons.middle />
        </div>
        <div id="{{ __('priority-list-'.$target) }}" class="hidden">
            <ul class="flex flex-col gap-2 bg-white p-2 border rounded">
                <li class="hover:bg-gray-100 rounded cursor-pointer p-2 task-priority" data-id="{{ $target }}" data-type="1">
                    <x-icons.highest />
                </li>
                <li class="hover:bg-gray-100 rounded cursor-pointer p-2 task-priority" data-id="{{ $target }}" data-type="2">
                    <x-icons.high />
                </li>
                <li class="hover:bg-gray-100 rounded cursor-pointer p-2 task-priority" data-id="{{ $target }}" data-type="3">
                    <x-icons.middle />
                </li>
                <li class="hover:bg-gray-100 rounded cursor-pointer p-2 task-priority" data-id="{{ $target }}" data-type="4">
                    <x-icons.low />
                </li>
                <li class="hover:bg-gray-100 rounded cursor-pointer p-2 task-priority" data-id="{{ $target }}" data-type="5">
                    <x-icons.lowest />
                </li>
            </ul>
        </div>
    </div>
    <div class="flex items-center pl-2">
        <div id="{{ __('main-person-'.$target) }}" data-dropdown-toggle="{{ __('person-list-'.$target) }}" class="cursor-pointer flex items-center" data-person="0" data-id="{{ $target }}">
            <i class="bi bi-person-circle text-gray-400 text-3xl mr-2"></i>
            主担当者を選択
        </div>
        <div id="{{ __('person-list-'.$target) }}" class="hidden">
            <ul class="flex flex-col gap-2 bg-white p-2 border rounded h-[200px] overflow-y-auto">
                @foreach($users as $user)
                    <li class="hover:bg-gray-100 rounded cursor-pointer p-2 task-person flex items-center" data-id="{{ $target }}" data-type="{{ $user->id }}">
                        @if($user->icon)
                            <x-icons.icon src="{{ $task->main_person_id.'/'.$task->main_person_icon }}" alt="{{ $task->main_person_name }}" />
                        @else
                            <i class="bi bi-person-circle text-gray-400 mr-2"></i>
                        @endif
                        {{ $user->name }}
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="flex justify-center items-center">
        <input type="date" value="" class="border-none w-full rounded start_date" data-id="{{ $target }}">
        〜
        <input type="date" value="" class="border-none w-full rounded end_date" data-id="{{ $target }}">
    </div>
    <div class="flex justify-center w-full">
        <button id="{{ __('register-'.$target) }}" class="bg-green-300 text-white flex py-2 px-4 rounded border border-green-700 hover:bg-green-500 register" type="button" data-id="{{ $target }}">
            register
        </button>
    </div>
</li>
