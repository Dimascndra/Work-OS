<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Productivity Hub') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Summary Stats -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-900 text-xl font-bold">Total Hours Today</div>
                    <div class="text-4xl text-indigo-600 mt-2 font-black">{{ $totalHours }} hrs</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-900 text-xl font-bold">Sessions Today</div>
                    <div class="text-4xl text-green-600 mt-2 font-black">{{ $todayEntries->count() }}</div>
                </div>
            </div>

            <!-- Active Timer -->
            @if ($activeTimer)
                <div
                    class="bg-indigo-50 border-l-4 border-indigo-400 p-4 shadow-sm sm:rounded-lg flex justify-between items-center">
                    <div>
                        <div class="text-indigo-700 font-bold text-lg">Current Session Active</div>
                        <div class="text-indigo-600">
                            Started at {{ $activeTimer->start_time->format('H:i') }}
                            @if ($activeTimer->task)
                                • Task: <span class="font-semibold">{{ $activeTimer->task->name }}</span>
                            @else
                                • <span class="italic">{{ $activeTimer->description ?? 'No description' }}</span>
                            @endif
                        </div>
                    </div>
                    <form action="{{ route('productivity.stop', $activeTimer) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded animate-pulse">
                            Stop Timer
                        </button>
                    </form>
                </div>
            @else
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Quick Start</h3>
                    <form action="{{ route('productivity.store') }}" method="POST" class="flex gap-4">
                        @csrf
                        <input type="text" name="description"
                            class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="What are you working on?">
                        <button type="submit"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                            Start Timer
                        </button>
                    </form>
                </div>
            @endif

            <!-- Recent Logs -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">Today's Activity</h3>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Time</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Activity</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Duration</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($todayEntries as $entry)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $entry->start_time->format('H:i') }} -
                                        {{ $entry->end_time ? $entry->end_time->format('H:i') : 'Now' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        @if ($entry->task)
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                Task
                                            </span>
                                            {{ $entry->task->name }}
                                        @else
                                            {{ $entry->description ?: 'Untitled Session' }}
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-gray-700">
                                        {{ $entry->duration_text }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-4 text-center text-gray-500">No activity recorded
                                        today.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
