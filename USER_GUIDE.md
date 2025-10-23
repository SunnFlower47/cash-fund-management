# 👥 User Guide

## Overview

Panduan lengkap untuk menggunakan Cash Management System. Dokumen ini mencakup semua fitur dan cara penggunaannya untuk kedua role: **Bendahara** dan **Anggota**.

## 🏠 Dashboard

### Bendahara Dashboard
Dashboard Bendahara menampilkan informasi komprehensif tentang sistem kas:

#### Cash Balance
- **Total Saldo**: Saldo kas terkini
- **Pemasukan**: Total pemasukan bulan ini
- **Pengeluaran**: Total pengeluaran bulan ini
- **Net Balance**: Saldo bersih

#### Recent Transactions
- **5 Transaksi Terbaru**: Daftar transaksi terbaru
- **Status**: Pending, Approved, atau Rejected
- **Amount**: Jumlah transaksi dengan format currency
- **User**: Nama user yang melakukan transaksi

#### Payment Proofs Status
- **Pending**: Jumlah bukti pembayaran yang menunggu review
- **Approved**: Jumlah bukti pembayaran yang sudah disetujui
- **Rejected**: Jumlah bukti pembayaran yang ditolak

#### Weekly Payment Statistics
- **Total Paid**: Total pembayaran mingguan yang sudah dibayar
- **Total Unpaid**: Total pembayaran mingguan yang belum dibayar
- **Pending Count**: Jumlah pembayaran yang pending

### Anggota Dashboard
Dashboard Anggota menampilkan informasi personal:

#### Cash Balance
- **Total Saldo**: Saldo kas terkini (read-only)

#### Personal Transactions
- **5 Transaksi Terbaru**: Transaksi personal
- **Status**: Status transaksi
- **Amount**: Jumlah dengan format currency

#### Weekly Payment Status
- **Current Month**: Status pembayaran bulan ini
- **Paid Weeks**: Minggu yang sudah dibayar
- **Unpaid Weeks**: Minggu yang belum dibayar
- **Total Amount**: Total yang harus dibayar

#### Payment Proofs Status
- **Pending**: Bukti pembayaran yang menunggu review
- **Approved**: Bukti pembayaran yang sudah disetujui
- **Rejected**: Bukti pembayaran yang ditolak

## 💰 Weekly Payment System

### Generate Weekly Bills (Bendahara)

#### Step 1: Access Menu
1. Klik menu **"Kas Mingguan"** di sidebar
2. Klik tombol **"Generate Tagihan"**

#### Step 2: Configure Generation
1. **Pilih Tahun**: Pilih tahun untuk generate tagihan
2. **Pilih Bulan**: Pilih bulan (otomatis update berdasarkan tahun)
3. **Pilih Minggu**: Pilih minggu spesifik atau "Generate Semua Minggu"
4. **Jumlah Bayar**: Set jumlah pembayaran per minggu (default: 10,000)
5. Klik **"Generate Tagihan"**

#### Step 3: Review Generated Bills
- Sistem akan generate tagihan untuk semua anggota
- Tagihan akan muncul di daftar dengan status "Unpaid"
- Setiap anggota akan mendapat notifikasi

### Track Payment Status (Anggota)

#### View Payment Status
1. Klik menu **"Kas Mingguan"** di sidebar
2. Lihat status pembayaran per minggu:
   - **Paid**: Sudah dibayar (hijau)
   - **Unpaid**: Belum dibayar (merah)
   - **Amount**: Jumlah yang harus dibayar

#### Payment Status Details
- **Week Period**: Periode minggu (e.g., "Januari 2025 - Minggu 1")
- **Amount**: Jumlah pembayaran
- **Status**: Status pembayaran
- **Paid Date**: Tanggal pembayaran (jika sudah dibayar)

### Approve Payments (Bendahara)

#### Individual Approval
1. Klik tombol **"Setujui"** pada pembayaran yang ingin disetujui
2. Masukkan **Jumlah Bayar** yang diterima
3. Klik **"Setujui Pembayaran"**
4. Sistem akan otomatis menghitung berapa minggu yang dibayar

#### Bulk Approval
1. Klik tombol **"Approve Pembayaran"**
2. Pilih **Anggota** yang akan disetujui
3. Masukkan **Jumlah Bayar** total
4. Klik **"Setujui Pembayaran"**
5. Sistem akan otomatis menghitung dan update status

#### Mark as Unpaid
1. Klik tombol **"Mark Unpaid"** pada pembayaran yang sudah dibayar
2. Konfirmasi aksi
3. Status akan berubah menjadi "Unpaid"
4. Saldo kas akan dikurangi

