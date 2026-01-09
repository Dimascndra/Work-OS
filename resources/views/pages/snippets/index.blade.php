@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/github-markdown-css/5.5.0/github-markdown.min.css">
    <style>
        /* GitHub README Markdown Content Styles */
        .markdown-body {
            box-sizing: border-box;
            min-width: 200px;
            max-width: 980px;
            margin: 0 auto;
            padding: 24px;

            /* Force Light Mode / High Contrast Colors */
            --color-canvas-default: #ffffff;
            --color-fg-default: #24292f;
            --color-canvas-subtle: #f6f8fa;
            --color-border-default: #d0d7de;
            --color-border-muted: #d8dee4;

            color: #24292f !important;
            background-color: #ffffff !important;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji";
            font-size: 14px;
            line-height: 1.5;
            word-wrap: break-word;
            border-radius: 6px;
        }

        /* Ensure table visibility */
        .markdown-body code {
            /* High Contrast Red for Inline Code */
            color: #d12020 !important;
            background-color: #f3f3f3 !important;
            padding: 0.2em 0.4em;
            border-radius: 6px;
            font-family: monospace;
            font-weight: 600;
        }

        .markdown-body pre {
            background-color: #f6f8fa;
            padding: 16px;
            border-radius: 6px;
            overflow: auto;
        }

        .markdown-body pre code {
            /* Restyle block code to normal */
            color: inherit !important;
            background-color: transparent !important;
            padding: 0;
            font-weight: normal;
        }

        .markdown-body table {
            display: block;
            width: 100%;
            overflow: auto;
        }

        .markdown-body table th {
            font-weight: 600;
        }

        .markdown-body table th,
        .markdown-body table td {
            padding: 6px 13px;
            border: 1px solid #d0d7de;
        }

        .markdown-body table tr {
            background-color: #ffffff;
            border-top: 1px solid #d0d7de;
        }

        .markdown-body table tr:nth-child(2n) {
            background-color: #f6f8fa;
        }

        /* Cursor for clickable header */
        .cursor-pointer {
            cursor: pointer;
        }

        /* Rotate chevron when expanded */
        .card-header[aria-expanded="true"] .rotate-icon {
            transform: rotate(180deg);
        }

        .rotate-icon {
            transition: transform 0.3s ease;
        }
    </style>
@endpush

<x-metrolar-layout title="Snippets">
    <x-card title="📚 Code Snippets">
        <x-slot:toolbar>
            <a href="{{ route('snippets.create') }}" class="btn btn-primary btn-sm font-weight-bolder">
                <i class="ki ki-plus icon-sm"></i> New Snippet
            </a>
        </x-slot:toolbar>

        @forelse($snippets as $snippet)
            <div class="card card-custom gutter-b border">
                <!-- Header (Clickable Collapse Trigger) -->
                <div class="card-header cursor-pointer" data-toggle="collapse"
                    data-target="#collapse-{{ $snippet->id }}" aria-expanded="false">
                    <div class="card-title">
                        <span class="card-icon">
                            <i class="flaticon-code text-primary"></i>
                        </span>
                        <h3 class="card-label">
                            {{ $snippet->title }}
                            <span
                                class="label label-inline label-light-primary ml-2">{{ $snippet->language ?? 'Text' }}</span>
                        </h3>
                    </div>
                    <div class="card-toolbar">
                        <!-- Edit Button (Prevent collapse propagation) -->
                        <a href="{{ route('snippets.edit', $snippet) }}"
                            class="btn btn-icon btn-light btn-hover-primary btn-sm mr-2" title="Edit snippet"
                            onclick="event.stopPropagation();">
                            <i class="flaticon2-edit"></i>
                        </a>
                        <!-- Collapse Indicator -->
                        <span class="btn btn-icon btn-light btn-hover-primary btn-sm">
                            <i class="flaticon2-down rotate-icon"></i>
                        </span>
                    </div>
                </div>

                <!-- Collapsible Body (Default: Hidden) -->
                <div id="collapse-{{ $snippet->id }}" class="collapse">
                    <div class="card-body">
                        @php
                            $language = strtolower($snippet->language ?? 'text');
                            $isMarkdown = in_array($language, ['markdown', 'md', 'text']);
                        @endphp

                        @if ($isMarkdown)
                            <!-- Server-Side Markdown Rendering -->
                            <div class="markdown-body">
                                {!! \Illuminate\Support\Str::markdown($snippet->code_content) !!}
                            </div>
                        @else
                            <div class="markdown-body">
                                <pre><code class="language-{{ $language }}">{{ $snippet->code_content }}</code></pre>
                            </div>
                        @endif

                        @if ($snippet->tags && count($snippet->tags) > 0)
                            <div class="mt-3">
                                @foreach ($snippet->tags as $tag)
                                    <span class="label label-inline label-light-info mr-1">{{ $tag }}</span>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="alert alert-custom alert-light-primary">
                <div class="alert-icon">
                    <i class="flaticon-code icon-lg"></i>
                </div>
                <div class="alert-text">
                    <h4 class="alert-heading">No snippets yet</h4>
                    <p>Create your first code snippet to get started</p>
                    <a href="{{ route('snippets.create') }}" class="btn btn-primary btn-sm font-weight-bolder mt-3">
                        <i class="ki ki-plus icon-sm"></i> Create First Snippet
                    </a>
                </div>
            </div>
        @endforelse
    </x-card>
</x-metrolar-layout>

@push('scripts')
    <!-- Load Prism.js for Syntax Highlighting (for non-markdown snippets) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/prism.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-markup.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-javascript.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-python.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-php.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-bash.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof Prism !== 'undefined') {
                Prism.highlightAll();
            }
        });
    </script>
@endpush
