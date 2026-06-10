<x-public-layout title="Web Vulnerability Scanner">
    <div class="row">
        <!-- Input Section -->
        <div class="col-lg-4">
            <x-card title="🛡️ Vulnerability Scanner" class="gutter-b shadow-sm">
                <form action="{{ route('vuln-scanner.scan') }}" method="POST" id="scanForm" data-loading-message="Memindai target..." data-loading-btn="Memindai...">
                    @csrf
                    <div class="form-group">
                        <label class="font-size-h6 font-weight-bolder text-dark">Target URL <span
                                class="text-danger">*</span></label>
                        <input type="url" name="url" class="form-control form-control-solid form-control-lg"
                            placeholder="https://example.com" required value="{{ old('url') }}">
                        <span class="form-text text-muted">Enter the full URL (including https://).</span>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg font-weight-bolder btn-block py-4">
                        Scan Website <i class="flaticon2-search-1 ml-2"></i>
                    </button>
                </form>
                <div class="separator separator-border-dashed my-5"></div>

                <div class="accordion accordion-light accordion-toggle-arrow" id="scoringAccordion">
                    <div class="card">
                        <div class="card-header" id="headingOne">
                            <div class="card-title collapsed" data-toggle="collapse" data-target="#collapseScoring">
                                <i class="flaticon2-list-3"></i> Scoring Guide
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

            <x-card title="ℹ️ Tentang Alat" class="gutter-b shadow-sm">
                <div class="text-dark-75 font-size-sm">
                    <h6 class="font-weight-bolder mb-2 text-primary">Deskripsi Fungsi:</h6>
                    <p class="text-muted mb-4">Memindai situs target untuk mengidentifikasi celah keamanan, konfigurasi SSL/TLS, keamanan web server, kepatuhan GDPR & PCI DSS, serta menganalisis header keamanan HTTP.</p>
                    
                    <h6 class="font-weight-bolder mb-2 text-primary">Cara Penggunaan:</h6>
                    <ol class="text-muted mb-4 pl-4">
                        <li>Masukkan URL lengkap target (termasuk https:// atau http://).</li>
                        <li>Klik tombol <strong>Scan Website</strong> untuk memulai pemindaian.</li>
                        <li>Tunggu hingga analisis selesai untuk melihat laporannya secara instan.</li>
                    </ol>
                    
                    <h6 class="font-weight-bolder mb-2 text-primary">Penjelasan Hasil:</h6>
                    <p class="text-muted mb-0">Menampilkan skor total (0-100), klasifikasi kerentanan (Tinggi, Sedang, Rendah) beserta panduan langkah mitigasi taktis untuk mengamankan situs.</p>
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
