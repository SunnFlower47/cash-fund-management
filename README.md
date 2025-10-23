# 💰 Cash Management System

Sistem manajemen kas yang modern dan user-friendly untuk mengelola keuangan organisasi dengan fitur lengkap untuk tracking pembayaran mingguan, bukti pembayaran, dan audit log.

## 🌟 Fitur Utama

### 👥 Manajemen User & Role
- **Multi-role System**: Bendahara dan Anggota dengan permission berbeda
- **Profile Management**: Edit profil dan ganti password
- **User Settings**: Kelola user dan role dengan mudah

### 💵 Weekly Payment System
- **Generate Bills**: Bendahara dapat generate tagihan mingguan
- **Payment Tracking**: Tracking pembayaran per minggu dan bulan
- **Bulk Approval**: Approve pembayaran dalam jumlah besar
- **Payment Status**: Status pembayaran real-time

### 📄 Payment Proof Management
- **Upload Proof**: Anggota upload bukti pembayaran
- **Review System**: Bendahara review dan approve/reject
- **File Management**: Support image dan PDF files
- **Status Tracking**: Real-time status update

### 📊 Transaction Log
- **Complete Log**: Semua transaksi kas tercatat
- **Filter System**: Filter berdasarkan type, status, user, tanggal
- **Export Excel**: Export data ke Excel dengan styling
- **Search Function**: Cari transaksi dengan mudah

### 🔍 Audit Log System
- **Activity Tracking**: Semua aktivitas user tercatat
- **Change History**: History perubahan data
- **User Activity**: Tracking login, logout, dan actions
- **Detailed Logs**: IP address, user agent, timestamps

### 📱 Progressive Web App (PWA)
- **Installable**: Dapat diinstall di device
- **Offline Support**: Bekerja offline dengan service worker
- **Mobile Friendly**: Responsive design untuk semua device
- **Fast Loading**: Optimized performance

### 🌙 Dark Mode
- **Theme Toggle**: Switch antara light dan dark mode
- **Consistent Design**: Semua komponen mendukung dark mode
- **Auto Save**: Preference tersimpan di localStorage
- **Smooth Transition**: Animasi smooth saat switch theme

## 🚀 Technology Stack

### Backend
- **Laravel 10**: PHP Framework
- **MySQL**: Database
- **Spatie Laravel Permission**: Role & Permission Management
- **Spatie Laravel Backup**: Database Backup
- **Maatwebsite Excel**: Excel Export

### Frontend
- **Tailwind CSS**: Utility-first CSS framework
- **Alpine.js**: Lightweight JavaScript framework
- **SweetAlert2**: Beautiful alerts and notifications
- **PWA**: Progressive Web App features

### Features
- **Responsive Design**: Mobile-first approach
- **Dark Mode**: Complete dark theme support
- **Loading Animations**: Smooth loading indicators
- **Form Validation**: Client & server-side validation
- **File Upload**: Secure file handling
- **Excel Export**: Styled Excel reports

## 📋 Requirements

### System Requirements
- PHP >= 8.1
- MySQL >= 8.0
- Composer
- Node.js & NPM (untuk asset compilation)

### PHP Extensions
- BCMath
- Ctype
- cURL
- DOM
- Fileinfo
- JSON
- Mbstring
- OpenSSL
- PCRE
- PDO
- Tokenizer
- XML

## 🛠️ Installation

### 1. Clone Repository
```bash
git clone <repository-url>
cd cash-management
```

### 2. Install Dependencies
```bash
composer install
npm install
```

### 3. Environment Setup
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Database Configuration
Edit `.env` file:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=cash_management
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 5. Database Migration & Seeding
```bash
php artisan migrate
php artisan db:seed
```

### 6. Build Assets
```bash
npm run build
```

### 7. Start Development Server
```bash
php artisan serve
```

## 👤 Default Users

### Bendahara (Admin)
- **Email**: bendahara@example.com
- **Password**: password
- **Permissions**: Full access to all features

### Anggota (Member)
- **Email**: anggota@example.com
- **Password**: password
- **Permissions**: Limited access to member features

## 📊 Database Schema

### Core Tables

