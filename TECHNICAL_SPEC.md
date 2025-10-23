# 🔧 Technical Specification

## Overview

Dokumentasi teknis lengkap untuk Cash Management System, mencakup arsitektur, komponen, dan implementasi detail.

## 🏗️ System Architecture

### High-Level Architecture
```
┌─────────────────┐    ┌─────────────────┐    ┌─────────────────┐
│   Frontend      │    │   Backend       │    │   Database      │
│   (Blade + JS)  │◄──►│   (Laravel)     │◄──►│   (MySQL)       │
└─────────────────┘    └─────────────────┘    └─────────────────┘
         │                       │                       │
         │                       │                       │
         ▼                       ▼                       ▼
┌─────────────────┐    ┌─────────────────┐    ┌─────────────────┐
│   PWA Features  │    │   File Storage  │    │   Redis Cache   │
│   (Service      │    │   (Local/Cloud) │    │   (Optional)    │
│    Worker)      │    │                 │    │                 │
└─────────────────┘    └─────────────────┘    └─────────────────┘
```

### Component Architecture
```
┌─────────────────────────────────────────────────────────────┐
│                    Presentation Layer                       │
├─────────────────────────────────────────────────────────────┤
│  Blade Templates  │  Tailwind CSS  │  Alpine.js  │  PWA    │
├─────────────────────────────────────────────────────────────┤
│                    Application Layer                        │
├─────────────────────────────────────────────────────────────┤
│  Controllers  │  Middleware  │  Services  │  Exports       │
├─────────────────────────────────────────────────────────────┤
│                    Business Logic Layer                    │
├─────────────────────────────────────────────────────────────┤
│  Models  │  Relationships  │  Scopes  │  Accessors        │
├─────────────────────────────────────────────────────────────┤
│                    Data Access Layer                       │
├─────────────────────────────────────────────────────────────┤
│  Eloquent ORM  │  Query Builder  │  Migrations  │  Seeders │
├─────────────────────────────────────────────────────────────┤
│                    Infrastructure Layer                     │
├─────────────────────────────────────────────────────────────┤
│  MySQL  │  Redis  │  File System  │  Queue  │  Cache       │
└─────────────────────────────────────────────────────────────┘
```

## 🎨 Frontend Architecture

### Technology Stack
- **Template Engine**: Laravel Blade
- **CSS Framework**: Tailwind CSS 3.x
- **JavaScript**: Alpine.js 3.x
- **Icons**: Custom PNG icons
- **PWA**: Service Worker + Manifest

### Component Structure
```
resources/views/
├── layouts/
│   ├── app.blade.php          # Main layout
│   └── navigation.blade.php   # Navigation component
├── components/
│   ├── nav-link.blade.php     # Navigation link
│   ├── text-input.blade.php   # Text input
│   ├── input-label.blade.php  # Input label
│   ├── input-error.blade.php  # Error display
│   └── dropdown.blade.php     # Dropdown component
├── dashboard/
│   ├── bendahara.blade.php    # Bendahara dashboard
│   └── anggota.blade.php      # Anggota dashboard
├── transactions/
│   ├── index.blade.php        # Transaction list
│   ├── show.blade.php         # Transaction detail
│   └── edit.blade.php         # Transaction edit
├── payment-proofs/
│   ├── index.blade.php        # Payment proof list
│   ├── show.blade.php         # Payment proof detail
│   ├── edit.blade.php         # Payment proof edit
│   └── create.blade.php       # Payment proof create
├── weekly-payments/
│   └── index.blade.php        # Weekly payment management
├── settings/
│   ├── index.blade.php        # User management
│   ├── create.blade.php       # Create user
│   ├── edit.blade.php         # Edit user
│   ├── roles.blade.php        # Role management
│   └── create-role.blade.php  # Create role
└── auth/
    ├── login.blade.php         # Login page
    └── forgot-password.blade.php # Forgot password
```

### CSS Architecture
```css
/* Tailwind Configuration */
module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
  ],
  darkMode: 'class',
  theme: {
    extend: {
      colors: {
        primary: {
          50: '#ecfdf5',
          500: '#10b981',
          600: '#059669',
          700: '#047857',
        }
      }
    }
  }
}
```

### JavaScript Architecture
```javascript
// Alpine.js Components
Alpine.data('dropdown', () => ({
  open: false,
  toggle() { this.open = !this.open },
  close() { this.open = false }
}))

// Dark Mode Toggle
Alpine.data('darkMode', () => ({
  init() {
    this.setTheme(localStorage.getItem('theme') || 'dark')
  },
  toggle() {
    this.setTheme(this.isDark ? 'light' : 'dark')
  },
  setTheme(theme) {
    localStorage.setItem('theme', theme)
    document.documentElement.classList.toggle('dark', theme === 'dark')
  }
}))
```

