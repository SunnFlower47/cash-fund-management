# 🔌 API Documentation

## Overview

Cash Management System menyediakan RESTful API endpoints untuk mengelola semua aspek sistem manajemen kas, termasuk pembayaran mingguan, bukti pembayaran, transaksi, dan audit log.

## 🔐 Authentication

### Authentication Method
- **Type**: Session-based authentication
- **Middleware**: `auth` middleware
- **CSRF Protection**: Enabled for all POST/PUT/DELETE requests

### Authentication Headers
```http
X-CSRF-TOKEN: {csrf_token}
Cookie: laravel_session={session_id}
```

## 📋 Base URL
```
Production: https://your-domain.com
Development: http://localhost:8000
```

## 🏠 Dashboard Endpoints

### Get Dashboard Data
```http
GET /dashboard
```

**Response (Bendahara)**:
```json
{
    "cash_balance": {
        "balance": 150000.00,
        "formatted_balance": "Rp 150.000"
    },
    "recent_transactions": [
        {
            "id": 1,
            "type": "income",
            "amount": 50000.00,
            "description": "Pembayaran mingguan",
            "status": "approved",
            "created_at": "2025-01-15T10:30:00Z"
        }
    ],
    "pending_payment_proofs": 3,
    "weekly_payment_stats": {
        "total_paid": 120000.00,
        "total_unpaid": 30000.00,
        "pending_count": 5
    }
}
```

**Response (Anggota)**:
```json
{
    "cash_balance": {
        "balance": 150000.00,
        "formatted_balance": "Rp 150.000"
    },
    "user_transactions": [
        {
            "id": 1,
            "type": "income",
            "amount": 10000.00,
            "description": "Pembayaran mingguan W1",
            "status": "approved",
            "created_at": "2025-01-15T10:30:00Z"
        }
    ],
    "weekly_payments": [
        {
            "id": 1,
            "week_period": "2025-01-W1",
            "amount": 10000.00,
            "is_paid": true,
            "paid_at": "2025-01-15T10:30:00Z"
        }
    ],
    "pending_payment_proofs": 1
}
```

## 💰 Transaction Endpoints

### Get All Transactions
```http
GET /transactions
```

**Query Parameters**:
- `type` (string): Filter by transaction type (`income`, `expense`)
- `status` (string): Filter by status (`pending`, `approved`, `rejected`)
- `user_name` (string): Filter by user name
- `page` (integer): Page number for pagination

**Response**:
```json
{
    "data": [
        {
            "id": 1,
            "user_id": 1,
            "type": "income",
            "amount": 50000.00,
            "description": "Pembayaran mingguan",
            "source": "weekly_payment",
            "status": "approved",
            "approved_at": "2025-01-15T10:30:00Z",
            "approver": {
                "id": 1,
                "name": "Bendahara"
            },
            "user": {
                "id": 2,
                "name": "Anggota 1"
            },
            "created_at": "2025-01-15T10:00:00Z"
        }
    ],
    "links": {
        "first": "http://localhost:8000/transactions?page=1",
        "last": "http://localhost:8000/transactions?page=5",
        "prev": null,
        "next": "http://localhost:8000/transactions?page=2"
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 5,
        "per_page": 20,
        "to": 20,
        "total": 100
    }
}
```

### Get Single Transaction
```http
GET /transactions/{id}
```

**Response**:
```json
{
    "id": 1,
    "user_id": 1,
    "type": "income",
    "amount": 50000.00,
    "description": "Pembayaran mingguan",
    "source": "weekly_payment",
    "source_id": "1",
    "status": "approved",
    "approved_at": "2025-01-15T10:30:00Z",
    "approver": {
        "id": 1,
        "name": "Bendahara"
    },
    "user": {
        "id": 2,
        "name": "Anggota 1"
    },
    "notes": "Pembayaran untuk minggu pertama",
    "created_at": "2025-01-15T10:00:00Z",
    "updated_at": "2025-01-15T10:30:00Z"
}
```

### Create Transaction
```http
POST /transactions
```

**Request Body**:
```json
{
    "type": "income",
    "amount": 50000.00,
    "description": "Pembayaran mingguan",
    "source": "weekly_payment",
    "source_id": "1",
    "notes": "Pembayaran untuk minggu pertama"
}
```

**Response**:
```json
{
    "id": 1,
    "user_id": 1,
    "type": "income",
    "amount": 50000.00,
    "description": "Pembayaran mingguan",
    "source": "weekly_payment",
    "source_id": "1",
    "status": "pending",
    "created_at": "2025-01-15T10:00:00Z"
}
```

