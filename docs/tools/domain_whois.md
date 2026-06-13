# 🗂️ Dokumentasi Pemeriksa WHOIS Domain (Domain WHOIS Checker)

## 1. Deskripsi & Cara Kerja (Logika Kode)
Pemeriksa WHOIS Domain ([DomainCheckerController](file:///d:/IT/App/Work-OS/app/Http/Controllers/DomainCheckerController.php)) digunakan untuk memeriksa ketersediaan domain, masa aktif kepemilikan domain (registrasi), informasi registrar, serta log record DNS lokal.
*   **Alur Kerja**: Sistem memeriksa status pendaftaran awal menggunakan fungsi `checkdnsrr` untuk record `NS` dan `A`. Jika terdaftar, sistem akan membuka koneksi socket TCP mentah pada port 43 (`fsockopen`) ke server WHOIS resmi sesuai dengan TLD domain target (misal: `whois.id` untuk `.id`, `whois.nic.me` untuk `.me`). Respon teks mentah dari server WHOIS kemudian disaring menggunakan regex untuk mengekstrak informasi kepemilikan.
*   **Rate Limiting**: Dibatasi maksimal 10 pemindaian per menit per IP (`throttle:10,1`).

---

## 2. Kategori Pengujian & Parameter
1.  **Status Registrasi**: Menampilkan status ketersediaan domain (apakah terdaftar atau tersedia untuk dibeli).
2.  **Detail Registrar**: Nama perusahaan tempat mendaftarkan domain (contoh: GoDaddy, Namecheap, Niagahoster).
3.  **Masa Aktif Domain**: Mengurai tanggal pendaftaran (`Creation Date`), pembaruan terakhir (`Updated Date`), dan tanggal kedaluwarsa (`Registry Expiry Date`).
4.  **Status Domain**: Menampilkan kode status EPP domain (misal: `clientTransferProhibited` untuk mencegah transfer ilegal).
5.  **Daftar Name Server (NS)**: Server DNS otoritatif yang mengelola pemetaan domain tersebut.

---

## 3. Analisis Dampak Tindak Lanjut

### ⚠️ Jika Hasil Scanning TIDAK Ditindaklanjuti (Dibiarkan)
*   **Kehilangan Domain Akibat Kedaluwarsa (Domain Sniping)**: Jika tanggal kedaluwarsa diabaikan dan domain melewati masa tenggang (*Grace Period*), domain akan dilepas kembali ke pasar publik. Peretas atau spekulan domain (*Domain Squatter*) dapat langsung membelinya secara otomatis menggunakan bot pendaftaran (*Domain Sniping*). Untuk mendapatkannya kembali, organisasi harus membayar ribuan dolar atau bahkan kehilangan nama domain tersebut selamanya.
*   **Kebocoran Data Pribadi Pemilik (Spam & Phishing)**: Jika WHOIS Checker menunjukkan bahwa fitur perlindungan privasi (*WHOIS Privacy Guard*) dinonaktifkan pada domain Anda, maka alamat email pribadi, nama lengkap, nomor telepon, dan alamat rumah admin domain akan terpampang bebas di internet. Ini memicu serangan spam telepon/email massal serta serangan rekayasa sosial (*social engineering*) terarah.
*   **Pembajakan Transfer Domain (Domain Hijacking)**: Jika status domain tidak diatur ke `clientTransferProhibited` (Transfer Lock), domain rentan dipindahkan secara ilegal ke registrar lain oleh pihak yang berhasil meretas akun kontrol panel domain Anda.

### ✅ Jika Hasil Scanning Ditindaklanjuti (Diperbaiki)
*   **Perpanjangan Domain Tepat Waktu**: Tim IT memiliki kalender pemantauan otomatis masa aktif aset domain organisasi untuk melakukan perpanjangan (*renewal*) jauh hari sebelum jatuh tempo.
*   **Pengaktifan WHOIS Privacy**: Menyembunyikan identitas pemilik domain dari publik untuk melindungi staf IT dari target penipuan dan spamming.
*   **Proteksi Kunci Domain (Registry Lock)**: Mengunci status domain ke opsi transfer terkunci guna menghindari pencurian domain secara tidak sah.
