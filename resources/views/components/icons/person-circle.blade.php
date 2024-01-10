@props(['attributes' => []])
<div class="inline-block">
    <div {!! $attributes->merge(['class' => 'rounded-full flex items-center justify-center bg-latte font-semibold text-white border mr-2']) !!}>
        {{ mb_substr($slot, 0, 1) }}
    </div>
</div>