## 📄 Payment Proof Management

### Upload Payment Proof (Anggota)

#### Step 1: Access Upload
1. Klik menu **"Bukti Pembayaran"** di sidebar
2. Klik tombol **"Upload Bukti Pembayaran"**

#### Step 2: Upload File
1. **Pilih File**: Klik "Choose File" dan pilih file
2. **Supported Formats**: JPG, PNG, PDF (max 10MB)
3. **Preview**: File akan ditampilkan preview
4. Klik **"Upload Bukti Pembayaran"**

#### Step 3: Confirmation
- File berhasil diupload
- Status: "Pending"
- Menunggu review dari Bendahara

### Review Payment Proofs (Bendahara)

#### View All Proofs
1. Klik menu **"Bukti Pembayaran"** di sidebar
2. Lihat daftar semua bukti pembayaran
3. Filter berdasarkan status: All, Pending, Approved, Rejected

#### Review Individual Proof
1. Klik **"Lihat Detail"** pada bukti pembayaran
2. **Preview File**: Lihat file yang diupload
3. **File Information**: Nama file, ukuran, tipe
4. **User Information**: Nama user yang upload

#### Approve Payment Proof
1. Klik tombol **"Setujui"**
2. **Note**: Ini hanya mengubah status bukti pembayaran
3. **Cash Update**: Gunakan menu "Kas Mingguan" untuk update saldo
4. Klik **"Setujui"**

#### Reject Payment Proof
1. Klik tombol **"Tolak"**
2. Masukkan **Alasan Penolakan**
3. Klik **"Tolak"**
4. User akan mendapat notifikasi penolakan

### Edit Payment Proof (Anggota)

#### Edit Uploaded Proof
1. Klik menu **"Bukti Pembayaran"** di sidebar
2. Klik **"Edit"** pada bukti pembayaran yang ingin diedit
3. **Upload File Baru**: Pilih file baru (opsional)
4. **Current File**: Lihat file saat ini
5. Klik **"Update Bukti Pembayaran"**

#### Delete Payment Proof
1. Klik **"Hapus"** pada bukti pembayaran
2. Konfirmasi penghapusan
3. File akan dihapus dari sistem

## 📊 Transaction Management

### View Transactions

#### All Transactions (Bendahara)
1. Klik menu **"Log Kas"** di sidebar
2. **Filter Options**:
   - **Type**: Income, Expense, All
   - **Status**: Pending, Approved, Rejected, All
   - **User Name**: Cari berdasarkan nama user
3. **Pagination**: Navigasi halaman
4. **Export**: Export ke Excel

#### Personal Transactions (Anggota)
1. Klik menu **"Log Kas"** di sidebar
2. Lihat transaksi personal
3. **Filter**: Berdasarkan type dan status
4. **Search**: Cari transaksi tertentu

### Transaction Details

#### View Transaction
1. Klik **"Lihat Detail"** pada transaksi
2. **Transaction Information**:
   - ID Transaksi
   - Jenis (Income/Expense)
   - Jumlah
   - Status
   - Deskripsi
   - Tanggal
   - Dibuat Oleh
   - Sumber
   - Catatan

#### Edit Transaction
1. Klik **"Edit"** pada transaksi
2. **Edit Fields**:
   - Jenis Transaksi
   - Jumlah
   - Deskripsi
   - Sumber (Opsional)
   - Catatan (Opsional)
3. Klik **"Update Transaksi"**

#### Delete Transaction
1. Klik **"Hapus"** pada transaksi
2. Konfirmasi penghapusan
3. Transaksi akan dihapus dari sistem

## 👥 User Management (Bendahara)

### View All Users
1. Klik menu **"Settings"** di sidebar
2. Lihat daftar semua user
3. **User Information**:
   - Nama
   - Email
   - Role
   - Tanggal Dibuat

### Create New User
1. Klik tombol **"Tambah User"**
2. **Fill Form**:
   - Nama
   - Email
   - Password
   - Role (Bendahara/Anggota)
3. Klik **"Tambah User"**

### Edit User
1. Klik **"Edit"** pada user yang ingin diedit
2. **Edit Fields**:
   - Nama
   - Email
   - Role
3. Klik **"Update User"**

### Reset Password
1. Klik **"Reset Password"** pada user
2. Masukkan **Password Baru**
3. Konfirmasi password
4. Klik **"Update Password"**

### Delete User
1. Klik **"Hapus"** pada user
2. Konfirmasi penghapusan
3. User akan dihapus dari sistem

## 🔍 Audit Log (Bendahara)

