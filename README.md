# 🚀 Project Web Admin Panel

Halo semuanya! Selamat datang di repositori utama untuk pengembangan project ini. 

---

## 🎯 Tentang Project Ini
Project ini adalah sebuah **Sistem Informasi / Admin Panel** berbasis web. Sistem ini nantinya akan digunakan untuk mengelola data secara dinamis. Salah satu fitur utama yang sedang kita bangun saat ini adalah sistem **Manajemen Hak Akses (Role & Permission)** yang cukup kompleks, di mana kita bisa mengatur siapa saja yang boleh melihat, menambah, mengedit, atau menghapus data di dalam sistem.

## 🛠️ Tech Stack (Teknologi yang Digunakan)
Agar sistem berjalan cepat, interaktif, dan mudah di-maintenance, kita menggunakan kombinasi teknologi berikut (sering disebut sebagai TALL stack tanpa Livewire):

*   **Backend:** **Laravel (PHP)** - Menangani urusan routing, database, keamanan, dan logika server.
*   **Frontend / Tampilan:** **Blade Templates** - Bawaan dari Laravel untuk membuat struktur HTML.
*   **Styling:** **Tailwind CSS** - Framework CSS *utility-first* untuk membuat desain yang modern. (Kita juga mengimplementasikan fitur *Dark Mode*!).
*   **Interaktivitas UI:** **Alpine.js** - Framework JavaScript yang sangat ringan untuk menangani *dropdown*, *modal*, *checkbox* interaktif (seperti fitur *Select All*), tanpa perlu menulis JavaScript yang panjang atau menggunakan jQuery.
*   **Role & Permission:** **Spatie Laravel Permission** - *Package* tambahan untuk mempermudah pengaturan otorisasi user.

---

## 🚦 Panduan Instalasi (Getting Started)
Untuk bisa mulai *ngoding* dan mencoba menjalankan project ini di komputer (localhost) kalian, ikuti langkah-langkah berurutan di bawah ini:

### 1. Kebutuhan Sistem (Prerequisites)
Pastikan di komputer kalian sudah ter-install:
*   [PHP](https://www.php.net/) (Minimal versi 8.1+)
*   [Composer](https://getcomposer.org/) (Untuk manajemen *package* PHP)
*   [Node.js & NPM](https://nodejs.org/) (Untuk meng-compile Tailwind & asset *frontend*)
*   Database Server (MySQL / MariaDB via XAMPP, Laragon, dsb.)
*   Git

### 2. Langkah Setup Project
Jalankan perintah berikut di terminal (Command Prompt / VS Code Terminal):

```bash
# 1. Clone repositori ini ke komputer kalian
git clone <masukkan_url_repository_di_sini>

# 2. Masuk ke dalam folder project
cd <nama_folder_project>

# 3. Install semua library PHP yang dibutuhkan Laravel
composer install

# 4. Install semua library Frontend (Tailwind, dll)
npm install

# 5. Buat file konfigurasi environment
cp .env.example .env

# 6. Generate *App Key* untuk keamanan Laravel
php artisan key:generate
```

### 3. Setup Database
1. Buka aplikasi database kalian (misal: phpMyAdmin) dan buat database kosong (misal: beri nama `admin_panel_db`).
2. Buka file `.env` di VS Code, lalu ubah bagian ini sesuai nama database yang baru saja dibuat:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=admin_panel_db
   DB_USERNAME=root
   DB_PASSWORD=
   ```
3. Jalankan migrasi dan *seeder* (agar database kalian langsung terisi data *dummy* seperti role Super Admin, dsb):
   ```bash
   php artisan migrate --seed
   ```

### 4. Menjalankan Project
Untuk menjalankan aplikasi, kalian butuh **dua terminal yang berjalan bersamaan**:

**Terminal 1 (Menjalankan server PHP):**
```bash
php artisan serve
```

**Terminal 2 (Meng-compile CSS/JS secara realtime setiap kali file disimpan):**
```bash
npm run dev
```
Setelah keduanya berjalan, buka browser dan akses: `http://localhost:8000`

---

## 🤝 Alur Kerja (Workflow) Kolaborasi
1. **Jangan pernah *commit* atau *push* langsung ke *branch* `main`.**
2. Selalu buat *branch* baru dari `main` jika ingin mengerjakan fitur/issue baru.
   *(Contoh: `git checkout -b feature/nama-fitur`)*
3. Jika sudah selesai, lakukan *push* *branch* kalian dan buat **Pull Request (PR)** di GitHub untuk di-review bersama.
4. Cek daftar tugas dan prioritas di menu **Issues** pada repository GitHub kita.

---

## 📞 Butuh Bantuan?
Bingung saat proses instalasi? Ada pesan *error* aneh yang muncul di terminal? Atau kurang paham dengan cara kerja Alpine.js dan Tailwind? 
Sama, akupun bingung 😝
Pande pande ajalah y, selamat ngoding! ☕💻
