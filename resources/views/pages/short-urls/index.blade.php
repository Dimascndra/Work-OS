<x-metrolar-layout title="URL Shortener">
    <x-card title="🔗 URL Shortener" class="card-stretch gutter-b">
        <x-slot:toolbar>
            <button type="button" class="btn btn-primary font-weight-bolder" data-toggle="modal"
                data-target="#createShortUrlModal">
                <i class="ki ki-plus icon-sm"></i> New Short URL
            </button>
        </x-slot:toolbar>

        <div class="table-responsive">
            <table class="table table-head-custom table-vertical-center table-head-bg table-borderless">
                <thead>
                    <tr class="text-left">
                        <th style="min-width: 250px" class="pl-7">Original URL</th>
                        <th style="min-width: 150px">Short Link</th>
                        <th style="min-width: 100px">Clicks</th>
                        <th style="min-width: 150px">Created At</th>
                        <th style="min-width: 100px">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($urls as $url)
                        <tr>
                            <td class="pl-7">
                                <span
                                    class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ $url->title ?: 'No Title' }}</span>
                                <a href="{{ $url->original_url }}" target="_blank"
                                    class="text-muted font-weight-bold text-hover-primary"
                                    style="max-width: 300px; display: inline-block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $url->original_url }}</a>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <a href="{{ route('short.redirect', $url->short_code) }}" target="_blank"
                                        class="text-primary font-weight-bold mr-2" id="short-link-{{ $url->id }}">
                                        {{ route('short.redirect', $url->short_code) }}
                                    </a>
                                    <button class="btn btn-icon btn-xs btn-light-primary btn-copy"
                                        data-clipboard-target="#short-link-{{ $url->id }}" title="Copy Link">
                                        <i class="flaticon2-copy"></i>
                                    </button>
                                </div>
                            </td>
                            <td>
                                <span
                                    class="label label-lg label-light-success label-inline font-weight-bold py-4">{{ number_format($url->clicks) }}</span>
                            </td>
                            <td>
                                <span
                                    class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ $url->created_at->diffForHumans() }}</span>
                                <span
                                    class="text-muted font-weight-bold">{{ $url->created_at->format('d M Y H:i') }}</span>
                            </td>
                            <td>
                                <form action="{{ route('short-urls.destroy', $url) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this URL?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-icon btn-light btn-hover-danger btn-sm"
                                        title="Delete">
                                        <i class="flaticon2-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted p-10">
                                <i class="flaticon2-search-1 icon-4x text-muted mb-3"></i>
                                <p class="font-size-lg font-weight-bold mb-0">No short URLs found</p>
                                <p class="text-muted font-size-sm">Create one to get started!</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $urls->links() }}
        </div>
    </x-card>

    <!-- Create Modal -->
    <div class="modal fade" id="createShortUrlModal" tabindex="-1" role="dialog"
        aria-labelledby="createShortUrlModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('short-urls.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="createShortUrlModalLabel">Create New Short URL</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Original URL <span class="text-danger">*</span></label>
                            <input type="url" name="original_url" class="form-control"
                                placeholder="https://example.com/very-long-url..." required>
                        </div>
                        <div class="form-group">
                            <label>Title (Optional)</label>
                            <input type="text" name="title" class="form-control" placeholder="My Awesome Link">
                        </div>
                        <div class="form-group">
                            <label>Custom Code (Optional)</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">{{ url('/s') }}/</span>
                                </div>
                                <input type="text" name="custom_code" class="form-control" placeholder="custom-alias"
                                    maxlength="20">
                            </div>
                            <small class="form-text text-muted">Leave blank for auto-generated code.</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-primary font-weight-bold"
                            data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary font-weight-bold">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- DIRECT SCRIPT INJECTION (Bypassing Stack) -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Short URL Copy Script Initialized');

            document.querySelectorAll('.btn-copy').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault(); // Prevent default button behavior

                    const targetSelector = this.getAttribute('data-clipboard-target');
                    const target = document.querySelector(targetSelector);

                    if (target) {
                        const textToCopy = target.getAttribute('href') || target.innerText.trim();

                        // Try Modern Async API
                        if (navigator.clipboard && navigator.clipboard.writeText) {
                            navigator.clipboard.writeText(textToCopy).then(() => {
                                toastr.success('Link copied to clipboard!');
                            }).catch(err => {
                                console.error('Clipboard API failed', err);
                                fallbackCopyText(textToCopy);
                            });
                        } else {
                            // Fallback for older browsers or non-secure contexts
                            fallbackCopyText(textToCopy);
                        }
                    } else {
                        console.error('Target element not found:', targetSelector);
                    }
                });
            });

            function fallbackCopyText(text) {
                const textArea = document.createElement("textarea");
                textArea.value = text;

                // Ensure it's not visible but part of DOM
                textArea.style.top = "0";
                textArea.style.left = "0";
                textArea.style.position = "fixed";
                textArea.style.opacity = "0";

                document.body.appendChild(textArea);
                textArea.focus();
                textArea.select();

                try {
                    const successful = document.execCommand('copy');
                    if (successful) {
                        toastr.success('Link copied (fallback)!');
                    } else {
                        toastr.error('Failed to copy link.');
                    }
                } catch (err) {
                    console.error('Fallback copy failed', err);
                    toastr.error('Could not copy text.');
                }

                document.body.removeChild(textArea);
            }
        });
    </script>
</x-metrolar-layout>
