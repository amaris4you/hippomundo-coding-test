<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Statistics') }}
        </h2>
    </x-slot>
    <div class="flex flex-col items-center flex-1 w-full py-6 mx-auto">
      <div class="flex-1 overflow-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="flex flex-col flex-1 overflow-auto shadow-lg scrollbar-hide">
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <!-- Number of Cards Completed This Month -->
                <div class="p-4 bg-white rounded shadow">
                    <h2 class="mb-4 text-lg font-semibold">Number of Cards Completed This Week</h2>
                    <p class="text-2xl font-bold">{{ $completedThisWeek }}</p>
                </div>
            
                <!-- Number of Cards Completed This Week -->
                <div class="p-4 bg-white rounded shadow">
                    <h2 class="mb-4 text-lg font-semibold">Number of Cards Completed This Month</h2>
                    <p class="text-2xl font-bold">{{ $completedThisMonth }}</p>
                </div>
            </div>
          
            <!-- User Statistics Card -->
            <div class="p-4 mt-4 bg-white rounded shadow">
              <h2 class="mb-4 text-lg font-semibold">Number of Cards Assigned for Each User</h2>
              <ul>
                @foreach ($assignedTasksPerUser as $user)
                  <li class="flex justify-between">
                    <span>{{ $user->name }}</span>
                    <span>{{ $user->total_assigned }}</span>
                  </li> 
                @endforeach
              </ul>
            </div>
        </div>
      </div>
    </div>
</x-app-layout>
