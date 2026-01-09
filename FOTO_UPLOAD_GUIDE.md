# 📸 Cara Upload & Display Foto Restaurant

## ✅ Setup Sudah Lengkap

Semua setup untuk upload dan display foto sudah siap:

### 1. Storage Symlink ✅
```
public/storage → storage/app/public
```
Sudah dibuat, jadi file di `storage/app/public` bisa diakses via HTTP

### 2. Folder untuk Upload ✅
```
storage/app/public/restaurants/
```
Sudah dibuat, siap untuk menyimpan foto

### 3. Controller Sudah Handle Upload ✅
```php
if ($request->hasFile('image')) {
    $validated['image'] = $request->file('image')->store('restaurants', 'public');
}
```

### 4. Views Sudah Display Foto ✅
```blade
<img src="{{ asset('storage/' . $restaurant->image) }}" />
```

---

## 🚀 Cara Menggunakan

### **1. Upload Foto saat Tambah Restaurant (Admin)**

```
1. Login admin@gmail.com
2. Click "+ Tambah" di halaman restaurants
3. Isi form:
   - Nama: Nasi Kuning Enak
   - Deskripsi: ...
   - Alamat: ...
   - Telepon: ...
   - Tipe Masakan: ...
   
4. ⭐ PENTING: Di section "Gambar"
   - Click "Pilih File" / "Browse"
   - Pilih foto dari komputer
   - Format: JPG, PNG, GIF
   - Max size: 2MB
   
5. Click "Simpan"
6. ✅ Foto akan langsung muncul di:
   - Halaman list restaurants (card)
   - Halaman detail restaurant
```

### **2. Upload Foto saat Edit Restaurant (Admin)**

```
1. Login admin@gmail.com
2. Click detail restaurant
3. Click tombol "Edit"
4. Di form edit:
   - Lihat gambar lama (jika ada preview)
   - Untuk ganti gambar:
     - Click "Pilih File"
     - Pilih foto baru
   
5. Click "Update"
6. ✅ Foto baru akan replace foto lama
```

---

## 📁 File Path

Saat upload, file akan disimpan di:
```
storage/app/public/restaurants/{nama-file-random}.jpg
```

Untuk display di view, gunakan:
```blade
<img src="{{ asset('storage/' . $restaurant->image) }}" />
```

Contoh URL yang dihasilkan:
```
http://localhost:8000/storage/restaurants/1704575342_nasi_kuning.jpg
```

---

## 🔍 Troubleshooting

### Foto tidak muncul di halaman?

**1. Cek apakah file sudah tersimpan**
```bash
# Di terminal, cek folder
ls storage/app/public/restaurants/
```

**2. Refresh browser**
- Ctrl+F5 (clear cache dan refresh)

**3. Cek HTML di browser**
- Right click → "Inspect"
- Lihat source gambar di tag `<img>`
- Pastikan path-nya benar

**4. Cek permissions**
```bash
# Pastikan folder punya write permission
chmod -R 755 storage/app/public
```

### Ukuran file terlalu besar?
- Max size: 2MB
- Compress gambar dulu sebelum upload
- Gunakan online tool seperti tinypng.com

### Format tidak support?
- Support: JPG, PNG, GIF
- Tidak support: WEBP, BMP, TIFF
- Konvert ke JPG/PNG dulu

---

## ✨ Tips

1. **Gunakan gambar berkualitas**
   - Minimal: 300x300px
   - Ideal: 500x500px atau lebih
   - Aspect ratio: square atau landscape

2. **Nama file jangan pake spasi**
   - ✅ nasi_kuning.jpg
   - ❌ nasi kuning.jpg

3. **Jangan upload gambar terlalu besar**
   - Ideal: 100-500KB
   - Max: 2MB

4. **Backup gambar original**
   - Edit/delete restaurant akan delete gambar juga
   - Pastikan punya backup

---

## 📸 Testing Checklist

- [ ] Upload foto saat tambah restaurant
- [ ] Foto muncul di halaman list (card)
- [ ] Foto muncul di halaman detail
- [ ] Edit restaurant dan ganti foto
- [ ] Foto lama ter-replace dengan foto baru
- [ ] Hapus restaurant (foto juga terhapus)
- [ ] Try upload foto > 2MB (akan reject)
- [ ] Try upload file bukan gambar (akan reject)

---

**Status: ✅ SIAP UPLOAD FOTO**

Semua setup sudah benar. Langsung bisa upload foto saat tambah/edit restaurant!
