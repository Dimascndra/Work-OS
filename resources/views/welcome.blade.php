<x-public-layout>
    @push('styles')
        <style>
            .hero-card {
                background: linear-gradient(135deg, #181c32 0%, #1e293b 100%);
                position: relative;
                overflow: hidden;
                border-radius: 16px !important;
                box-shadow: 0 10px 30px rgba(24, 28, 50, 0.15);
                border: none;
            }
            .hero-card::before {
                content: '';
                position: absolute;
                top: -50%;
                left: -50%;
                width: 200%;
                height: 200%;
                background: radial-gradient(circle, rgba(54, 153, 255, 0.15) 0%, transparent 60%);
                animation: rotate-mesh 25s linear infinite;
                pointer-events: none;
            }
            @keyframes rotate-mesh {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }
            .tool-card {
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                border: 1px solid rgba(0, 0, 0, 0.05) !important;
                border-radius: 12px !important;
                overflow: hidden;
                background-color: #ffffff;
            }
            .tool-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 12px 28px rgba(0, 0, 0, 0.08) !important;
                border-color: rgba(56, 189, 248, 0.2) !important;
            }
            .tool-icon-box {
                transition: transform 0.3s ease;
            }
            .tool-card:hover .tool-icon-box {
                transform: scale(1.1);
            }
            .recent-scan-link {
                background-color: #ffffff;
                border: 1px solid #e4e6ef;
                border-radius: 12px;
                padding: 14px;
                display: flex;
                align-items: center;
                text-decoration: none !important;
                transition: transform 0.2s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.2s cubic-bezier(0.4, 0, 0.2, 1), background-color 0.2s ease, border-color 0.2s ease;
            }
            .recent-scan-link:hover {
                transform: translateY(-2px);
                box-shadow: 0 6px 20px rgba(0,0,0,0.05) !important;
                background-color: #ebf5ff;
                border-color: #3699ff !important;
            }
        </style>
    @endpush

    <div class="row mb-8">
        <div class="col-12">
            <div class="card hero-card text-white py-10 px-8 py-md-12 px-md-10">
                <div class="card-body p-0 position-relative" style="z-index: 1;">
                    <span class="label label-light-primary label-inline font-weight-bold mb-4 px-3 py-2 text-uppercase" style="letter-spacing: 1px;">Security Suite</span>
                    <h1 class="font-weight-boldest text-white font-size-h2 font-size-md-h1 mb-3">Selamat Datang di Web Security Scanner Tools</h1>
                    <p class="text-white-50 font-size-lg mb-0 max-w-600px">
                        Kumpulan alat analisis dan diagnosa keamanan jaringan untuk developer, administrator sistem, dan analis keamanan.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Scans History Widget -->
    <div class="row mb-8 d-none" id="recent-scans-card">
        <div class="col-12">
            <div class="card card-custom shadow-sm border-0" style="border-radius: 12px;">
                <div class="card-header border-0 pb-0 bg-transparent d-flex align-items-center justify-content-between">
                    <h3 class="card-title font-weight-bolder text-dark font-size-h5 mb-0">
                        <i class="flaticon2-time text-primary mr-2"></i> Riwayat Pemindaian Terakhir
                    </h3>
                    <button id="clear-scans-btn" class="btn btn-clean btn-sm text-danger font-weight-bold" style="border-radius: 8px;">
                        <i class="flaticon-delete-1 text-danger mr-1"></i> Hapus Semua
                    </button>
                </div>
                <div class="card-body pt-3 pb-5">
                    <div id="recent-scans-list" class="row">
                        <!-- Dynamic content -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tools Grid -->
    <div class="row">
        <!-- Web Analyzer -->
        <div class="col-12 col-md-6 col-xl-4 mb-6">
            <div class="card card-custom tool-card h-100 d-flex flex-column justify-content-between">
                <div class="card-body p-6">
                    <div class="d-flex align-items-center mb-5">
                        <span class="symbol symbol-50 symbol-light-primary mr-4 tool-icon-box">
                            <span class="symbol-label">
                                <i class="flaticon2-browser-2 text-primary font-size-h3"></i>
                            </span>
                        </span>
                        <div class="d-flex flex-column">
                            <a href="{{ route('web-analyzer.index') }}"
                                class="text-dark font-weight-boldest text-hover-primary font-size-h5 mb-0">
                                Penganalisis Web
                            </a>
                            <span class="text-muted font-weight-bold font-size-xs">Web Stack Analyzer</span>
                        </div>
                    </div>
                    <p class="text-dark-70 font-size-sm mb-5">
                        Analisis teknologi website secara mendalam untuk mendeteksi framework (React, Vue, Laravel), server (Nginx, Apache), CMS (WordPress), bahasa pemrograman, serta verifikasi kelengkapan header keamanan HTTP (CSP, HSTS, XSS Protection, X-Frame-Options) guna mencegah serangan clickjacking dan scripting.
                    </p>
                </div>
                <div class="card-footer bg-transparent border-0 px-6 pb-6 pt-0">
                    <a href="{{ route('web-analyzer.index') }}" class="btn btn-sm btn-light-primary font-weight-bold btn-block py-3">
                        Buka Alat <i class="flaticon2-next ml-2 font-size-xs"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Vuln Scanner -->
        <div class="col-12 col-md-6 col-xl-4 mb-6">
            <div class="card card-custom tool-card h-100 d-flex flex-column justify-content-between">
                <div class="card-body p-6">
                    <div class="d-flex align-items-center mb-5">
                        <span class="symbol symbol-50 symbol-light-danger mr-4 tool-icon-box">
                            <span class="symbol-label">
                                <i class="flaticon2-protection text-danger font-size-h3"></i>
                            </span>
                        </span>
                        <div class="d-flex flex-column">
                            <a href="{{ route('vuln-scanner.index') }}"
                                class="text-dark font-weight-boldest text-hover-primary font-size-h5 mb-0">
                                Pemindai Kerentanan
                            </a>
                            <span class="text-muted font-weight-bold font-size-xs">Vulnerability Scan</span>
                        </div>
                    </div>
                    <p class="text-dark-70 font-size-sm mb-5">
                        Pindai kerentanan keamanan kritis pada aplikasi web Anda secara otomatis. Alat ini memeriksa konfigurasi SSL lemah, proteksi CORS, cookie yang tidak aman, paparan direktori sensitif, serta memberikan saran mitigasi taktis berbasis standar keamanan industri.
                    </p>
                </div>
                <div class="card-footer bg-transparent border-0 px-6 pb-6 pt-0">
                    <a href="{{ route('vuln-scanner.index') }}" class="btn btn-sm btn-light-danger font-weight-bold btn-block py-3">
                        Mulai Pindai <i class="flaticon2-next ml-2 font-size-xs"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Subdomain Finder -->
        <div class="col-12 col-md-6 col-xl-4 mb-6">
            <div class="card card-custom tool-card h-100 d-flex flex-column justify-content-between">
                <div class="card-body p-6">
                    <div class="d-flex align-items-center mb-5">
                        <span class="symbol symbol-50 symbol-light-primary mr-4 tool-icon-box">
                            <span class="symbol-label">
                                <i class="flaticon2-search-1 text-primary font-size-h3"></i>
                            </span>
                        </span>
                        <div class="d-flex flex-column">
                            <a href="{{ route('subdomain-finder.index') }}"
                                class="text-dark font-weight-boldest text-hover-primary font-size-h5 mb-0">
                                Pencari Subdomain
                            </a>
                            <span class="text-muted font-weight-bold font-size-xs">Passive Recon</span>
                        </div>
                    </div>
                    <p class="text-dark-70 font-size-sm mb-5">
                        Temukan seluruh subdomain terdaftar dari domain target secara instan menggunakan metode pasif Certificate Transparency (CT) logs. Aman digunakan karena tidak melakukan kontak langsung (non-intrusif) ke server target sehingga tidak memicu alarm keamanan.
                    </p>
                </div>
                <div class="card-footer bg-transparent border-0 px-6 pb-6 pt-0">
                    <a href="{{ route('subdomain-finder.index') }}" class="btn btn-sm btn-light-primary font-weight-bold btn-block py-3">
                        Cari Domain <i class="flaticon2-next ml-2 font-size-xs"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- DNS Checker -->
        <div class="col-12 col-md-6 col-xl-4 mb-6">
            <div class="card card-custom tool-card h-100 d-flex flex-column justify-content-between">
                <div class="card-body p-6">
                    <div class="d-flex align-items-center mb-5">
                        <span class="symbol symbol-50 symbol-light-info mr-4 tool-icon-box">
                            <span class="symbol-label">
                                <i class="flaticon2-world text-info font-size-h3"></i>
                            </span>
                        </span>
                        <div class="d-flex flex-column">
                            <a href="{{ route('dns-checker.index') }}"
                                class="text-dark font-weight-boldest text-hover-primary font-size-h5 mb-0">
                                Pemeriksa DNS
                            </a>
                            <span class="text-muted font-weight-bold font-size-xs">Propagation Check</span>
                        </div>
                    </div>
                    <p class="text-dark-70 font-size-sm mb-5">
                        Lacak propagasi dan nilai DNS record (A, AAAA, MX, CNAME, TXT, NS) secara global dari berbagai server DNS di benua Asia, Amerika, Eropa, hingga Australia. Sangat berguna untuk memverifikasi perubahan DNS yang baru Anda lakukan.
                    </p>
                </div>
                <div class="card-footer bg-transparent border-0 px-6 pb-6 pt-0">
                    <a href="{{ route('dns-checker.index') }}" class="btn btn-sm btn-light-info font-weight-bold btn-block py-3">
                        Periksa DNS <i class="flaticon2-next ml-2 font-size-xs"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- SSL Checker -->
        <div class="col-12 col-md-6 col-xl-4 mb-6">
            <div class="card card-custom tool-card h-100 d-flex flex-column justify-content-between">
                <div class="card-body p-6">
                    <div class="d-flex align-items-center mb-5">
                        <span class="symbol symbol-50 symbol-light-success mr-4 tool-icon-box">
                            <span class="symbol-label">
                                <i class="flaticon2-lock text-success font-size-h3"></i>
                            </span>
                        </span>
                        <div class="d-flex flex-column">
                            <a href="{{ route('ssl-checker.index') }}"
                                class="text-dark font-weight-boldest text-hover-primary font-size-h5 mb-0">
                                Pemeriksa SSL
                            </a>
                            <span class="text-muted font-weight-bold font-size-xs">Certificate Status</span>
                        </div>
                    </div>
                    <p class="text-dark-70 font-size-sm mb-5">
                        Periksa validitas sertifikat SSL/TLS, masa kedaluwarsa, kekuatan enkripsi cipher, data Certificate Authority (CA) penerbit, serta kelengkapan rantai sertifikat (chain of trust) untuk menghindari peringatan 'koneksi tidak aman' pada browser pengunjung.
                    </p>
                </div>
                <div class="card-footer bg-transparent border-0 px-6 pb-6 pt-0">
                    <a href="{{ route('ssl-checker.index') }}" class="btn btn-sm btn-light-success font-weight-bold btn-block py-3">
                        Periksa SSL <i class="flaticon2-next ml-2 font-size-xs"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- DNSSEC Analyzer -->
        <div class="col-12 col-md-6 col-xl-4 mb-6">
            <div class="card card-custom tool-card h-100 d-flex flex-column justify-content-between">
                <div class="card-body p-6">
                    <div class="d-flex align-items-center mb-5">
                        <span class="symbol symbol-50 symbol-light-warning mr-4 tool-icon-box">
                            <span class="symbol-label">
                                <i class="flaticon2-shield text-warning font-size-h3"></i>
                            </span>
                        </span>
                        <div class="d-flex flex-column">
                            <a href="{{ route('dnssec-analyzer.index') }}"
                                class="text-dark font-weight-boldest text-hover-primary font-size-h5 mb-0">
                                Penganalisis DNSSEC
                            </a>
                            <span class="text-muted font-weight-bold font-size-xs">Chain of Trust</span>
                        </div>
                    </div>
                    <p class="text-dark-70 font-size-sm mb-5">
                        Periksa integritas konfigurasi ekstensi keamanan DNS (DNSSEC) pada domain target. Alat ini menganalisis rantai tanda tangan kriptografis dari DS record, DNSKEY, hingga RRSIG untuk memastikan domain Anda aman dari serangan DNS spoofing dan hijacking.
                    </p>
                </div>
                <div class="card-footer bg-transparent border-0 px-6 pb-6 pt-0">
                    <a href="{{ route('dnssec-analyzer.index') }}" class="btn btn-sm btn-light-warning font-weight-bold btn-block py-3">
                        Analisis DNSSEC <i class="flaticon2-next ml-2 font-size-xs"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Domain WHOIS -->
        <div class="col-12 col-md-6 col-xl-4 mb-6">
            <div class="card card-custom tool-card h-100 d-flex flex-column justify-content-between">
                <div class="card-body p-6">
                    <div class="d-flex align-items-center mb-5">
                        <span class="symbol symbol-50 symbol-light-dark mr-4 tool-icon-box">
                            <span class="symbol-label">
                                <i class="flaticon2-search text-dark font-size-h3"></i>
                            </span>
                        </span>
                        <div class="d-flex flex-column">
                            <a href="{{ route('domain-checker.index') }}"
                                class="text-dark font-weight-boldest text-hover-primary font-size-h5 mb-0">
                                WHOIS Domain
                            </a>
                            <span class="text-muted font-weight-bold font-size-xs">Registration Info</span>
                        </div>
                    </div>
                    <p class="text-dark-70 font-size-sm mb-5">
                        Ambil informasi registrasi resmi domain target, termasuk tanggal registrasi, tanggal kedaluwarsa, registrar resmi, status domain, nama server (NS), serta detail kontak administrative/technical untuk memeriksa kepemilikan dan ketersediaan domain.
                    </p>
                </div>
                <div class="card-footer bg-transparent border-0 px-6 pb-6 pt-0">
                    <a href="{{ route('domain-checker.index') }}" class="btn btn-sm btn-light-dark font-weight-bold btn-block py-3">
                        Periksa WHOIS <i class="flaticon2-next ml-2 font-size-xs"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Port Scanner -->
        <div class="col-12 col-md-6 col-xl-4 mb-6">
            <div class="card card-custom tool-card h-100 d-flex flex-column justify-content-between">
                <div class="card-body p-6">
                    <div class="d-flex align-items-center mb-5">
                        <span class="symbol symbol-50 symbol-light-warning mr-4 tool-icon-box">
                            <span class="symbol-label">
                                <i class="flaticon-computer text-warning font-size-h3"></i>
                            </span>
                        </span>
                        <div class="d-flex flex-column">
                            <a href="{{ route('port-scanner.index') }}"
                                class="text-dark font-weight-boldest text-hover-primary font-size-h5 mb-0">
                                Pemindai Port
                            </a>
                            <span class="text-muted font-weight-bold font-size-xs">Open Port Scan</span>
                        </div>
                    </div>
                    <p class="text-dark-70 font-size-sm mb-5">
                        Pindai port jaringan standar (seperti FTP, SSH, HTTP, HTTPS, MySQL, dll.) pada target IP atau domain eksternal secara real-time untuk mengidentifikasi layanan yang aktif dan mendeteksi potensi port administratif yang terekspos.
                    </p>
                </div>
                <div class="card-footer bg-transparent border-0 px-6 pb-6 pt-0">
                    <a href="{{ route('port-scanner.index') }}" class="btn btn-sm btn-light-warning font-weight-bold btn-block py-3">
                        Pindai Port <i class="flaticon2-next ml-2 font-size-xs"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            (function() {
                function escapeHtml(str) {
                    if (!str) return '';
                    return str.replace(/&/g, "&amp;")
                              .replace(/</g, "&lt;")
                              .replace(/>/g, "&gt;")
                              .replace(/"/g, "&quot;")
                              .replace(/'/g, "&#039;");
                }

                function renderRecentScans() {
                    const card = document.getElementById('recent-scans-card');
                    const list = document.getElementById('recent-scans-list');
                    if (!card || !list) return;

                    let scans = [];
                    try {
                        scans = JSON.parse(localStorage.getItem('wss_recent_scans')) || [];
                    } catch (e) {
                        scans = [];
                    }

                    if (!Array.isArray(scans) || scans.length === 0) {
                        card.classList.add('d-none');
                        return;
                    }

                    card.classList.remove('d-none');
                    list.innerHTML = '';

                    scans.forEach(function(scan) {
                        const targetParam = scan.paramName || 'url';
                        const href = `${scan.route}?${targetParam}=${encodeURIComponent(scan.target)}`;
                        
                        const itemHtml = `
                            <div class="col-12 col-sm-6 col-md-4 mb-4">
                                <a href="${href}" class="recent-scan-link">
                                    <div class="symbol symbol-40 symbol-light-${scan.color} mr-3 flex-shrink-0">
                                        <span class="symbol-label">
                                            <i class="${scan.icon} text-${scan.color} font-size-h5"></i>
                                        </span>
                                    </div>
                                    <div class="d-flex flex-column min-w-0 flex-grow-1">
                                        <span class="text-dark font-weight-boldest font-size-sm text-truncate mb-0">${escapeHtml(scan.target)}</span>
                                        <span class="text-muted font-size-xs text-truncate">${scan.toolName}</span>
                                    </div>
                                    <i class="flaticon2-next text-muted font-size-xs ml-2"></i>
                                </a>
                            </div>
                        `;
                        list.insertAdjacentHTML('beforeend', itemHtml);
                    });
                }

                document.addEventListener('DOMContentLoaded', function() {
                    renderRecentScans();

                    const clearBtn = document.getElementById('clear-scans-btn');
                    if (clearBtn) {
                        clearBtn.addEventListener('click', function() {
                            localStorage.removeItem('wss_recent_scans');
                            renderRecentScans();
                        });
                    }

                    window.addEventListener('wss_recent_scans_updated', renderRecentScans);
                });
            })();
        </script>
    @endpush
</x-public-layout>
