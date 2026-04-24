# MoNgapain - To-Do List Web App

MoNgapain adalah aplikasi manajemen tugas berbasis web yang dibangun menggunakan Laravel. Aplikasi ini dibuat untuk membantu pengguna mencatat tugas harian, memperbarui status tugas, dan menyimpan riwayat tugas yang sudah selesai.

## Fitur Utama

- Autentikasi pengguna (register, login, logout).
- Manajemen tugas (CRUD):
	- Tambah tugas.
	- Lihat daftar tugas aktif.
	- Edit tugas.
	- Hapus tugas.
- Riwayat tugas selesai:
	- Saat tugas ditandai selesai, data dipindahkan ke tab **Tugas Selesai**.
	- Riwayat disimpan ke tabel database terpisah (`completed_task_histories`).
- Pengaturan akun:
	- Ganti nama pengguna.
	- Ganti kata sandi.
	- Dukungan unggah foto profil (tersedia di implementasi saat ini).
- Antarmuka dan pesan validasi berbahasa Indonesia.
- Branding aplikasi: **MoNgapain**.

## Teknologi yang Digunakan

- **Backend**: Laravel 10, PHP 8.1+
- **Database**: MySQL
- **Frontend build tool**: Vite
- **CSS/Templating**: Blade + CSS sederhana