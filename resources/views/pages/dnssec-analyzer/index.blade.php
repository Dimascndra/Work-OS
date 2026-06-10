<x-public-layout title="DNSSEC Analyzer">
    <div class="row justify-content-center">
        <!-- Input Section -->
        <div class="col-lg-8 mb-5">
            <x-card class="gutter-b shadow-sm text-center">
                <div class="d-flex flex-column align-items-center mb-5">
                    <div class="symbol symbol-60 symbol-light-primary mb-4">
                        <span class="symbol-label">
                            <i class="flaticon2-shield icon-2x text-primary"></i>
                        </span>
                    </div>
                    <h2 class="font-weight-bolder text-dark mb-2">DNSSEC Analyzer</h2>
                    <p class="text-muted font-size-lg">Analyze the DNSSEC Chain of Trust for any domain</p>
                </div>

                <form action="{{ route('dnssec-analyzer.analyze') }}" method="POST" class="mb-5" id="scanForm" data-loading-message="Menganalisis rantai DNSSEC..." data-loading-btn="Menganalisis...">
                    @csrf
                    <div class="form-group mb-0">
                        <div class="d-flex flex-column flex-sm-row align-items-stretch">
                            <input type="text" name="domain" class="form-control form-control-solid form-control-lg pl-5 mr-0 mr-sm-3 mb-3 mb-sm-0" placeholder="Masukkan domain (contoh: example.com)"
                                required value="{{ old('domain') }}">
                            <button type="submit" class="btn btn-primary btn-lg font-weight-bolder px-10">
                                Analisis
                            </button>
                        </div>
                        <span class="form-text text-muted mt-3 text-left">Masukkan nama domain untuk memvisualisasikan rantai tanda tangan keamanan DNSSEC.</span>
                    </div>
                </form>
            </x-card>

            <x-card title="ℹ️ Tentang Alat" class="gutter-b shadow-sm text-left">
                <div class="text-dark-75 font-size-sm">
                    <h6 class="font-weight-bolder mb-2 text-primary">Deskripsi Fungsi:</h6>
                    <p class="text-muted mb-4">Menganalisis Rantai Kepercayaan (Chain of Trust) protokol keamanan DNSSEC pada domain Anda, memverifikasi tanda tangan digital (RRSIG) dan kunci publik (DNSKEY) secara hierarkis mulai dari Root server, TLD server, hingga name server otoritatif domain Anda.</p>
                    
                    <h6 class="font-weight-bolder mb-2 text-primary">Cara Penggunaan:</h6>
                    <ol class="text-muted mb-4 pl-4">
                        <li>Masukkan nama domain utama (contoh: example.com) pada kolom input.</li>
                        <li>Klik tombol <strong>Analisis</strong>.</li>
                        <li>Sistem akan melakukan query DNS dan memetakan struktur rantai kepercayaan delegasi DNSSEC.</li>
                    </ol>
                    
                    <h6 class="font-weight-bolder mb-2 text-primary">Penjelasan Hasil:</h6>
                    <p class="text-muted mb-0">Menampilkan pohon struktur visual enkripsi DNSSEC. Status keamanan yang valid untuk rekaman DS (Delegation Signer), DNSKEY, dan RRSIG di setiap tingkat zona (Root, TLD, dan Domain anak) menunjukkan bahwa domain terproteksi dari serangan pemalsuan DNS (DNS spoofing/cache poisoning).</p>
                </div>
            </x-card>
        </div>

        <!-- Result Section -->
        <div class="col-lg-10" id="resultContainer">
            @include('pages.dnssec-analyzer._result', ['res' => session('dnssec_result')])
        </div>
    </div>
</x-public-layout>

