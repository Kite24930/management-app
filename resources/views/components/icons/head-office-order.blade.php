@props(['attributes' => []])
<div {!! $attributes->merge(['class' => 'px-2 inline-flex items-center']) !!}>
    <x-icons.icon src="head_office_order.png" alt="head_office_order" class="w-8 h-8" />
    <span class="text-sm">本社案件</span>
</div>
