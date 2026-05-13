<x-public-layout title="Web Analyzer">
    <!-- Search Card -->
    <x-card class="card-stretch gutter-b">
        <div class="d-flex align-items-center mb-5">
            <div class="symbol symbol-40 symbol-light-primary mr-3">
                <span class="symbol-label">
                    <i class="flaticon2-browser-2 text-primary"></i>
                </span>
            </div>
            <div>
                <div class="text-dark-75 font-weight-bold font-size-h6">Web Analyzer</div>
                <div class="text-muted font-size-sm">Analyze Performance, SEO, and Security Headers</div>
            </div>
        </div>

        <form action="{{ route('web-analyzer.analyze') }}" method="POST" id="scanForm">
            @csrf
            <div class="form-group mb-0">
                <div class="input-group input-group-lg input-group-solid">
                    <input type="url" name="url" class="form-control pl-5" placeholder="https://example.com"
                        required value="{{ old('url') }}">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary font-weight-bold px-10">
                            Analyze <i class="flaticon2-search-1 ml-2"></i>
                        </button>
                    </div>
                </div>
            </div>
        </form>

        <div class="separator separator-border-dashed my-5"></div>

        <div class="text-muted mb-5">
            <p class="mb-2"><i class="flaticon2-correct text-success mr-1"></i> Checks Load Time, Page Size,
                and SEO Metadata.</p>
            <p class="mb-0"><i class="flaticon2-shield text-warning mr-1"></i> Verifies Security Headers (CSP,
                HSTS, X-Frame).</p>
        </div>

        <div id="resultContainer">
            @include('pages.web-analyzer._result', [
                'res' => session('web_analyzer_result'),
                'error' => session('error'),
            ])
        </div>
    </x-card>

    @push('scripts')
        <script>
            document.getElementById('scanForm').addEventListener('submit', function(e) {
                e.preventDefault();

                var form = this;
                var url = form.action;
                var formData = new FormData(form);
                var resultContainer = document.getElementById('resultContainer');
                var btn = form.querySelector('button[type="submit"]');
                var originalBtnHtml = btn.innerHTML;

                KTApp.block(document.body, {
                    overlayColor: '#000000',
                    state: 'primary',
                    message: 'Analyzing Website...',
                    opacity: 0.3
                });

                btn.innerHTML = '<i class="spinner spinner-white spinner-right pr-4"></i> Analyzing...';
                btn.disabled = true;

                fetch(url, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        KTApp.unblock(document.body);
                        btn.innerHTML = originalBtnHtml;
                        btn.disabled = false;

                        if (data.html) {
                            resultContainer.innerHTML = data.html;
                            resultContainer.scrollIntoView({
                                behavior: 'smooth',
                                block: 'start'
                            });
                        }
                    })
                    .catch(error => {
                        KTApp.unblock(document.body);
                        btn.innerHTML = originalBtnHtml;
                        btn.disabled = false;
                        console.error('Error:', error);
                        toastr.error('An error occurred during analysis.');
                    });
            });
        </script>
    @endpush
</x-public-layout>
