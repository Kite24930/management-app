@props(['attributes' => []])
<div {!! $attributes->merge(['class' => 'px-2 inline-flex items-center']) !!}>
    <x-icons.icon src="head_office_order.png" alt="head_office_order" />
    <span class="text-sm">本社案件</span>
</div>
