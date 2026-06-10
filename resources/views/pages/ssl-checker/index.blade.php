<x-public-layout title="SSL Expiry Checker">
    <div class="row">
        <!-- Input Section -->
        <div class="col-lg-5 mb-5">
            <x-card class="gutter-b shadow-sm">
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

                <form action="{{ route('ssl-checker.check') }}" method="POST" id="scanForm" data-loading-message="Memverifikasi SSL..." data-loading-btn="Memeriksa...">
                    @csrf
                    <div class="form-group">
                        <label class="font-size-h6 font-weight-bolder text-dark">Domain / URL <span
                                class="text-danger">*</span></label>
                        <input type="text" name="domain" class="form-control form-control-solid form-control-lg"
                            placeholder="contoh: google.com" required value="{{ old('domain') }}">
                        <span class="form-text text-muted">Masukkan nama domain saja (tanpa https:// atau http://).</span>
                    </div>

                    <button type="submit" class="btn btn-success btn-lg font-weight-bolder btn-block py-4">
                        Periksa SSL <i class="flaticon2-search-1 ml-2"></i>
                    </button>
                </form>
            </x-card>

            <x-card title="ℹ️ Tentang Alat" class="gutter-b shadow-sm">
                <div class="text-dark-75 font-size-sm">
                    <h6 class="font-weight-bolder mb-2 text-primary">Deskripsi Fungsi:</h6>
                    <p class="text-muted mb-4">Memeriksa status masa berlaku sertifikat SSL/TLS, memverifikasi rantai sertifikat, tipe enkripsi, serta otoritas penerbit sertifikat (Certificate Authority).</p>
                    
                    <h6 class="font-weight-bolder mb-2 text-primary">Cara Penggunaan:</h6>
                    <ol class="text-muted mb-4 pl-4">
                        <li>Masukkan nama domain (contoh: example.com) pada kolom input.</li>
                        <li>Klik tombol <strong>Periksa SSL</strong>.</li>
                        <li>Sistem akan melakukan koneksi aman ke port 443 secara real-time.</li>
                    </ol>
                    
                    <h6 class="font-weight-bolder mb-2 text-primary">Penjelasan Hasil:</h6>
                    <p class="text-muted mb-0">Menampilkan sisa masa aktif (dalam hari), tanggal mulai/akhir sertifikat, nama penerbit, dan tipe algoritma kunci untuk mendeteksi potensi kedaluwarsa.</p>
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

