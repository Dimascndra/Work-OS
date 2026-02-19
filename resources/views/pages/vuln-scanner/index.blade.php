<x-public-layout title="Web Vulnerability Scanner">
    <div class="row">
        <!-- Input Section -->
        <div class="col-lg-4">
            <x-card title="🛡️ Vulnerability Scanner" class="card-stretch gutter-b">
                <form action="{{ route('vuln-scanner.scan') }}" method="POST" id="scanForm">
                    @csrf
                    <div class="form-group">
                        <label class="font-size-h6 font-weight-bolder text-dark">Target URL <span
                                class="text-danger">*</span></label>
                        <input type="url" name="url" class="form-control form-control-solid form-control-lg"
                            placeholder="https://example.com" required value="{{ old('url') }}">
                        <span class="form-text text-muted">Enter the full URL (including https://).</span>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg font-weight-bolder btn-block py-4">
                        Scan Website <i class="flaticon-search ml-2"></i>
                    </button>
                </form>
                <div class="separator separator-border-dashed my-5"></div>

                <div class="accordion accordion-light accordion-toggle-arrow" id="scoringAccordion">
                    <div class="card">
                        <div class="card-header" id="headingOne">
                            <div class="card-title collapsed" data-toggle="collapse" data-target="#collapseScoring">
                                <i class="flaticon-interface-10"></i> Scoring Guide
                            </div>
                        </div>
                        <div id="collapseScoring" class="collapse" data-parent="#scoringAccordion">
                            <div class="card-body pl-0 pr-0">
                                <table class="table table-borderless table-sm">
                                    <tr>
                                        <td>Web Server Security</td>
                                        <td class="text-right font-weight-bold">10 pts</td>
                                    </tr>
                                    <tr>
                                        <td>Web Software Security</td>
                                        <td class="text-right font-weight-bold">10 pts</td>
                                    </tr>
                                    <tr>
                                        <td>GDPR Compliance</td>
                                        <td class="text-right font-weight-bold">10 pts</td>
                                    </tr>
                                    <tr>
                                        <td>PCI DSS Compliance</td>
                                        <td class="text-right font-weight-bold">10 pts</td>
                                    </tr>
                                    <tr>
                                        <td>HTTP Headers</td>
                                        <td class="text-right font-weight-bold">10 pts</td>
                                    </tr>
                                    <tr>
                                        <td>Content Security Policy</td>
                                        <td class="text-right font-weight-bold">10 pts</td>
                                    </tr>
                                    <tr>
                                        <td>Cookies Security</td>
                                        <td class="text-right font-weight-bold">10 pts</td>
                                    </tr>
                                    <tr>
                                        <td>External Content (CORS)</td>
                                        <td class="text-right font-weight-bold">10 pts</td>
                                    </tr>
                                    <tr>
                                        <td>Data Scraping Protection</td>
                                        <td class="text-right font-weight-bold">10 pts</td>
                                    </tr>
                                    <tr>
                                        <td>DNSSEC Configuration</td>
                                        <td class="text-right font-weight-bold">10 pts</td>
                                    </tr>
                                    <tr class="border-top">
                                        <td><strong>Total</strong></td>
                                        <td class="text-right font-weight-bold"><strong>100 pts</strong></td>
                                    </tr>
                                </table>
                                <div class="mt-3">
                                    <span
                                        class="label label-inline label-light-success font-weight-bold mr-2">90-100</span>
                                    Sangat Aman
                                    <div class="separator separator-border-dashed my-2"></div>
                                    <span
                                        class="label label-inline label-light-primary font-weight-bold mr-2">75-89</span>
                                    Aman
                                    <div class="separator separator-border-dashed my-2"></div>
                                    <span
                                        class="label label-inline label-light-warning font-weight-bold mr-2">60-74</span>
                                    Perlu Perbaikan
                                    <div class="separator separator-border-dashed my-2"></div>
                                    <span class="label label-inline label-light-danger font-weight-bold mr-2">
                                        < 60 </span> Berisiko
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </x-card>
        </div>

        <!-- Result Section -->
        <div class="col-lg-8" id="resultContainer">
            @include('pages.vuln-scanner._result', [
                'res' => session('vuln_result'),
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
                    message: 'Scanning Target...',
                    opacity: 0.3
                });

                // Disable button
                var btn = form.querySelector('button[type="submit"]');
                var originalBtnHtml = btn.innerHTML;
                btn.innerHTML = '<i class="spinner spinner-white spinner-right pr-4"></i> Scanning...';
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
                            // Re-init Metronic components if needed (scrollers, accordions, etc inside partial)
                            // KTApp.init(); // Often safe to re-run or just specific inits
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
