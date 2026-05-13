<x-public-layout title="SSL Expiry Checker">
    <div class="row">
        <!-- Input Section -->
        <div class="col-lg-5 mb-5">
            <x-card class="card-stretch gutter-b">
                <div class="d-flex align-items-center mb-5">
                    <div class="symbol symbol-50 symbol-light-success mr-4">
                        <span class="symbol-label">
                            <i class="flaticon2-lock icon-lg text-success"></i>
                        </span>
                    </div>
                    <div>
                        <h3 class="font-weight-bolder text-dark mb-0">SSL Expiry Checker</h3>
                        <span class="text-muted font-weight-bold">Check certificate validity</span>
                    </div>
                </div>

                <form action="{{ route('ssl-checker.check') }}" method="POST" id="scanForm">
                    @csrf
                    <div class="form-group">
                        <label class="font-size-h6 font-weight-bolder text-dark">Domain URL <span
                                class="text-danger">*</span></label>
                        <input type="text" name="domain" class="form-control form-control-solid form-control-lg"
                            placeholder="example.com" required value="{{ old('domain') }}">
                        <span class="form-text text-muted">Enter the domain name (e.g. google.com).</span>
                    </div>

                    <button type="submit" class="btn btn-success btn-lg font-weight-bolder btn-block py-4">
                        Check Expiry <i class="flaticon2-search-1 ml-2"></i>
                    </button>
                </form>
                <div class="text-muted mt-5">
                    <i class="flaticon2-information text-primary mr-1"></i> We verify certificate expiration date and issuer
                    from port 443.
                </div>
            </x-card>
        </div>

        <!-- Result Section -->
        <div class="col-lg-7" id="resultContainer">
            @include('pages.ssl-checker._result', [
                'res' => session('ssl_result'),
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
                    message: 'Verifying SSL...',
                    opacity: 0.3
                });

                // Disable button
                var btn = form.querySelector('button[type="submit"]');
                var originalBtnHtml = btn.innerHTML;
                btn.innerHTML = '<i class="spinner spinner-white spinner-right pr-4"></i> Checking...';
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
                        toastr.error('An error occurred during the check. Please try again.');
                    });
            });
        });
    </script>
@endpush
