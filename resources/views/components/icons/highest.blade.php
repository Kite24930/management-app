@props(['attributes' => []])
<div {!! $attributes->merge(['class' => 'px-2 bg-red-200 inline-flex items-center *:text-red-700']) !!}>
    <i class="bi bi-chevron-double-up"></i>
    <span class="text-sm">Highest</span>
</div>
