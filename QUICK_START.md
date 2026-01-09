# 🔑 QUICK START - LOGIN CREDENTIALS

## Admin Account
```
Email:    admin@gmail.com
Password: admin123
Role:     Admin
```

## User Account  
```
Email:    test@example.com
Password: password
Role:     User
```

---

## 📱 What Admin Can Do

✅ **Create Restaurant**
- Login → Lihat tombol "+ Tambah" → Isi form → Submit

✅ **Edit Restaurant**
- Login → Click detail resto → Click "Edit" → Update → Submit

✅ **Delete Restaurant**
- Login → Click detail resto → Click "Hapus" → Confirm

---

## 👤 What User Can Do

✅ **View Restaurants** (without login)
- Lihat list, search, view detail

✅ **Write Review** (after login)
- Login → Click detail resto → "Tulis Review" → Submit

✅ **Delete Own Review**
- Login → Click detail resto → Find my review → Delete

❌ **Cannot create/edit/delete restaurant**
- Buttons hidden untuk user biasa
- URL access akan di-block dengan error message

---

## 🎯 Test Scenarios

### Scenario 1: Admin CRUD
```
1. Login admin@gmail.com
2. Click "+ Tambah" di list
3. Isi & Submit → Resto baru muncul
4. Detail resto → Click "Edit" → Update
5. Detail resto → Click "Hapus" → Konfirmasi
```

### Scenario 2: User Review
```
1. Buka aplikasi (no login)
2. Search/lihat restaurant
3. Click "Login"
4. Login test@example.com
5. Click detail resto
6. Scroll "Tulis Review"
7. Fill rating & comment → Submit
8. Review muncul, rating terupdate
```

### Scenario 3: Security
```
1. Logout
2. Coba akses /restaurants/create
3. → Redirect ke login
4. Login dengan test@example.com (user biasa)
5. Coba akses /restaurants/1/edit
6. → Redirect dengan error "Harus login sebagai admin"
```

---

## 🔗 Key URLs

```
Public:
GET  http://localhost:8000/restaurants
GET  http://localhost:8000/restaurants/search?search=nasi
GET  http://localhost:8000/restaurants/1

Admin Only:
GET  http://localhost:8000/restaurants/create
GET  http://localhost:8000/restaurants/1/edit
POST http://localhost:8000/restaurants
PUT  http://localhost:8000/restaurants/1
DELETE http://localhost:8000/restaurants/1

Auth Only:
POST http://localhost:8000/restaurants/1/reviews
DELETE http://localhost:8000/reviews/1
```

---

## ✅ Status

**Database:** ✅ Seeded dengan admin, user, dan 1 test restaurant
**Routes:** ✅ Protected dengan middleware
**Views:** ✅ Admin buttons hanya untuk admin
**Security:** ✅ CSRF, authorization checks implemented

**READY TO USE! 🚀**
