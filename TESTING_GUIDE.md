# 🎯 Sistem Role Admin & User - RevResto

## ✅ Implementasi Selesai

Sistem role 2 tier telah berhasil diimplementasikan dengan fitur lengkap:

### **1. ADMIN - admin@gmail.com / admin123**
- ✅ **Login** sebagai admin
- ✅ **CRUD Restaurant** (Create, Read, Update, Delete)
  - Tombol "+ Tambah" di halaman list untuk menambah resto
  - Tombol "Edit" & "Hapus" di halaman detail untuk edit/delete resto
- ✅ **Review Privileges** seperti user biasa (optional)

### **2. USER / PUBLIC - test@example.com / password**
- ✅ **Publik Access** (tanpa login):
  - Lihat daftar restaurant
  - Search restaurant
  - Lihat detail restaurant dan reviews
  
- ✅ **User Login**:
  - Semua akses publik +
  - **Tulis Review** untuk restaurant
  - **Hapus review sendiri**

---

## 📦 Test Data yang Sudah Dibuat

### User Accounts
```
┌─────────────────────────────────────────────┐
│ ADMIN ACCOUNT                               │
├─────────────────────────────────────────────┤
│ Email:    admin@gmail.com                   │
│ Password: admin123                          │
│ Role:     admin                             │
└─────────────────────────────────────────────┘

┌─────────────────────────────────────────────┐
│ REGULAR USER ACCOUNT                        │
├─────────────────────────────────────────────┤
│ Email:    test@example.com                  │
│ Password: password                          │
│ Role:     user                              │
└─────────────────────────────────────────────┘
```

### Test Restaurant
```
Nama:           Nasi Kuning Enak
Cuisine Type:   Indonesian
Alamat:         Jl. Merdeka No. 123, Jakarta Pusat
Phone:          021-1234567
Deskripsi:      Restoran dengan nasi kuning tradisional yang lezat 
                dan gurih. Bahan-bahan pilihan dimasak dengan bumbu 
                rempah yang sempurna.
Rating:         0 (siap untuk di-review)
```

---

## 🔧 Files yang Dimodifikasi

### Model
- **`app/Models/User.php`**
  - `$fillable` + `'role'`
  - `isAdmin()` method
  - `isUser()` method

### Middleware (NEW)
- **`app/Http/Middleware/IsAdmin.php`**
  - Check apakah user adalah admin
  - Reject non-admin dengan redirect

### Controller
- **`app/Http/Controllers/RestaurantController.php`**
  - `edit()` - form edit (NEW)
  - `update()` - process update (NEW)
  - `destroy()` - delete restaurant (NEW)

### Routes
- **`routes/web.php`**
  - Public routes: `index`, `search`, `show`
  - Admin routes (dengan middleware `['auth', 'admin']`):
    - `create`, `store`, `edit`, `update`, `delete`
  - User routes (dengan middleware `auth`):
    - `reviews.store`, `reviews.destroy`

### Middleware Registration
- **`bootstrap/app.php`**
  - Register `IsAdmin` middleware dengan alias `'admin'`

### Views
- **`resources/views/restaurants/create.blade.php`**
  - Form tambah restaurant (admin only)

- **`resources/views/restaurants/edit.blade.php`** (NEW)
  - Form edit restaurant (admin only)
  - Preview gambar lama + opsi ganti baru

- **`resources/views/restaurants/index.blade.php`**
  - Tombol "+ Tambah" muncul hanya untuk admin
  - Search tetap publik

- **`resources/views/restaurants/show.blade.php`**
  - Tombol "Edit" & "Hapus" hanya untuk admin
  - Section review untuk semua user terauthentikasi

### Database
- **`database/seeders/DatabaseSeeder.php`**
  - Create admin user
  - Create test user
  - Create test restaurant

---

## 🚀 Testing Guide

### 1. **Test Admin Features**

#### Login sebagai Admin
```
1. Buka aplikasi
2. Click "Login"
3. Masukkan:
   - Email: admin@gmail.com
   - Password: admin123
4. Perhatikan: Tombol "+ Tambah" muncul di halaman restaurants
```

#### Tambah Restaurant
```
1. Click tombol "+ Tambah"
2. Fill form:
   - Nama: [sesuai keinginan]
   - Deskripsi: [optional]
   - Alamat: [required]
   - Telepon: [required]
   - Tipe Masakan: [required]
   - Gambar: [optional]
3. Click "Simpan"
4. Restaurant akan muncul di list
```

