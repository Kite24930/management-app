@props(['attributes' => []])
<div {!! $attributes->merge(['class' => 'px-2 bg-yellow-300 inline-flex items-center *:text-yellow-700']) !!}>
    <i class="bi bi-p-square mr-2"></i>
    <span class="text-sm">Pending</span>
</div>
