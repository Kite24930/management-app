@props(['attributes' => []])
<div {!! $attributes->merge(['class' => 'px-2 bg-red-50 inline-flex items-center *:text-red-500']) !!}>
    <i class="bi bi-exclamation-square mr-2"></i>
    <span class="text-sm">Progress</span>
</div>