#### Edit Restaurant
```
1. Login sebagai admin
2. Click detail salah satu restaurant
3. Perhatikan: Tombol "Edit" & "Hapus" ada
4. Click "Edit"
5. Ubah data sesuai keinginan
6. Click "Update"
```

#### Delete Restaurant
```
1. Login sebagai admin
2. Click detail restaurant
3. Click tombol "Hapus"
4. Konfirmasi dialog
5. Restaurant terhapus
```

---

### 2. **Test User Features (Non-Login)**

#### Lihat & Search Restaurant
```
1. Tanpa login, akses halaman utama
2. Lihat list restaurants
3. Search dengan keyword (e.g., "Nasi", "Indonesian")
4. Click detail restaurant
5. Lihat reviews
6. Perhatikan: Tombol "+ Tambah" TIDAK ada
```

#### Akses Blocked untuk Tambah/Edit/Hapus
```
1. Tanpa login, coba akses:
   - http://localhost:8000/restaurants/create
   - Akan redirect ke login page
2. Coba akses edit URL:
   - http://localhost:8000/restaurants/1/edit
   - Akan redirect dengan error "Anda harus login sebagai admin!"
```

---

### 3. **Test User Features (With Login)**

#### Login sebagai User Biasa
```
1. Click "Login"
2. Masukkan:
   - Email: test@example.com
   - Password: password
3. Perhatikan:
   - Tombol "+ Tambah" TIDAK muncul di list
   - Di detail restaurant, TIDAK ada tombol "Edit" & "Hapus"
```

#### Tulis Review
```
1. Login sebagai user (test@example.com)
2. Click detail restaurant (Nasi Kuning Enak)
3. Scroll ke section "Tulis Review"
4. Isi form:
   - Rating: 5 (Sangat Baik)
   - Komentar: "Mantap! Nasi kunungnya lezat"
5. Click "Kirim Review"
6. Review akan muncul di section review
7. Rating restaurant akan terupdate otomatis
```

#### Hapus Review Sendiri
```
1. Scroll ke section review
2. Cari review milik sendiri
3. Click tombol "Hapus" di review
4. Review terhapus
5. Rating restaurant terupdate
```

#### Coba Edit/Delete Restaurant (akan denied)
```
1. Login sebagai user
2. Coba akses: /restaurants/1/edit
3. Akan redirect ke homepage dengan error:
   "Anda harus login sebagai admin!"
```

---

## 🔐 Security Implementation

✅ **Routes Protection**
- Admin routes dilindungi middleware `['auth', 'admin']`
- Unauthorized access → redirect with error message

✅ **CSRF Protection**
- Semua form include `@csrf`
- DELETE method use form spoofing `@method('DELETE')`

✅ **Authorization Checks**
- Review delete check `Auth::id() === $review->user_id`
- Admin-only routes check `auth()->user()->isAdmin()`

✅ **Frontend Guards**
- Admin buttons hanya muncul untuk admin
- Delete confirmation dialog sebelum remove

---

## 📊 Role Permissions Matrix

| Feature | Public | User | Admin |
|---------|--------|------|-------|
| View Restaurants List | ✅ | ✅ | ✅ |
| View Restaurant Detail | ✅ | ✅ | ✅ |
| Search Restaurants | ✅ | ✅ | ✅ |
| **Create Restaurant** | ❌ | ❌ | ✅ |
| **Edit Restaurant** | ❌ | ❌ | ✅ |
| **Delete Restaurant** | ❌ | ❌ | ✅ |
| Write Review | ❌ | ✅ | ✅ |
| Delete Own Review | ❌ | ✅ | ✅ |

---

## 📝 Next Steps (Optional)

- [ ] Tambah soft delete untuk restaurant
- [ ] Tambah audit log untuk track siapa edit/delete
- [ ] Tambah role "moderator" jika diperlukan
- [ ] Implementasi spatie/laravel-permission untuk granular permissions
- [ ] Tambah restaurant owner role
- [ ] Rating average calculation di migration jika perlu

---

## 💡 Tips Testing

1. **Buka 2 browser tab** - satu untuk admin, satu untuk user
2. **Test akses direct URL** - coba edit/delete tanpa login
3. **Test search** - pastikan publik bisa search tanpa login
4. **Test review flow** - lihat rating berubah setelah review
5. **Clear browser cache** - jika ada issue dengan session

---

**Status: ✅ READY TO TEST**

Aplikasi siap untuk di-test. Gunakan credentials di atas untuk testing semua fitur.
