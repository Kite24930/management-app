<li class="flex w-full items-center gap-2 px-2">
    <div id="{{ __('modal-sub-priority-0') }}" data-dropdown-toggle="{{ __('modal-sub-priority-list-0') }}" class="cursor-pointer w-20" data-id="0" data-priority="3">
        <x-icons.middle />
    </div>
    <div id="{{ __('modal-sub-priority-list-0') }}" class="hidden">
        <ul class="flex flex-col gap-2 bg-white p-2 border rounded">
            <li class="hover:bg-gray-100 rounded cursor-pointer p-2 modal-sub-add-priority" data-id="0" data-priority="1">
                <x-icons.highest />
            </li>
            <li class="hover:bg-gray-100 rounded cursor-pointer p-2 modal-sub-add-priority" data-id="0" data-priority="2">
                <x-icons.high />
            </li>
            <li class="hover:bg-gray-100 rounded cursor-pointer p-2 modal-sub-add-priority" data-id="0" data-priority="3">
                <x-icons.middle />
            </li>
            <li class="hover:bg-gray-100 rounded cursor-pointer p-2 modal-sub-add-priority" data-id="0" data-priority="4">
                <x-icons.low />
            </li>
            <li class="hover:bg-gray-100 rounded cursor-pointer p-2 modal-sub-add-priority" data-id="0" data-priority="5">
                <x-icons.lowest />
            </li>
        </ul>
    </div>
    <div class="flex-1">
        <input type="text" id="{{ __('modal-sub-title-0') }}" class="border-none rounded-lg w-full text-sm py-1 my-2" value="">
    </div>
    <div id="{{ __('modal-sub-main-0') }}" data-dropdown-toggle="{{ __('modal-sub-main-list-0') }}" class="cursor-pointer" data-person="0">
        <i class="bi bi-person-circle text-gray-400 text-2xl mr-2"></i>
    </div>
    <div id="{{ __('modal-sub-main-list-0') }}" class="hidden">
        <ul class="flex flex-col gap-2 bg-white pt-4 p-2 border rounded h-[200px] overflow-y-auto">
            @foreach($users as $user)
                <li class="hover:bg-gray-100 rounded cursor-pointer p-2 modal-sub-add-person flex items-center" data-id="0" data-person="{{ $user->id }}">
                    @if($user->icon)
                        <x-icons.icon src="{{ $user->id.'/'.$user->icon }}" alt="{{ $user->name }}" class="w-6 h-6" />
                    @else
                        <x-icons.person-circle class="w-6 h-6 text-sm">{{ $user->name }}</x-icons.person-circle>
                    @endif
                    {{ $user->name }}
                </li>
            @endforeach
        </ul>
    </div>
    <div id="{{ __('modal-sub-status-0') }}" class="modal-sub-status cursor-pointer w-28" data-dropdown-toggle="{{ __('modal-sub-status-list-0') }}" data-id="0" data-status="0">
        <x-icons.todo />
    </div>
    <div id="{{ __('modal-sub-status-list-0') }}" class="hidden">
        <ul class="flex flex-col gap-2 bg-white pt-4 pb-2 px-2 border rounded">
            <li class="hover:bg-gray-100 rounded cursor-pointer p-2 modal-sub-add-status" data-id="0" data-status="0">
                <x-icons.todo />
            </li>
            <li class="hover:bg-gray-100 rounded cursor-pointer p-2 modal-sub-add-status" data-id="0" data-status="1">
                <x-icons.progress />
            </li>
            <li class="hover:bg-gray-100 rounded cursor-pointer p-2 modal-sub-add-status" data-id="0" data-status="2">
                <x-icons.pending />
            </li>
            <li class="hover:bg-gray-100 rounded cursor-pointer p-2 modal-sub-add-status" data-id="0" data-status="3">
                <x-icons.completed />
            </li>
            <li class="hover:bg-gray-100 rounded cursor-pointer p-2 modal-sub-add-status" data-id="0" data-status="4">
                <x-icons.other />
            </li>
            <li class="hover:bg-gray-100 rounded cursor-pointer p-2 modal-sub-add-status" data-id="0" data-status="5">
                <x-icons.cancel />
            </li>
        </ul>
    </div>
    <div id="{{ __('modal-title-edit-0') }}" class="w-auto h-8 modal-title-edit cursor-pointer flex justify-center items-center" data-id="0">
        <i class="bi bi-plus-square text-gray-400 mr-1"></i>add
    </div>
</li>