### Update Transaction
```http
PUT /transactions/{id}
```

**Request Body**:
```json
{
    "type": "income",
    "amount": 60000.00,
    "description": "Pembayaran mingguan (updated)",
    "notes": "Updated payment amount"
}
```

### Delete Transaction
```http
DELETE /transactions/{id}
```

**Response**: `204 No Content`

## 📄 Payment Proof Endpoints

### Get All Payment Proofs
```http
GET /payment-proofs
```

**Query Parameters**:
- `status` (string): Filter by status (`pending`, `approved`, `rejected`)
- `user_id` (integer): Filter by user ID
- `page` (integer): Page number for pagination

**Response**:
```json
{
    "data": [
        {
            "id": 1,
            "user_id": 2,
            "file_name": "payment_proof_1.jpg",
            "file_size": 1024000,
            "file_type": "image/jpeg",
            "status": "pending",
            "user": {
                "id": 2,
                "name": "Anggota 1"
            },
            "created_at": "2025-01-15T10:00:00Z"
        }
    ],
    "links": {
        "first": "http://localhost:8000/payment-proofs?page=1",
        "last": "http://localhost:8000/payment-proofs?page=3",
        "prev": null,
        "next": "http://localhost:8000/payment-proofs?page=2"
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 3,
        "per_page": 20,
        "to": 20,
        "total": 50
    }
}
```

### Get Single Payment Proof
```http
GET /payment-proofs/{id}
```

**Response**:
```json
{
    "id": 1,
    "user_id": 2,
    "file_name": "payment_proof_1.jpg",
    "file_path": "storage/payment_proofs/1/payment_proof_1.jpg",
    "file_size": 1024000,
    "file_type": "image/jpeg",
    "status": "pending",
    "reviewed_at": null,
    "reviewer": null,
    "review_notes": null,
    "user": {
        "id": 2,
        "name": "Anggota 1"
    },
    "file_url": "http://localhost:8000/storage/payment_proofs/1/payment_proof_1.jpg",
    "formatted_file_size": "1.02 MB",
    "created_at": "2025-01-15T10:00:00Z",
    "updated_at": "2025-01-15T10:00:00Z"
}
```

### Upload Payment Proof
```http
POST /payment-proofs
Content-Type: multipart/form-data
```

**Request Body** (Form Data):
```
file: [binary file data]
```

**Response**:
```json
{
    "id": 1,
    "user_id": 2,
    "file_name": "payment_proof_1.jpg",
    "file_size": 1024000,
    "file_type": "image/jpeg",
    "status": "pending",
    "file_url": "http://localhost:8000/storage/payment_proofs/1/payment_proof_1.jpg",
    "formatted_file_size": "1.02 MB",
    "created_at": "2025-01-15T10:00:00Z"
}
```

### Update Payment Proof
```http
PUT /payment-proofs/{id}
Content-Type: multipart/form-data
```

**Request Body** (Form Data):
```
file: [binary file data] (optional)
```

### Approve Payment Proof
```http
POST /payment-proofs/{id}/approve
```

**Request Body**:
```json
{
    "notes": "Payment proof approved"
}
```

### Reject Payment Proof
```http
POST /payment-proofs/{id}/reject
```

**Request Body**:
```json
{
    "review_notes": "Payment proof rejected - unclear image"
}
```

### Delete Payment Proof
```http
DELETE /payment-proofs/{id}
```

**Response**: `204 No Content`

## 📅 Weekly Payment Endpoints

### Get Weekly Payments
```http
GET /weekly-payments
```

**Query Parameters**:
- `year` (integer): Filter by year
- `month` (integer): Filter by month (1-12)
- `week` (integer): Filter by week (1-4)
- `user_id` (integer): Filter by user ID
- `status` (string): Filter by payment status (`paid`, `unpaid`)
- `page` (integer): Page number for pagination

**Response**:
```json
{
    "data": [
        {
            "id": 1,
            "week_period": "2025-01-W1",
            "user_id": 2,
            "amount": 10000.00,
            "is_paid": true,
            "paid_at": "2025-01-15T10:30:00Z",
            "notes": null,
            "user": {
                "id": 2,
                "name": "Anggota 1"
            },
            "week_period_display": "Januari 2025 - Minggu 1",
            "created_at": "2025-01-01T00:00:00Z",
            "updated_at": "2025-01-15T10:30:00Z"
        }
    ],
    "links": {
        "first": "http://localhost:8000/weekly-payments?page=1",
        "last": "http://localhost:8000/weekly-payments?page=2",
        "prev": null,
        "next": "http://localhost:8000/weekly-payments?page=2"
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 2,
        "per_page": 20,
        "to": 20,
        "total": 30
    }
}
```

