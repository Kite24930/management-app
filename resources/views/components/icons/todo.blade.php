@props(['attributes' => []])
<div {!! $attributes->merge(['class' => 'px-2 bg-yellow-50 inline-flex items-center *:text-yellow-500']) !!}>
    <i class="bi bi-dash-square mr-2"></i>
    <span class="text-sm">TODO</span>
</div>
