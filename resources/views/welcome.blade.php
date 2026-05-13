<x-public-layout>
    <div class="row">
        <div class="col-12 mb-8">
            <div class="card card-custom bg-transparent shadow-none border-0">
                <div class="card-body p-0">
                    <h1 class="font-weight-bolder text-dark font-size-h1 mb-2">Selamat Datang di Alat Keamanan Work-OS</h1>
                    <p class="text-dark-50 font-size-lg text-muted">Kumpulan alat keamanan untuk developer dan
                        administrator sistem.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tools Grid -->
    <div class="row">
        <!-- Web Analyzer -->
        <div class="col-12">
            <div class="card card-custom card-stretch wave wave-animate-slow">
                <div class="card-body pt-8">
                    <div class="d-flex align-items-center mb-5">
                        <span class="symbol symbol-60 symbol-light-primary mr-5">
                            <span class="symbol-label">
                                <i class="flaticon2-browser-2 text-primary font-size-h1"></i>
                            </span>
                        </span>
                        <div class="d-flex flex-column">
                            <a href="{{ route('web-analyzer.index') }}"
                                class="text-dark font-weight-bold text-hover-primary font-size-h4 mb-1">
                                Penganalisis Web
                            </a>
                            <span class="text-muted font-weight-bold">Teknologi Web</span>
                        </div>
                    </div>
                    <p class="text-dark-75 font-weight-nomal mb-5">
                        Identifikasi teknologi, framework, dan server yang digunakan oleh website.
                    </p>
                </div>
            </div>
        </div>

        <!-- Vuln Scanner -->
        <div class="col-xl-4 col-md-6 mb-6">
            <div class="card card-custom card-stretch wave wave-animate-slow">
                <div class="card-body pt-8">
                    <div class="d-flex align-items-center mb-5">
                        <span class="symbol symbol-60 symbol-light-danger mr-5">
                            <span class="symbol-label">
                                <i class="flaticon2-protection text-danger font-size-h1"></i>
                            </span>
                        </span>
                        <div class="d-flex flex-column">
                            <a href="{{ route('vuln-scanner.index') }}"
                                class="text-dark font-weight-bold text-hover-primary font-size-h4 mb-1">
                                Pemindai Kerentanan
                            </a>
                            <span class="text-muted font-weight-bold">Pemindaian Kerentanan Web</span>
                        </div>
                    </div>
                    <p class="text-dark-75 font-weight-nomal mb-5">
                        Deteksi kerentanan keamanan umum pada aplikasi web Anda.
                    </p>
                </div>
            </div>
        </div>

        <!-- Subdomain Finder -->
        <div class="col-xl-4 col-md-6 mb-6">
            <div class="card card-custom card-stretch wave wave-animate-slow">
                <div class="card-body pt-8">
                    <div class="d-flex align-items-center mb-5">
                        <span class="symbol symbol-60 symbol-light-primary mr-5">
                            <span class="symbol-label">
                                <i class="flaticon2-search-1 text-primary font-size-h1"></i>
                            </span>
                        </span>
                        <div class="d-flex flex-column">
                            <a href="{{ route('subdomain-finder.index') }}"
                                class="text-dark font-weight-bold text-hover-primary font-size-h4 mb-1">
                                Pencari Subdomain
                            </a>
                            <span class="text-muted font-weight-bold">Alat Rekonesans</span>
                        </div>
                    </div>
                    <p class="text-dark-75 font-weight-nomal mb-5">
                        Temukan subdomain untuk domain target secara instan.
                    </p>
                </div>
            </div>
        </div>

        <!-- DNS Checker -->
        <div class="col-xl-4 col-md-6 mb-6">
            <div class="card card-custom card-stretch wave wave-animate-slow">
                <div class="card-body pt-8">
                    <div class="d-flex align-items-center mb-5">
                        <span class="symbol symbol-60 symbol-light-info mr-5">
                            <span class="symbol-label">
                                <i class="flaticon2-world text-info font-size-h1"></i>
                            </span>
                        </span>
                        <div class="d-flex flex-column">
                            <a href="{{ route('dns-checker.index') }}"
                                class="text-dark font-weight-bold text-hover-primary font-size-h4 mb-1">
                                Pemeriksa DNS
                            </a>
                            <span class="text-muted font-weight-bold">Propagasi Global</span>
                        </div>
                    </div>
                    <p class="text-dark-75 font-weight-nomal mb-5">
                        Periksa propagasi DNS di berbagai nameserver global.
                    </p>
                </div>
            </div>
        </div>

        <!-- SSL Checker -->
        <div class="col-xl-4 col-md-6 mb-6">
            <div class="card card-custom card-stretch wave wave-animate-slow">
                <div class="card-body pt-8">
                    <div class="d-flex align-items-center mb-5">
                        <span class="symbol symbol-60 symbol-light-success mr-5">
                            <span class="symbol-label">
                                <i class="flaticon2-lock text-success font-size-h1"></i>
                            </span>
                        </span>
                        <div class="d-flex flex-column">
                            <a href="{{ route('ssl-checker.index') }}"
                                class="text-dark font-weight-bold text-hover-primary font-size-h4 mb-1">
                                Pemeriksa SSL
                            </a>
                            <span class="text-muted font-weight-bold">Status Sertifikat</span>
                        </div>
                    </div>
                    <p class="text-dark-75 font-weight-nomal mb-5">
                        Verifikasi validitas, masa berlaku, dan masalah rantai sertifikat SSL.
                    </p>
                </div>
            </div>
        </div>

        <!-- DNSSEC Analyzer -->
        <div class="col-xl-4 col-md-6 mb-6">
            <div class="card card-custom card-stretch wave wave-animate-slow">
                <div class="card-body pt-8">
                    <div class="d-flex align-items-center mb-5">
                        <span class="symbol symbol-60 symbol-light-warning mr-5">
                            <span class="symbol-label">
                                <i class="flaticon2-shield text-warning font-size-h1"></i>
                            </span>
                        </span>
                        <div class="d-flex flex-column">
                            <a href="{{ route('dnssec-analyzer.index') }}"
                                class="text-dark font-weight-bold text-hover-primary font-size-h4 mb-1">
                                Penganalisis DNSSEC
                            </a>
                            <span class="text-muted font-weight-bold">Ekstensi Keamanan</span>
                        </div>
                    </div>
                    <p class="text-dark-75 font-weight-nomal mb-5">
                        Analisis konfigurasi DNSSEC dan chain of trust.
                    </p>
                </div>
            </div>
        </div>

        <!-- Domain WHOIS -->
        <div class="col-xl-4 col-md-6 mb-6">
            <div class="card card-custom card-stretch wave wave-animate-slow">
                <div class="card-body pt-8">
                    <div class="d-flex align-items-center mb-5">
                        <span class="symbol symbol-60 symbol-light-dark mr-5">
                            <span class="symbol-label">
                                <i class="flaticon2-search text-dark font-size-h1"></i>
                            </span>
                        </span>
                        <div class="d-flex flex-column">
                            <a href="{{ route('domain-checker.index') }}"
                                class="text-dark font-weight-bold text-hover-primary font-size-h4 mb-1">
                                WHOIS Domain
                            </a>
                            <span class="text-muted font-weight-bold">Data Registrasi</span>
                        </div>
                    </div>
                    <p class="text-dark-75 font-weight-nomal mb-5">
                        Ambil detail registrasi dan kepemilikan untuk domain apa pun.
                    </p>
                </div>
            </div>
        </div>

    </div>
</x-public-layout>
