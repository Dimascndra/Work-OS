# 🔍 Dokumentasi Pencari Subdomain (Subdomain Finder)

## 1. Deskripsi & Cara Kerja (Logika Kode)
Pencari Subdomain ([SubdomainFinderController](file:///d:/IT/App/Work-OS/app/Http/Controllers/SubdomainFinderController.php)) berfungsi untuk memetakan arsitektur dan footprint digital suatu organisasi dengan cara memindai subdomain terdaftar secara pasif dan melacak status aktifnya.
*   **Alur Kerja**:
    1.  Sistem melakukan pencarian pasif ke log Certificate Transparency SSL `crt.sh`.
    2.  Jika `crt.sh` lambat atau timeout, sistem secara otomatis beralih ke REST API cadangan dari `HackerTarget`.
    3.  Subdomain yang ditemukan dibersihkan dari duplikasi, disaring agar sesuai dengan root domain, dan dibatasi maksimal 100 subdomain teratas.
    4.  Sistem me-resolve record DNS `A`, `AAAA`, dan `CNAME` secara paralel untuk membedakan subdomain aktif dan tidak aktif.
    5.  Menghubungi endpoint batch `ip-api.com` untuk memetakan IP address ke nama ISP/Hosting Provider dan lokasi geografis.
*   **Rate Limiting**: Dibatasi maksimal 10 pemindaian per menit per IP (`throttle:10,1`).

---

## 2. Kategori Pengujian & Parameter
1.  **Resolusi Subdomain**: Mengonfirmasi keaktifan subdomain melalui record IPv4 (`A`) atau IPv6 (`AAAA`).
2.  **Pemetaan CNAME**: Mengidentifikasi alias subdomain ke pihak ketiga (misal: AWS S3, Shopify, GitHub Pages).
3.  **Geolokasi & Provider**: Mendeteksi penyedia infrastruktur (AWS, DigitalOcean, Cloudflare) dan negara server.

---

## 3. Analisis Dampak Tindak Lanjut

### ⚠️ Jika Hasil Scanning TIDAK Ditindaklanjuti (Dibiarkan)
*   **Subdomain Takeover (Pengambilalihan Subdomain)**: Bahaya paling kritis. Jika subdomain memiliki record `CNAME` yang mengarah ke layanan pihak ketiga yang sudah tidak aktif atau dihapus (misalnya wadah Amazon S3, proyek GitHub Pages, atau instansi Zendesk yang sudah kedaluwarsa), peretas dapat mendaftarkan akun di layanan pihak ketiga tersebut dengan nama yang sama untuk mengambil alih kontrol atas subdomain Anda sepenuhnya. Mereka dapat memanipulasi konten, mencuri cookie sesi utama, atau menyebarkan malware.
*   **Kerentanan Shadow IT**: Subdomain yang dibuat untuk keperluan tes sementara (misal: `test-db.domain.com` atau `staging.domain.com`) seringkali terlupakan oleh administrator. Server-server ini biasanya tidak diperbarui, tidak memiliki firewall yang ketat, atau memiliki celah keamanan lama yang dapat dieksploitasi sebagai pintu masuk ke jaringan utama organisasi.
*   **Target Reconnaissance Peretas**: Penyerang memetakan subdomain organisasi untuk menemukan target yang paling lemah. Jika organisasi tidak memantau apa saja subdomain mereka yang aktif, mereka tidak akan sadar ketika salah satu server tes disusupi.

### ✅ Jika Hasil Scanning Ditindaklanjuti (Diperbaiki)
*   **Pencegahan Instan Subdomain Takeover**: Administrator dapat mendeteksi CNAME yang menggantung (*dangling CNAME*) dan segera menghapus record DNS tersebut sebelum dimanfaatkan oleh pihak luar.
*   **Hardening Shadow IT**: Administrator dapat menonaktifkan subdomain dan server testing yang sudah tidak digunakan lagi untuk mengurangi beban biaya infrastruktur dan mengecilkan permukaan serangan (*attack surface*).
*   **Manajemen Aset yang Teratur**: Membantu tim IT memetakan seluruh inventori publik organisasi secara akurat dan memastikan kepatuhan standar sertifikat SSL pada setiap subdomain aktif.
