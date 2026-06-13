# 💻 Dokumentasi Pemindai Port (Port Scanner)

## 1. Deskripsi & Cara Kerja (Logika Kode)
Pemindai Port ([PortScannerController](file:///d:/IT/App/Work-OS/app/Http/Controllers/PortScannerController.php)) digunakan untuk memindai port jaringan terbuka pada alamat IP atau domain host guna memetakan layanan/layanan yang aktif pada server.
*   **Alur Kerja**: Sistem melakukan iterasi (looping) koneksi socket TCP kilat menggunakan `fsockopen` ke target IP/domain pada 12 nomor port standar yang umum digunakan. Untuk menghindari pemindaian yang memakan waktu lama (hang), sistem menerapkan batas timeout koneksi yang sangat singkat sebesar **0.35 detik** per port.
*   **Daftar Port yang Dipindai**:
    *   `21` (FTP) - Berbagi berkas
    *   `22` (SSH) - Terminal remote aman
    *   `23` (Telnet) - Terminal remote tidak terenkripsi
    *   `25` (SMTP) - Surat elektronik
    *   `53` (DNS) - Server DNS
    *   `80` (HTTP) - Server web biasa
    *   `110` (POP3) - Email inbox
    *   `143` (IMAP) - Email sync
    *   `443` (HTTPS) - Server web aman TLS
    *   `3306` (MySQL) - Database port
    *   `3389` (RDP) - Remote Desktop Windows
    *   `8080` (HTTP Alt) - Port alternatif web
*   **Rate Limiting**: Dibatasi maksimal 10 pemindaian per menit per IP (`throttle:10,1`).

---

## 2. Kategori Pengujian & Parameter
1.  **Status Port**: Menentukan status port sebagai terbuka (`open`) jika socket berhasil terhubung, atau tertutup (`closed`) jika gagal terhubung.
2.  **Identifikasi Layanan**: Menampilkan fungsi standar dari port yang terbuka serta deskripsi resikonya.

---

## 3. Analisis Dampak Tindak Lanjut

### ⚠️ Jika Hasil Scanning TIDAK Ditindaklanjuti (Dibiarkan)
*   **Serangan Brute-Force Massal**: Jika port administratif seperti `22` (SSH) atau `3389` (RDP) dibiarkan terbuka lebar untuk jaringan publik internet, bot peretas otomatis akan melancarkan ribuan tebakan password (serangan *brute-force* atau kamus) setiap harinya. Sekali mereka menemukan kredensial yang lemah, peretas akan memperoleh akses kendali root atas server Anda.
*   **Eksploitasi Celah Keamanan Database**: Port database seperti `3306` (MySQL) yang terbuka untuk publik sangat rawan diserang. Peretas dapat mencari celah keamanan zero-day pada software database, meluncurkan SQL Injection eksternal, atau mencuri seluruh basis data organisasi.
*   **Penyadapan Sesi (Eavesdropping)**: Layanan tidak terenkripsi seperti `21` (FTP) dan `23` (Telnet) mentransmisikan password dan data dalam format teks polos (*plain text*). Siapapun di jalur jaringan yang sama dapat menyadap dan mencuri password administrator dengan mudah menggunakan tools seperti Wireshark.

### ✅ Jika Hasil Scanning Ditindaklanjuti (Diperbaiki)
*   **Penutupan Pintu Masuk Peretas (Firewall Hardening)**: Administrator dapat mengonfigurasi Firewall (UFW/iptables) server untuk menutup port administratif dari akses publik internet dan hanya mengizinkannya diakses dari alamat IP internal (IP Whitelisting) atau melalui koneksi Virtual Private Network (VPN).
*   **Penghentian Layanan Tidak Aman**: Menutup port `23` (Telnet) atau `21` (FTP) secara permanen dan menggantinya dengan layanan terenkripsi seperti SSH (`22`) atau SFTP/FTPS.
*   **Mitigasi Ancaman Eksternal**: Memastikan port database (`3306`) hanya mendengarkan koneksi lokal (`bind-address = 127.0.0.1`) agar tidak bisa dihubungi dari jaringan luar, mengeliminasi risiko pembobolan database dari internet.
