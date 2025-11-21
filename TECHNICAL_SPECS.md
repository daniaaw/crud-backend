# 📘 SPESIFIKASI TEKNIS APLIKASI TOKO-5129

## 🔧 Tech Stack

### Backend
- **Framework**: Laravel 10+
- **PHP Version**: 8.1+
- **Architecture**: Monolithic
- **ORM**: Eloquent
- **Authentication**: Laravel Breeze
- **Validation**: Server-side with Validator::make()

### Frontend
- **CSS Framework**: Bootstrap 5.3.0
- **Icons**: Font Awesome 6.0.0
- **JavaScript Library**: SweetAlert2 (via CDN)
- **Templating**: Blade Templates

### Database
- **DBMS**: MySQL/MariaDB (via Laragon)
- **Tables**: 
  - `users` (with role column)
  - `produks` (products)
  - `password_reset_tokens`
  - `failed_jobs`
  - `personal_access_tokens`

---

## 📁 Project Structure

```
toko-5129/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── ProdukController.php      # Main product CRUD controller
│   │   │   ├── HomeController.php        # Homepage controller
│   │   │   └── DashboardController.php   # Dashboard controller
│   │   └── Middleware/
│   │       └── RoleMiddleware.php        # Role-based access control
│   └── Models/
│       ├── Produk.php                    # Product model
│       └── User.php                      # User model with role
│
├── database/
│   ├── migrations/
│   │   ├── create_produks_table.php
│   │   ├── add_role_to_users_table.php
│   │   └── add_stock_to_produks_table.php
│   └── seeders/
│       ├── ProdukSeeder.php
│       ├── UserSeeder.php
│       └── TestUserSeeder.php            # For testing
│
├── resources/
│   └── views/
│       ├── admin/
│       │   └── products/
│       │       ├── index.blade.php       # Admin product list
│       │       ├── create.blade.php      # Add product form
│       │       └── edit.blade.php        # Edit product form
│       ├── products/
│       │   └── index.blade.php           # User product list
│       ├── front/
│       │   └── home.blade.php            # Homepage
│       ├── dashboard/
│       │   ├── admin.blade.php           # Admin dashboard
│       │   ├── user.blade.php            # User dashboard
│       │   └── staff.blade.php           # Staff dashboard
│       └── layouts/
│           ├── main.blade.php            # Public layout
│           ├── app.blade.php             # Auth layout (Breeze)
│           └── guest.blade.php           # Guest layout (Breeze)
│
├── routes/
│   └── web.php                           # All web routes
│
└── public/
    └── img/                              # Product images upload folder
```

---

## 🗄️ Database Schema

### Table: `users`
```sql
id              BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT
name            VARCHAR(255) NOT NULL
email           VARCHAR(255) UNIQUE NOT NULL
email_verified_at TIMESTAMP NULL
password        VARCHAR(255) NOT NULL
role            VARCHAR(255) DEFAULT 'user'    # NEW: admin, user, staff
remember_token  VARCHAR(100) NULL
created_at      TIMESTAMP NULL
updated_at      TIMESTAMP NULL
```

### Table: `produks`
```sql
id_produk       BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT
nama            VARCHAR(255) NOT NULL
harga           INTEGER NOT NULL
diskon          INTEGER NULL
gambar          VARCHAR(255) NULL
stock           INTEGER DEFAULT 0              # NEW
created_at      TIMESTAMP NULL
updated_at      TIMESTAMP NULL
```

---

## 🛣️ API Routes

### Public Routes (No Auth Required)
```
GET  /                      → home (HomeController@home)
GET  /home                  → home
GET  /products              → products.index (ProdukController@index)
GET  /produk                → alias for /products
```

### Authentication Routes (Laravel Breeze)
```
GET   /login                → login form
POST  /login                → authenticate
GET   /register             → register form
POST  /register             → store user
POST  /logout               → logout
```

### Protected Routes (Auth Required)
```
GET   /dashboard            → dashboard (DashboardController@index)
GET   /profile              → profile.edit
PATCH /profile              → profile.update
DELETE /profile             → profile.destroy
```

### Admin Routes (Auth + Role:Admin Required)
```
GET    /admin                              → admin.dashboard
GET    /admin/products                     → admin.products.index
GET    /admin/products/create              → admin.products.create
POST   /admin/products                     → admin.products.store
GET    /admin/products/{id}/edit           → admin.products.edit
PUT    /admin/products/{id}                → admin.products.update
DELETE /admin/products/{id}                → admin.products.destroy
```

---

## 🔐 Middleware Configuration

### Kernel.php - Route Middleware
```php
protected $middlewareAliases = [
    'auth' => \App\Http\Middleware\Authenticate::class,
    'role' => \App\Http\Middleware\RoleMiddleware::class,
    // ... other middleware
];
```

### RoleMiddleware Usage
```php
// In routes/web.php
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Admin only routes
});

Route::middleware(['auth', 'role:user'])->group(function () {
    // User only routes
});
```

---

## ✅ Validation Rules

### Product Store/Update Validation
```php
[
    'nama' => 'required|max:100',
    'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',  // 5MB
    'harga' => 'required|numeric|gt:0',
    'stock' => 'required|integer|min:0',
    'diskon' => 'nullable|numeric|min:0|max:100',
]
```

### Custom Error Messages
```php
[
    'nama.required' => 'Nama produk wajib diisi',
    'nama.max' => 'Nama produk maksimal 100 karakter',
    'gambar.required' => 'Gambar produk wajib diupload',
    'gambar.max' => 'Ukuran gambar maksimal 5MB',
    'harga.gt' => 'Harga harus lebih besar dari 0',
    'stock.min' => 'Stock minimal 0',
]
```

