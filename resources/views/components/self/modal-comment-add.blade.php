<div class="flex flex-col rounded-lg w-full">
    <button id="modal-new-comment" type="button">
        <i class="bi bi-plus-square mr-2"></i>new comment
    </button>
    <div id="modal-comment-wrapper" class="hidden flex-col w-full">
        <div class="w-full flex items-end justify-between">
            <div id="{{ __('modal-comment-icon-0') }}" data-id="0" class="text-sm">
                @if($user->icon)
                    <x-icons.icon src="{{ $user->id.'/'.$user->icon }}" alt="{{ $user->name }}" />
                @else
                    <x-icons.person-circle class="w-6 h-6 text-sm !mr-0">{{ $user->name }}</x-icons.person-circle>
                @endif
                {{ $user->name }}
            </div>
            <div class="text-xs text-gray-400">

            </div>
        </div>
        <textarea id="{{ __('modal-comment-0') }}" class="hidden"></textarea>
        <div id="{{ __('modal-comment-editor-0') }}" class="comment-add-editor w-full my-2 z-40 relative" data-id="0"></div>
        <div class="w-full flex justify-end items-center">
            <button id="{{ __('modal-comment-register-0') }}" class="text-sm hover:underline" type="button" data-id="0">
                <i class="bi bi-plus-square mr-2"></i>add comment
            </button>
        </div>
    </div>
</div>

