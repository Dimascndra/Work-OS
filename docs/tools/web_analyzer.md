# 📊 Dokumentasi Penganalisis Web (Web Analyzer)

## 1. Deskripsi & Cara Kerja (Logika Kode)
Penganalisis Web ([WebAnalyzerController](file:///d:/IT/App/Work-OS/app/Http/Controllers/WebAnalyzerController.php)) menganalisis efisiensi performa muat halaman web, kualitas keramahan mesin pencari (SEO On-Page), dan validitas header web.
*   **Alur Kerja**: Sistem mengirimkan HTTP request GET ke URL target menggunakan Laravel HTTP Client dengan menirukan User-Agent browser modern. Sistem mengukur durasi pemuatan halaman (`load_time`), mengukur ukuran halaman, kemudian memuat kode HTML ke dalam PHP `DOMDocument` untuk membaca tag meta, judul, heading (H1, H2), tag kanonikal, meta viewport, atribut alt gambar, dan Open Graph.
*   **Rate Limiting**: Dibatasi maksimal 10 pemindaian per menit per IP (`throttle:10,1`).

---

## 2. Kategori Pengujian & Parameter
1.  **Performa Halaman**: Menguji load time (kecepatan respon server) dan ukuran halaman (page size). Memberikan rating performa dari A (tercepat) hingga D (terlambat).
2.  **SEO On-Page**: Memeriksa tag `<title>`, tag `<meta name="description">`, keberadaan heading utama `<h1>`, atribut `alt` pada semua gambar, tag kanonikal (`rel="canonical"`), dan keberadaan file `robots.txt`.
3.  **Tampilan Seluler (Mobile-Friendly)**: Memeriksa tag `<meta name="viewport">`.
4.  **Pratinjau Sosial (Social Preview)**: Memeriksa tag Open Graph (`og:image`, `og:title`, dsb).
5.  **Teknologi Web**: Mendeteksi server engine (Nginx/Apache/Cloudflare) dan header kompresi (Brotli/Gzip).

---

## 3. Analisis Dampak Tindak Lanjut

### ⚠️ Jika Hasil Scanning TIDAK Ditindaklanjuti (Dibiarkan)
*   **Kehilangan Pengunjung & Trafik (Bounce Rate Tinggi)**: Jika kecepatan muat halaman lambat (> 2 detik) dan halaman berukuran sangat besar, pengunjung akan segera menutup tab website. Riset Google menunjukkan 53% pengguna seluler meninggalkan situs yang memuat lebih dari 3 detik.
*   **Penurunan Peringkat Pencarian Google (Search Ranking Drop)**: Google memprioritaskan situs web yang memiliki tag kanonikal, deskripsi meta yang jelas, hierarki `<h1>`, serta ramah seluler (*mobile-friendly*). Tanpa elemen-elemen ini, mesin pencari akan menurunkan peringkat indeks web Anda.
*   **Duplicate Content Issues**: Tanpa tautan kanonikal (`rel="canonical"`), mesin pencari mungkin menganggap URL parameter yang berbeda sebagai halaman duplikat dan memberikan penalti SEO.
*   **Tampilan Share Media Sosial yang Buruk**: Tanpa meta Open Graph (OG), saat tautan dibagikan ke platform seperti WhatsApp, Slack, atau Facebook, tidak akan muncul pratinjau gambar atau deskripsi ringkas, sehingga menurunkan minat klik pengguna lain.

### ✅ Jika Hasil Scanning Ditindaklanjuti (Diperbaiki)
*   **Peningkatan Konversi & Retensi**: Optimasi ukuran halaman dan kompresi (Gzip/Brotli) mempercepat waktu muat halaman, sehingga meningkatkan kepuasan pengguna dan rasio konversi.
*   **Optimasi Peringkat Search Engine (SEO)**: Konten web terindeks secara sempurna dengan meta description dan judul yang rapi, meningkatkan visibilitas di halaman hasil pencarian (SERP).
*   **Aksesibilitas Lebih Baik**: Penambahan atribut `alt` pada gambar memungkinkan pembaca layar tunanetra (screen-reader) membaca deskripsi gambar dan menaikkan skor indeks pencarian gambar Google.
*   **Link Sharing Lebih Profesional**: Penggunaan Open Graph membuat tampilan tautan yang dibagikan memiliki gambar banner, judul, dan subjudul profesional.
