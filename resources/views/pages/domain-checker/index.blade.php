<x-public-layout title="Domain Checker">
    <div class="row">
        <!-- Input Section -->
        <div class="col-lg-5">
            <x-card title="🔍 Domain Availability & Whois" class="card-stretch gutter-b">
                <form action="{{ route('domain-checker.check') }}" method="POST" id="scanForm">
                    @csrf
                    <div class="form-group">
                        <label class="font-size-h6 font-weight-bolder text-dark">Domain Name <span
                                class="text-danger">*</span></label>
                        <input type="text" name="domain" class="form-control form-control-solid form-control-lg"
                            placeholder="example.com" required value="{{ old('domain') }}">
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg font-weight-bolder btn-block py-4">
                        Search Domain <i class="flaticon2-search-1 ml-2"></i>
                    </button>
                </form>
                <div class="separator separator-border-dashed my-5"></div>
                <div class="text-muted">
                    <p class="mb-2">This tool checks if a domain is registered by querying DNS records (NS/A). It also
                        attempts to fetch WHOIS information.</p>
                    <p class="mb-0"><strong>Note:</strong> Some TLDs may restrict WHOIS access or require CAPTCHA.</p>
                </div>
            </x-card>
        </div>

        <!-- Result Section -->
        <div class="col-lg-7" id="resultContainer">
            @include('pages.domain-checker._result', [
                'res' => session('domain_result'),
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
                var btn = form.querySelector('button[type="submit"]');
                var originalBtnHtml = btn.innerHTML;

                KTApp.block(document.body, {
                    overlayColor: '#000000',
                    state: 'primary',
                    message: 'Checking Domain & WHOIS...',
                    opacity: 0.3
                });

                btn.innerHTML = '<i class="spinner spinner-white spinner-right pr-4"></i> Searching...';
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
                        KTApp.unblock(document.body);
                        btn.innerHTML = originalBtnHtml;
                        btn.disabled = false;

                        if (data.html) {
                            resultContainer.innerHTML = data.html;
                        }
                    })
                    .catch(error => {
                        KTApp.unblock(document.body);
                        btn.innerHTML = originalBtnHtml;
                        btn.disabled = false;
                        console.error('Error:', error);
                        toastr.error('An error occurred during the check.');
                    });
            });
        });
    </script>
@endpush
