@props(['attributes' => []])
<div {!! $attributes->merge(['class' => 'px-2 bg-green-50 inline-flex items-center *:text-green-500']) !!}>
    <i class="bi bi-chevron-compact-up"></i>
    <span class="text-sm">Middle</span>
</div>