---

## 📤 File Upload Configuration

### Upload Location
```
public/img/{timestamp}_{original_filename}
```

### Upload Process
```php
// In ProdukController@store
if ($request->hasFile('gambar')) {
    $image = $request->file('gambar');
    $imageName = time() . '_' . $image->getClientOriginalName();
    $image->move(public_path('img'), $imageName);
}
```

### Delete Old Image
```php
// In ProdukController@update or @destroy
if ($produk->gambar && file_exists(public_path('img/' . $produk->gambar))) {
    unlink(public_path('img/' . $produk->gambar));
}
```

---

## 🎨 UI/UX Components

### Color Palette
```css
--primary-color: #6366f1    /* Indigo */
--secondary-color: #8b5cf6  /* Purple */
--success-color: #10b981    /* Green */
--danger-color: #ef4444     /* Red */
--warning-color: #f59e0b    /* Orange */
--light-bg: #f8fafc         /* Light Gray */
```

### SweetAlert2 Configuration

#### Success Alert
```javascript
Swal.fire({
    icon: 'success',
    title: 'Berhasil!',
    text: '{{ session('success') }}',
    showConfirmButton: false,
    timer: 2000,
    toast: true,
    position: 'top-end'
});
```

#### Error Alert
```javascript
Swal.fire({
    icon: 'error',
    title: 'Gagal!',
    text: '{{ session('error') }}',
    showConfirmButton: true
});
```

#### Confirm Delete
```javascript
Swal.fire({
    title: 'Apakah Anda yakin?',
    text: "Data produk akan dihapus permanen!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: 'Ya, hapus!',
    cancelButtonText: 'Batal'
}).then((result) => {
    if (result.isConfirmed) {
        form.submit();
    }
});
```

---

## 🔒 Security Features

### 1. CSRF Protection
- All forms include `@csrf` token
- Automatic validation by Laravel

### 2. Authentication
- Password hashing with bcrypt
- Session-based authentication (Breeze)
- Remember me functionality

### 3. Authorization
- Role-based access control (RBAC)
- Middleware guards routes
- 403 error for unauthorized access

### 4. Input Validation
- Server-side validation for all inputs
- SQL injection prevention (Eloquent ORM)
- XSS prevention (Blade escaping)

### 5. File Upload Security
- File type validation
- File size restriction (max 5MB)
- Unique filename generation

---

## 📊 Features Matrix

| Feature | User | Admin | Guest |
|---------|------|-------|-------|
| View Products | ✅ | ✅ | ✅ |
| Search Products | ✅ | ✅ | ✅ |
| View Homepage | ✅ | ✅ | ✅ |
| Add Product | ❌ | ✅ | ❌ |
| Edit Product | ❌ | ✅ | ❌ |
| Delete Product | ❌ | ✅ | ❌ |
| Access Dashboard | ✅ | ✅ | ❌ |
| Manage Users | ❌ | ❌ | ❌ |

---

## 🚀 Performance Considerations

### Database Queries
- Use Eloquent ORM for efficient queries
- Order by created_at DESC for latest products
- Lazy loading for relationships

### Image Optimization
- Recommended: compress images before upload
- Max size: 5MB
- Suggested dimensions: 800x800px

### Caching (Future Enhancement)
```php
// Cache product list for 60 minutes
$products = Cache::remember('products', 3600, function () {
    return Produk::orderBy('id_produk', 'desc')->get();
});
```

---

## 📝 Code Standards

### Naming Conventions
- **Controllers**: PascalCase with Controller suffix
  - Example: `ProdukController`
- **Models**: PascalCase, singular
  - Example: `Produk`, `User`
- **Routes**: kebab-case
  - Example: `/admin/products`, `/products/create`
- **Views**: kebab-case
  - Example: `create.blade.php`, `edit.blade.php`
- **Methods**: camelCase
  - Example: `adminIndex()`, `store()`

### Blade Directives Usage
```blade
@extends('layout')
@section('title', 'Page Title')
@yield('content')
@include('partials.header')
@if / @elseif / @else / @endif
@foreach / @endforeach
@forelse / @empty / @endforelse
@error('field') / @enderror
@csrf
@method('PUT')
```

---

## 🔄 Future Enhancements

### Recommended Features
1. **Pagination** - Add pagination for product list
2. **Product Categories** - Add category management
3. **Shopping Cart** - Implement cart functionality
4. **Order Management** - Add order processing
5. **Payment Gateway** - Integrate payment system
6. **Product Reviews** - Allow users to review products
7. **Email Notifications** - Send email on order
8. **Export to Excel** - Export product data
9. **Image Gallery** - Multiple images per product
10. **Inventory Management** - Stock alerts

---

## 📚 Documentation References

- [Laravel 10 Documentation](https://laravel.com/docs/10.x)
- [Laravel Breeze](https://laravel.com/docs/10.x/starter-kits#laravel-breeze)
- [Bootstrap 5 Documentation](https://getbootstrap.com/docs/5.3/)
- [SweetAlert2 Documentation](https://sweetalert2.github.io/)
- [Font Awesome Icons](https://fontawesome.com/icons)

---

## 🤝 Support & Maintenance

### Known Issues
- None reported yet

### Browser Compatibility
- ✅ Chrome 90+
- ✅ Firefox 88+
- ✅ Safari 14+
- ✅ Edge 90+

### Server Requirements
- PHP >= 8.1
- MySQL >= 5.7 or MariaDB >= 10.3
- Composer
- Node.js & NPM (for asset compilation)

---

**Version**: 1.0.0  
**Last Updated**: November 19, 2025  
**Author**: Development Team
