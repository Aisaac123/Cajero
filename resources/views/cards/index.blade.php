<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Cards') }}
        </h2>
    </x-slot>
    <div class="py-12 mx-4 sm:x-0">

        <livewire:card-list />
    </div>
</x-app-layout>
