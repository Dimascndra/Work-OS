<x-public-layout title="Web Analyzer">
    <div class="row">
        <!-- Main Section -->
        <div class="col-lg-8 mb-5">
            <x-card class="card-stretch gutter-b">
                <div class="d-flex align-items-center mb-5">
                    <div class="symbol symbol-40 symbol-light-primary mr-3">
                        <span class="symbol-label">
                            <i class="flaticon2-browser-2 text-primary"></i>
                        </span>
                    </div>
                    <div>
                        <div class="text-dark-75 font-weight-bold font-size-h6">Web Analyzer</div>
                        <div class="text-muted font-size-sm">Menganalisis Performa, SEO, dan Header Keamanan</div>
                    </div>
                </div>

                <form action="{{ route('web-analyzer.analyze') }}" method="POST" id="scanForm" data-loading-message="Menganalisis situs web..." data-loading-btn="Menganalisis...">
                    @csrf
                    <div class="form-group mb-0">
                        <div class="d-flex flex-column flex-sm-row align-items-stretch">
                            <input type="url" name="url" class="form-control form-control-solid form-control-lg pl-5 mr-0 mr-sm-3 mb-3 mb-sm-0" placeholder="https://example.com"
                                required value="{{ old('url') }}">
                            <button type="submit" class="btn btn-primary btn-lg font-weight-bolder px-10">
                                Analisis <i class="flaticon2-search-1 ml-2"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </x-card>
        </div>

        <!-- Info Section -->
        <div class="col-lg-4 mb-5">
            <x-card title="ℹ️ Tentang Alat" class="card-stretch gutter-b shadow-sm">
                <div class="text-dark-75 font-size-sm">
                    <h6 class="font-weight-bolder mb-2 text-primary">Deskripsi Fungsi:</h6>
                    <p class="text-muted mb-3">Menganalisis kecepatan muat halaman situs web (load time), ukuran halaman total, struktur meta tag SEO, dan kehadiran header perlindungan keamanan (seperti CSP, HSTS, X-Content-Type).</p>
                    
                    <h6 class="font-weight-bolder mb-2 text-primary">Cara Penggunaan:</h6>
                    <ol class="text-muted mb-3 pl-4">
                        <li>Masukkan URL situs web lengkap (contoh: https://example.com).</li>
                        <li>Klik tombol <strong>Analisis</strong>.</li>
                        <li>Sistem akan memuat halaman tersebut dan menganalisis strukturnya.</li>
                    </ol>
                    
                    <h6 class="font-weight-bolder mb-2 text-primary">Penjelasan Hasil:</h6>
                    <p class="text-muted mb-0">Menampilkan metrik kecepatan pemuatan halaman, analisis SEO dasar, dan daftar header keamanan yang terpasang untuk melindungi situs Anda.</p>
                </div>
            </x-card>
        </div>
    </div>

    <!-- Result Section (Full Width) -->
    <div class="row" id="resultContainer">
        @include('pages.web-analyzer._result', [
            'res' => session('web_analyzer_result'),
            'error' => session('error'),
        ])
    </div>
</x-public-layout>