### Generate Weekly Bills
```http
POST /weekly-payments/generate
```

**Request Body**:
```json
{
    "year": 2025,
    "month": 1,
    "week": 1,
    "amount": 10000.00,
    "generate_all_weeks": false
}
```

**Response**:
```json
{
    "message": "Weekly bills generated successfully",
    "generated_count": 5,
    "total_amount": 50000.00
}
```

### Mark Payment as Paid
```http
POST /weekly-payments/{id}/mark-paid
```

**Response**:
```json
{
    "message": "Payment marked as paid successfully",
    "payment": {
        "id": 1,
        "is_paid": true,
        "paid_at": "2025-01-15T10:30:00Z"
    }
}
```

### Mark Payment as Unpaid
```http
POST /weekly-payments/{id}/mark-unpaid
```

**Response**:
```json
{
    "message": "Payment marked as unpaid successfully",
    "payment": {
        "id": 1,
        "is_paid": false,
        "paid_at": null
    }
}
```

### Approve Payment
```http
POST /weekly-payments/approve-payment
```

**Request Body**:
```json
{
    "user_id": 2,
    "amount_paid": 30000.00,
    "weekly_amount": 10000.00
}
```

**Response**:
```json
{
    "message": "Payment approved successfully",
    "weeks_paid": 3,
    "remaining_amount": 0.00,
    "transaction": {
        "id": 1,
        "type": "income",
        "amount": 30000.00,
        "description": "Pembayaran mingguan - 3 minggu"
    }
}
```

## 👥 Settings Endpoints

### Get All Users
```http
GET /settings
```

**Response**:
```json
{
    "users": [
        {
            "id": 1,
            "name": "Bendahara",
            "email": "bendahara@example.com",
            "roles": [
                {
                    "id": 1,
                    "name": "bendahara"
                }
            ],
            "created_at": "2025-01-01T00:00:00Z"
        }
    ]
}
```

### Create User
```http
POST /settings/users
```

**Request Body**:
```json
{
    "name": "New User",
    "email": "newuser@example.com",
    "password": "password123",
    "role": "anggota"
}
```

### Update User
```http
PUT /settings/users/{id}
```

**Request Body**:
```json
{
    "name": "Updated User",
    "email": "updated@example.com",
    "role": "bendahara"
}
```

### Update User Password
```http
PUT /settings/users/{id}/password
```

**Request Body**:
```json
{
    "password": "newpassword123",
    "password_confirmation": "newpassword123"
}
```

### Delete User
```http
DELETE /settings/users/{id}
```

**Response**: `204 No Content`

## 📊 Audit Log Endpoints

### Get Audit Logs
```http
GET /audit-logs
```

**Query Parameters**:
- `action` (string): Filter by action type
- `model_type` (string): Filter by model type
- `user_id` (integer): Filter by user ID
- `date_from` (date): Filter from date
- `date_to` (date): Filter to date
- `page` (integer): Page number for pagination

**Response**:
```json
{
    "data": [
        {
            "id": 1,
            "action": "CREATE",
            "model_type": "App\\Models\\Transaction",
            "model_id": 1,
            "user_id": 1,
            "old_values": null,
            "new_values": {
                "type": "income",
                "amount": 50000.00,
                "description": "Pembayaran mingguan"
            },
            "ip_address": "127.0.0.1",
            "user_agent": "Mozilla/5.0...",
            "description": "Created new transaction",
            "user": {
                "id": 1,
                "name": "Bendahara"
            },
            "action_display": "Membuat",
            "model_display": "Transaksi",
            "created_at": "2025-01-15T10:00:00Z"
        }
    ],
    "links": {
        "first": "http://localhost:8000/audit-logs?page=1",
        "last": "http://localhost:8000/audit-logs?page=10",
        "prev": null,
        "next": "http://localhost:8000/audit-logs?page=2"
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 10,
        "per_page": 20,
        "to": 20,
        "total": 200
    }
}
```

### Get Single Audit Log
```http
GET /audit-logs/{id}
```

**Response**:
```json
{
    "id": 1,
    "action": "UPDATE",
    "model_type": "App\\Models\\Transaction",
    "model_id": 1,
    "user_id": 1,
    "old_values": {
        "status": "pending",
        "amount": 50000.00
    },
    "new_values": {
        "status": "approved",
        "amount": 50000.00,
        "approved_at": "2025-01-15T10:30:00Z"
    },
    "ip_address": "127.0.0.1",
    "user_agent": "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36",
    "description": "Transaction approved by bendahara",
    "user": {
        "id": 1,
        "name": "Bendahara"
    },
    "action_display": "Mengubah",
    "model_display": "Transaksi",
    "created_at": "2025-01-15T10:00:00Z",
    "updated_at": "2025-01-15T10:00:00Z"
}
```

