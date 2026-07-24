# Sistem Informasi Akademik - SD Islam Al-Ukhuwah

Aplikasi manajemen akademik sekolah berbasis CodeIgniter 4 dengan desain modern dan responsif.

## 🚀 Fitur Utama

- Manajemen Siswa & Guru
- Pengaturan Jadwal Pelajaran
- Sistem Penilaian & Rapor Otomatis
- Presensi Siswa
- Dashboard Wali Kelas, Guru, Kepala Sekolah, dan Orang Tua
- Konfigurasi Bobot Nilai (PH, UTS, UAS)

## 🛠 Persyaratan Sistem

- **PHP**: ^8.2
- **Database**: MySQL 5.7+ atau MariaDB 10.3+
- **Composer**: Dependency Manager untuk PHP
- **Node.js & NPM**: Untuk kompilasi aset (TailwindCSS)
- **Ekstensi PHP**: `intl`, `mbstring`, `mysqli`, `gd`, `curl`, `xml`

## 💻 Instalasi Lokal (Laragon/XAMPP)

### 1. Persiapan Folder

Clone repository ini atau extract file ZIP ke folder server lokal Anda:

- Laragon: `C:\laragon\www\akademik`
- XAMPP: `C:\xampp\htdocs\akademik`

### 2. Instalasi Dependensi PHP

Buka terminal di folder proyek dan jalankan:

```bash
composer install
```

### 3. Instalasi Dependensi Frontend

Jalankan perintah berikut untuk menginstal paket JavaScript:

```bash
npm install
```

### 4. Konfigurasi Database

1. Buat database baru di MySQL (contoh: `akademik`).
2. Import file database yang berada di `database/akademik.sql`.
3. Rename file `env` menjadi `.env` jika belum ada.
4. Sesuaikan pengaturan database di file `.env`:

```ini
database.default.hostname = localhost
database.default.database = akademik
database.default.username = root
database.default.password =
database.default.DBDriver = MySQLi
```

### 5. Konfigurasi App Base URL

Sesuaikan URL aplikasi Anda di file `.env`:

```ini
app.baseURL = 'http://akademik.test/' # Sesuaikan dengan virtual host atau localhost
```

### 6. Kompilasi Aset (TailwindCSS)

Jalankan kompilasi CSS untuk memastikan tampilan sesuai:

```bash
npm run build
```

### 7. Jalankan Aplikasi

Jika menggunakan PHP build-in server:

```bash
php spark serve
```

Akses melalui `http://localhost:8080`.

## 🌐 Hosting (cPanel)

Untuk panduan detail mengenai hosting di cPanel, silakan lihat file [cpanel_setup_guide.md](.gemini/antigravity/brain/712d4283-ac6d-4752-a77c-32a021e9a6f9/cpanel_setup_guide.md).

## 📄 Lisensi

[MIT License](LICENSE)
