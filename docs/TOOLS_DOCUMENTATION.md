# Dokumentasi Sistem dan Alat (Tools Documentation) - Work-OS

Dokumen ini berisi dokumentasi detail mengenai seluruh peralatan (tools) dan modul manajemen yang tersedia di aplikasi **Work-OS**. Dokumentasi ini mencakup fungsi utama, alur logika teknis, parameter input, serta endpoint route yang digunakan.

---

## Daftar Isi
1. [Fitur Pemindai Keamanan & Analisis (Public Tools)](#1-fitur-pemindai-keamanan--analisis-public-tools)
    - [Vulnerability Scanner](#vulnerability-scanner)
    - [Subdomain Finder](#subdomain-finder)
    - [DNS Propagation Checker](#dns-propagation-checker)
    - [SSL Checker](#ssl-checker)
    - [DNSSEC Analyzer](#dnssec-analyzer)
    - [Domain Checker (WHOIS & Availability)](#domain-checker-whois--availability)
    - [Web Analyzer (SEO, Speed & Headers)](#web-analyzer-seo-speed--headers)
    - [Port Scanner](#port-scanner)
2. [Modul Produktivitas & Manajemen (Authenticated Modules)](#2-modul-produktivitas--manajemen-authenticated-modules)
    - [Credentials Manager](#credentials-manager)
    - [Server & Backup Manager](#server--backup-manager)
    - [Domain Monitors](#domain-monitors)
    - [Time Entry Productivity Tracker](#time-entry-productivity-tracker)
    - [Task Manager](#task-manager)
    - [Todo List & Scratchpad](#todo-list--scratchpad)
    - [Code Snippet Manager](#code-snippet-manager)
    - [URL Shortener](#url-shortener)
    - [QR Code Generator](#qr-code-generator)
    - [Activity Logs](#activity-logs)
3. [Keamanan & Mekanisme Global](#3-keamanan--mekanisme-global)

---

## 1. Fitur Pemindai Keamanan & Analisis (Public Tools)

Peralatan di bawah ini dapat diakses secara publik tanpa memerlukan autentikasi login (berada di luar middleware `auth`).

### Vulnerability Scanner
*   **Controller**: [VulnerabilityScannerController.php](file:///d:/IT/App/Work-OS/app/Http/Controllers/VulnerabilityScannerController.php)
*   **Routes**:
    *   `GET /vuln-scanner` (`vuln-scanner.index`)
    *   `POST /vuln-scanner` (`vuln-scanner.scan`)
*   **Deskripsi**: Memindai kerentanan keamanan dan kepatuhan dari sebuah URL web berdasarkan konfigurasi header HTTP dan DNSSEC.
*   **Parameter Input**:
    *   `url` (Required, string, valid URL)
*   **Fungsi & Kategori Pengujian (Skor Maksimal 100)**:
    1.  **Web Server Security Test (10 pts)**: Memvalidasi penggunaan HTTPS dan mendeteksi apakah header `Server` memaparkan informasi versi perangkat lunak (banner leakage).
    2.  **Web Software Security Test (10 pts)**: Memeriksa eksposur informasi framework atau bahasa pemrograman melalui header `X-Powered-By`, `X-AspNet-Version`, atau `X-AspNetMvc-Version`.
    3.  **GDPR Compliance Test (10 pts)**: Menganalisis kepatuhan privasi dasar melalui keberadaan cookie (memeriksa atribut `SameSite`) serta ketatnya nilai `Referrer-Policy`.
    4.  **PCI DSS Compliance Test (10 pts)**: Memvalidasi kepatuhan transaksi kartu kredit dasar (wajib HTTPS dan penggunaan header HSTS / `Strict-Transport-Security`).
    5.  **HTTP Headers Security Test (10 pts)**: Memvalidasi keberadaan proteksi serangan Clickjacking (`X-Frame-Options`), MIME-sniffing (`X-Content-Type-Options: nosniff`), serta filter XSS (`X-XSS-Protection` atau CSP).
    6.  **Content Security Policy (CSP) Test (10 pts)**: Memeriksa keberadaan header CSP serta mendeteksi penggunaan direktif berbahaya seperti `'unsafe-inline'` dan `'unsafe-eval'`.
    7.  **Cookies Privacy & Security Test (10 pts)**: Memeriksa seluruh cookie yang disetel di client dan memastikan status flag `Secure`, `HttpOnly`, dan `SameSite` terkonfigurasi.
    8.  **External Content Security Test (10 pts)**: Memeriksa kebijakan CORS (`Access-Control-Allow-Origin: *`) dan keberadaan `Permissions-Policy` atau `Feature-Policy`.
    9.  **Protection from Data Scraping (10 pts)**: Mendeteksi indikator perlindungan bot (seperti bypass Cloudflare `cf-ray`) serta keberadaan header pembatasan laju trafik (`RateLimit-Limit` / `X-RateLimit-Limit`).
    10. **DNSSEC Configuration Test (10 pts)**: Melakukan resolusi record `DS` dan `DNSKEY` pada domain target untuk memvalidasi rantai keamanan DNSSEC.
*   **Output**: Skor angka (0-100), Grade Keamanan (A/B/C/F), ringkasan kualitatif, serta daftar rekomendasi perbaikan lengkap dengan cuplikan kode konfigurasi untuk Nginx, Apache, PHP, atau baris header HTTP.

---

### Subdomain Finder
*   **Controller**: [SubdomainFinderController.php](file:///d:/IT/App/Work-OS/app/Http/Controllers/SubdomainFinderController.php)
*   **Routes**:
    *   `GET /subdomain-finder` (`subdomain-finder.index`)
    *   `POST /subdomain-finder` (`subdomain-finder.scan`)
*   **Deskripsi**: Mencari daftar subdomain terdaftar dari suatu root domain menggunakan pencarian Certificate Transparency logs dan resolusi IP secara massal.
*   **Parameter Input**:
    *   `url` (Required, string, domain target)
*   **Fungsi & Alur Logika**:
    1.  **Ekstraksi Sumber**: Melakukan request HTTP ke log sertifikat SSL `crt.sh` (`https://crt.sh/?q=%.domain&output=json`). Jika gagal atau timeout, sistem akan beralih ke API cadangan HackerTarget (`https://api.hackertarget.com/hostsearch/?q=domain`).
    2.  **Pembersihan Data**: Menghapus duplikasi, membuang wildcard (`*`), menyaring karakter whitespace, dan membatasi output maksimal hingga **100 subdomain teratas** untuk menjaga performa server.
    3.  **Resolusi DNS**: Menggunakan fungsi `dns_get_record` PHP untuk mengambil informasi record `A` (IPv4), `AAAA` (IPv6), dan `CNAME` dari masing-masing subdomain secara real-time.
    4.  **Geolokasi & ISP**: Melakukan query batch secara massal ke layanan IP-API (`http://ip-api.com/batch`) untuk mendapatkan lokasi fisik (Kota, Negara) serta nama Internet Service Provider (ISP)/Hosting Provider dari IP subdomain yang berhasil di-resolve.
*   **Output**: Jumlah total subdomain yang ditemukan, persentase subdomain yang aktif (berhasil di-resolve), daftar lengkap nama subdomain, IP address, CNAME host, hosting provider, geolocated city & country, beserta sumber data (`crt.sh` atau `HackerTarget`).

---

### DNS Propagation Checker
*   **Controller**: [DnsCheckerController.php](file:///d:/IT/App/Work-OS/app/Http/Controllers/DnsCheckerController.php)
*   **Routes**:
    *   `GET /dns-checker` (`dns-checker.index`)
    *   `POST /dns-checker` (`dns-checker.check`)
*   **Deskripsi**: Menguji propagasi record DNS secara global di 19 server DNS yang tersebar di wilayah Amerika, Eropa, dan Asia.
*   **Parameter Input**:
    *   `domain` (Required, string, domain target)
    *   `type` (Required, enum: `A`, `AAAA`, `MX`, `CNAME`, `NS`, `TXT`, `PTR`, `SOA`)
*   **Fungsi & Alur Logika**:
    *   Melakukan query pencarian record DNS ke berbagai server DNS dunia menggunakan REST API DNS-over-HTTPS (DoH) dari Google Public DNS, Cloudflare DNS, Quad9, OpenDNS, AdGuard, CleanBrowsing, dan fallback DoH acak untuk server regional lainnya.
    *   **19 Lokasi Pengujian**:
        *   *Amerika*: Mountain View CA, San Francisco CA, Broomfield CO, Reston VA, Clifton NJ, Los Angeles CA.
        *   *Eropa*: Zurich (Swiss), Moskow (Rusia), Kopenhagen (Denmark), Sterling VA.
        *   *Asia*: Singapura, Jakarta (Indonesia), Tokyo (Jepang), Seoul (Korea Selatan), Mumbai (India), Shanghai (Cina).
    *   **Deteksi DNSSEC**: Mengecek flag *Authenticated Data* (`AD`) pada respon DoH untuk melihat apakah record tersebut tervalidasi secara kriptografis oleh DNSSEC.
*   **Output**: Peta interaktif (Leaflet.js) yang menampilkan marker status sukses/gagal di setiap negara penguji, statistik konsistensi (apakah seluruh server dunia mengembalikan nilai record yang seragam), serta daftar detail nilai record, TTL (Time-To-Live), dan status validasi DNSSEC.

---

### SSL Checker
*   **Controller**: [SslCheckerController.php](file:///d:/IT/App/Work-OS/app/Http/Controllers/SslCheckerController.php)
*   **Routes**:
    *   `GET /ssl-checker` (`ssl-checker.index`)
    *   `POST /ssl-checker` (`ssl-checker.check`)
*   **Deskripsi**: Memeriksa validitas, kedaluwarsa, parameter enkripsi, dan rantai sertifikat SSL/TLS pada port 443 milik domain target.
*   **Parameter Input**:
    *   `domain` (Required, string, domain target)
*   **Fungsi & Alur Logika**:
    1.  Membuka koneksi socket TLS terenkripsi langsung ke target menggunakan `stream_socket_client` ke host target di port `443` dengan waktu timeout 10 detik.
    2.  Mengaktifkan parameter context `capture_peer_cert` dan `capture_peer_cert_chain` untuk menangkap data sertifikat mentah.
    3.  Mengurai informasi sertifikat menggunakan fungsi bawaan `openssl_x509_parse`.
    4.  Mengekstrak atribut SSL:
        *   **Subject**: CN (Common Name) / penerima sertifikat.
        *   **Issuer**: Organisasi/otoritas penerbit (contoh: Let's Encrypt, DigiCert).
        *   **Signature Type**: Algoritma enkripsi tanda tangan (contoh: SHA256withRSA).
        *   **Fingerprint SHA256**: Hash unik sertifikat.
        *   **SAN (Subject Alternative Names)**: Daftar domain alternatif yang dicakup oleh sertifikat tersebut.
        *   **Rantai Sertifikat (Chain Count)**: Jumlah sertifikat perantara yang dikirim oleh server web.
        *   **Protokol & Cipher**: Versi SSL/TLS (misal TLSv1.3) dan cipher suite yang digunakan dalam koneksi.
        *   **Validity**: Masa mulai (`validFrom`) dan kedaluwarsa (`validTo`), lalu menghitung sisa hari aktif sertifikat.
*   **Output**: Status validasi (`valid`, `warning` jika <30 hari menuju kedaluwarsa, atau `expired`), visualisasi progress bar sisa hari, detail penerbit, data enkripsi, serta raw payload JSON sertifikat untuk kebutuhan audit mendalam.

---

### DNSSEC Analyzer
*   **Controller**: [DnsSecAnalyzerController.php](file:///d:/IT/App/Work-OS/app/Http/Controllers/DnsSecAnalyzerController.php)
*   **Routes**:
    *   `GET /dnssec-analyzer` (`dnssec-analyzer.index`)
    *   `POST /dnssec-analyzer` (`dnssec-analyzer.analyze`)
*   **Deskripsi**: Menganalisis rantai kepercayaan (Chain of Trust) kriptografis DNSSEC dari Root Zone hingga zona leaf domain target guna mendeteksi ancaman manipulasi DNS cache poisoning.
*   **Parameter Input**:
    *   `domain` (Required, string, domain target)
*   **Fungsi & Alur Logika**:
    1.  **Zona Root (`.`)**: Melakukan query record DNSKEY dari root DNS dan mencocokkannya dengan signature trust anchor (tag kunci default 20326).
    2.  **Zona TLD (Top-Level Domain, misal `.com.`)**: Mengambil record `DS` (Delegation Signer) dari zona TLD di server induk, mengambil record `DNSKEY` dari zona TLD itu sendiri, dan memverifikasi kecocokan hash DS terhadap DNSKEY.
    3.  **Zona Domain Daun (Leaf Domain, misal `domain.com.`)**: Menanyakan record `DS` di parent zone (TLD), mencocokkannya dengan `DNSKEY` di zona domain target, memverifikasi tanda tangan `RRSIG` di atas kumpulan record kunci, serta memvalidasi tanda tangan `RRSIG` pada record alamat IP utama (`A` record).
*   **Output**: Visualisasi hierarki Chain of Trust (Root -> TLD -> Domain), log detail tiap tahapan validasi tanda tangan kriptografi (Key Tag, algoritma hash), serta status kesimpulan (`success`, `warning`, `info`, atau `broken`).

---

### Domain Checker (WHOIS & Availability)
*   **Controller**: [DomainCheckerController.php](file:///d:/IT/App/Work-OS/app/Http/Controllers/DomainCheckerController.php)
*   **Routes**:
    *   `GET /domain-checker` (`domain-checker.index`)
    *   `POST /domain-checker` (`domain-checker.check`)
*   **Deskripsi**: Mengecek status ketersediaan pendaftaran domain serta melakukan pencarian detail informasi registrasi (WHOIS) dan ringkasan DNS lokal.
*   **Parameter Input**:
    *   `domain` (Required, string, nama domain)
*   **Fungsi & Alur Logika**:
    1.  **Pengecekan Ketersediaan**: Melakukan pengujian awal menggunakan `checkdnsrr` untuk tipe record `NS` dan `A`. Jika salah satu ditemukan, maka domain berstatus terdaftar (*Registered*).
    2.  **Query WHOIS**: Membuka koneksi socket TCP mentah pada port 43 (`fsockopen`) langsung ke server WHOIS otoritatif sesuai dengan TLD domain target (contoh: `whois.id` untuk `.id`, `whois.nic.google` untuk `.dev`, dll. Jika TLD tidak dikenal, query diarahkan ke server fallback global `whois.iana.org`).
    3.  **Parsing WHOIS**: Menggunakan ekspresi reguler (Regex) untuk menyaring data kunci seperti Nama Registrar, Tanggal Registrasi (`Creation Date`), Tanggal Pembaruan (`Updated Date`), Tanggal Kedaluwarsa (`Registry Expiry Date`), Status Domain (`Domain Status`), dan Name Servers.
    4.  **Ikhtisar DNS**: Mengambil record DNS penting (`A`, `AAAA`, `MX`, `NS`) milik domain melalui server DNS lokal untuk menampilkan informasi pemetaan server.
*   **Output**: Informasi status pendaftaran domain, tabel ringkasan tanggal registrasi/kedaluwarsa, nama NS, daftar alamat IP server, serta log mentah respon tekstual dari server WHOIS.

---

### Web Analyzer (SEO, Speed & Headers)
*   **Controller**: [WebAnalyzerController.php](file:///d:/IT/App/Work-OS/app/Http/Controllers/WebAnalyzerController.php)
*   **Routes**:
    *   `GET /web-analyzer` (`web-analyzer.index`)
    *   `POST /web-analyzer` (`web-analyzer.analyze`)
*   **Deskripsi**: Melakukan audit performa kecepatan muat halaman, keamanan header, kepatuhan SEO on-page dasar, dan deteksi tumpukan teknologi (tech stack).
*   **Parameter Input**:
    *   `url` (Required, string, valid URL)
*   **Fungsi & Alur Logika**:
    1.  **Analisis Performa**: Menggunakan Laravel HTTP Client untuk mengirim request GET ke URL target. Mengukur selisih waktu (`microtime`) sebelum dan sesudah request untuk mendapatkan Load Time dalam milidetik (ms), membaca ukuran halaman (page size dalam KB), serta status respon HTTP.
    2.  **Analisis Security Headers**: Memeriksa ada tidaknya header keamanan penting (seperti `Strict-Transport-Security`, `Content-Security-Policy`, `X-Frame-Options`, `X-Content-Type-Options`, `X-XSS-Protection`, dan `Referrer-Policy`).
    3.  **Analisis SEO & HTML**: Memuat dokumen HTML ke objek `DOMDocument` untuk menguji tag `<title>`, deskripsi meta, heading halaman (`<h1>`, `<h2>`), tag viewport perangkat seluler, tag URL kanonikal, jumlah meta Open Graph (`og:`), atribut `alt` pada elemen gambar (`<img>`), serta kode bahasa halaman (`<html lang="...">`).
    4.  **Deteksi Teknologi**: Mengekstrak nilai header `Server`, `X-Powered-By`, serta atribut meta generator untuk mendeteksi software web server dan framework backend yang dipakai.
    5.  **Pencarian Robots.txt**: Mengirim request HTTP ke `/robots.txt` pada domain target untuk mengecek keberadaan berkas instruksi bot pencari.
*   **Output**: Skor kualitas halaman (0-100), Grade performa (A/B/C/D), data struktur SEO, daftar rekomendasi taktis terbagi atas kategori Kecepatan, SEO, dan Keamanan.

---

### Port Scanner
*   **Controller**: [PortScannerController.php](file:///d:/IT/App/Work-OS/app/Http/Controllers/PortScannerController.php)
*   **Routes**:
    *   `GET /port-scanner` (`port-scanner.index`)
    *   `POST /port-scanner` (`port-scanner.scan`)
*   **Deskripsi**: Memeriksa status terbuka/tertutup dari port-port jaringan standar yang sering digunakan pada server.
*   **Parameter Input**:
    *   `target` (Required, string, domain atau alamat IP)
*   **Fungsi & Alur Logika**:
    *   Melakukan koneksi socket tcp kilat menggunakan `fsockopen` ke target dengan batas timeout rendah sebesar **0.35 detik** per port guna memangkas durasi tunggu.
    *   **Port yang Dipindai (12 Port Standar)**:
        *   `21` (FTP - Transfer berkas)
        *   `22` (SSH - Remote terminal aman)
        *   `23` (Telnet - Remote terminal tidak aman)
        *   `25` (SMTP - Pengiriman email)
        *   `53` (DNS - Resolusi nama domain)
        *   `80` (HTTP - Server web biasa)
        *   `110` (POP3 - Pengambilan email)
        *   `143` (IMAP - Sinkronisasi direktori email)
        *   `443` (HTTPS - Server web aman SSL/TLS)
        *   `3306` (MySQL - Database server)
        *   `3389` (RDP - Remote desktop Windows)
        *   `8080` (HTTP Alt - Port alternatif server web)
*   **Output**: Total port yang aktif (open), status masing-masing port (`open` / `closed`), deskripsi standar kegunaan port, serta alamat IP/domain target yang dipindai.

---

## 2. Modul Produktivitas & Manajemen (Authenticated Modules)

Modul-modul ini dilindungi oleh middleware `auth` dan mewajibkan pengguna terautentikasi untuk menggunakannya.

### Credentials Manager
*   **Controller**: [CredentialController.php](file:///d:/IT/App/Work-OS/app/Http/Controllers/CredentialController.php)
*   **Model**: [Credential.php](file:///d:/IT/App/Work-OS/app/Models/Credential.php)
*   **Fungsi Utama**:
    *   Menyimpan secara aman informasi sensitif seperti username, password, URL, deskripsi, dan catatan (notes) untuk keperluan operasional IT.
*   **Mekanisme Keamanan Kriptografi**:
    *   Atribut `password` dan `notes` pada database disimpan dalam bentuk sandi terenkripsi menggunakan modul kriptografi simetris AES-256 milik Laravel (`Crypt::encryptString`/`Crypt::decryptString`) via setter dan getter Eloquent Mutator. Hal ini melindungi data dari pencurian seandainya data database mentah bocor.
    *   Menerapkan **Global Scope** Eloquent di level model untuk secara otomatis membatasi data query agar pengguna hanya dapat melihat dan memodifikasi data kredensial miliknya sendiri (`where('user_id', auth()->id())`).

---

### Server & Backup Manager
*   **Controller**: [ServerController.php](file:///d:/IT/App/Work-OS/app/Http/Controllers/ServerController.php) & [ServerBackupController.php](file:///d:/IT/App/Work-OS/app/Http/Controllers/ServerBackupController.php)
*   **Model**: [Server.php](file:///d:/IT/App/Work-OS/app/Models/Server.php) & [ServerBackup.php](file:///d:/IT/App/Work-OS/app/Models/ServerBackup.php)
*   **Fungsi Utama**:
    *   **Server Manager**: Mencatat inventarisasi infrastruktur server organisasi (Nama Server, Alamat IP, Port SSH, Username, OS type, tipe server, dan deskripsi). Kolom `password` dan `private_key` secara otomatis disandikan di database dengan enkripsi bawaan Laravel (`casts: encrypted`).
    *   **Server Backup**: Mencatat log riwayat eksekusi backup server (Server ID, nama file arsip backup, ukuran file dalam MB, lokasi direktori penyimpanan backup, serta status eksekusi `success` atau `failed`).

---

### Domain Monitors
*   **Controller**: [DomainMonitorController.php](file:///d:/IT/App/Work-OS/app/Http/Controllers/DomainMonitorController.php)
*   **Model**: [DomainMonitor.php](file:///d:/IT/App/Work-OS/app/Models/DomainMonitor.php)
*   **Service**: [DomainMonitorService.php](file:///d:/IT/App/Work-OS/app/Services/DomainMonitorService.php)
*   **Fungsi Utama**:
    *   Melakukan pemantauan berkala status server web (Uptime/Downtime), masa aktif sertifikat SSL, dan tanggal kedalwarsa pendaftaran domain.
*   **Logika Pemantauan (`checkDomain`)**:
    1.  **Uptime HTTP**: Mengirim request `HEAD` ke URL domain menggunakan context stream HTTP PHP dengan batas timeout 10 detik. Membaca status HTTP (200-399 = `healthy`, 400-499 = `warning`, 500+ atau kegagalan koneksi = `down`).
    2.  **SSL Monitor**: Membuka stream socket TLS ke port 443 domain, mengambil parameter sertifikat rekanan (peer certificate), mengurainya, dan merekam tanggal kedaluwarsanya.
    3.  **Domain Registry Expiry**: Menghubungi port WHOIS (43) dari TLD domain terkait, mengambil data teks registrasi, dan menggunakan regex untuk mengekstrak tanggal kedaluwarsa domain dari WHOIS registry.

---

### Time Entry Productivity Tracker
*   **Controller**: [TimeEntryController.php](file:///d:/IT/App/Work-OS/app/Http/Controllers/TimeEntryController.php)
*   **Model**: [TimeEntry.php](file:///d:/IT/App/Work-OS/app/Models/TimeEntry.php)
*   **Fungsi Utama**:
    *   Menghitung durasi pengerjaan aktivitas kerja harian (Time Tracker).
    *   **Pemicu Otomatis**: Ketika pengguna memulai timer baru, sistem akan mendeteksi apabila ada timer lain yang masih berstatus berjalan (tanpa `end_time`). Jika ada, timer lama tersebut akan dihentikan secara paksa, diisi waktu selesainya, dan dihitung selisih detiknya (`duration`). Hal ini memastikan hanya ada satu aktivitas aktif pada satu waktu per pengguna.
    *   Menghitung total jam kerja produktif yang diakumulasikan khusus pada hari berjalan.

---

### Task Manager
*   **Controller**: [TaskController.php](file:///d:/IT/App/Work-OS/app/Http/Controllers/TaskController.php)
*   **Model**: [Task.php](file:///d:/IT/App/Work-OS/app/Models/Task.php)
*   **Fungsi Utama**:
    *   Manajemen tugas (task tracking) dengan atribut Judul, Deskripsi, Prioritas (`low`, `medium`, `high`), Status workflow (`todo`, `in_progress`, `review`, `done`), serta batas tanggal penyelesaian (`due_date`).
    *   Terintegrasi dengan modul pencatatan waktu kerja (menampilkan indikator jika ada timer berjalan yang diasosiasikan dengan suatu tugas).

---

### Todo List & Scratchpad
*   **Controller**: [TodoController.php](file:///d:/IT/App/Work-OS/app/Http/Controllers/TodoController.php) & [ScratchpadController.php](file:///d:/IT/App/Work-OS/app/Http/Controllers/ScratchpadController.php)
*   **Model**: [Todo.php](file:///d:/IT/App/Work-OS/app/Models/Todo.php) & [Scratchpad.php](file:///d:/IT/App/Work-OS/app/Models/Scratchpad.php)
*   **Fungsi Utama**:
    *   **Todo List**: Antarmuka CRUD cepat (berbasis AJAX) untuk daftar tugas kecil pribadi yang dapat diselesaikan dengan cepat.
    *   **Scratchpad**: Papan catatan tempel (sticky notes) personal. Menyimpan judul catatan, isi catatan, dan pilihan warna aksen (`warning`, `danger`, `success`, `info`, dsb.). Dilengkapi dengan fitur penataan posisi drag-and-drop melalui API route reorder (`put todos/scratchpad/reorder`) untuk memperbarui kolom `position` catatan secara berurutan.

---

### Code Snippet Manager
*   **Controller**: [SnippetController.php](file:///d:/IT/App/Work-OS/app/Http/Controllers/SnippetController.php)
*   **Model**: [Snippet.php](file:///d:/IT/App/Work-OS/app/Models/Snippet.php)
*   **Service**: [SnippetService.php](file:///d:/IT/App/Work-OS/app/Services/SnippetService.php)
*   **Fungsi Utama**:
    *   Menyimpan potongan kode pemrograman (code snippets) beserta judul, deskripsi, bahasa pemrograman, dan label tag.
    *   **Mekanisme Tag**: Menerima input tag berupa teks terpisah koma (CSV), kemudian Service memisahkan teks tersebut (`explode`), merapikan whitespace (`trim`), dan menyimpannya sebagai array terstruktur di database.

---

### URL Shortener
*   **Controller**: [ShortUrlController.php](file:///d:/IT/App/Work-OS/app/Http/Controllers/ShortUrlController.php)
*   **Model**: [ShortUrl.php](file:///d:/IT/App/Work-OS/app/Models/ShortUrl.php)
*   **Fungsi Utama**:
    *   Membuat tautan pendek dari URL asli yang panjang.
    *   **Logika Kode Unik**: Menerima pilihan kode kustom (`custom_code`) dengan validasi keunikan. Jika dikosongkan, sistem akan menghasilkan kode alfanumerik acak sepanjang 6 karakter (`Str::random(6)`) dan melakukan validasi pengulangan (looping) untuk menjamin tidak ada duplikasi kode di database.
    *   **Redireksi & Tracker**: Endpoint `/s/{code}` menangkap kode pendek, meningkatkan counter klik (`clicks`), lalu melakukan redireksi 302 ke `original_url`.

---

### QR Code Generator
*   **Controller**: [QrCodeController.php](file:///d:/IT/App/Work-OS/app/Http/Controllers/QrCodeController.php)
*   **Fungsi Utama**:
    *   Menyediakan antarmuka pembuatan kode QR (QR Code) dari target URL secara langsung di sisi klien (client-side) menggunakan library javascript terintegrasi `QRCode.js` untuk merender kode QR dalam format SVG/Canvas.
    *   Menyediakan tombol download untuk menyimpan hasil kode QR dalam format gambar PNG secara instan.

---

### Activity Logs
*   **Controller**: [ActivityLogController.php](file:///d:/IT/App/Work-OS/app/Http/Controllers/ActivityLogController.php)
*   **Model**: [ActivityLog.php](file:///d:/IT/App/Work-OS/app/Models/ActivityLog.php)
*   **Fungsi Utama**:
    *   Mencatat jejak aktivitas sistem yang dilakukan oleh pengguna organisasi.
    *   Menampilkan kronologi aktivitas terbaru lengkap dengan informasi nama pengguna, deskripsi aksi, target objek, serta waktu perekaman.

---

## 3. Keamanan & Mekanisme Global

Aplikasi **Work-OS** dirancang dengan beberapa mekanisme keamanan dan pembatasan global yang terintegrasi:

1.  **Rate Limiting (Throttle Middleware)**: Seluruh tool publik dilindungi oleh middleware throttle Laravel (`throttle:10,1`), membatasi pengiriman request scan maksimal 10 request per menit per alamat IP untuk mencegah penyalahgunaan API dan serangan Denial of Service (DoS).
2.  **Database Level Encryption**: Penyimpanan kunci privat SSH, kata sandi server, dan rahasia modul kredensial menggunakan enkripsi bawaan Laravel (`Crypt::encryptString`) sehingga aman dari kebocoran fisik database.
3.  **Multi-Tenant Isolation**: Menggunakan Eloquent Global Scope pada tabel kredensial dan catatan untuk memastikan isolasi data antar pengguna yang terdaftar sehingga tidak ada kebocoran data internal.
4.  **Optimal Socket Timeouts**: Penggunaan timeout singkat pada socket koneksi tool (misal 0.35s untuk Port Scanner, 10s untuk WHOIS & SSL) mencegah penumpukan proses PHP (hanging processes) yang dapat memperlambat server.
