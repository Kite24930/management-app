@props(['attributes' => []])
<div {!! $attributes->merge(['class' => 'px-2 bg-red-50 inline-flex items-center *:text-red-500']) !!}>
    <i class="bi bi-chevron-up"></i>
    <span class="text-sm">High</span>
</div>
