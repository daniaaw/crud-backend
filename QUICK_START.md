# 🚀 QUICK START GUIDE - TOKO-5129

## ⚡ Langkah Cepat untuk Memulai

### 1️⃣ Persiapan Database
Pastikan Laragon sudah running dan database sudah dibuat.

```powershell
# Check migration status
php artisan migrate:status

# If not migrated yet
php artisan migrate
```

### 2️⃣ Buat User untuk Testing (Opsional)
```powershell
php artisan db:seed --class=TestUserSeeder
```

**Login Credentials:**
- Admin: `admin@toko.com` / `password`
- User: `user@toko.com` / `password`

### 3️⃣ Jalankan Aplikasi
```powershell
php artisan serve
```

Buka browser: **http://localhost:8000**

---

## 🎯 Quick Test Flow

### ✅ Test Admin (5 menit)
1. Login sebagai admin (`admin@toko.com` / `password`)
2. Klik nama Anda → Dashboard
3. Klik "Kelola Produk"
4. Klik "Tambah Produk"
5. Isi form & upload gambar
6. Klik "Simpan"
7. ✅ Success! Produk muncul di tabel

### ✅ Test User (2 menit)
1. Logout, login sebagai user (`user@toko.com` / `password`)
2. Klik "Produk" di navbar
3. Coba search produk
4. ✅ Success! Produk bisa dilihat

### ✅ Test Guest (1 menit)
1. Logout
2. Browse homepage & produk
3. Coba akses `/admin/products`
4. ✅ Success! Redirect ke login

---

## 📂 Struktur URL Penting

### Public (Semua Orang)
- **Homepage**: `/` atau `/home`
- **Produk**: `/products`

### Auth (Login Required)
- **Dashboard**: `/dashboard`
- **Profile**: `/profile`

### Admin (Role: Admin)
- **Kelola Produk**: `/admin/products`
- **Tambah Produk**: `/admin/products/create`
- **Edit Produk**: `/admin/products/{id}/edit`

---

## 🎨 Fitur Utama

### ✅ CRUD Produk (Admin)
- ➕ Tambah produk dengan upload gambar
- ✏️ Edit produk
- 🗑️ Hapus produk dengan confirm
- 📋 Lihat daftar produk

### ✅ Validasi Form
- Nama: max 100 karakter
- Gambar: max 5MB, format JPG/PNG/GIF
- Harga: harus > 0
- Stock: minimal 0

### ✅ User Interface
- 🎨 Soft colors (indigo & purple)
- 📱 Responsive design
- ✨ Hover effects
- 🔔 SweetAlert notifications

### ✅ Access Control
- 👤 User: view only
- 👨‍💼 Admin: full CRUD
- 🚫 Guest: browse only

---

## 🔍 Troubleshooting Cepat

### ❌ Error: Class not found
```powershell
composer dump-autoload
```

### ❌ Error: Permission denied
```powershell
# Windows
icacls storage /grant Everyone:F /t
icacls bootstrap\cache /grant Everyone:F /t
```

### ❌ Error: SQLSTATE connection refused
1. Buka Laragon
2. Start Apache & MySQL
3. Check `.env` file

### ❌ Gambar tidak terupload
```powershell
mkdir public\img -Force
```

---

## 📞 Bantuan Lebih Lanjut

Baca dokumentasi lengkap:
- 📋 `IMPLEMENTATION_SUMMARY.md` - Ringkasan implementasi
- 🧪 `TESTING_GUIDE.md` - Panduan testing detail
- 📘 `TECHNICAL_SPECS.md` - Spesifikasi teknis
- 📖 `README.md` - Penjelasan arsitektur

---

## ✅ READY TO GO!

Aplikasi siap digunakan. Selamat mencoba! 🎉

**Happy Coding! 🚀**
