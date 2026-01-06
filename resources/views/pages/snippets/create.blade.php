<x-metrolar-layout title="Add Snippet">
    <x-card title="Add New Snippet">
        <x-slot:toolbar>
            <a href="{{ route('snippets.index') }}" class="btn btn-secondary btn-sm font-weight-bolder">
                Back
            </a>
        </x-slot:toolbar>

        <form action="{{ route('snippets.store') }}" method="POST">
            @csrf

            <x-input label="Title" name="title" placeholder="Snippet name" required />

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="language">Language</label>
                        <select class="form-control form-control-solid select2" name="language" id="language">
                            <option value="text">Text</option>
                            <option value="php">PHP</option>
                            <option value="javascript">JavaScript</option>
                            <option value="html">HTML</option>
                            <option value="css">CSS</option>
                            <option value="bash">Bash</option>
                            <option value="sql">SQL</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <x-input label="Tags" name="tags" placeholder="laravel, helper, utility (comma separated)" />
                </div>
            </div>

            <div class="form-group">
                <label for="code_content">Code Content</label>
                <textarea class="form-control form-control-solid @error('code_content') is-invalid @enderror" name="code_content"
                    id="code_content" rows="10" style="font-family: monospace;"></textarea>
                @error('code_content')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary font-weight-bold">Save Snippet</button>
            </div>
        </form>
    </x-card>

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#language').select2();
            });
        </script>
    @endpush
</x-metrolar-layout>
