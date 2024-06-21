@props(['num', 'tasks', 'target' => null])

<div id="{{ __('taskWrapper_'.$num) }}" class="border rounded-lg p-4 flex flex-col gap-2">
    <div class="flex items-center justify-between">
        <div class="flex gap-2 items-center">
            <label for="{{ __('task_'.$num) }}" class="text-xs text-slate">Task -</label>
            <select name="{{ __('task_'.$num) }}" id="{{ __('task_'.$num) }}" class="p-2 border border-slate rounded-lg task text-xs" required>
                <option value="" class="hidden">Select Task</option>
                @foreach ($tasks as $task)
                    <option value="{{ $task['id'] }}" @if($target !== null && $target->task_id === $task['id']) selected @endif>{{ $task['title'] }}</option>
                @endforeach
            </select>
        </div>
        @if($num !== 0 || $target !== null)
            <button id="{{ __('removeBtn_'.$num) }}" type="button" class="h-8 w-8 rounded-full shadow bg-red-100 bg-opacity-70 hover:bg-red-200 duration-500 text-sm removeBtn flex items-center justify-center remove-btn" data-target="{{ __('taskWrapper_'.$num) }}"><i class="bi bi-trash"></i></button>
        @endif
    </div>
    <div class="flex items-center gap-6">
        <div class="flex gap-2 items-center">
            <label for="{{ __('hours_'.$num) }}" class="text-xs text-slate">Hours -</label>
            @if($target)
                <input name="{{ __('hours_'.$num) }}" id="{{ __('hours_'.$num) }}" type="number" class="p-2 border border-slate rounded-lg hours" min="0" max="24" step="0.25" value="{{ $target->hours }}">
            @else
                <input name="{{ __('hours_'.$num) }}" id="{{ __('hours_'.$num) }}" type="number" class="p-2 border border-slate rounded-lg hours" min="0" max="24" step="0.25" value="0">
            @endif

        </div>
        <div class="flex gap-2 items-center">
            <label for="{{ __('progress_'.$num) }}" class="text-xs text-slate">Progress -</label>
            @if($target)
                <input name="{{ __('progress_'.$num) }}" id="{{ __('progress_'.$num) }}" type="number" class="p-2 border border-slate rounded-lg progress" min="0" max="100" step="1" value="{{ $target->progress }}">
            @else
                <input name="{{ __('progress_'.$num) }}" id="{{ __('progress_'.$num) }}" type="number" class="p-2 border border-slate rounded-lg progress" min="0" max="100" step="1" value="0">
            @endif
        </div>
    </div>
    <div>
        <label for="{{ __('detail_'.$num) }}" class="text-xs text-slate">Detail</label>
        <div id="{{ __('detail_'.$num) }}" class="border rounded-lg">

        </div>
    </div>
    <div>
        <label for="{{ __('problem_'.$num) }}" class="text-xs text-slate">Problem</label>
        <div id="{{ __('problem_'.$num) }}" class="border rounded-lg">

        </div>
    </div>
</div>
