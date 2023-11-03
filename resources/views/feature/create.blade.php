<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Feature Setting') }}
        </h2>
    </x-slot>
    <div class="px-8 py-12 mx-8 my-16 bg-white rounded-md shadow-md md:mx-24 lg:mx-56">
        <form action="{{ route('update-phases') }}" method="POST">
            @csrf
            <div class="mx-auto space-y-6 max-w-7xl sm:px-6 lg:px-8">
                <h5 class="text-xl">Please select any phase for completion.</h5>
                <div class="flex flex-col gap-4 py-5">
                    @foreach ($phases as $phase)
                        <div class="flex items-center space-x-2">
                            <input type="checkbox" name="phases[]" value="{{ $phase->id }}" {{ $phase->status == 1 ? 'checked' : '' }}>
                            <h1>{{ $phase->name }}</h1>
                        </div>
                    @endforeach
                </div>
                <button type="submit" class="inline-flex justify-center px-3 py-2 text-sm font-semibold text-white bg-blue-600 rounded-md shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">Update</button>
            </div>
        </form>
    </div>
</x-app-layout>
