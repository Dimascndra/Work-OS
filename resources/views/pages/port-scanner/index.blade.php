<x-public-layout title="Pemindai Port Terbuka">
    <div class="row">
        <!-- Input Section -->
        <div class="col-lg-5 mb-5">
            <x-card title="🔍 Pemindai Port Jaringan" class="gutter-b shadow-sm">
                <form action="{{ route('port-scanner.scan') }}" method="POST" id="scanForm" data-loading-message="Memindai port terbuka..." data-loading-btn="Memindai...">
                    @csrf
                    <div class="form-group">
                        <label class="font-size-h6 font-weight-bolder text-dark">Target IP atau Domain <span
                                class="text-danger">*</span></label>
                        <input type="text" name="target" class="form-control form-control-solid form-control-lg"
                            placeholder="contoh: google.com atau 8.8.8.8" required value="{{ old('target') }}">
                        <span class="form-text text-muted">Masukkan nama domain atau alamat IP eksternal untuk dipindai.</span>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg font-weight-bolder btn-block py-4">
                        Mulai Pemindaian <i class="flaticon2-search-1 ml-2"></i>
                    </button>
                </form>
            </x-card>

            <x-card title="ℹ️ Tentang Alat" class="gutter-b shadow-sm">
                <div class="text-dark-75 font-size-sm">
                    <h6 class="font-weight-bolder mb-2 text-primary">Deskripsi Fungsi:</h6>
                    <p class="text-muted mb-4">Memindai port jaringan standar pada server target untuk mengidentifikasi layanan yang aktif dan mendeteksi potensi port administratif/sensitif yang terekspos secara publik.</p>
                    
                    <h6 class="font-weight-bolder mb-2 text-primary">Cara Penggunaan:</h6>
                    <ol class="text-muted mb-4 pl-4">
                        <li>Masukkan alamat IP atau domain target.</li>
                        <li>Klik tombol <strong>Mulai Pemindaian</strong>.</li>
                        <li>Sistem akan mencoba membuka koneksi socket singkat pada 12 port umum secara real-time.</li>
                    </ol>
                    
                    <h6 class="font-weight-bolder mb-2 text-primary">Penjelasan Hasil:</h6>
                    <p class="text-muted mb-0">Menampilkan tabel daftar port beserta statusnya. Port berstatus <span class="text-success font-weight-bold">Terbuka</span> (Open) siap menerima koneksi, sementara port <span class="text-muted font-weight-bold">Tertutup / Terfilter</span> berarti terlindung atau tidak aktif.</p>
                </div>
            </x-card>
        </div>

        <!-- Result Section -->
        <div class="col-lg-7" id="resultContainer">
            @include('pages.port-scanner._result', [
                'res' => session('port_result'),
                'error' => session('error'),
            ])
        </div>
    </div>
</x-public-layout>
