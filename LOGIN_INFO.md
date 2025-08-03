# 🔑 **INFO LOGIN APLIKASI INVENTARIS**

## 👥 **Default Users & Credentials** ✅ VERIFIED WORKING

| Role | Email | Password | Status | Akses |
|------|-------|----------|--------|-------|
| **👑 Admin** | `admin@inventaris.com` | `admin123` | ✅ TESTED | Full access ke semua fitur |
| **👔 Manager** | `manager@inventaris.com` | `manager123` | ✅ TESTED | Kelola barang + transaksi |
| **👥 Staff** | `staff@inventaris.com` | `staff123` | ✅ TESTED | View data + transaksi stok |
| **👤 User** | `user@inventaris.com` | `user123` | ✅ TESTED | View data saja (read-only) |

## 🚀 **Cara Test Role:**

### **1. Login sebagai Admin:**
- Email: `admin@inventaris.com`
- Password: `admin123`
- ✅ Bisa akses semua menu termasuk "Manajemen Pengguna"

### **2. Login sebagai Manager:**
- Email: `manager@inventaris.com` 
- Password: `manager123`
- ✅ Bisa tambah/edit barang, transaksi stok, lihat laporan
- ❌ Tidak bisa kelola kategori atau user

### **3. Login sebagai Staff:**
- Email: `staff@inventaris.com`
- Password: `staff123`
- ✅ Bisa lihat data dan input transaksi stok
- ❌ Tidak bisa edit/tambah barang atau kategori

### **4. Login sebagai User:**
- Email: `user@inventaris.com`
- Password: `user123`
- ✅ Hanya bisa lihat data dan laporan
- ❌ Tidak bisa edit atau transaksi apapun

## 🔧 **Troubleshooting:**

### **Masalah: Tidak bisa login dengan credentials di atas**
**Solusi:** Test dulu credentials dengan command:
```bash
php artisan test:login [email] [password]
```

### **Masalah: Role tampil "Pengguna" padahal sudah login**
**Solusi:** User belum punya role yang sesuai. Gunakan command:
```bash
php artisan user:assign-role [email] [role]
```

### **Masalah: Lupa password**
**Solusi:** Reset password dengan command:
```bash
php artisan user:reset-password [email] [password-baru]
```

### **Masalah: Menu tidak tampil sesuai role**
**Solusi:** Clear cache dan pastikan role sudah benar:
```bash
php artisan cache:clear
php artisan config:clear
```

### **Masalah: Permission denied**
**Solusi:** Pastikan user sudah login dengan role yang sesuai

## 🛠️ **Utility Commands:**

```bash
# Lihat semua user dan role mereka
php artisan user:list

# Test login credentials 
php artisan test:login email@example.com password

# Assign role ke user
php artisan user:assign-role email@example.com admin

# Reset password user
php artisan user:reset-password email@example.com newpassword
```

## 🆕 **Membuat User Baru:**

### **Via Web Interface (Recommended):**
1. Login sebagai Admin
2. Buka "Manajemen Pengguna"
3. Klik "Tambah Pengguna Baru"
4. Pilih role yang sesuai

### **Via Command:**
```bash
# Lihat semua user
php artisan user:list

# Assign role ke user
php artisan user:assign-role user@example.com staff
```

## 📊 **Permission Summary:**

| Fitur | Admin | Manager | Staff | User |
|-------|-------|---------|-------|------|
| Dashboard | ✅ | ✅ | ✅ | ✅ |
| View Kategori | ✅ | ✅ | ✅ | ✅ |
| Kelola Kategori | ✅ | ❌ | ❌ | ❌ |
| View Barang | ✅ | ✅ | ✅ | ✅ |
| Tambah/Edit Barang | ✅ | ✅ | ❌ | ❌ |
| Delete Barang | ✅ | ❌ | ❌ | ❌ |
| Transaksi Stok | ✅ | ✅ | ✅ | ❌ |
| View Laporan | ✅ | ✅ | ✅ | ✅ |
| Kelola User | ✅ | ❌ | ❌ | ❌ |

---

**💡 TIP:** Untuk testing yang efektif, buka aplikasi di beberapa browser/tab berbeda dan login dengan role yang berbeda untuk melihat perbedaan aksesnya!