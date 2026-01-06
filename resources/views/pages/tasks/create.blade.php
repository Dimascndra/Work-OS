<x-metrolar-layout title="Add Task">
    <x-card title="Add New Task">
        <x-slot:toolbar>
            <a href="{{ route('tasks.index') }}" class="btn btn-secondary btn-sm font-weight-bolder">
                Back
            </a>
        </x-slot:toolbar>

        <form action="{{ route('tasks.store') }}" method="POST">
            @csrf

            <div class="row">
                <div class="col-md-8">
                    <x-input label="Title" name="title" placeholder="Task title" required />
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="due_date">Due Date</label>
                        <input type="date"
                            class="form-control form-control-solid @error('due_date') is-invalid @enderror"
                            name="due_date" id="due_date" />
                        @error('due_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control form-control-solid @error('description') is-invalid @enderror" name="description"
                    rows="3"></textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="priority">Priority</label>
                        <select class="form-control form-control-solid select2" name="priority" id="priority">
                            <option value="low">Low</option>
                            <option value="medium" selected>Medium</option>
                            <option value="high">High</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control form-control-solid select2" name="status" id="status">
                            <option value="todo" selected>To Do</option>
                            <option value="in_progress">In Progress</option>
                            <option value="review">Review</option>
                            <option value="done">Done</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary font-weight-bold">Save Task</button>
            </div>
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
</x-metrolar-layout>
