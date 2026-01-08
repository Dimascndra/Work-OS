# Work OS - Dashboard Manajemen Personal

Work OS adalah aplikasi berbasis Laravel yang komprehensif, dirancang untuk mengelola alur kerja pribadi maupun profesional. Aplikasi ini mencakup modul yang kuat untuk kredensial keamanan, pemantauan infrastruktur, dan alat produktivitas harian, semuanya dibalut dalam antarmuka gaya Metronic yang premium.

## 🚀 Fitur

### 🔐 Layer Keamanan (Security)

-   **Manajer Kredensial**: Simpan login dan rahasia dengan aman. Password dan catatan otomatis dienkripsi di database menggunakan enkripsi Laravel.
-   **Log Aktivitas**: Lacak tindakan pengguna yang penting dan event sistem untuk tujuan audit.
-   **Manajemen Pengguna**: Kelola pengguna sistem, peran, dan reset password admin.

### 🌐 Layer Infrastruktur

-   **Manajemen Server**: Pantau server VPS/Dedicated Anda (IP, Port, OS, Status). Simpan SSH private key dengan aman.
-   **Pemantauan Domain**: Pantau masa berlaku SSL dan status domain (Sehat/Down/Warning).
-   **Manajemen SSH Keys**: Simpan dan kelola kunci SSH (Private/Public) untuk akses server yang aman.
-   **Backup**: Catat dan lacak riwayat backup server (Nama file, Ukuran, Status).

### ⚡ Layer Produktivitas (Alat Harian)

-   **Tugas (Kanban)**: Kelola tugas harian dengan prioritas (Rendah/Sedang/Tinggi) dan status (Todo/In Progress/Review/Done).
-   **Snippet Kode**: Simpan potongan kode yang berguna (PHP, JS, Bash, dll) dengan highlight sintaks dan tagging.
-   **Langganan (Subscriptions)**: Lacak pengeluaran rutin (SaaS, tagihan Server) dengan siklus penagihan dan tanggal jatuh tempo.

## 🛠️ Instalasi

Ikuti langkah-langkah ini untuk menjalankan proyek secara lokal:

### 1. Clone Repository

```bash
git clone https://github.com/Dimascndra/Work-OS.git
cd Work-OS
```

### 2. Install Dependencies

**PHP Dependencies:**

```bash
composer install
```

**Node.js Dependencies:**

```bash
npm install
```

### 3. Pengaturan Environment

Salin file contoh environment dan konfigurasi kredensial database Anda:

```bash
cp .env.example .env
```

Buka `.env` dan atur detail koneksi database Anda (`DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`).

### 4. Generate App Key

```bash
php artisan key:generate
```

### 5. Jalankan Migrasi

Buat tabel database yang diperlukan:

```bash
php artisan migrate
```

### 6. Build Assets

Kompilasi aset frontend menggunakan Vite:

```bash
npm run build
```

### 7. Jalankan Aplikasi

Mulai server development lokal:

```bash
php artisan serve
```

Buka `http://localhost:8000` di browser Anda.

## 📖 Alur Kerja Aplikasi

### Autentikasi

-   Daftar akun baru atau login dengan kredensial yang ada.
-   Dashboard dilindungi dan memerlukan autentikasi.

### Mengelola Kredensial

1. Navigasi ke **Security > Credentials**.
2. Klik **Add New** untuk menyimpan login baru.
3. Gunakan tombol **Copy** untuk menyalin password ke clipboard dengan cepat.

### Memantau Infrastruktur

1. **Servers**: Tambahkan detail server Anda di **Infrastructure > Servers**. Simpan kunci SSH dengan aman.
2. **Monitors**: Tambahkan domain yang ingin dipantau di **Infrastructure > Domain Monitors**.
3. **Backups**: Catat hasil backup manual atau otomatis di **Infrastructure > Backups**.

### Produktivitas Harian

1. **Tasks**: Gunakan bagian **Productivity > Tasks** untuk mengelola daftar to-do harian Anda.
2. **Snippets**: Simpan kode yang dapat digunakan kembali di **Productivity > Snippets**.
3. **Subscriptions**: Pantau tagihan bulanan/tahunan Anda di **Productivity > Subscriptions**.

## 💻 Tech Stack

-   **Framework**: Laravel 12
-   **UI Theme**: Metronic (Custom Blade Components)
-   **Frontend**: Blade, Alpine.js (Lightweight), Bootstrap (via Metronic)
-   **Database**: MySQL/MariaDB

## 📄 Lisensi

Proyek ini adalah perangkat lunak open-source yang dilisensikan di bawah [lisensi MIT](https://opensource.org/licenses/MIT).
