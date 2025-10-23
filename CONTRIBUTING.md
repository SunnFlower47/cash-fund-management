# 🤝 Contributing Guide

## Overview

Terima kasih atas minat Anda untuk berkontribusi pada Cash Management System! Panduan ini akan membantu Anda memahami cara berkontribusi dengan efektif.

## 📋 Table of Contents

- [Code of Conduct](#code-of-conduct)
- [Getting Started](#getting-started)
- [Development Setup](#development-setup)
- [Contributing Process](#contributing-process)
- [Coding Standards](#coding-standards)
- [Testing Guidelines](#testing-guidelines)
- [Documentation](#documentation)
- [Issue Reporting](#issue-reporting)
- [Pull Request Process](#pull-request-process)

## 📜 Code of Conduct

### Our Pledge
Kami berkomitmen untuk membuat pengalaman kontribusi yang terbuka dan menyenangkan untuk semua orang, terlepas dari usia, ukuran tubuh, disabilitas, etnis, karakteristik gender, tingkat pengalaman, pendidikan, status sosial-ekonomi, kewarganegaraan, penampilan pribadi, ras, agama, atau orientasi seksual.

### Our Standards
Contoh perilaku yang berkontribusi untuk menciptakan lingkungan yang positif:

- Menggunakan bahasa yang ramah dan inklusif
- Menghormati perbedaan pandangan dan pengalaman
- Menerima kritik konstruktif dengan baik
- Fokus pada apa yang terbaik untuk komunitas
- Menunjukkan empati terhadap anggota komunitas lainnya

### Enforcement
Instances of abusive, harassing, or otherwise unacceptable behavior may be reported by contacting the project team. All complaints will be reviewed and investigated and will result in a response that is deemed necessary and appropriate to the circumstances.

## 🚀 Getting Started

### Prerequisites
- PHP 8.1 atau lebih tinggi
- Composer
- Node.js 16+ dan NPM
- MySQL 8.0+
- Git

### Fork and Clone
1. Fork repository ini
2. Clone fork Anda:
```bash
git clone https://github.com/your-username/cash-management.git
cd cash-management
```

3. Tambahkan upstream remote:
```bash
git remote add upstream https://github.com/original-owner/cash-management.git
```

## 🛠️ Development Setup

### 1. Install Dependencies
```bash
# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install
```

### 2. Environment Setup
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 3. Database Setup
```bash
# Create database
mysql -u root -p
CREATE DATABASE cash_management_test;

# Run migrations
php artisan migrate

# Seed database
php artisan db:seed
```

### 4. Build Assets
```bash
# Build for development
npm run dev

# Build for production
npm run build
```

### 5. Start Development Server
```bash
php artisan serve
```

## 🔄 Contributing Process

### 1. Create Feature Branch
```bash
# Update main branch
git checkout main
git pull upstream main

# Create feature branch
git checkout -b feature/your-feature-name
```

### 2. Make Changes
- Buat perubahan yang diperlukan
- Ikuti coding standards
- Tulis tests untuk fitur baru
- Update dokumentasi jika diperlukan

### 3. Test Changes
```bash
# Run tests
php artisan test

# Run specific test
php artisan test --filter=YourTestClass

# Check code style
./vendor/bin/pint --test
```

### 4. Commit Changes
```bash
# Add changes
git add .

# Commit with descriptive message
git commit -m "feat: add new feature for user management"
```

### 5. Push Changes
```bash
git push origin feature/your-feature-name
```

### 6. Create Pull Request
- Buka GitHub dan buat Pull Request
- Isi template PR dengan lengkap
- Tunggu review dari maintainer

## 📝 Coding Standards

### PHP Standards
- Ikuti PSR-12 coding standard
- Gunakan Laravel Pint untuk formatting
- Tulis kode yang clean dan readable
- Gunakan meaningful variable names

```php
// Good
public function getUserTransactions($userId)
{
    return Transaction::where('user_id', $userId)
        ->with(['user', 'approver'])
        ->latest()
        ->get();
}

// Bad
public function get($id)
{
    return Transaction::where('user_id', $id)->get();
}
```

### Blade Template Standards
- Gunakan consistent indentation
- Pisahkan logic dari view
- Gunakan components untuk reusable elements
- Comment complex logic

```blade
{{-- Good --}}
@if($user->isBendahara())
    <x-button :href="route('transactions.create')">
        Create Transaction
    </x-button>
@endif

{{-- Bad --}}
@if($user->role === 'bendahara')
    <a href="/transactions/create" class="btn btn-primary">Create Transaction</a>
@endif
```

### JavaScript Standards
- Gunakan Alpine.js untuk interactivity
- Tulis clean dan readable code
- Comment complex functions
- Gunakan consistent naming

```javascript
// Good
Alpine.data('transactionForm', () => ({
    amount: 0,
    description: '',
    
    validate() {
        return this.amount > 0 && this.description.length > 0;
    },
    
    async submit() {
        if (!this.validate()) return;
        
        // Submit logic
    }
}));

// Bad
Alpine.data('form', () => ({
    a: 0,
    d: '',
    
    v() {
        return this.a > 0 && this.d.length > 0;
    }
}));
```

### CSS Standards
- Gunakan Tailwind CSS classes
- Consistent spacing dan colors
- Mobile-first approach
- Dark mode support

```css
/* Good */
.transaction-card {
    @apply bg-white dark:bg-slate-800 rounded-lg shadow-md p-4;
}

/* Bad */
.transaction-card {
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    padding: 16px;
}
```

## 🧪 Testing Guidelines

### Test Structure
```
tests/
├── Feature/           # Feature tests
│   ├── TransactionTest.php
│   ├── PaymentProofTest.php
│   └── WeeklyPaymentTest.php
├── Unit/             # Unit tests
│   ├── UserTest.php
│   ├── TransactionTest.php
│   └── WeeklyPaymentTest.php
└── TestCase.php      # Base test case
```

### Writing Tests
```php
// Feature Test Example
class TransactionTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_bendahara_can_create_transaction()
    {
        $bendahara = User::factory()->create(['role' => 'bendahara']);
        
        $response = $this->actingAs($bendahara)
            ->post('/transactions', [
                'type' => 'income',
                'amount' => 50000,
                'description' => 'Test transaction'
            ]);
        
        $response->assertRedirect('/transactions');
        $this->assertDatabaseHas('transactions', [
            'type' => 'income',
            'amount' => 50000,
            'description' => 'Test transaction'
        ]);
    }
}

// Unit Test Example
class UserTest extends TestCase
{
    public function test_user_has_correct_role()
    {
        $user = User::factory()->create(['role' => 'bendahara']);
        
        $this->assertTrue($user->isBendahara());
        $this->assertFalse($user->isAnggota());
    }
}
```

### Test Commands
```bash
# Run all tests
php artisan test

# Run specific test
php artisan test --filter=TransactionTest

# Run with coverage
php artisan test --coverage

# Run specific test method
php artisan test --filter=test_bendahara_can_create_transaction
```

## 📚 Documentation

### Code Documentation
- Tulis PHPDoc untuk semua public methods
- Comment complex logic
- Update README jika ada perubahan besar
- Dokumentasikan API endpoints

```php
/**
 * Create a new transaction
 *
 * @param array $data Transaction data
 * @return Transaction Created transaction
 * @throws ValidationException If data is invalid
 */
public function createTransaction(array $data): Transaction
{
    // Implementation
}
```

### README Updates
- Update installation instructions
- Add new features to feature list
- Update requirements if needed
- Add troubleshooting section

### API Documentation
- Dokumentasikan semua endpoints
- Include request/response examples
- Add authentication requirements
- Update error codes

## 🐛 Issue Reporting

### Before Creating Issue
1. Cek apakah issue sudah ada
2. Cari di closed issues
3. Cek documentation
4. Coba reproduce issue

### Issue Template
```markdown
## Bug Report

### Description
Brief description of the bug

### Steps to Reproduce
1. Go to '...'
2. Click on '...'
3. See error

### Expected Behavior
What should happen

### Actual Behavior
What actually happens

### Environment
- OS: [e.g. Windows 10]
- Browser: [e.g. Chrome 91]
- PHP Version: [e.g. 8.1]
- Laravel Version: [e.g. 10.x]

### Screenshots
If applicable, add screenshots

### Additional Context
Any other context about the problem
```

### Feature Request Template
```markdown
## Feature Request

### Description
Brief description of the feature

### Use Case
Why is this feature needed?

### Proposed Solution
How should this feature work?

### Alternatives
Any alternative solutions considered?

### Additional Context
Any other context about the feature request
```

## 🔄 Pull Request Process

### PR Template
```markdown
## Description
Brief description of changes

## Type of Change
- [ ] Bug fix
- [ ] New feature
- [ ] Breaking change
- [ ] Documentation update

## Testing
- [ ] Tests pass locally
- [ ] New tests added for new functionality
- [ ] Manual testing completed

## Checklist
- [ ] Code follows style guidelines
- [ ] Self-review completed
- [ ] Documentation updated
- [ ] No breaking changes
```

### Review Process
1. **Automated Checks**: CI/CD pipeline runs
2. **Code Review**: Maintainer reviews code
3. **Testing**: Manual testing if needed
4. **Approval**: Maintainer approves PR
5. **Merge**: PR merged to main branch

### PR Guidelines
- Keep PRs small and focused
- Write descriptive commit messages
- Update documentation if needed
- Add tests for new features
- Follow coding standards

## 🏷️ Commit Message Convention

### Format
```
type(scope): description

[optional body]

[optional footer]
```

### Types
- `feat`: New feature
- `fix`: Bug fix
- `docs`: Documentation changes
- `style`: Code style changes
- `refactor`: Code refactoring
- `test`: Adding tests
- `chore`: Maintenance tasks

### Examples
```bash
# Good commit messages
feat(transactions): add bulk approval functionality
fix(payment-proofs): resolve file upload validation issue
docs(api): update endpoint documentation
test(weekly-payments): add unit tests for payment calculation

# Bad commit messages
fix stuff
update
changes
```

## 🔧 Development Tools

### Recommended Tools
- **IDE**: PhpStorm, VS Code
- **Database**: MySQL Workbench, phpMyAdmin
- **API Testing**: Postman, Insomnia
- **Version Control**: Git, GitHub Desktop

### VS Code Extensions
- Laravel Blade Snippets
- PHP Intelephense
- Tailwind CSS IntelliSense
- Alpine.js IntelliSense
- GitLens

### Useful Commands
```bash
# Code formatting
./vendor/bin/pint

# Database operations
php artisan migrate:fresh --seed
php artisan db:wipe

# Cache operations
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Queue operations
php artisan queue:work
php artisan queue:restart
```

## 📞 Getting Help

### Resources
- **Documentation**: Check project documentation
- **Issues**: Search existing issues
- **Discussions**: GitHub discussions
- **Community**: Laravel community

### Contact
- **Email**: maintainer@cashmanagement.com
- **GitHub**: @maintainer
- **Discord**: Cash Management Community

## 🎉 Recognition

### Contributors
Kontributor akan diakui di:
- README.md contributors section
- Release notes
- Project documentation

### Types of Contributions
- Code contributions
- Documentation improvements
- Bug reports
- Feature requests
- Testing
- Community support

---

**Contributing Guide** - Complete guide for contributing to Cash Management System. 🤝✨