### View Audit Logs
1. Klik menu **"Settings"** di sidebar
2. Klik **"Audit Log"**
3. **Filter Options**:
   - **Action**: CREATE, UPDATE, DELETE, LOGIN, LOGOUT
   - **Model Type**: User, Transaction, PaymentProof, WeeklyPayment
   - **User**: Filter berdasarkan user
   - **Date Range**: Filter berdasarkan tanggal
4. **Pagination**: Navigasi halaman

### Audit Log Details
1. Klik **"Lihat Detail"** pada audit log
2. **Log Information**:
   - Action
   - Model Type
   - User
   - IP Address
   - User Agent
   - Description
   - Old Values
   - New Values
   - Timestamp

## 📤 Data Export

### Export All Data
1. Klik menu **"Settings"** di sidebar
2. Klik **"Backup & Export"**
3. Klik **"Export Semua Data"**
4. File Excel akan didownload

### Export Specific Data
1. **Export Transactions**: Export data transaksi
2. **Export Weekly Payments**: Export data pembayaran mingguan
3. **Export Payment Proofs**: Export data bukti pembayaran
4. **Export Kas Mingguan**: Export data kas mingguan

### Database Backup
1. Klik **"Backup Database"**
2. File backup akan didownload
3. **Backup includes**:
   - Database structure
   - All data
   - User accounts
   - File references

## 🌙 Dark Mode

### Toggle Dark Mode
1. Klik tombol **Dark Mode** di navbar
2. **Light Mode**: Background putih, text hitam
3. **Dark Mode**: Background gelap, text putih
4. **Preference**: Tersimpan otomatis

### Dark Mode Features
- **Consistent Design**: Semua komponen mendukung dark mode
- **Smooth Transition**: Animasi smooth saat switch
- **Auto Save**: Preference tersimpan di browser
- **Mobile Support**: Dark mode di mobile juga

## 📱 Mobile Usage

### Mobile Navigation
- **Bottom Navigation**: 4 menu utama di bawah
- **Touch Friendly**: Tombol besar untuk mobile
- **Responsive**: Layout menyesuaikan ukuran layar

### Mobile Features
- **Swipe Navigation**: Navigasi dengan swipe
- **Touch Gestures**: Pinch to zoom, tap to select
- **Mobile Forms**: Form yang mobile-friendly
- **Mobile Tables**: Tabel responsive dengan card view

## 🔧 Profile Settings

### Edit Profile
1. Klik **Profile** di navbar
2. Klik **"Profile"**
3. **Edit Fields**:
   - Nama
   - Email
4. Klik **"Save"**

### Change Password
1. Klik **Profile** di navbar
2. Klik **"Profile"**
3. **Change Password Section**:
   - Current Password
   - New Password
   - Confirm Password
4. Klik **"Save"**

### Delete Account
1. Klik **Profile** di navbar
2. Klik **"Profile"**
3. Scroll ke **"Delete Account"**
4. Klik **"Delete Account"**
5. Masukkan password untuk konfirmasi
6. Klik **"Delete Account"**

## 🚨 Troubleshooting

### Common Issues

#### Login Issues
- **Wrong Password**: Pastikan password benar
- **Account Locked**: Hubungi administrator
- **Email Not Found**: Pastikan email benar

#### Upload Issues
- **File Too Large**: Maksimal 10MB
- **Wrong Format**: Gunakan JPG, PNG, atau PDF
- **Upload Failed**: Coba lagi atau hubungi support

#### Display Issues
- **Dark Mode Not Working**: Refresh halaman
- **Mobile Layout**: Pastikan menggunakan browser terbaru
- **Loading Issues**: Clear cache browser

### Contact Support
- **Email**: support@cashmanagement.com
- **Phone**: +62-xxx-xxxx-xxxx
- **Documentation**: Lihat dokumentasi lengkap
- **FAQ**: Frequently Asked Questions

## 📚 Best Practices

### For Bendahara
1. **Regular Review**: Review bukti pembayaran secara berkala
2. **Backup Data**: Lakukan backup data secara rutin
3. **User Management**: Kelola user dengan baik
4. **Audit Trail**: Monitor audit log secara berkala

### For Anggota
1. **Timely Payment**: Bayar tepat waktu
2. **Clear Proof**: Upload bukti pembayaran yang jelas
3. **Update Profile**: Update profil secara berkala
4. **Secure Account**: Jaga keamanan akun

### General Tips
1. **Regular Login**: Login secara berkala
2. **Clear Cache**: Clear cache browser secara berkala
3. **Update Browser**: Gunakan browser terbaru
4. **Secure Connection**: Gunakan koneksi yang aman

---

**User Guide** - Complete user manual for Cash Management System. 👥✨
