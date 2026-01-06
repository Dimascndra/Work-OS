<x-metrolar-layout title="Edit Snippet">
    <x-card title="Edit Snippet: {{ $snippet->title }}">
        <x-slot:toolbar>
            <a href="{{ route('snippets.index') }}" class="btn btn-secondary btn-sm font-weight-bolder">
                Back
            </a>
        </x-slot:toolbar>

        <form action="{{ route('snippets.update', $snippet) }}" method="POST">
            @csrf
            @method('PUT')

            <x-input label="Title" name="title" :value="$snippet->title" placeholder="Snippet name" required />

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="language">Language</label>
                        <select class="form-control form-control-solid select2" name="language" id="language">
                            <option value="text" {{ $snippet->language == 'text' ? 'selected' : '' }}>Text</option>
                            <option value="php" {{ $snippet->language == 'php' ? 'selected' : '' }}>PHP</option>
                            <option value="javascript" {{ $snippet->language == 'javascript' ? 'selected' : '' }}>
                                JavaScript</option>
                            <option value="html" {{ $snippet->language == 'html' ? 'selected' : '' }}>HTML</option>
                            <option value="css" {{ $snippet->language == 'css' ? 'selected' : '' }}>CSS</option>
                            <option value="bash" {{ $snippet->language == 'bash' ? 'selected' : '' }}>Bash</option>
                            <option value="sql" {{ $snippet->language == 'sql' ? 'selected' : '' }}>SQL</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <x-input label="Tags" name="tags" :value="implode(', ', $snippet->tags ?? [])"
                        placeholder="laravel, helper, utility (comma separated)" />
                </div>
            </div>

            <div class="form-group">
                <label for="code_content">Code Content</label>
                <textarea class="form-control form-control-solid @error('code_content') is-invalid @enderror" name="code_content"
                    id="code_content" rows="10" style="font-family: monospace;">{{ $snippet->code_content }}</textarea>
                @error('code_content')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-between">
                <button type="button" class="btn btn-danger font-weight-bold"
                    onclick="document.getElementById('delete-form').submit();">Delete Snippet</button>
                <button type="submit" class="btn btn-primary font-weight-bold ml-auto">Update Snippet</button>
            </div>
        </form>

        <form id="delete-form" action="{{ route('snippets.destroy', $snippet) }}" method="POST" class="d-none">
            @csrf
            @method('DELETE')
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
