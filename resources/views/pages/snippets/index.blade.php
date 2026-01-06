<x-metrolar-layout title="Snippets">
    <x-card title="Code Snippets">
        <x-slot:toolbar>
            <a href="{{ route('snippets.create') }}" class="btn btn-primary btn-sm font-weight-bolder">
                <i class="ki ki-plus icon-sm"></i> Add Snippet
            </a>
        </x-slot:toolbar>

        <div class="row">
            @forelse($snippets as $snippet)
                <div class="col-md-6 mb-4">
                    <div class="card card-custom border">
                        <div class="card-header min-h-50px px-4 py-2">
                            <div class="card-title">
                                <span class="card-icon"><i class="flaticon-code text-primary"></i></span>
                                <h3 class="card-label font-size-h6">{{ $snippet->title }}
                                    <span class="d-block text-muted pt-1 font-size-sm">{{ $snippet->language }}</span>
                                </h3>
                            </div>
                            <div class="card-toolbar">
                                <a href="{{ route('snippets.edit', $snippet) }}"
                                    class="btn btn-icon btn-sm btn-hover-light-primary">
                                    <i class="flaticon2-edit"></i>
                                </a>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <pre class="bg-light p-3 rounded " style="max-height: 200px; overflow-y: auto;"><code>{{ Str::limit($snippet->code_content, 150) }}</code></pre>
                            @if ($snippet->tags)
                                <div class="mt-2">
                                    @foreach ($snippet->tags as $tag)
                                        <span
                                            class="label label-inline label-light-info mr-1">{{ $tag }}</span>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center text-muted">No snippets found</div>
            @endforelse
        </div>
    </x-card>
</x-metrolar-layout>
