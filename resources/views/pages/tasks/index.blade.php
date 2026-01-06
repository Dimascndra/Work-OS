<x-metrolar-layout title="Tasks">
    <x-card title="Kanban Tasks">
        <x-slot:toolbar>
            <a href="{{ route('tasks.create') }}" class="btn btn-primary btn-sm font-weight-bolder">
                <i class="ki ki-plus icon-sm"></i> Add Task
            </a>
        </x-slot:toolbar>

        <div class="table-responsive">
            <table class="table table-head-custom table-vertical-center">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Status</th>
                        <th>Priority</th>
                        <th>Due Date</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tasks as $task)
                        <tr>
                            <td>
                                <span
                                    class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ $task->title }}</span>
                                <span class="text-muted font-size-sm">{{ Str::limit($task->description, 50) }}</span>
                            </td>
                            <td>
                                @php
                                    $statusClasses = [
                                        'todo' => 'secondary',
                                        'in_progress' => 'primary',
                                        'review' => 'warning',
                                        'done' => 'success',
                                    ];
                                    $statusLabel = ucfirst(str_replace('_', ' ', $task->status));
                                @endphp
                                <span
                                    class="label label-lg label-light-{{ $statusClasses[$task->status] }} label-inline">{{ $statusLabel }}</span>
                            </td>
                            <td>
                                @php
                                    $priorityClasses = [
                                        'low' => 'info',
                                        'medium' => 'warning',
                                        'high' => 'danger',
                                    ];
                                @endphp
                                <span class="label label-dot label-{{ $priorityClasses[$task->priority] }} mr-2"></span>
                                <span
                                    class="font-weight-bold text-{{ $priorityClasses[$task->priority] }}">{{ ucfirst($task->priority) }}</span>
                            </td>
                            <td>
                                @if ($task->due_date)
                                    {{ $task->due_date->format('Y-m-d') }}
                                    @if ($task->due_date->isPast() && $task->status != 'done')
                                        <span class="text-danger font-weight-bold ml-1">!</span>
                                    @endif
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="text-right">
                                <a href="{{ route('tasks.edit', $task) }}"
                                    class="btn btn-icon btn-light btn-hover-primary btn-sm">
                                    <i class="flaticon2-edit"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">No tasks found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-card>
</x-metrolar-layout>
