@props(['attributes' => []])
<div {!! $attributes->merge(['class' => 'px-2 bg-blue-200 inline-flex items-center *:text-blue-700']) !!}>
    <i class="bi bi-chevron-double-down"></i>
    <span class="text-sm">Lowest</span>
</div>
