<x-public-layout title="Subdomain Finder">
    <div class="row">
        <!-- Input Section -->
        <div class="col-lg-4">
            <x-card title="🔍 Subdomain Finder" class="card-stretch gutter-b">
                <form action="{{ route('subdomain-finder.scan') }}" method="POST" id="scanForm">
                    @csrf
                    <div class="form-group">
                        <label class="font-size-h6 font-weight-bolder text-dark">Target Domain <span
                                class="text-danger">*</span></label>
                        <input type="text" name="url" class="form-control form-control-solid form-control-lg"
                            placeholder="example.com" required value="{{ old('url') }}">
                        <span class="form-text text-muted">Enter a domain name (e.g., example.com).</span>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg font-weight-bolder btn-block py-4">
                        Find Subdomains <i class="flaticon2-search-1 ml-2"></i>
                    </button>
                </form>
                <div class="separator separator-border-dashed my-5"></div>
                <div class="d-flex align-items-center">
                    <div class="symbol symbol-40 symbol-light-primary mr-3">
                        <span class="symbol-label font-size-h4 font-weight-bold">
                            <i class="flaticon2-world text-primary"></i>
                        </span>
                    </div>
                    <div>
                        <div class="text-dark-75 font-weight-bold">Passive Reconnaissance</div>
                        <div class="text-muted font-size-sm">Uses crt.sh logs. Safe & Non-intrusive.</div>
                    </div>
                </div>
            </x-card>
        </div>

        <!-- Result Section -->
        <div class="col-lg-8" id="resultContainer">
            @include('pages.subdomain-finder._result', [
                'res' => session('subdomain_result'),
                'error' => session('error'),
            ])
        </div>
    </div>
</x-public-layout>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var form = document.getElementById('scanForm');
            if (!form) return;

            form.addEventListener('submit', function(e) {
                e.preventDefault();

                var url = form.action;
                var formData = new FormData(form);
                var resultContainer = document.getElementById('resultContainer');

                // Block UI
                KTApp.block(resultContainer, {
                    overlayColor: '#000000',
                    state: 'primary',
                    message: 'Discovering Subdomains...',
                    opacity: 0.3
                });

                // Disable button
                var btn = form.querySelector('button[type="submit"]');
                var originalBtnHtml = btn.innerHTML;
                btn.innerHTML = '<i class="spinner spinner-white spinner-right pr-4"></i> Documenting...';
                btn.disabled = true;

                fetch(url, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute(
                                    'content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        KTApp.unblock(resultContainer);
                        btn.innerHTML = originalBtnHtml;
                        btn.disabled = false;

                        if (data.html) {
                            resultContainer.innerHTML = data.html;
                        }

                        // Scroll to result
                        resultContainer.scrollIntoView({
                            behavior: 'smooth'
                        });
                    })
                    .catch(error => {
                        KTApp.unblock(resultContainer);
                        btn.innerHTML = originalBtnHtml;
                        btn.disabled = false;
                        console.error('Error:', error);
                        toastr.error('An error occurred during the scan. Please try again.');
                    });
            });
        });
    </script>
@endpush
