# 🧪 PANDUAN TESTING APLIKASI TOKO-5129

## 📝 Persiapan Testing

### 1. Buat User untuk Testing
Jalankan seeder untuk membuat user admin dan user biasa:

```powershell
php artisan db:seed --class=TestUserSeeder
```

**Login Credentials:**
- **Admin**: 
  - Email: `admin@toko.com`
  - Password: `password`
- **User Biasa**: 
  - Email: `user@toko.com`
  - Password: `password`

### 2. Jalankan Server
```powershell
php artisan serve
```

Buka browser: `http://localhost:8000`

---

## ✅ Test Case 1: Testing Sebagai ADMIN

### A. Login sebagai Admin
1. Klik **Login** di navbar
2. Masukkan email: `admin@toko.com`
3. Masukkan password: `password`
4. Klik Login
5. **Expected**: Redirect ke dashboard

### B. Akses Dashboard Admin
1. Setelah login, klik nama Anda di navbar → **Dashboard**
2. **Expected**: Tampil dashboard dengan 3 quick action cards:
   - Kelola Produk
   - Lihat Produk
   - Tambah Produk

### C. Lihat Daftar Produk
1. Klik **Kelola Produk** atau akses `http://localhost:8000/admin/products`
2. **Expected**: 
   - Tampil tabel produk dengan kolom: No, Gambar, Nama, Harga, Stock, Diskon, Aksi
   - Ada tombol "Tambah Produk"
   - Setiap baris ada tombol Edit (kuning) dan Hapus (merah)

### D. Tambah Produk Baru
1. Klik tombol **"Tambah Produk"**
2. **Expected**: Form dengan field:
   - Nama Produk (required)
   - Gambar Produk (required, dengan preview)
   - Harga (required, dengan prefix Rp)
   - Stock (required)
   - Diskon (optional)

3. **Test Validasi - Submit Form Kosong:**
   - Klik "Simpan" tanpa mengisi apapun
   - **Expected**: SweetAlert muncul dengan pesan error validasi

4. **Test Validasi - Upload Gambar Besar:**
   - Isi semua field
   - Upload gambar > 5MB
   - Klik "Simpan"
   - **Expected**: Error "Ukuran gambar maksimal 5MB"

5. **Test Validasi - Harga Invalid:**
   - Isi harga = 0 atau negatif
   - Klik "Simpan"
   - **Expected**: Error "Harga harus lebih besar dari 0"

6. **Test Validasi - Stock Invalid:**
   - Isi stock = -1
   - Klik "Simpan"
   - **Expected**: Error "Stock minimal 0"

7. **Test Success - Submit Valid Data:**
   - Nama: "Laptop Gaming"
   - Upload gambar valid (< 5MB)
   - Harga: 15000000
   - Stock: 10
   - Diskon: 10
   - Klik "Simpan"
   - **Expected**: 
     - Redirect ke halaman daftar produk
     - SweetAlert success muncul: "Produk berhasil ditambahkan!"
     - Produk muncul di tabel

### E. Edit Produk
1. Di halaman daftar produk, klik tombol **Edit** (kuning)
2. **Expected**: 
   - Form edit muncul dengan data produk yang dipilih
   - Gambar saat ini ditampilkan
   - Semua field terisi dengan data lama

3. Ubah beberapa data (misal: ubah stock menjadi 15)
4. Klik "Update"
5. **Expected**: 
   - Redirect ke daftar produk
   - SweetAlert success: "Produk berhasil diperbarui!"
   - Data terupdate di tabel

### F. Hapus Produk
1. Di halaman daftar produk, klik tombol **Hapus** (merah)
2. **Expected**: 
   - SweetAlert confirm dialog muncul
   - Teks: "Apakah Anda yakin? Data produk akan dihapus permanen!"
   - Ada tombol "Ya, hapus!" dan "Batal"

3. Klik "Batal"
4. **Expected**: Dialog tutup, data tidak terhapus

5. Klik "Hapus" lagi, kemudian klik "Ya, hapus!"
6. **Expected**: 
   - Produk terhapus dari database
   - SweetAlert success: "Produk berhasil dihapus"
   - Baris produk hilang dari tabel

---

## ✅ Test Case 2: Testing Sebagai USER

### A. Logout dari Admin
1. Klik nama di navbar → **Logout**
2. **Expected**: Redirect ke homepage

### B. Login sebagai User
1. Klik **Login**
2. Email: `user@toko.com`
3. Password: `password`
4. Klik Login
5. **Expected**: Redirect ke dashboard user

### C. Lihat Produk (User View)
1. Klik **Produk** di navbar atau akses `http://localhost:8000/products`
2. **Expected**: 
   - Tampil grid produk dengan kartu
   - Ada form search dengan 3 field (Nama, Harga Min, Harga Max)
   - Setiap kartu produk menampilkan:
     - Gambar
     - Nama
     - Badge kategori (Premium/Menengah/Ekonomis)
     - Harga (dengan diskon jika ada)
     - Badge stock (warna hijau jika > 10, kuning jika 1-10, merah jika 0)
     - Tombol "Lihat Detail"

### D. Test Search Produk
1. **Test Search by Nama:**
   - Isi field "Nama produk": "Laptop"
   - Klik "Cari"
   - **Expected**: Hanya produk dengan nama mengandung "Laptop" yang muncul

