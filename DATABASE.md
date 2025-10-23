# 🗄️ Database Documentation

## Overview

Cash Management System menggunakan MySQL sebagai database utama dengan struktur yang dirancang untuk mendukung sistem manajemen kas yang komprehensif, termasuk tracking pembayaran mingguan, bukti pembayaran, dan audit logging.

## 📊 Database Schema

### Core Tables

#### 1. Users Table
**Purpose**: Menyimpan informasi user dan authentication data

```sql
CREATE TABLE users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    email_verified_at TIMESTAMP NULL,
    password VARCHAR(255) NOT NULL,
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

**Indexes**:
- `PRIMARY KEY (id)`
- `UNIQUE KEY users_email_unique (email)`
- `KEY users_email_index (email)`

**Relationships**:
- `hasMany` transactions
- `hasMany` payment_proofs
- `hasMany` weekly_payments
- `hasMany` audit_logs
- `belongsToMany` roles

#### 2. Roles Table
**Purpose**: Menyimpan definisi role dalam sistem

```sql
CREATE TABLE roles (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    guard_name VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

**Indexes**:
- `PRIMARY KEY (id)`
- `UNIQUE KEY roles_name_guard_name_unique (name, guard_name)`

**Default Roles**:
- `bendahara` - Administrator dengan akses penuh
- `anggota` - Member dengan akses terbatas

#### 3. Permissions Table
**Purpose**: Menyimpan definisi permission dalam sistem

```sql
CREATE TABLE permissions (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    guard_name VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

**Indexes**:
- `PRIMARY KEY (id)`
- `UNIQUE KEY permissions_name_guard_name_unique (name, guard_name)`

**Available Permissions**:
- `manage_transactions` - Kelola transaksi
- `manage_payment_proofs` - Kelola bukti pembayaran
- `manage_weekly_payments` - Kelola pembayaran mingguan
- `view_weekly_payments` - Lihat pembayaran mingguan
- `view_audit_logs` - Lihat audit log
- `manage_settings` - Kelola settings
- `view_settings` - Lihat settings
- `edit_payment_proofs` - Edit bukti pembayaran
- `delete_payment_proofs` - Hapus bukti pembayaran
- `view_transactions` - Lihat transaksi

#### 4. Weekly Payments Table
**Purpose**: Tracking pembayaran mingguan anggota

```sql
CREATE TABLE weekly_payments (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    week_period VARCHAR(255) NOT NULL,
    user_id BIGINT UNSIGNED NOT NULL,
    amount DECIMAL(15,2) NOT NULL DEFAULT 0.00,
    is_paid BOOLEAN NOT NULL DEFAULT FALSE,
    paid_at TIMESTAMP NULL,
    notes TEXT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    UNIQUE KEY weekly_payments_week_period_user_id_unique (week_period, user_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```

**Indexes**:
- `PRIMARY KEY (id)`
- `UNIQUE KEY weekly_payments_week_period_user_id_unique (week_period, user_id)`
- `KEY weekly_payments_user_id_foreign (user_id)`

**Week Period Format**: `YYYY-MM-WX` (e.g., `2025-01-W1`)

#### 5. Transactions Table
**Purpose**: Mencatat semua transaksi keuangan

```sql
CREATE TABLE transactions (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    type ENUM('income', 'expense') NOT NULL,
    amount DECIMAL(15,2) NOT NULL,
    description TEXT NOT NULL,
    source VARCHAR(255) NULL,
    source_id VARCHAR(255) NULL,
    status ENUM('pending', 'approved', 'rejected') NOT NULL DEFAULT 'pending',
    approved_at TIMESTAMP NULL,
    approver_id BIGINT UNSIGNED NULL,
    notes TEXT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (approver_id) REFERENCES users(id) ON DELETE SET NULL
);
```

**Indexes**:
- `PRIMARY KEY (id)`
- `KEY transactions_user_id_foreign (user_id)`
- `KEY transactions_approver_id_foreign (approver_id)`
- `KEY transactions_type_index (type)`
- `KEY transactions_status_index (status)`
- `KEY transactions_created_at_index (created_at)`

**Transaction Types**:
- `income` - Pemasukan kas
- `expense` - Pengeluaran kas

**Status Types**:
- `pending` - Menunggu persetujuan
- `approved` - Disetujui
- `rejected` - Ditolak

#### 6. Payment Proofs Table
**Purpose**: Menyimpan bukti pembayaran yang diupload

```sql
CREATE TABLE payment_proofs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    file_name VARCHAR(255) NOT NULL,
    file_path VARCHAR(255) NOT NULL,
    file_size BIGINT UNSIGNED NOT NULL,
    file_type VARCHAR(255) NOT NULL,
    status ENUM('pending', 'approved', 'rejected') NOT NULL DEFAULT 'pending',
    reviewed_at TIMESTAMP NULL,
    reviewer_id BIGINT UNSIGNED NULL,
    review_notes TEXT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (reviewer_id) REFERENCES users(id) ON DELETE SET NULL
);
```

**Indexes**:
- `PRIMARY KEY (id)`
- `KEY payment_proofs_user_id_foreign (user_id)`
- `KEY payment_proofs_reviewer_id_foreign (reviewer_id)`
- `KEY payment_proofs_status_index (status)`

**Supported File Types**:
- Images: JPG, JPEG, PNG, GIF
- Documents: PDF

#### 7. Cash Balance Table
**Purpose**: Menyimpan saldo kas terkini

```sql
CREATE TABLE cash_balance (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    balance DECIMAL(15,2) NOT NULL DEFAULT 0.00,
    updated_at TIMESTAMP NULL
);
```

**Note**: Hanya satu record yang aktif dalam tabel ini.

#### 8. Audit Logs Table
**Purpose**: Mencatat semua aktivitas user untuk audit

```sql
CREATE TABLE audit_logs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    action VARCHAR(255) NOT NULL,
    model_type VARCHAR(255) NULL,
    model_id BIGINT UNSIGNED NULL,
    user_id BIGINT UNSIGNED NOT NULL,
    old_values JSON NULL,
    new_values JSON NULL,
    ip_address VARCHAR(45) NULL,
    user_agent TEXT NULL,
    description TEXT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```

**Indexes**:
- `PRIMARY KEY (id)`
- `KEY audit_logs_user_id_foreign (user_id)`
- `KEY audit_logs_action_model_index (action, model_type, model_id)`
- `KEY audit_logs_user_created_index (user_id, created_at)`

**Action Types**:
- `CREATE` - Membuat data baru
- `UPDATE` - Mengubah data
- `DELETE` - Menghapus data
- `LOGIN` - User login
- `LOGOUT` - User logout
- `APPROVE` - Menyetujui
- `REJECT` - Menolak

### Pivot Tables

#### 9. Model Has Roles Table
**Purpose**: Menghubungkan users dengan roles

```sql
CREATE TABLE model_has_roles (
    role_id BIGINT UNSIGNED NOT NULL,
    model_type VARCHAR(255) NOT NULL,
    model_id BIGINT UNSIGNED NOT NULL,
    PRIMARY KEY (role_id, model_id, model_type),
    FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE
);
```

#### 10. Model Has Permissions Table
**Purpose**: Menghubungkan roles dengan permissions

```sql
CREATE TABLE model_has_permissions (
    permission_id BIGINT UNSIGNED NOT NULL,
    model_type VARCHAR(255) NOT NULL,
    model_id BIGINT UNSIGNED NOT NULL,
    PRIMARY KEY (permission_id, model_id, model_type),
    FOREIGN KEY (permission_id) REFERENCES permissions(id) ON DELETE CASCADE
);
```

#### 11. Role Has Permissions Table
**Purpose**: Menghubungkan roles dengan permissions

```sql
CREATE TABLE role_has_permissions (
    permission_id BIGINT UNSIGNED NOT NULL,
    role_id BIGINT UNSIGNED NOT NULL,
    PRIMARY KEY (permission_id, role_id),
    FOREIGN KEY (permission_id) REFERENCES permissions(id) ON DELETE CASCADE,
    FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE
);
```

## 🔗 Relationships

### User Relationships
```php
// User Model
public function transactions()
{
    return $this->hasMany(Transaction::class);
}

public function paymentProofs()
{
    return $this->hasMany(PaymentProof::class);
}

public function weeklyPayments()
{
    return $this->hasMany(WeeklyPayment::class);
}

public function auditLogs()
{
    return $this->hasMany(AuditLog::class);
}

public function roles()
{
    return $this->belongsToMany(Role::class, 'model_has_roles');
}
```

### Transaction Relationships
```php
// Transaction Model
public function user()
{
    return $this->belongsTo(User::class);
}

public function approver()
{
    return $this->belongsTo(User::class, 'approver_id');
}

public function paymentProof()
{
    return $this->morphOne(PaymentProof::class, 'source');
}
```

### Weekly Payment Relationships
```php
// WeeklyPayment Model
public function user()
{
    return $this->belongsTo(User::class);
}
```

### Payment Proof Relationships
```php
// PaymentProof Model
public function user()
{
    return $this->belongsTo(User::class);
}

public function reviewer()
{
    return $this->belongsTo(User::class, 'reviewer_id');
}

public function transactions()
{
    return $this->morphMany(Transaction::class, 'source');
}
```

### Audit Log Relationships
```php
// AuditLog Model
public function user()
{
    return $this->belongsTo(User::class);
}

public function model()
{
    return $this->morphTo();
}
```

## 📈 Database Optimization

### Indexes Strategy
1. **Primary Keys**: Auto-increment BIGINT UNSIGNED
2. **Foreign Keys**: Indexed for join performance
3. **Search Fields**: Indexed for query optimization
4. **Composite Indexes**: For complex queries

### Query Optimization
1. **Eager Loading**: Prevent N+1 queries
2. **Select Specific**: Only select needed columns
3. **Pagination**: Limit result sets
4. **Caching**: Cache frequently accessed data

### Performance Monitoring
```sql
-- Check slow queries
SHOW PROCESSLIST;

-- Analyze query performance
EXPLAIN SELECT * FROM transactions WHERE user_id = 1;

-- Check index usage
SHOW INDEX FROM transactions;
```

## 🔒 Security Considerations

### Data Protection
1. **Password Hashing**: Laravel's bcrypt
2. **CSRF Protection**: Token-based protection
3. **SQL Injection**: Parameterized queries
4. **XSS Prevention**: Input sanitization

### Access Control
1. **Role-Based**: Permission-based access
2. **Data Isolation**: User-specific data access
3. **Audit Trail**: Complete activity logging
4. **File Security**: Secure file storage

### Backup Strategy
1. **Daily Backups**: Automated database backups
2. **File Backups**: Payment proof file backups
3. **Recovery Testing**: Regular restore tests
4. **Offsite Storage**: Remote backup storage

## 📊 Data Flow

### Weekly Payment Flow
1. **Generate Bills**: Bendahara creates weekly bills
2. **Payment Tracking**: Members track payment status
3. **Proof Upload**: Members upload payment proofs
4. **Review Process**: Bendahara reviews and approves
5. **Balance Update**: Cash balance automatically updated

### Transaction Flow
1. **Create Transaction**: User creates transaction
2. **Status Pending**: Transaction awaits approval
3. **Approval Process**: Bendahara approves/rejects
4. **Balance Update**: Cash balance updated accordingly
5. **Audit Log**: All actions logged

### Audit Flow
1. **Action Triggered**: User performs action
2. **Log Creation**: System creates audit log
3. **Data Capture**: Old/new values captured
4. **Metadata**: IP, user agent, timestamp recorded
5. **Storage**: Log stored in database

## 🧪 Testing Data

### Sample Data Structure
```sql
-- Sample Users
INSERT INTO users (name, email, password) VALUES
('Bendahara', 'bendahara@example.com', '$2y$10$...'),
('Anggota 1', 'anggota1@example.com', '$2y$10$...'),
('Anggota 2', 'anggota2@example.com', '$2y$10$...');

-- Sample Weekly Payments
INSERT INTO weekly_payments (week_period, user_id, amount, is_paid) VALUES
('2025-01-W1', 2, 10000.00, TRUE),
('2025-01-W2', 2, 10000.00, FALSE),
('2025-01-W1', 3, 10000.00, TRUE);

-- Sample Transactions
INSERT INTO transactions (user_id, type, amount, description, status) VALUES
(1, 'income', 50000.00, 'Pembayaran mingguan', 'approved'),
(1, 'expense', 20000.00, 'Pengeluaran operasional', 'approved');
```

## 🔧 Maintenance

### Regular Maintenance Tasks
1. **Index Optimization**: Analyze and optimize indexes
2. **Data Cleanup**: Remove old audit logs
3. **Backup Verification**: Test backup integrity
4. **Performance Monitoring**: Monitor query performance

### Database Health Checks
```sql
-- Check table sizes
SELECT 
    table_name,
    ROUND(((data_length + index_length) / 1024 / 1024), 2) AS 'Size (MB)'
FROM information_schema.tables
WHERE table_schema = 'cash_management'
ORDER BY (data_length + index_length) DESC;

-- Check slow queries
SELECT * FROM mysql.slow_log 
WHERE start_time > DATE_SUB(NOW(), INTERVAL 1 DAY);

-- Check table fragmentation
SELECT 
    table_name,
    data_free,
    ROUND((data_free / 1024 / 1024), 2) AS 'Fragmentation (MB)'
FROM information_schema.tables
WHERE table_schema = 'cash_management' 
AND data_free > 0;
```

## 📋 Migration History

### Version 1.0.0
- Initial database structure
- User management system
- Role and permission system
- Weekly payment tracking
- Transaction management
- Payment proof system
- Audit logging system
- Cash balance management

### Future Enhancements
- Multi-currency support
- Advanced reporting
- API endpoints
- Real-time notifications
- Advanced analytics

---

**Database Documentation** - Comprehensive guide to Cash Management System database structure and relationships. 🗄️✨
