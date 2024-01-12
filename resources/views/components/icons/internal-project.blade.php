@props(['attributes' => []])
<div {!! $attributes->merge(['class' => 'px-2 inline-flex items-center']) !!}>
    <x-icons.icon src="internal_project.png" alt="internal_project" class="w-8 h-8" />
    <span class="text-sm">社内プロジェクト</span>
</div>