#### Users Table
```sql
- id (Primary Key)
- name (String)
- email (String, Unique)
- email_verified_at (Timestamp)
- password (String)
- remember_token (String)
- created_at (Timestamp)
- updated_at (Timestamp)
```

#### Roles Table
```sql
- id (Primary Key)
- name (String, Unique)
- guard_name (String)
- created_at (Timestamp)
- updated_at (Timestamp)
```

#### Permissions Table
```sql
- id (Primary Key)
- name (String, Unique)
- guard_name (String)
- created_at (Timestamp)
- updated_at (Timestamp)
```

#### Weekly Payments Table
```sql
- id (Primary Key)
- week_period (String, Unique with user_id)
- user_id (Foreign Key to users)
- amount (Decimal)
- is_paid (Boolean)
- paid_at (Timestamp, Nullable)
- notes (Text, Nullable)
- created_at (Timestamp)
- updated_at (Timestamp)
```

#### Transactions Table
```sql
- id (Primary Key)
- user_id (Foreign Key to users)
- type (Enum: income, expense)
- amount (Decimal)
- description (Text)
- source (String, Nullable)
- source_id (String, Nullable)
- status (Enum: pending, approved, rejected)
- approved_at (Timestamp, Nullable)
- approver_id (Foreign Key to users, Nullable)
- notes (Text, Nullable)
- created_at (Timestamp)
- updated_at (Timestamp)
```

#### Payment Proofs Table
```sql
- id (Primary Key)
- user_id (Foreign Key to users)
- file_name (String)
- file_path (String)
- file_size (Integer)
- file_type (String)
- status (Enum: pending, approved, rejected)
- reviewed_at (Timestamp, Nullable)
- reviewer_id (Foreign Key to users, Nullable)
- review_notes (Text, Nullable)
- created_at (Timestamp)
- updated_at (Timestamp)
```

#### Cash Balance Table
```sql
- id (Primary Key)
- balance (Decimal)
- updated_at (Timestamp)
```

#### Audit Logs Table
```sql
- id (Primary Key)
- action (String)
- model_type (String, Nullable)
- model_id (Integer, Nullable)
- user_id (Foreign Key to users)
- old_values (JSON, Nullable)
- new_values (JSON, Nullable)
- ip_address (String, Nullable)
- user_agent (String, Nullable)
- description (Text, Nullable)
- created_at (Timestamp)
- updated_at (Timestamp)
```

## 🔐 Permissions System

### Bendahara Permissions
- `manage_transactions` - Kelola transaksi
- `manage_payment_proofs` - Kelola bukti pembayaran
- `manage_weekly_payments` - Kelola pembayaran mingguan
- `view_weekly_payments` - Lihat pembayaran mingguan
- `view_audit_logs` - Lihat audit log
- `manage_settings` - Kelola settings
- `view_settings` - Lihat settings

### Anggota Permissions
- `view_transactions` - Lihat transaksi
- `edit_payment_proofs` - Edit bukti pembayaran sendiri
- `delete_payment_proofs` - Hapus bukti pembayaran sendiri
- `view_weekly_payments` - Lihat pembayaran mingguan
- `view_settings` - Lihat settings

## 📱 PWA Features

### Manifest Configuration
- **App Name**: Cash Management System
- **Short Name**: CashApp
- **Theme Color**: #10b981 (Emerald)
- **Background Color**: #0f172a (Slate)
- **Display**: standalone
- **Orientation**: portrait

### Service Worker
- **Cache Strategy**: Cache-first for static assets
- **Network-first**: For dynamic content
- **Offline Support**: Basic offline functionality
- **Icon Caching**: Optimized icon loading

## 🎨 UI/UX Features

### Design System
- **Color Palette**: Emerald & Teal primary colors
- **Typography**: Inter font family
- **Spacing**: Consistent 4px grid system
- **Shadows**: Layered shadow system
- **Borders**: Rounded corners (8px, 12px, 16px)

### Components
- **Cards**: Glass effect with backdrop blur
- **Buttons**: Gradient backgrounds with hover effects
- **Forms**: Consistent styling with focus states
- **Modals**: Responsive with backdrop blur
- **Tables**: Responsive with mobile card view
- **Navigation**: Mobile-first with smooth transitions

