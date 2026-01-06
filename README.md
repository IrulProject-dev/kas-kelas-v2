<p align="center">
  <a href="#" target="_blank">
    <img src="https://lh3.googleusercontent.com/d/1-TrhdCX8Geg0MPz6wW44Gst2bRhawRC3" width="300" alt="TRPL Logo">
  </a>
</p>

<h1 align="center">Sistem Manajemen Kas Kelas (Aurora Theme)</h1>

<p align="center">
    Aplikasi manajemen keuangan kelas berbasis web modern dengan tampilan <b>Dark Mode Aurora</b> & <b>Glassmorphism</b>. Dibuat untuk memudahkan Bendahara dalam pencatatan, pelaporan, dan penagihan uang kas.
</p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://img.shields.io/badge/Laravel-v10%2F11-FF2D20?style=for-the-badge&logo=laravel" alt="Laravel"></a>
<a href="https://filamentphp.com/"><img src="https://img.shields.io/badge/Filament-v3-F2C94C?style=for-the-badge" alt="FilamentPHP"></a>
<a href="https://tailwindcss.com/"><img src="https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css" alt="Tailwind CSS"></a>
<a href="https://img.shields.io/badge/License-MIT-green?style=for-the-badge" alt="License"></a>
</p>

---

## 🔥 Fitur Utama

Aplikasi ini tidak hanya sekedar mencatat angka, tapi memberikan pengalaman pengguna (UX) yang memanjakan mata dan memudahkan pekerjaan:

-   **🎨 Aurora Glassmorphism UI:** Tampilan antarmuka modern, full dark mode dengan efek kaca (blur) yang estetik.
-   **📊 Dashboard Interaktif:** Statistik pemasukan, pengeluaran, dan saldo akhir ditampilkan dengan grafik visual.
-   **📅 Weekly Tracking:** Pencatatan kas per minggu yang fleksibel.
-   **👥 Member Management:** Kelola data mahasiswa (Nama, NIM, Status Aktif).
-   **📉 Expense Tracking:** Pencatatan pengeluaran kelas (fotocopy, acara, dll) yang transparan.
-   **📱 Mobile Responsive:** Tampilan admin panel menyesuaikan layar HP, Tablet, dan Desktop.

## 📸 Screenshots

| Dashboard Aurora | Weekly List & Status |
| :---: | :---: |
| ![Dashboard](https://lh3.googleusercontent.com/d/1842Dty-AvNSZXR00qZ9YuXD7ceJwLAkI) | ![Weekly](https://lh3.googleusercontent.com/d/1j08MGPQEK3rHq9GzPNfNfWCm3_6tPI-c) |

---

## 🛠️ Teknologi yang Digunakan

-   **Framework:** [Laravel 10/11](https://laravel.com)
-   **Admin Panel:** [FilamentPHP v3](https://filamentphp.com)
-   **Frontend:** Blade, Livewire, Tailwind CSS
-   **Database:** MySQL
-   **Asset Bundler:** Vite

## 🚀 Cara Install (Localhost)

Ikuti langkah-langkah ini untuk menjalankan project di komputer lokal Anda:

1.  **Clone Repository**
    ```bash
    git clone https://github.com/IrulProject-dev/kas-kelas-v2.git
    cd kas-kelas-v2
    ```

2.  **Install Dependencies**
    ```bash
    composer install
    npm install
    ```

3.  **Setup Environment**
    -   Copy file `.env.example` menjadi `.env`
    -   Atur konfigurasi database di file `.env`
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4.  **Database Migration & Seeder**
    ```bash
    php artisan migrate --seed
    ```

5.  **Build Assets (Penting untuk Tema Aurora)**
    Karena menggunakan custom CSS, wajib menjalankan build:
    ```bash
    npm run build
    ```

6.  **Buat Storage Link**
    Agar gambar profil/upload bisa muncul:
    ```bash
    php artisan storage:link
    ```

7.  **Jalankan Server**
    ```bash
    php artisan serve
    ```
    Buka `http://127.0.0.1:8000/admin` di browser.

---

## ☁️ Catatan Deployment (Shared Hosting/cPanel)

Jika ingin meng-online-kan aplikasi ini di cPanel/Niagahoster:

1.  Pastikan menggunakan **PHP 8.2+**.
2.  Lakukan `npm run build` di local (laptop), lalu upload folder `public/build` ke hosting.
3.  Jalankan `php artisan filament:assets` untuk mempublish aset default.
4.  Gunakan **Symbolic Link** manual jika hosting memblokir fungsi `symlink()` PHP.
5.  Set `APP_URL` di `.env` harus menggunakan `https://` agar tidak terjadi *Mixed Content Error*.

## 👨‍💻 Author

**Fauzan Fathoni Khoirul Huda**
* **Prodi:** D4 Teknologi Rekayasa Perangkat Lunak (TRPL)
* **Kampus:** Universitas Duta Bangsa Surakarta
* **Angkatan:** 2025
* **Instagram:** [_f.thoni](https://www.instagram.com/_f.thoni/)

---

## 📄 License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
