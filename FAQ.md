# ❓ Frequently Asked Questions (FAQ)

## Overview

Daftar pertanyaan yang sering diajukan tentang Cash Management System beserta jawabannya.

## 🚀 Installation & Setup

### Q: Bagaimana cara install Cash Management System?
**A**: Ikuti langkah-langkah berikut:
1. Clone repository: `git clone <repository-url>`
2. Install dependencies: `composer install && npm install`
3. Copy environment: `cp .env.example .env`
4. Generate key: `php artisan key:generate`
5. Setup database: `php artisan migrate --seed`
6. Build assets: `npm run build`
7. Start server: `php artisan serve`

### Q: Apa saja requirements untuk menjalankan sistem?
**A**: Requirements minimal:
- PHP 8.1+
- MySQL 8.0+
- Composer
- Node.js 16+ dan NPM
- Web server (Apache/Nginx)

### Q: Bagaimana cara setup database?
**A**: 
1. Buat database MySQL
2. Update konfigurasi di `.env`
3. Jalankan migration: `php artisan migrate`
4. Seed data: `php artisan db:seed`

### Q: User default apa saja yang tersedia?
**A**: 
- **Bendahara**: bendahara@example.com / password
- **Anggota**: anggota@example.com / password

## 👥 User Management

### Q: Bagaimana cara menambah user baru?
**A**: 
1. Login sebagai Bendahara
2. Klik menu "Settings"
3. Klik "Tambah User"
4. Isi form dan pilih role
5. Klik "Tambah User"

### Q: Apa perbedaan role Bendahara dan Anggota?
**A**: 
- **Bendahara**: Akses penuh ke semua fitur
- **Anggota**: Akses terbatas untuk fitur member

### Q: Bagaimana cara reset password user?
**A**: 
1. Login sebagai Bendahara
2. Klik menu "Settings"
3. Klik "Reset Password" pada user
4. Masukkan password baru
5. Klik "Update Password"

### Q: Bagaimana cara mengubah role user?
**A**: 
1. Login sebagai Bendahara
2. Klik menu "Settings"
3. Klik "Edit" pada user
4. Pilih role baru
5. Klik "Update User"

## 💰 Weekly Payment System

### Q: Bagaimana cara generate tagihan mingguan?
**A**: 
1. Login sebagai Bendahara
2. Klik menu "Kas Mingguan"
3. Klik "Generate Tagihan"
4. Pilih tahun, bulan, dan minggu
5. Set jumlah pembayaran
6. Klik "Generate Tagihan"

### Q: Bagaimana cara approve pembayaran mingguan?
**A**: 
1. Login sebagai Bendahara
2. Klik menu "Kas Mingguan"
3. Klik "Approve Pembayaran"
4. Pilih anggota dan masukkan jumlah
5. Klik "Setujui Pembayaran"

### Q: Bagaimana cara melihat status pembayaran?
**A**: 
1. Login sebagai Anggota
2. Klik menu "Kas Mingguan"
3. Lihat status pembayaran per minggu
4. Status: Paid (hijau) atau Unpaid (merah)

### Q: Bagaimana cara mark unpaid pembayaran?
**A**: 
1. Login sebagai Bendahara
2. Klik menu "Kas Mingguan"
3. Klik "Mark Unpaid" pada pembayaran
4. Konfirmasi aksi
5. Status akan berubah menjadi "Unpaid"

## 📄 Payment Proof Management

### Q: Bagaimana cara upload bukti pembayaran?
**A**: 
1. Login sebagai Anggota
2. Klik menu "Bukti Pembayaran"
3. Klik "Upload Bukti Pembayaran"
4. Pilih file (JPG, PNG, PDF)
5. Klik "Upload Bukti Pembayaran"

### Q: File apa saja yang bisa diupload?
**A**: 
- **Images**: JPG, JPEG, PNG
- **Documents**: PDF
- **Maximum Size**: 10MB

### Q: Bagaimana cara review bukti pembayaran?
**A**: 
1. Login sebagai Bendahara
2. Klik menu "Bukti Pembayaran"
3. Klik "Lihat Detail" pada bukti
4. Review file yang diupload
5. Klik "Setujui" atau "Tolak"

