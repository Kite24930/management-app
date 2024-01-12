<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <a href="{{ route('index') }}" class="p-6 text-gray-900 border-b hover:bg-gray-200 block">
                    {{ __("TOP MENU") }}
                </a>
                <a href="{{ route('profile.edit') }}" class="p-6 text-gray-900 hover:bg-gray-200 block">
                    {{ __("プロフィール編集") }}
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
