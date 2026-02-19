<x-public-layout title="DNSSEC Analyzer">
    <div class="row justify-content-center">
        <!-- Input Section -->
        <div class="col-lg-8 mb-5">
            <x-card class="card-stretch gutter-b text-center">
                <div class="d-flex flex-column align-items-center mb-5">
                    <div class="symbol symbol-60 symbol-light-primary mb-4">
                        <span class="symbol-label">
                            <i class="flaticon2-shield icon-2x text-primary"></i>
                        </span>
                    </div>
                    <h2 class="font-weight-bolder text-dark mb-2">DNSSEC Analyzer</h2>
                    <p class="text-muted font-size-lg">Analyze the DNSSEC Chain of Trust for any domain</p>
                </div>

                <form action="{{ route('dnssec-analyzer.analyze') }}" method="POST" class="mb-5" id="scanForm">
                    @csrf
                    <div class="form-group">
                        <div class="input-group input-group-lg input-group-solid">
                            <input type="text" name="domain" class="form-control pl-5" placeholder="example.com"
                                required value="{{ old('domain') }}">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-primary font-weight-bold px-10">
                                    Analyze
                                </button>
                            </div>
                        </div>
                        <span class="form-text text-muted mt-2 text-left ml-2">Enter a domain name to visualize its
                            DNSSEC signature chain.</span>
                    </div>
                </form>
            </x-card>
        </div>

        <!-- Result Section -->
        <div class="col-lg-10" id="resultContainer">
            @include('pages.dnssec-analyzer._result', ['res' => session('dnssec_result')])
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

                // Block UI
                KTApp.block(document.body, {
                    overlayColor: '#000000',
                    state: 'primary',
                    message: 'Tracing Chain of Trust...',
                    opacity: 0.3
                });

                btn.innerHTML = '<i class="spinner spinner-white spinner-right pr-4"></i> Analyzing...';
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
                            resultContainer.scrollIntoView({
                                behavior: 'smooth',
                                block: 'start'
                            });
                        }

                        if (data.error) {
                            toastr.error(data.error);
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
        });
    </script>
@endpush