## 🗄️ Backend Architecture

### Laravel Structure
```
app/
├── Http/
│   ├── Controllers/
│   │   ├── DashboardController.php      # Dashboard logic
│   │   ├── TransactionController.php   # Transaction management
│   │   ├── PaymentProofController.php   # Payment proof handling
│   │   ├── WeeklyPaymentController.php # Weekly payment system
│   │   ├── SettingsController.php      # User/role management
│   │   ├── AuditLogController.php      # Audit log viewing
│   │   └── BackupController.php         # Data export/backup
│   ├── Middleware/
│   │   ├── Authenticate.php            # Authentication
│   │   └── Authorize.php               # Authorization
│   └── Requests/
│       ├── TransactionRequest.php      # Transaction validation
│       └── PaymentProofRequest.php      # Payment proof validation
├── Models/
│   ├── User.php                        # User model
│   ├── Transaction.php                 # Transaction model
│   ├── PaymentProof.php                # Payment proof model
│   ├── WeeklyPayment.php               # Weekly payment model
│   ├── CashBalance.php                 # Cash balance model
│   └── AuditLog.php                    # Audit log model
├── Exports/
│   ├── TransactionsExport.php          # Transaction Excel export
│   └── WeeklyPaymentsExport.php        # Weekly payment Excel export
└── Services/
    ├── PaymentService.php               # Payment processing
    └── AuditService.php                 # Audit logging
```

### Model Relationships
```php
// User Model
class User extends Authenticatable
{
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
}

// Transaction Model
class Transaction extends Model
{
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
}
```

### Controller Architecture
```php
// Base Controller Pattern
abstract class Controller
{
    protected function authorize($ability, $arguments = [])
    {
        return Gate::authorize($ability, $arguments);
    }
    
    protected function audit($action, $model = null, $oldValues = null, $newValues = null)
    {
        return AuditLogController::log($action, $model, $oldValues, $newValues);
    }
}

// Transaction Controller
class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('view_transactions');
        
        $query = Transaction::with(['user', 'approver']);
        
        // Apply filters
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('user_name')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->user_name . '%');
            });
        }
        
        $transactions = $query->latest()->paginate(20);
        
        return view('transactions.index', compact('transactions'));
    }
}
```

## 🗄️ Database Architecture

### Database Schema
```sql
-- Users Table
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

-- Transactions Table
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

-- Weekly Payments Table
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

### Indexing Strategy
```sql
-- Primary Indexes
ALTER TABLE users ADD PRIMARY KEY (id);
ALTER TABLE transactions ADD PRIMARY KEY (id);
ALTER TABLE weekly_payments ADD PRIMARY KEY (id);

-- Foreign Key Indexes
ALTER TABLE transactions ADD INDEX transactions_user_id_foreign (user_id);
ALTER TABLE transactions ADD INDEX transactions_approver_id_foreign (approver_id);
ALTER TABLE weekly_payments ADD INDEX weekly_payments_user_id_foreign (user_id);

-- Performance Indexes
ALTER TABLE transactions ADD INDEX transactions_type_index (type);
ALTER TABLE transactions ADD INDEX transactions_status_index (status);
ALTER TABLE transactions ADD INDEX transactions_created_at_index (created_at);
ALTER TABLE weekly_payments ADD INDEX weekly_payments_week_period_index (week_period);
ALTER TABLE weekly_payments ADD INDEX weekly_payments_is_paid_index (is_paid);
```

### Query Optimization
```php
// Eager Loading to prevent N+1 queries
$transactions = Transaction::with(['user', 'approver'])
    ->where('type', 'income')
    ->latest()
    ->paginate(20);

// Specific column selection
$users = User::select(['id', 'name', 'email'])
    ->with('roles:id,name')
    ->get();

// Query scopes for reusability
class Transaction extends Model
{
    public function scopeIncome($query)
    {
        return $query->where('type', 'income');
    }
    
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }
    
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
}
```

## 🔐 Security Architecture

### Authentication
```php
// Laravel Sanctum for API authentication
class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }
        
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.'
        ]);
    }
}
```

### Authorization
```php
// Role-based permissions
class TransactionController extends Controller
{
    public function index()
    {
        $this->authorize('view_transactions');
        // Controller logic
    }
    
    public function store(Request $request)
    {
        $this->authorize('manage_transactions');
        // Controller logic
    }
}

