<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Tasks') }}
        </h2>
    </x-slot>

    <div class="flex flex-col flex-1 py-6" id="kanban-content">
        <kanban-board></kanban-board>
    </div>
</x-app-layout>
