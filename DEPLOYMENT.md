# 🚀 Deployment Guide - Rotiku Bakery

## ✅ Konfigurasi Sudah Selesai

Project ini sudah dikonfigurasi untuk deploy ke **Vercel** dengan **Supabase** sebagai database dan storage.

---

## 📋 Prerequisites

1. ✅ Akun Supabase (sudah setup)
2. ✅ Akun Vercel
3. ✅ GitHub Repository (https://github.com/ntshap2nd/rotiku.git)
4. ✅ Supabase Project ID: `qujnddqrsmswnzrkbgos`

---

## 🗄️ Setup Supabase Storage

### 1. Buat Storage Bucket untuk Gambar Produk

1. Buka Supabase Dashboard: https://supabase.com/dashboard/project/qujnddqrsmswnzrkbgos
2. Klik **Storage** di sidebar
3. Klik **New Bucket**
4. Isi form:
   - **Name**: `produk-images`
   - **Public bucket**: ✅ **Centang ini** (agar gambar bisa diakses public)
5. Klik **Create Bucket**

### 2. Set Bucket Policies (Optional - untuk lebih aman)

Jika ingin kontrol akses lebih ketat:

```sql
-- Allow public read access
create policy "Public Access"
on storage.objects for select
using ( bucket_id = 'produk-images' );

-- Allow authenticated users to upload
create policy "Authenticated users can upload"
on storage.objects for insert
with check ( bucket_id = 'produk-images' AND auth.role() = 'authenticated' );

-- Allow authenticated users to update their uploads
create policy "Users can update own files"
on storage.objects for update
using ( bucket_id = 'produk-images' AND auth.role() = 'authenticated' );

-- Allow authenticated users to delete
create policy "Users can delete files"
on storage.objects for delete
using ( bucket_id = 'produk-images' AND auth.role() = 'authenticated' );
```

---

## 🔧 Vercel Deployment

### 1. Push ke GitHub

```bash
git add .
git commit -m "Setup Supabase integration for Vercel deployment"
git push origin main
```

### 2. Import Project di Vercel

1. Login ke https://vercel.com
2. Klik **Add New...** → **Project**
3. Import repository: `ntshap2nd/rotiku`
4. Klik **Import**

### 3. Configure Project Settings

#### **Framework Preset:**
- Pilih: **Other**

#### **Build & Output Settings:**

```
Build Command:
composer install --optimize-autoloader --no-dev && php artisan config:cache && php artisan route:cache && php artisan view:cache && npm install && npm run build

Install Command:
(leave empty or: composer install)

Output Directory:
(leave empty)

Development Command:
php artisan serve
```

### 4. Environment Variables

Tambahkan environment variables berikut di Vercel Dashboard:

#### **🔴 REQUIRED - App Configuration**

```env
APP_NAME=RotikuBakery
APP_ENV=production
APP_KEY=base64:XXgqustpT5l7cDAzMwVzfGeo7tBLKtztHSfr33/JObs=
APP_DEBUG=false
APP_URL=https://your-project.vercel.app
```

⚠️ **Note**: Ganti `APP_URL` dengan URL Vercel Anda setelah deploy pertama!

#### **🔴 REQUIRED - Database (Supabase PostgreSQL)**

```env
DB_CONNECTION=pgsql
DB_HOST=db.qujnddqrsmswnzrkbgos.supabase.co
DB_PORT=5432
DB_DATABASE=postgres
DB_USERNAME=postgres
DB_PASSWORD=mB6jXG4BkW3hfHuU
```

#### **🔴 REQUIRED - Storage (Supabase Storage)**

```env
FILESYSTEM_DISK=s3
AWS_BUCKET=produk-images
AWS_DEFAULT_REGION=us-east-1
AWS_ENDPOINT=https://qujnddqrsmswnzrkbgos.supabase.co/storage/v1/s3
AWS_URL=https://qujnddqrsmswnzrkbgos.supabase.co/storage/v1/object/public
AWS_USE_PATH_STYLE_ENDPOINT=true
```

⚠️ **Note**: `AWS_ACCESS_KEY_ID` dan `AWS_SECRET_ACCESS_KEY` kosongkan dulu (Supabase Storage menggunakan JWT auth via service key)

#### **🔴 REQUIRED - Supabase API**

```env
SUPABASE_URL=https://qujnddqrsmswnzrkbgos.supabase.co
SUPABASE_KEY=sb_publishable_dimYBvptzlsDX8wcHCmYKQ_YZvmChok
SUPABASE_SERVICE_KEY=eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6InF1am5kZHFyc21zd256cmtiZ29zIiwicm9sZSI6InNlcnZpY2Vfcm9sZSIsImlhdCI6MTc2NzA4NzA2MiwiZXhwIjoyMDgyNjYzMDYyfQ.24f2D1a1QNHPvqUC_ZHIkaglVpkviQUMvIJmT5YSrvg
```

#### **🟡 OPTIONAL - Session & Cache**

```env
SESSION_DRIVER=database
SESSION_LIFETIME=120
CACHE_DRIVER=database
CACHE_STORE=database
```

#### **🟡 OPTIONAL - Queue & Mail**

```env
QUEUE_CONNECTION=database
LOG_CHANNEL=stderr
MAIL_MAILER=log
```

#### **🟢 SYSTEM**

```env
VERCEL=1
```

### 5. Deploy!

1. Klik **Deploy**
2. Tunggu build process (~5-10 menit)
3. Jika berhasil, akan muncul URL: `https://your-project.vercel.app`

---

## 🧪 Testing After Deployment

### 1. Test Homepage
```
https://your-project.vercel.app
```

### 2. Test Admin Login
```
https://your-project.vercel.app/admin
```

**Default Admin:**
- Email: (sesuai seeder)
- Password: (sesuai seeder)

### 3. Test CRUD Products
1. Login ke admin panel
2. Create new product dengan upload gambar
3. Verify gambar tersimpan di Supabase Storage
4. Test Update & Delete

### 4. Check Logs (jika ada error)
- Vercel Dashboard → Your Project → Deployments → View Function Logs
- Atau: Runtime Logs untuk real-time errors

---

## 🔧 Troubleshooting

### ❌ Error: "could not connect to server"

**Solusi:**
1. Check `DB_HOST`, `DB_PASSWORD` di Environment Variables
2. Pastikan Supabase project tidak di-pause (free tier)
3. Test koneksi local: `php artisan migrate`

### ❌ Error: File upload failed

**Solusi:**
1. Pastikan bucket `produk-images` sudah dibuat di Supabase
2. Pastikan bucket di-set sebagai **public**
3. Check `AWS_ENDPOINT` dan `AWS_URL` benar
4. Pastikan `FILESYSTEM_DISK=s3` di environment variables

### ❌ Error: 504 Gateway Timeout

**Solusi:**
1. Database migration terlalu lama
2. Run migration manual di local: `php artisan migrate --force`
3. Atau gunakan Supabase SQL Editor untuk run migration manual

### ❌ Error: Class 'Storage' not found

**Solusi:**
```bash
composer require league/flysystem-aws-s3-v3 "^3.0"
```

### ❌ Error: Session not persisting

**Solusi:**
1. Pastikan `SESSION_DRIVER=database`
2. Pastikan table `sessions` sudah ada (migration)
3. Check `APP_KEY` sudah di-set

---

## 📊 Database Schema

Tables yang dibuat saat migration:

- ✅ `users` - Admin users
- ✅ `produks` - Products (nama, kategori, gambar, stok, harga, aktif)
- ✅ `orders` - Orders (produk_id, nama_pelanggan, qty, total_harga, status)
- ✅ `sessions` - User sessions
- ✅ `cache` - Cache storage
- ✅ `jobs` - Queue jobs

---

## 🔒 Security Notes

1. ⚠️ **NEVER** commit `.env` file ke Git
2. ✅ Service Role Key hanya untuk backend
3. ✅ Publishable Key aman untuk frontend
4. ✅ Enable Row Level Security (RLS) di Supabase untuk production
5. ✅ Use Connection Pooler untuk better performance

---

## 🎯 Post-Deployment Checklist

- [ ] Migration berhasil di Supabase ✅
- [ ] Storage bucket `produk-images` sudah dibuat ✅
- [ ] Environment variables di Vercel sudah lengkap ✅
- [ ] Deploy berhasil (status: Ready) ⏳
- [ ] Test admin login ⏳
- [ ] Test CRUD products ⏳
- [ ] Test file upload gambar ⏳
- [ ] Update `APP_URL` di Vercel dengan URL production ⏳
- [ ] Test di mobile browser ⏳

---

## 📚 Resources

- **Vercel Dashboard**: https://vercel.com/dashboard
- **Supabase Dashboard**: https://supabase.com/dashboard/project/qujnddqrsmswnzrkbgos
- **GitHub Repo**: https://github.com/ntshap2nd/rotiku
- **Supabase Docs**: https://supabase.com/docs
- **Laravel Docs**: https://laravel.com/docs

---

## 🆘 Support

Jika ada masalah deployment:
1. Check Vercel deployment logs
2. Check Supabase database logs
3. Test koneksi local terlebih dahulu
4. Pastikan semua environment variables sudah benar

---

**Deployment Prepared by**: GitHub Copilot  
**Date**: December 30, 2025  
**Status**: ✅ Ready for deployment