// Policy-based authorization
class TransactionPolicy
{
    public function view(User $user, Transaction $transaction)
    {
        return $user->isBendahara() || $transaction->user_id === $user->id;
    }
    
    public function update(User $user, Transaction $transaction)
    {
        return $user->isBendahara() || 
               ($transaction->user_id === $user->id && $transaction->status === 'pending');
    }
}
```

### Data Validation
```php
// Form Request Validation
class TransactionRequest extends FormRequest
{
    public function rules()
    {
        return [
            'type' => 'required|in:income,expense',
            'amount' => 'required|numeric|min:0',
            'description' => 'required|string|max:1000',
            'source' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:1000'
        ];
    }
    
    public function messages()
    {
        return [
            'type.required' => 'Jenis transaksi harus dipilih.',
            'amount.required' => 'Jumlah transaksi harus diisi.',
            'amount.numeric' => 'Jumlah harus berupa angka.',
            'amount.min' => 'Jumlah tidak boleh negatif.'
        ];
    }
}
```

### File Security
```php
// Secure file upload
class PaymentProofController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:10240'
        ]);
        
        $file = $request->file('file');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('payment_proofs/' . auth()->id(), $filename, 'private');
        
        $paymentProof = PaymentProof::create([
            'user_id' => auth()->id(),
            'file_name' => $file->getClientOriginalName(),
            'file_path' => $path,
            'file_size' => $file->getSize(),
            'file_type' => $file->getMimeType()
        ]);
        
        return redirect()->route('payment-proofs.index')
            ->with('success', 'Bukti pembayaran berhasil diupload.');
    }
}
```

## 📊 Performance Architecture

### Caching Strategy
```php
// Redis Caching
class CacheService
{
    public function cacheUserPermissions($userId)
    {
        $key = "user_permissions_{$userId}";
        
        return Cache::remember($key, 3600, function() use ($userId) {
            return User::find($userId)->getAllPermissions();
        });
    }
    
    public function cacheDashboardData()
    {
        $key = 'dashboard_data_' . auth()->id();
        
        return Cache::remember($key, 300, function() {
            return [
                'cash_balance' => CashBalance::first(),
                'recent_transactions' => Transaction::latest()->limit(5)->get(),
                'pending_proofs' => PaymentProof::where('status', 'pending')->count()
            ];
        });
    }
}
```

### Database Optimization
```php
// Query optimization
class TransactionRepository
{
    public function getTransactionsWithFilters($filters)
    {
        $query = Transaction::with(['user:id,name', 'approver:id,name']);
        
        if (isset($filters['type'])) {
            $query->where('type', $filters['type']);
        }
        
        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }
        
        if (isset($filters['user_name'])) {
            $query->whereHas('user', function($q) use ($filters) {
                $q->where('name', 'like', '%' . $filters['user_name'] . '%');
            });
        }
        
        return $query->latest()->paginate(20);
    }
}
```

### Frontend Optimization
```javascript
// Lazy loading for images
const lazyImages = document.querySelectorAll('img[data-src]');
const imageObserver = new IntersectionObserver((entries, observer) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            const img = entry.target;
            img.src = img.dataset.src;
            img.classList.remove('lazy');
            observer.unobserve(img);
        }
    });
});

lazyImages.forEach(img => imageObserver.observe(img));

// Debounced search
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

const searchInput = document.getElementById('search');
const debouncedSearch = debounce((value) => {
    // Perform search
}, 300);

searchInput.addEventListener('input', (e) => {
    debouncedSearch(e.target.value);
});
```

## 🔄 PWA Architecture

### Service Worker
```javascript
// sw.js
const CACHE_NAME = 'cash-management-v1.1.0';
const STATIC_CACHE_NAME = 'cash-management-static-v1.1.0';

const urlsToCache = [
    '/',
    '/dashboard',
    '/transactions',
    '/payment-proofs',
    '/weekly-payments',
    '/settings'
];

const staticUrlsToCache = [
    '/money-transfer.png',
    '/money.png',
    '/calendar.png',
    '/searching.png',
    '/receipt.png',
    '/profile.png',
    '/seting.png',
    '/logout.png',
    '/user.png',
    '/history.png'
];

// Install event
self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then((cache) => cache.addAll(urlsToCache))
    );
});

