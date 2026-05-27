from pathlib import Path

content = """# 📌 ResepKu Backend Setup Guide

## 📖 Deskripsi
Panduan ini digunakan untuk menjalankan backend **ResepKu** sebelum menjalankan aplikasi Flutter. Pastikan mengikuti langkah-langkah berikut secara berurutan agar sistem dapat berjalan dengan baik.

---

## ⚙️ Prasyarat
Sebelum memulai, pastikan sudah menginstal:
- XAMPP (Apache + MySQL)
- PHP (sudah termasuk di XAMPP / Laravel)
- Composer (jika menggunakan Laravel)
- Git (untuk clone repository)
- Emulator Android / device fisik (jika menjalankan Flutter)

---

## 🚀 Langkah Instalasi Backend

### 1. Buat Folder di XAMPP
Buat folder project di dalam direktori berikut:

C:\\xampp\\htdocs\\ResepKu

---

### 2. Clone Project Database / Backend
Buka terminal (CMD / Git Bash), lalu jalankan:

git clone <URL_REPOSITORY_DATABASE> C:\\xampp\\htdocs\\ResepKu

> Pastikan semua file backend berada di dalam folder ResepKu

---

### 3. Jalankan XAMPP
Buka XAMPP Control Panel, lalu:
- Start Apache
- Start MySQL

---

### 4. Jalankan Backend (Laravel)
Masuk ke folder project:

cd C:\\xampp\\htdocs\\ResepKu

Lalu jalankan server Laravel:

php artisan serve --host=0.0.0.0 --port=8000

---

### 5. Pastikan Server Berjalan
Jika berhasil, akan muncul pesan:

INFO Server running on http://0.0.0.0:8000

Artinya backend sudah aktif dan siap digunakan.

---

## 📱 Akses dari Flutter / Emulator
Gunakan endpoint:

http://10.0.2.2:8000

atau jika di device fisik:

http://IP_LAPTOP_KAMU:8000

---

## ⚠️ Catatan Penting
- Pastikan XAMPP selalu aktif saat backend dijalankan
- Jangan tutup terminal php artisan serve
- Pastikan .env sudah dikonfigurasi dengan benar (database MySQL)
- Jika error port, ganti misalnya ke 8001

---

## 👨‍💻 Developer
ResepKu Project - Backend & API  
Untuk kebutuhan tugas / UAS / praktikum
"""

file_path = Path("/mnt/data/README_ResepKu.md")
file_path.write_text(content, encoding="utf-8")

file_path.name
