<x-public-layout title="Subdomain Finder">
    <div class="row">
        <!-- Input Section -->
        <div class="col-lg-4">
            <x-card title="🔍 Subdomain Finder" class="gutter-b shadow-sm">
                <form action="{{ route('subdomain-finder.scan') }}" method="POST" id="scanForm" data-loading-message="Mencari subdomain..." data-loading-btn="Mencari...">
                    @csrf
                    <div class="form-group">
                        <label class="font-size-h6 font-weight-bolder text-dark">Target Domain <span
                                class="text-danger">*</span></label>
                        <input type="text" name="url" class="form-control form-control-solid form-control-lg"
                            placeholder="example.com" required value="{{ old('url') }}">
                        <span class="form-text text-muted">Enter a domain name (e.g., example.com).</span>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg font-weight-bolder btn-block py-4">
                        Find Subdomains <i class="flaticon2-search-1 ml-2"></i>
                    </button>
                </form>
            </x-card>

            <x-card title="ℹ️ Tentang Alat" class="gutter-b shadow-sm">
                <div class="text-dark-75 font-size-sm">
                    <h6 class="font-weight-bolder mb-2 text-primary">Deskripsi Fungsi:</h6>
                    <p class="text-muted mb-4">Melacak subdomain aktif dari domain utama secara pasif dengan memanfaatkan log Certificate Transparency publik (crt.sh). Metode ini aman dan tanpa melakukan kontak langsung dengan server target.</p>
                    
                    <h6 class="font-weight-bolder mb-2 text-primary">Cara Penggunaan:</h6>
                    <ol class="text-muted mb-4 pl-4">
                        <li>Masukkan domain utama (contoh: example.com).</li>
                        <li>Klik tombol <strong>Find Subdomains</strong> untuk memulai pencarian.</li>
                        <li>Sistem akan mengumpulkan dan menganalisis rekaman DNS dari log publik.</li>
                    </ol>
                    
                    <h6 class="font-weight-bolder mb-2 text-primary">Penjelasan Hasil:</h6>
                    <p class="text-muted mb-0">Menampilkan jumlah subdomain aktif, alamat IP server, catatan DNS (AAAA/CNAME), penyedia hosting, dan lokasi geografis server untuk setiap subdomain yang terdeteksi.</p>
                </div>
            </x-card>
        </div>

        <!-- Result Section -->
        <div class="col-lg-8" id="resultContainer">
            @include('pages.subdomain-finder._result', [
                'res' => session('subdomain_result'),
                'error' => session('error'),
            ])
        </div>
    </div>
</x-public-layout>