### Q: Bagaimana cara edit bukti pembayaran?
**A**: 
1. Login sebagai Anggota
2. Klik menu "Bukti Pembayaran"
3. Klik "Edit" pada bukti
4. Upload file baru (opsional)
5. Klik "Update Bukti Pembayaran"

## 📊 Transaction Management

### Q: Bagaimana cara melihat semua transaksi?
**A**: 
1. Login sebagai Bendahara
2. Klik menu "Log Kas"
3. Lihat daftar semua transaksi
4. Gunakan filter untuk mencari transaksi tertentu

### Q: Bagaimana cara filter transaksi?
**A**: 
1. Klik menu "Log Kas"
2. Gunakan filter:
   - **Type**: Income, Expense, All
   - **Status**: Pending, Approved, Rejected, All
   - **User Name**: Cari berdasarkan nama
3. Klik "Filter"

### Q: Bagaimana cara export data transaksi?
**A**: 
1. Klik menu "Settings"
2. Klik "Backup & Export"
3. Klik "Export Transactions"
4. File Excel akan didownload

### Q: Bagaimana cara edit transaksi?
**A**: 
1. Klik menu "Log Kas"
2. Klik "Edit" pada transaksi
3. Edit informasi yang diperlukan
4. Klik "Update Transaksi"

## 🔍 Audit Log

### Q: Bagaimana cara melihat audit log?
**A**: 
1. Login sebagai Bendahara
2. Klik menu "Settings"
3. Klik "Audit Log"
4. Lihat semua aktivitas user
5. Gunakan filter untuk mencari aktivitas tertentu

### Q: Apa saja yang dicatat di audit log?
**A**: 
- **User Actions**: Login, logout, create, update, delete
- **Model Changes**: Perubahan data
- **IP Address**: Alamat IP user
- **User Agent**: Browser dan device
- **Timestamps**: Waktu aktivitas

### Q: Bagaimana cara filter audit log?
**A**: 
1. Klik menu "Audit Log"
2. Gunakan filter:
   - **Action**: CREATE, UPDATE, DELETE, LOGIN, LOGOUT
   - **Model Type**: User, Transaction, PaymentProof
   - **User**: Pilih user tertentu
   - **Date Range**: Filter berdasarkan tanggal

## 📱 Mobile & PWA

### Q: Apakah sistem bisa diakses di mobile?
**A**: Ya, sistem fully responsive dan mobile-friendly dengan:
- Touch-friendly interface
- Mobile navigation
- Responsive forms dan tables
- Mobile-optimized layouts

### Q: Bagaimana cara install sebagai PWA?
**A**: 
1. Buka sistem di browser mobile
2. Klik tombol "Install" yang muncul
3. Konfirmasi instalasi
4. Aplikasi akan terinstall di device

### Q: Apakah PWA bisa offline?
**A**: Ya, PWA memiliki service worker yang memungkinkan:
- Caching static assets
- Offline functionality
- Background sync
- Push notifications (future)

## 🌙 Dark Mode

### Q: Bagaimana cara mengaktifkan dark mode?
**A**: 
1. Klik tombol dark mode di navbar
2. Theme akan berubah otomatis
3. Preference tersimpan di browser

### Q: Apakah dark mode tersimpan?
**A**: Ya, preference dark mode tersimpan di localStorage browser dan akan diingat saat login berikutnya.

### Q: Apakah semua halaman mendukung dark mode?
**A**: Ya, semua halaman dan komponen mendukung dark mode dengan styling yang konsisten.

## 📤 Export & Backup

### Q: Bagaimana cara export data ke Excel?
**A**: 
1. Klik menu "Settings"
2. Klik "Backup & Export"
3. Pilih jenis export:
   - Export Semua Data
   - Export Transactions
   - Export Weekly Payments
   - Export Payment Proofs
4. File Excel akan didownload

### Q: Bagaimana cara backup database?
**A**: 
1. Klik menu "Settings"
2. Klik "Backup & Export"
3. Klik "Backup Database"
4. File backup akan didownload

