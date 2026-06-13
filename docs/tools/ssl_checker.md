# 🔒 Dokumentasi Pemeriksa SSL (SSL Checker)

## 1. Deskripsi & Cara Kerja (Logika Kode)
Pemeriksa SSL ([SslCheckerController](file:///d:/IT/App/Work-OS/app/Http/Controllers/SslCheckerController.php)) berfungsi untuk memvalidasi konfigurasi enkripsi HTTPS, rantai otoritas sertifikat (*Certificate Chain*), dan menghitung sisa masa aktif sertifikat SSL/TLS pada domain target.
*   **Alur Kerja**: Sistem membuka koneksi socket TLS terenkripsi langsung ke port 443 target menggunakan fungsi `stream_socket_client` dengan mengaktifkan flag `capture_peer_cert` dan `capture_peer_cert_chain`. Jika koneksi berhasil terbentuk, objek sertifikat mentah diurai menggunakan fungsi `openssl_x509_parse` untuk membaca struktur data sertifikat.
*   **Rate Limiting**: Dibatasi maksimal 10 pemindaian per menit per IP (`throttle:10,1`).

---

## 2. Kategori Pengujian & Parameter
1.  **Status Sertifikat**: Menentukan apakah sertifikat masih aktif (`valid`), mendekati kedaluwarsa dalam <30 hari (`warning`), atau sudah lewat batas (`expired`).
2.  **Detail Enkripsi**: Mengurai Nama Penerbit (Issuer CN/O), Nama Subjek, tipe algoritma tanda tangan (*Signature Type*), dan sidik jari sertifikat (Fingerprint SHA-256).
3.  **Subject Alternative Names (SAN)**: Memisahkan dan mendokumentasikan daftar subdomain lain yang dicakup oleh sertifikat yang sama.
4.  **Rantai Sertifikat**: Menghitung jumlah sertifikat perantara (Intermediate CA) dalam rantai enkripsi untuk memastikan keabsahan validasi.
5.  **Protokol & Cipher Suite**: Mendeteksi versi TLS yang dinegosiasikan (misal TLSv1.3) dan nama cipher yang aktif.

---

## 3. Analisis Dampak Tindak Lanjut

### ⚠️ Jika Hasil Scanning TIDAK Ditindaklanjuti (Dibiarkan)
*   **Situs Terblokir oleh Browser**: Jika sertifikat SSL kedaluwarsa, browser modern (Chrome, Firefox, Safari) akan langsung memblokir akses ke situs Anda dan menampilkan halaman peringatan merah yang sangat menakutkan (*"Your connection is not private"*). Hal ini merusak reputasi organisasi dalam hitungan detik.
*   **Kehilangan Kepercayaan Pengguna & Kerugian Finansial**: Pengunjung akan segera membatalkan transaksi karena takut data kartu kredit atau password mereka dicuri. Untuk situs e-commerce atau portal perbankan, sertifikat kedaluwarsa berarti kehilangan pendapatan instan.
*   **Serangan Man-in-the-Middle (MITM)**: Jika sertifikat menggunakan cipher suite lama yang terdeteksi lemah atau versi TLS usang (seperti TLS 1.0 atau 1.1), penyerang dapat mencegat koneksi pengguna, mendekripsi komunikasi sensitif, dan mencuri data sesi login.
*   **Rantai Enkripsi Rusak (Broken Chain)**: Jika rantai sertifikat perantara (*Intermediate Certificate*) tidak terinstal lengkap di server web (meskipun sertifikat utama valid), beberapa aplikasi seluler dan browser versi lama akan gagal memvalidasi koneksi dan memutus sambungan.

### ✅ Jika Hasil Scanning Ditindaklanjuti (Diperbaiki)
*   **Operasional Bisnis Tanpa Hambatan**: Menjamin situs web selalu dapat diakses oleh pelanggan tanpa adanya interupsi peringatan keamanan browser.
*   **Keamanan Data Transaksi**: Penerapan TLS 1.2/1.3 dengan cipher suite modern yang kuat memastikan seluruh transmisi data sensitif pengguna (password, data perbankan) terenkripsi secara kokoh dan tidak dapat didekripsi oleh pihak tengah.
*   **Peringatan Dini Pembaruan (Early Warning)**: Dengan mengetahui sisa masa aktif sertifikat melalui dashboard, tim IT dapat menjadwalkan pembaruan sertifikat (atau menguji skrip auto-renewal Let's Encrypt) sebelum sertifikat kedaluwarsa.
