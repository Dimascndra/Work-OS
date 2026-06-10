<x-public-layout title="Domain Checker">
    <div class="row">
        <!-- Input Section -->
        <div class="col-lg-5">
            <x-card title="🔍 Domain Availability & Whois" class="gutter-b shadow-sm">
                <form action="{{ route('domain-checker.check') }}" method="POST" id="scanForm" data-loading-message="Memeriksa Domain & WHOIS..." data-loading-btn="Memeriksa...">
                    @csrf
                    <div class="form-group">
                        <label class="font-size-h6 font-weight-bolder text-dark">Nama Domain <span
                                class="text-danger">*</span></label>
                        <input type="text" name="domain" class="form-control form-control-solid form-control-lg"
                            placeholder="contoh: google.com" required value="{{ old('domain') }}">
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg font-weight-bolder btn-block py-4">
                        Cari Domain <i class="flaticon2-search-1 ml-2"></i>
                    </button>
                </form>
            </x-card>

            <x-card title="ℹ️ Tentang Alat" class="gutter-b shadow-sm">
                <div class="text-dark-75 font-size-sm">
                    <h6 class="font-weight-bolder mb-2 text-primary">Deskripsi Fungsi:</h6>
                    <p class="text-muted mb-4">Melakukan pencarian WHOIS dan status ketersediaan domain untuk melihat status registrasi, tanggal pembuatan, kedaluwarsa, server nama (name server), serta data kontak pendaftar (registran) domain.</p>
                    
                    <h6 class="font-weight-bolder mb-2 text-primary">Cara Penggunaan:</h6>
                    <ol class="text-muted mb-4 pl-4">
                        <li>Masukkan nama domain lengkap beserta ekstensinya (contoh: example.com).</li>
                        <li>Klik tombol <strong>Cari Domain</strong>.</li>
                        <li>Sistem akan mengueri database WHOIS global untuk mengambil detail registrasi.</li>
                    </ol>
                    
                    <h6 class="font-weight-bolder mb-2 text-primary">Penjelasan Hasil:</h6>
                    <p class="text-muted mb-0">Menampilkan status ketersediaan (apakah domain dapat didaftarkan atau sudah terisi), ringkasan waktu registrasi (aktif/habis masa berlaku), name server aktif, serta teks mentah data WHOIS resmi dari server TLD.</p>
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

