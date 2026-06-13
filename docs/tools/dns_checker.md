# 🌐 Dokumentasi Pemeriksa DNS (DNS Checker / Propagation)

## 1. Deskripsi & Cara Kerja (Logika Kode)
Pemeriksa DNS ([DnsCheckerController](file:///d:/IT/App/Work-OS/app/Http/Controllers/DnsCheckerController.php)) digunakan untuk menguji validitas dan propagasi (penyebaran) record DNS dari domain target di berbagai penjuru dunia secara real-time.
*   **Alur Kerja**: Sistem menghubungi endpoint DNS-over-HTTPS (DoH) dari penyedia global seperti Google Public DNS, Cloudflare, Quad9, OpenDNS, AdGuard, CleanBrowsing, dan beberapa server proxy regional lainnya. Total terdapat 19 server DNS di Amerika, Eropa, dan Asia yang dihubungi untuk membandingkan kecocokan nilai record DNS yang tersimpan.
*   **Jenis Record**: Mendukung pengecekan tipe `A`, `AAAA`, `MX`, `CNAME`, `NS`, `TXT`, `PTR`, dan `SOA`.
*   **Rate Limiting**: Dibatasi maksimal 10 pemindaian per menit per IP (`throttle:10,1`).

---

## 2. Kategori Pengujian & Parameter
1.  **Konsistensi Resolusi**: Memeriksa apakah semua server DNS global memberikan jawaban yang seragam.
2.  **Rentang TTL**: Menampilkan durasi cache record (Time-To-Live) terendah dan tertinggi yang terdeteksi di server-server DNS.
3.  **Status DNSSEC**: Mendeteksi status keamanan kriptografi record melalui flag `AD` (Authenticated Data) pada respons server DoH.

---

## 3. Analisis Dampak Tindak Lanjut

### ⚠️ Jika Hasil Scanning TIDAK Ditindaklanjuti (Dibiarkan)
*   **Downtime & Gangguan Akses Pengguna**: Setelah melakukan migrasi server atau pembaruan IP website, record DNS membutuhkan waktu untuk menyebar (propagasi). Jika terdapat server DNS di wilayah tertentu yang mengembalikan IP lama (inkonsisten), pengguna di wilayah tersebut akan mengalami pemadaman akses (*downtime*) atau diarahkan ke website lama yang sudah tidak aktif.
*   **Kegagalan Pengiriman Email (Email Bounce)**: Jika record `MX` (Mail Exchanger) tidak menyebar secara konsisten atau salah terkonfigurasi, email yang dikirimkan ke domain organisasi akan memantul kembali (*bounce*) atau gagal diterima, mengganggu operasional komunikasi bisnis.
*   **Phishing & Email Spoofing**: Pengabaian terhadap record `TXT` (terutama SPF, DKIM, dan DMARC) dapat menyebabkan domain disalahgunakan oleh peretas untuk mengirimkan email phishing palsu atas nama domain organisasi, karena server penerima tidak memiliki acuan validasi DNS yang kuat.

### ✅ Jika Hasil Scanning Ditindaklanjuti (Diperbaiki)
*   **Meminimalkan Dampak Migrasi**: Tim IT dapat memantau dengan tepat kapan propagasi DNS selesai 100% di seluruh dunia pasca-migrasi server sebelum mematikan infrastruktur lama secara aman.
*   **Deteksi Dini Pembajakan DNS (DNS Hijacking)**: Jika hasil resolusi di salah satu negara menunjukkan IP server yang mencurigakan (tidak sesuai dengan IP asli), tim dapat mendeteksi adanya manipulasi DNS cache poisoning lokal di wilayah tersebut.
*   **Keamanan Email yang Solid**: Memastikan SPF, DKIM, dan DMARC terkonfigurasi dengan benar di seluruh DNS resolver dunia untuk menjaga reputasi pengiriman email organisasi agar tidak masuk folder spam.
