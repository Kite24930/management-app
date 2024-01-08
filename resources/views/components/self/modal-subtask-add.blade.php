<li class="flex w-full items-center gap-6 px-2">
    <div id="{{ __('modal-sub-priority-0') }}" data-dropdown-toggle="{{ __('modal-sub-priority-list-0') }}" class="cursor-pointer" data-id="0" data-priority="3">
        <x-icons.middle />
    </div>
    <div id="{{ __('modal-sub-priority-list-0') }}" class="hidden">
        <ul class="flex flex-col gap-2 bg-white p-2 border rounded">
            <li class="hover:bg-gray-100 rounded cursor-pointer p-2 modal-sub-priority" data-id="0" data-type="1">
                <x-icons.highest />
            </li>
            <li class="hover:bg-gray-100 rounded cursor-pointer p-2 modal-sub-priority" data-id="0" data-type="2">
                <x-icons.high />
            </li>
            <li class="hover:bg-gray-100 rounded cursor-pointer p-2 modal-sub-priority" data-id="0" data-type="3">
                <x-icons.middle />
            </li>
            <li class="hover:bg-gray-100 rounded cursor-pointer p-2 modal-sub-priority" data-id="0" data-type="4">
                <x-icons.low />
            </li>
            <li class="hover:bg-gray-100 rounded cursor-pointer p-2 modal-sub-priority" data-id="0" data-type="5">
                <x-icons.lowest />
            </li>
        </ul>
    </div>
    <div class="flex-1">
        <input type="text" id="{{ __('modal-sub-title-0') }}" class="border-none rounded-lg w-full" value="">
    </div>
    <div id="{{ __('modal-title-edit-0') }}" class="w-8 h-8 modal-title-edit cursor-pointer flex justify-center items-center" data-id="0">
        <i class="bi bi-pencil-square text-gray-400"></i>
    </div>
    <div id="{{ __('modal-sub-main-0') }}" data-dropdown-toggle="{{ __('modal-sub-main-list-0') }}" class="cursor-pointer" data-id="0">
        <i class="bi bi-person-circle text-2xl mr-2"></i>
    </div>
    <div id="{{ __('modal-sub-main-list-0') }}" class="hidden">
        <ul class="flex flex-col gap-2 bg-white pt-4 p-2 border rounded h-[200px] overflow-y-auto">
            @foreach($users as $user)
                <li class="hover:bg-gray-100 rounded cursor-pointer p-2 modal-sub-person flex items-center" data-id="0" data-type="{{ $user->id }}">
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
    <div id="{{ __('modal-sub-status-0') }}" class="modal-sub-status cursor-pointer" data-dropdown-toggle="{{ __('modal-sub-status-list-0') }}" data-id="0" data-status="0">
        <x-icons.todo />
    </div>
    <div id="{{ __('modal-sub-status-list-0') }}" class="hidden">
        <ul class="flex flex-col gap-2 bg-white pt-4 pb-2 px-2 border rounded">
            <li class="hover:bg-gray-100 rounded cursor-pointer p-2 modal-status" data-id="0" data-type="0">
                <x-icons.todo />
            </li>
            <li class="hover:bg-gray-100 rounded cursor-pointer p-2 modal-status" data-id="0" data-type="1">
                <x-icons.progress />
            </li>
            <li class="hover:bg-gray-100 rounded cursor-pointer p-2 modal-status" data-id="0" data-type="2">
                <x-icons.pending />
            </li>
            <li class="hover:bg-gray-100 rounded cursor-pointer p-2 modal-status" data-id="0" data-type="3">
                <x-icons.completed />
            </li>
            <li class="hover:bg-gray-100 rounded cursor-pointer p-2 modal-status" data-id="0" data-type="4">
                <x-icons.other />
            </li>
            <li class="hover:bg-gray-100 rounded cursor-pointer p-2 modal-status" data-id="0" data-type="5">
                <x-icons.cancel />
            </li>
        </ul>
    </div>
</li>