2. **Test Search by Harga:**
   - Isi "Harga minimum": 5000000
   - Isi "Harga maksimum": 10000000
   - Klik "Cari"
   - **Expected**: Hanya produk dengan harga 5jt - 10jt yang muncul

3. **Test Reset Filter:**
   - Klik "Reset Filter"
   - **Expected**: Semua produk ditampilkan kembali

### E. Lihat Homepage
1. Klik **Home** di navbar
2. **Expected**: 
   - Banner/hero section di atas
   - Section "Produk Unggulan" dengan maksimal 8 produk
   - Info section dengan 3 kartu (Pengiriman, Pembayaran, Customer Support)
   - Footer dengan info copyright

### F. Test Access Control (User tidak bisa akses Admin)
1. Sebagai user, coba akses `http://localhost:8000/admin/products`
2. **Expected**: Error 403 - "Akses ditolak"

---

## ✅ Test Case 3: Testing Tanpa Login (Guest)

### A. Akses Homepage
1. Logout (jika sedang login)
2. Akses `http://localhost:8000`
3. **Expected**: 
   - Homepage tampil normal
   - Navbar menampilkan tombol "Login" dan "Register"
   - Produk tetap bisa dilihat

### B. Akses Halaman Produk
1. Klik **Produk** di navbar
2. **Expected**: 
   - Halaman produk tampil normal
   - Search berfungsi
   - Guest bisa browsing produk

### C. Test Access Control (Guest tidak bisa akses Admin)
1. Coba akses `http://localhost:8000/admin/products`
2. **Expected**: Redirect ke halaman login

### D. Register Akun Baru
1. Klik **Register** di navbar
2. Isi form:
   - Name: "User Baru"
   - Email: "userbaru@test.com"
   - Password: "password"
   - Confirm Password: "password"
3. Klik "Register"
4. **Expected**: 
   - User terdaftar dengan role "user" (default)
   - Redirect ke dashboard
   - Bisa akses produk tapi tidak bisa akses admin

---

## 📊 Checklist Fitur yang Harus Berfungsi:

### ✅ CRUD Produk (Admin)
- [x] **Create**: Form tambah produk dengan validasi lengkap
- [x] **Read**: Tabel daftar produk dengan pagination
- [x] **Update**: Form edit produk dengan data existing
- [x] **Delete**: Hapus produk dengan confirm dialog

### ✅ Validasi Form
- [x] Nama: required, max 100 karakter
- [x] Gambar: required (create), max 5MB, format image
- [x] Harga: required, > 0
- [x] Stock: required, integer, >= 0
- [x] Error ditampilkan dengan SweetAlert2
- [x] Error per-field dengan @error directive

### ✅ Upload Gambar
- [x] Upload ke folder public/img/
- [x] Preview sebelum upload
- [x] Validasi ukuran max 5MB
- [x] Validasi format (JPG, PNG, GIF)
- [x] Auto delete gambar lama saat update/delete

### ✅ Autentikasi
- [x] Login dengan Laravel Breeze
- [x] Register user baru
- [x] Logout
- [x] Middleware auth melindungi halaman admin

### ✅ Role-Based Access
- [x] Admin bisa akses CRUD produk
- [x] User hanya bisa lihat produk
- [x] Guest bisa browsing, tidak bisa akses admin
- [x] Middleware role:admin berfungsi

### ✅ User Interface
- [x] Navbar responsive dengan dropdown
- [x] Warna soft (indigo & purple gradient)
- [x] Hover effects pada cards
- [x] Icon Font Awesome
- [x] SweetAlert2 untuk notifikasi
- [x] Bootstrap 5 styling

### ✅ Search & Filter
- [x] Search by nama produk
- [x] Filter by harga minimum
- [x] Filter by harga maksimum
- [x] Reset filter button

---

## 🐛 Troubleshooting

### Issue: Gambar tidak terupload
**Solusi:**
```powershell
# Pastikan folder img ada dan writable
mkdir public\img -Force
icacls public\img /grant Everyone:F
```

### Issue: Error 403 saat akses admin
**Solusi:**
- Pastikan user login memiliki `role = 'admin'`
- Check di database tabel `users`, kolom `role`

### Issue: SweetAlert tidak muncul
**Solusi:**
- Pastikan ada koneksi internet (CDN)
- Atau download SweetAlert2 dan simpan local

### Issue: Validasi tidak bekerja
**Solusi:**
- Check controller `ProdukController.php`
- Pastikan method `store()` dan `update()` ada validasi

---

## 📸 Screenshot Expected Results

### 1. Admin - Daftar Produk
- Tabel dengan data produk
- Tombol Edit (kuning) & Hapus (merah)
- Badge stock dengan warna sesuai jumlah

### 2. Admin - Form Tambah Produk
- Form dengan 5 field
- Preview gambar
- Tombol Simpan & Kembali

### 3. User - Halaman Produk
- Grid cards produk
- Search form di atas
- Badge kategori & stock

### 4. Homepage
- Banner/Hero section
- Featured products (8 items)
- Info cards di bawah

### 5. SweetAlert Notifications
- Success: hijau dengan icon checklist
- Error: merah dengan icon X
- Confirm: warning dengan tombol Ya/Batal

---

## ✅ TESTING SELESAI!

Jika semua test case di atas berhasil, berarti aplikasi sudah berfungsi dengan baik dan sesuai dengan ketentuan yang diminta.

**Good Luck with Your Testing! 🚀**
