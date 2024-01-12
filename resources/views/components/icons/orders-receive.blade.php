@props(['attributes' => []])
<div {!! $attributes->merge(['class' => 'px-2 inline-flex items-center']) !!}>
    <x-icons.icon src="orders_receive.png" alt="orders_receive" class="w-8 h-8" />
    <span class="text-sm">受注案件</span>
</div>