### Dark Mode
- **Theme Toggle**: Smooth transition between themes
- **Color Scheme**: Slate-based dark palette
- **Consistency**: All components support dark mode
- **Persistence**: Theme preference saved in localStorage

## 📈 Performance Optimizations

### Frontend
- **Asset Optimization**: Minified CSS/JS
- **Image Optimization**: WebP format support
- **Lazy Loading**: Images loaded on demand
- **Service Worker**: Aggressive caching strategy
- **PWA**: Offline-first approach

### Backend
- **Database Indexing**: Optimized queries
- **Eager Loading**: Reduced N+1 queries
- **Caching**: Route and view caching
- **File Storage**: Efficient file handling
- **Export Optimization**: Memory-efficient Excel generation

## 🔧 Development

### Code Structure
```
app/
├── Http/Controllers/     # Application controllers
├── Models/              # Eloquent models
├── Exports/             # Excel export classes
├── Http/Middleware/     # Custom middleware
└── Providers/           # Service providers

resources/
├── views/               # Blade templates
├── css/                 # Tailwind CSS
└── js/                  # JavaScript files

database/
├── migrations/          # Database migrations
├── seeders/            # Database seeders
└── factories/          # Model factories
```

### Key Controllers
- `DashboardController` - Dashboard logic
- `TransactionController` - Transaction management
- `PaymentProofController` - Payment proof handling
- `WeeklyPaymentController` - Weekly payment system
- `SettingsController` - User and role management
- `AuditLogController` - Audit log viewing
- `BackupController` - Data backup and export

### Key Models
- `User` - User management with roles
- `Transaction` - Financial transactions
- `PaymentProof` - Payment proof files
- `WeeklyPayment` - Weekly payment tracking
- `CashBalance` - Cash balance management
- `AuditLog` - Activity logging

## 🧪 Testing

### Running Tests
```bash
# Run all tests
php artisan test

# Run specific test
php artisan test --filter=TransactionTest

# Run with coverage
php artisan test --coverage
```

### Test Structure
```
tests/
├── Feature/             # Feature tests
├── Unit/               # Unit tests
└── TestCase.php        # Base test case
```

## 📦 Deployment

### Production Setup
1. **Environment Configuration**
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

2. **Database Migration**
   ```bash
   php artisan migrate --force
   ```

3. **Asset Compilation**
   ```bash
   npm run build
   ```

4. **Permission Setup**
   ```bash
   php artisan db:seed --class=ProductionPermissionsSeeder
   ```

### Server Requirements
- **PHP**: 8.1 or higher
- **MySQL**: 8.0 or higher
- **Web Server**: Apache/Nginx
- **SSL**: Required for PWA features
- **Storage**: Sufficient space for file uploads

## 🔒 Security Features

### Authentication
- **Laravel Sanctum**: API authentication
- **CSRF Protection**: Cross-site request forgery protection
- **XSS Protection**: Cross-site scripting prevention
- **SQL Injection**: Parameterized queries

### File Security
- **File Validation**: Type and size validation
- **Secure Storage**: Files stored outside web root
- **Access Control**: Role-based file access
- **Virus Scanning**: File content validation

### Data Protection
- **Encryption**: Sensitive data encryption
- **Audit Logging**: All actions logged
- **Access Control**: Role-based permissions
- **Data Backup**: Regular automated backups

## 📞 Support

### Documentation
- **API Documentation**: Available in `/docs` endpoint
- **User Manual**: Comprehensive user guide
- **Developer Guide**: Technical documentation
- **Troubleshooting**: Common issues and solutions

### Contact
- **Email**: support@cashmanagement.com
- **Documentation**: [GitHub Wiki](https://github.com/your-repo/wiki)
- **Issues**: [GitHub Issues](https://github.com/your-repo/issues)

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 🤝 Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📝 Changelog

### Version 1.0.0
- Initial release
- Complete cash management system
- PWA support
- Dark mode implementation
- Mobile-responsive design
- Audit logging system
- Excel export functionality
- Weekly payment tracking
- Payment proof management

---

**Cash Management System** - Modern, secure, and user-friendly financial management solution. 💰✨