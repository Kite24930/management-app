@props(['attributes' => []])
<div {!! $attributes->merge(['class' => 'px-2 bg-blue-50 inline-flex items-center *:text-blue-500']) !!}>
    <i class="bi bi-chevron-down"></i>
    <span class="text-sm">Low</span>
</div>
