# 🔑 Dokumentasi Penganalisis DNSSEC (DNSSEC Analyzer)

## 1. Deskripsi & Cara Kerja (Logika Kode)
Penganalisis DNSSEC ([DnsSecAnalyzerController](file:///d:/IT/App/Work-OS/app/Http/Controllers/DnsSecAnalyzerController.php)) berfungsi untuk memetakan dan memverifikasi rantai tanda tangan kriptografis DNSSEC (*Chain of Trust*) yang melindungi domain dari serangan manipulasi record DNS.
*   **Alur Kerja**: Sistem melakukan analisis bertingkat dari Root Zone, TLD Zone, hingga Leaf Domain:
    1.  **Root Zone (`.`)**: Mengambil record DNSKEY dari root internet dan mencocokkannya dengan signature jangkar (default Key Tag 20326).
    2.  **TLD Zone (misal `.id.`)**: Mengambil record `DS` (Delegation Signer) dari zona induk, mencocokkannya dengan record `DNSKEY` di zona TLD.
    3.  **Leaf Zone (misal `domain.id.`)**: Mengambil record `DS` dari parent zone (TLD), mencocokkannya dengan `DNSKEY` di zona domain, memverifikasi tanda tangan `RRSIG` pada record kunci, dan memverifikasi tanda tangan `RRSIG` di atas record alamat IP (`A`).
*   **API Penyedia**: Query menggunakan REST API DoH Cloudflare dan Google DNS.
*   **Rate Limiting**: Dibatasi maksimal 10 pemindaian per menit per IP (`throttle:10,1`).

---

## 2. Kategori Pengujian & Parameter
1.  **Validasi Record DS**: Memeriksa keberadaan dan kecocokan algoritma hash record DS (Delegation Signer) di zona induk.
2.  **Validasi DNSKEY**: Mengurai tag kunci DNSKEY (Key Tag) dan memisahkan tipe kunci (Zone Signing Key / Key Signing Key).
3.  **Verifikasi RRSIG**: Memeriksa kecocokan tanda tangan digital (`RRSIG`) terhadap kumpulan rekaman sumber daya DNS (RRset) untuk memastikan integritas data.

---

## 3. Analisis Dampak Tindak Lanjut

### ⚠️ Jika Hasil Scanning TIDAK Ditindaklanjuti (Dibiarkan)
*   **Kerentanan DNS Cache Poisoning & DNS Spoofing**: Tanpa DNSSEC, protokol DNS standar tidak memiliki cara untuk memverifikasi keaslian respon DNS yang diterimanya. Peretas dapat menyusupi server DNS milik ISP pengguna atau router Wi-Fi lokal, lalu memalsukan catatan DNS (memperacuni cache DNS) untuk mengarahkan pengguna ke situs web kloning tiruan (situs phishing). Korban akan melihat nama domain yang benar di address bar browser mereka, tetapi sebenarnya sedang terhubung ke server milik peretas.
*   **Man-in-the-Middle (MITM) pada DNS**: DNS resolver tidak dapat mendeteksi apakah data DNS telah dimodifikasi atau disisipkan secara ilegal di tengah jalan selama proses query berlangsung.
*   **Kegagalan Deteksi Rantai Enkripsi Rusak (Broken Chain of Trust)**: Jika DNSSEC dikonfigurasi secara salah (misal: kunci DNSKEY diubah namun record DS di registrar domain tidak diperbarui), hal ini akan menyebabkan "broken chain". Seluruh DNS resolver yang mendukung DNSSEC akan memutus koneksi dan menolak menyelesaikan nama domain Anda, menyebabkan website Anda mengalami downtime total bagi pengguna global.

### ✅ Jika Hasil Scanning Ditindaklanjuti (Diperbaiki)
*   **Perlindungan Mutlak Terhadap DNS Spoofing**: Seluruh respon DNS ditandatangani secara digital. Browser dan resolver DNS yang melakukan validasi akan otomatis menolak respon palsu yang tidak memiliki tanda tangan kriptografi yang sah, sehingga mencegah pengalihan trafik ke situs phishing.
*   **Integritas Jalur Koneksi**: Menjamin bahwa ketika pengguna mengetik nama domain Anda, mereka dijamin terhubung ke alamat IP server fisik Anda yang sebenarnya.
*   **Deteksi Dini Kesalahan Konfigurasi**: Memungkinkan administrator untuk melihat apakah pembaruan kunci DNS (*Key Rollover*) telah diterapkan dengan benar tanpa mematahkan rantai kepercayaan publik.
