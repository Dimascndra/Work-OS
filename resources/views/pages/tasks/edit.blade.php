<x-metrolar-layout title="Edit Task">
    <x-card title="Edit Task: {{ $task->title }}">
        <x-slot:toolbar>
            <a href="{{ route('tasks.index') }}" class="btn btn-secondary btn-sm font-weight-bolder">
                Back
            </a>
        </x-slot:toolbar>

        <form action="{{ route('tasks.update', $task) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-8">
                    <x-input label="Title" name="title" :value="$task->title" placeholder="Task title" required />
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="due_date">Due Date</label>
                        <input type="date"
                            class="form-control form-control-solid @error('due_date') is-invalid @enderror"
                            name="due_date" id="due_date"
                            value="{{ $task->due_date ? $task->due_date->format('Y-m-d') : '' }}" />
                        @error('due_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control form-control-solid @error('description') is-invalid @enderror" name="description"
                    rows="3">{{ $task->description }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="priority">Priority</label>
                        <select class="form-control form-control-solid select2" name="priority" id="priority">
                            <option value="low" {{ $task->priority == 'low' ? 'selected' : '' }}>Low</option>
                            <option value="medium" {{ $task->priority == 'medium' ? 'selected' : '' }}>Medium</option>
                            <option value="high" {{ $task->priority == 'high' ? 'selected' : '' }}>High</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control form-control-solid select2" name="status" id="status">
                            <option value="todo" {{ $task->status == 'todo' ? 'selected' : '' }}>To Do</option>
                            <option value="in_progress" {{ $task->status == 'in_progress' ? 'selected' : '' }}>In
                                Progress</option>
                            <option value="review" {{ $task->status == 'review' ? 'selected' : '' }}>Review</option>
                            <option value="done" {{ $task->status == 'done' ? 'selected' : '' }}>Done</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-between">
                <button type="button" class="btn btn-danger font-weight-bold"
                    onclick="document.getElementById('delete-form').submit();">Delete Task</button>
                <button type="submit" class="btn btn-primary font-weight-bold ml-auto">Update Task</button>
            </div>
        </form>

        <form id="delete-form" action="{{ route('tasks.destroy', $task) }}" method="POST" class="d-none">
            @csrf
            @method('DELETE')
        </form>
    </x-card>

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#priority, #status').select2({
                    minimumResultsForSearch: Infinity
                });
            });
        </script>
    @endpush

    <x-card title="Time Logs" class="mt-6">
        <div class="table-responsive">
            <table class="table table-head-custom table-vertical-center">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>User</th>
                        <th>Duration</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($task->timeEntries as $entry)
                        <tr>
                            <td>{{ $entry->start_time->format('Y-m-d H:i') }}</td>
                            <td>{{ $entry->user->name ?? 'Unknown' }}</td>
                            <td>{{ $entry->duration_text }}</td>
                            <td>{{ $entry->description ?: '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">No time logs recorded for this task.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-card>
</x-metrolar-layout>