### Q: Apa saja yang termasuk dalam export?
**A**: 
- **Transactions**: Semua data transaksi
- **Weekly Payments**: Data pembayaran mingguan
- **Payment Proofs**: Data bukti pembayaran
- **Users**: Data user dan role
- **Summary**: Ringkasan dan total

## 🔧 Technical Issues

### Q: Error "Method Not Allowed" saat login?
**A**: 
1. Clear cache: `php artisan cache:clear`
2. Clear config: `php artisan config:clear`
3. Restart server: `php artisan serve`

### Q: File upload gagal?
**A**: 
1. Cek ukuran file (max 10MB)
2. Cek format file (JPG, PNG, PDF)
3. Cek permission folder storage
4. Cek konfigurasi PHP upload

### Q: Database connection error?
**A**: 
1. Cek konfigurasi database di `.env`
2. Cek koneksi MySQL
3. Cek user dan password database
4. Cek database exists

### Q: Dark mode tidak berfungsi?
**A**: 
1. Clear browser cache
2. Refresh halaman
3. Cek JavaScript enabled
4. Cek localStorage support

## 🚨 Troubleshooting

### Q: Halaman tidak load?
**A**: 
1. Cek koneksi internet
2. Clear browser cache
3. Restart server
4. Cek error logs

### Q: Form tidak submit?
**A**: 
1. Cek JavaScript enabled
2. Cek CSRF token
3. Cek validation errors
4. Cek network connection

### Q: Data tidak tersimpan?
**A**: 
1. Cek database connection
2. Cek permission database
3. Cek validation rules
4. Cek error logs

### Q: Export tidak berfungsi?
**A**: 
1. Cek PHP memory limit
2. Cek file permission
3. Cek disk space
4. Cek PHP extensions

## 📞 Support

### Q: Bagaimana cara mendapat bantuan?
**A**: 
1. **Documentation**: Baca dokumentasi lengkap
2. **GitHub Issues**: Laporkan bug di GitHub
3. **Email**: support@cashmanagement.com
4. **Community**: Diskusi di GitHub

### Q: Bagaimana cara melaporkan bug?
**A**: 
1. Buka GitHub Issues
2. Pilih template "Bug Report"
3. Isi informasi lengkap
4. Sertakan screenshot jika ada

### Q: Bagaimana cara request fitur baru?
**A**: 
1. Buka GitHub Issues
2. Pilih template "Feature Request"
3. Jelaskan fitur yang diinginkan
4. Berikan use case dan benefit

## 🔒 Security

### Q: Apakah data aman?
**A**: Ya, sistem memiliki berbagai fitur keamanan:
- Password hashing dengan bcrypt
- CSRF protection
- XSS prevention
- SQL injection protection
- File upload security
- Role-based access control

### Q: Bagaimana cara backup data?
**A**: 
1. **Database Backup**: Klik "Backup Database"
2. **File Backup**: Backup folder storage
3. **Automated Backup**: Setup cron job
4. **Cloud Backup**: Upload ke cloud storage

### Q: Bagaimana cara update sistem?
**A**: 
1. Backup data terlebih dahulu
2. Pull latest changes: `git pull`
3. Update dependencies: `composer install`
4. Run migrations: `php artisan migrate`
5. Clear cache: `php artisan optimize`

## 📚 Documentation

### Q: Di mana dokumentasi lengkap?
**A**: Dokumentasi tersedia di:
- **README.md**: Overview dan installation
- **DATABASE.md**: Database schema
- **API.md**: API documentation
- **DEPLOYMENT.md**: Production deployment
- **USER_GUIDE.md**: User manual
- **TECHNICAL_SPEC.md**: Technical details

### Q: Bagaimana cara contribute?
**A**: 
1. Fork repository
2. Create feature branch
3. Make changes
4. Write tests
5. Submit pull request

### Q: Bagaimana cara report security issue?
**A**: 
1. **DO NOT** buat issue publik
2. Kirim email ke security@cashmanagement.com
3. Berikan detail kerentanan
4. Tunggu response dari security team

---

**FAQ** - Frequently Asked Questions for Cash Management System. ❓✨