## 📤 Export Endpoints

### Export All Data
```http
GET /backup/export-all
```

**Response**: Excel file download

### Export Transactions
```http
GET /backup/export-transactions
```

**Query Parameters**:
- `type` (string): Filter by transaction type
- `status` (string): Filter by status
- `date_from` (date): Filter from date
- `date_to` (date): Filter to date

**Response**: Excel file download

### Export Weekly Payments
```http
GET /backup/export-weekly-payments
```

**Query Parameters**:
- `year` (integer): Filter by year
- `month` (integer): Filter by month
- `user_id` (integer): Filter by user ID

**Response**: Excel file download

### Export Payment Proofs
```http
GET /backup/export-payment-proofs
```

**Query Parameters**:
- `status` (string): Filter by status
- `user_id` (integer): Filter by user ID

**Response**: Excel file download

## 🔐 Authentication Endpoints

### Login
```http
POST /login
```

**Request Body**:
```json
{
    "email": "bendahara@example.com",
    "password": "password",
    "remember": false
}
```

**Response**:
```json
{
    "message": "Login successful",
    "user": {
        "id": 1,
        "name": "Bendahara",
        "email": "bendahara@example.com",
        "roles": ["bendahara"]
    }
}
```

### Logout
```http
POST /logout
```

**Response**:
```json
{
    "message": "Logout successful"
}
```

### Forgot Password
```http
POST /forgot-password
```

**Request Body**:
```json
{
    "email": "bendahara@example.com"
}
```

**Response**:
```json
{
    "message": "Password reset link sent to your email"
}
```

## 📊 Dashboard Statistics

### Get Cash Balance
```http
GET /api/cash-balance
```

**Response**:
```json
{
    "balance": 150000.00,
    "formatted_balance": "Rp 150.000",
    "last_updated": "2025-01-15T10:30:00Z"
}
```

### Get Weekly Payment Stats
```http
GET /api/weekly-payment-stats
```

**Query Parameters**:
- `year` (integer): Year to get stats for
- `month` (integer): Month to get stats for

**Response**:
```json
{
    "total_paid": 120000.00,
    "total_unpaid": 30000.00,
    "pending_count": 5,
    "paid_count": 12,
    "total_members": 17
}
```

### Get Transaction Stats
```http
GET /api/transaction-stats
```

**Query Parameters**:
- `date_from` (date): Start date
- `date_to` (date): End date

**Response**:
```json
{
    "total_income": 200000.00,
    "total_expense": 50000.00,
    "net_balance": 150000.00,
    "transaction_count": 25,
    "approved_count": 20,
    "pending_count": 5
}
```

## 🚨 Error Responses

### Validation Errors
```json
{
    "message": "The given data was invalid.",
    "errors": {
        "email": [
            "The email field is required."
        ],
        "password": [
            "The password field is required."
        ]
    }
}
```

### Authentication Errors
```json
{
    "message": "Unauthenticated."
}
```

### Authorization Errors
```json
{
    "message": "This action is unauthorized."
}
```

### Not Found Errors
```json
{
    "message": "No query results for model [Transaction] 999"
}
```

### Server Errors
```json
{
    "message": "Server Error"
}
```

## 📝 Rate Limiting

### Rate Limits
- **General API**: 100 requests per minute
- **Authentication**: 5 attempts per minute
- **File Upload**: 10 uploads per minute

### Rate Limit Headers
```http
X-RateLimit-Limit: 100
X-RateLimit-Remaining: 95
X-RateLimit-Reset: 1640995200
```

## 🔧 Development

### Testing Endpoints
```bash
# Test authentication
curl -X POST http://localhost:8000/login \
  -H "Content-Type: application/json" \
  -d '{"email":"bendahara@example.com","password":"password"}'

# Test transaction creation
curl -X POST http://localhost:8000/transactions \
  -H "Content-Type: application/json" \
  -H "X-CSRF-TOKEN: {csrf_token}" \
  -d '{"type":"income","amount":50000,"description":"Test transaction"}'
```

### API Testing with Postman
1. Import the collection from `/docs/postman-collection.json`
2. Set up environment variables
3. Run the authentication flow
4. Test all endpoints

---

**API Documentation** - Complete reference for Cash Management System API endpoints. 🔌✨