// Fetch event
self.addEventListener('fetch', (event) => {
    const { request } = event;
    const url = new URL(request.url);
    
    // Cache strategy for different types of requests
    if (request.method === 'GET') {
        if (url.pathname.startsWith('/api/')) {
            // Network first for API calls
            event.respondWith(networkFirst(request));
        } else if (isIconFile(url)) {
            // Cache first for icons
            event.respondWith(cacheFirst(request));
        } else {
            // Stale while revalidate for pages
            event.respondWith(staleWhileRevalidate(request));
        }
    }
});
```

### Manifest Configuration
```json
{
    "name": "Cash Management System",
    "short_name": "CashApp",
    "description": "Modern cash management system with PWA support",
    "start_url": "/",
    "display": "standalone",
    "background_color": "#0f172a",
    "theme_color": "#10b981",
    "orientation": "portrait",
    "icons": [
        {
            "src": "/icon-192x192.png",
            "sizes": "192x192",
            "type": "image/png"
        },
        {
            "src": "/icon-512x512.png",
            "sizes": "512x512",
            "type": "image/png"
        }
    ]
}
```

## 📈 Monitoring Architecture

### Audit Logging
```php
// Audit Log Service
class AuditService
{
    public static function log($action, $model = null, $oldValues = null, $newValues = null, $description = null)
    {
        $auditLog = new AuditLog();
        $auditLog->action = $action;
        $auditLog->user_id = Auth::id();
        $auditLog->ip_address = request()->ip();
        $auditLog->user_agent = request()->userAgent();
        $auditLog->description = $description;
        
        if ($model) {
            $auditLog->model_type = get_class($model);
            $auditLog->model_id = $model->id;
        }
        
        if ($oldValues) {
            $auditLog->old_values = $oldValues;
        }
        
        if ($newValues) {
            $auditLog->new_values = $newValues;
        }
        
        $auditLog->save();
    }
}
```

### Error Handling
```php
// Global Exception Handler
class Handler extends ExceptionHandler
{
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            if ($this->shouldReport($e)) {
                Log::error('Application Error', [
                    'exception' => $e,
                    'user_id' => Auth::id(),
                    'url' => request()->url(),
                    'method' => request()->method()
                ]);
            }
        });
    }
    
    public function render($request, Throwable $e)
    {
        if ($e instanceof ModelNotFoundException) {
            return response()->view('errors.404', [], 404);
        }
        
        if ($e instanceof AuthorizationException) {
            return response()->view('errors.403', [], 403);
        }
        
        return parent::render($request, $e);
    }
}
```

## 🧪 Testing Architecture

### Test Structure
```php
// Feature Tests
class TransactionTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_bendahara_can_view_all_transactions()
    {
        $bendahara = User::factory()->create(['role' => 'bendahara']);
        $transaction = Transaction::factory()->create();
        
        $response = $this->actingAs($bendahara)
            ->get('/transactions');
        
        $response->assertStatus(200);
        $response->assertSee($transaction->description);
    }
    
    public function test_anggota_can_only_view_own_transactions()
    {
        $anggota = User::factory()->create(['role' => 'anggota']);
        $ownTransaction = Transaction::factory()->create(['user_id' => $anggota->id]);
        $otherTransaction = Transaction::factory()->create();
        
        $response = $this->actingAs($anggota)
            ->get('/transactions');
        
        $response->assertStatus(200);
        $response->assertSee($ownTransaction->description);
        $response->assertDontSee($otherTransaction->description);
    }
}

// Unit Tests
class WeeklyPaymentTest extends TestCase
{
    public function test_weekly_payment_has_correct_attributes()
    {
        $payment = new WeeklyPayment([
            'week_period' => '2025-01-W1',
            'user_id' => 1,
            'amount' => 10000.00,
            'is_paid' => false
        ]);
        
        $this->assertEquals('2025-01-W1', $payment->week_period);
        $this->assertEquals(10000.00, $payment->amount);
        $this->assertFalse($payment->is_paid);
    }
}
```

## 📊 Export Architecture

### Excel Export
```php
// Transaction Export
class TransactionsExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    public function collection()
    {
        return Transaction::with(['user', 'approver'])->get();
    }
    
    public function headings(): array
    {
        return [
            'ID',
            'User',
            'Type',
            'Amount',
            'Description',
            'Status',
            'Approver',
            'Created At'
        ];
    }
    
    public function map($transaction): array
    {
        return [
            $transaction->id,
            $transaction->user->name,
            ucfirst($transaction->type),
            'Rp ' . number_format($transaction->amount, 0, ',', '.'),
            $transaction->description,
            ucfirst($transaction->status),
            $transaction->approver ? $transaction->approver->name : '-',
            $transaction->created_at->format('d/m/Y H:i:s')
        ];
    }
    
    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
```

---

**Technical Specification** - Complete technical documentation for Cash Management System. 🔧✨
