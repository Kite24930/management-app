<div id="{{ __('modal-comment-'.$comment->id) }}" class="flex flex-col border p-2 rounded-lg w-full">
    <div class="w-full flex items-end justify-between">
        <div id="{{ __('modal-comment-icon-'.$comment->id) }}" data-id="{{ $comment->id }}">
            @if($comment->icon)
                <x-icons.icon src="{{ $comment->user_id.'/'.$comment->icon }}" alt="{{ $comment->name }}" />
            @else
                <x-icons.person-circle class="w-6 h-6 text-sm">{{ $comment->name }}</x-icons.person-circle>
            @endif
            {{ $comment->name }}
        </div>
        <div class="flex gap-2">
            <div class="flex-1 text-xs text-gray-400 flex items-center">
                {{ $comment->created_at }}
                @if((string)$comment->created_at !== (string)$comment->updated_at)
                    (updated:{{ $comment->updated_at }})
                @endif
            </div>
            <div class="gap-2 @if($comment->user_id === $user->id) flex @else hidden @endif">
                <button id="{{ __('modal-comment-edit-'.$comment->id) }}" class="w-8 h-8 modal-comment-edit text-xs hover:bg-gray-600 group rounded-lg" data-id="{{ $comment->id }}" type="button">
                    <i class="bi bi-pencil-square text-gray-400 group-hover:text-white"></i>
                </button>
                <button id="{{ __('modal-comment-delete-'.$comment->id) }}" class="w-8 h-8 modal-comment-delete text-xs hover:bg-red-600 rounded-lg group" data-id="{{ $comment->id }}" type="button">
                    <i class="bi bi-trash text-red-400 group-hover:text-white"></i>
                </button>
            </div>
        </div>
    </div>
    <hr class="mt-2 w-full">
    <textarea id="{{ __('modal-comment-md-'.$comment->id) }}" class="hidden">{{ $comment->comment }}</textarea>
    <div id="{{ __('modal-comment-editor-'.$comment->id) }}" class="hidden modal-comment-editor" data-id="{{ $comment->id }}"></div>
    <div id="{{ __('modal-comment-register-wrapper-'.$comment->id) }}" class="w-full justify-end gap-10 items-center hidden mt-2">
        <button id="{{ __('modal-comment-register-'.$comment->id) }}" class="text-sm hover:underline" type="button" data-id="{{ $comment->id }}">
            <i class="bi bi-pencil-square mr-2"></i>update comment
        </button>
        <button id="{{ __('modal-comment-cancel-'.$comment->id) }}" class="text-sm hover:underline" type="button" data-id="{{ $comment->id }}">
            <i class="bi bi-x-square mr-2"></i>cancel
        </button>
    </div>
    <div id="{{ __('modal-comment-viewer-'.$comment->id) }}" class="modal-comment-viewer" data-id="{{ $comment->id }}"></div>
</div>
