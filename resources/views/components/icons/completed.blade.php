@props(['attributes' => []])
<div {!! $attributes->merge(['class' => 'px-2 bg-green-50 inline-flex items-center *:text-green-500']) !!}>
    <i class="bi bi-check2-square mr-2"></i>
    <span class="text-sm">Completed</span>
</div>
