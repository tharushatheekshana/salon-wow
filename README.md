# ✂️ Salon WOW — Modern Salon & Bridal Booking Management System

<p align="center">
  <img src="public/images/salon-wow-logo.jpg" alt="Salon WOW Logo" width="140" style="border-radius: 50%;" />
</p>

<p align="center">
  A premium, full-stack appointment booking and management platform built with <strong>Laravel 13</strong>, <strong>Livewire 4</strong>, <strong>Flux UI</strong>, and <strong>Tailwind CSS</strong>. Designed for modern salons, barbershops, and bridal dressing studios.
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-13.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel 13" />
  <img src="https://img.shields.io/badge/Livewire-4.x-FB70A9?style=for-the-badge&logo=livewire&logoColor=white" alt="Livewire 4" />
  <img src="https://img.shields.io/badge/PHP-8.4-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP 8.4" />
  <img src="https://img.shields.io/badge/Tailwind_CSS-v4-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white" alt="Tailwind CSS" />
  <img src="https://img.shields.io/badge/Pest_PHP-Tested-4F46E5?style=for-the-badge" alt="Pest PHP" />
</p>

---

## ✨ Features

### 🌟 Public Customer Experience
- **Interactive Multi-Step Booking Wizard**:
  - Filter and select services by categorized tabs (Gents Grooming, Ladies Styling, Bridal & Event Dressing, Facials & Skin Care).
  - Select preferred specialist/staff member or choose any available stylist.
  - Real-time dynamic time-slot engine considering staff working hours, break times, service duration, and buffer intervals.
  - Instant guest or authenticated booking with reference code generation.
- **Live Booking Tracker**:
  - Track appointment status and details in real-time using the booking reference code or customer contact information.
- **Customer Portal**:
  - View upcoming and past appointments, check status, and leave authentic service reviews.

### 👑 Admin Suite
- **Appointment Dashboard**:
  - Comprehensive dashboard to view, filter, confirm, complete, or reschedule bookings.
- **Service & Category Manager**:
  - Full CRUD operations for service catalog, pricing, duration, buffer times, and specialist assignments.
- **Business Insights**:
  - Track booking statistics, staff load, and customer feedback.

### ✂️ Staff Specialist Portal
- **Weekly Schedule Manager**:
  - Configure daily working hours, lunch/break times, and days off.
- **Daily Appointment Feed**:
  - Review scheduled clients and preparation details for upcoming services.

### 🔐 Security & Modern Authentication
- **Laravel Fortify** powered authentication.
- **Two-Factor Authentication (2FA)** with QR codes and recovery keys.
- **WebAuthn / Passkeys** support for passwordless and biometric authentication.
- Role-based authorization (`admin`, `staff`, `customer`).

---

## 🛠️ Tech Stack

- **Framework**: [Laravel 13](https://laravel.com)
- **Frontend / Reactivity**: [Livewire 4](https://livewire.laravel.com) & [Flux UI](https://flux.livewire.com)
- **Styling**: [Tailwind CSS v4](https://tailwindcss.com)
- **Authentication**: [Laravel Fortify](https://laravel.com/docs/fortify) & `@laravel/passkeys` (WebAuthn)
- **Database**: SQLite (default) / MySQL / PostgreSQL
- **Testing**: [Pest PHP](https://pestphp.com)
- **Code Style & Static Analysis**: [Laravel Pint](https://laravel.com/docs/pint) & [Larastan / PHPStan](https://github.com/larastan/larastan)

---

## 🚀 Getting Started

### Prerequisites

Ensure you have the following installed on your machine:
- **PHP 8.4+** with required extensions (`pdo`, `sqlite`, `mbstring`, `openssl`, etc.)
- **Composer** (v2+)
- **Node.js** (v20+) & **npm**

### Installation Steps

1. **Clone the repository**:
   ```bash
   git clone https://github.com/tharushatheekshana/salon-wow.git
   cd salon-wow
   ```

2. **Install PHP and Node dependencies**:
   ```bash
   composer install
   npm install
   ```

3. **Configure Environment**:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Run Database Migrations & Seeders**:
   ```bash
   php artisan migrate --seed
   ```

5. **Build Assets & Start the Development Server**:
   ```bash
   # Run Vite development server
   npm run dev

   # In a separate terminal, start the Laravel server
   php artisan serve
   ```
   Or run the concurrent development workflow:
   ```bash
   composer run dev
   ```

6. Open your browser and navigate to:
   ```text
   http://localhost:8000
   ```

---

## 🔑 Demo Accounts

After running `php artisan migrate --seed`, the following accounts are ready for testing:

| Role | Email | Password | Description |
| :--- | :--- | :--- | :--- |
| **Admin** | `admin@salonwow.lk` | `password` | Full salon control, services, and appointment management |
| **Staff Specialist** | `nuwan@salonwow.lk` | `password` | Gents Hair Stylist & Barber |
| **Staff Specialist** | `sanduni@salonwow.lk` | `password` | Bridal Dressing & Ladies Hair Specialist |
| **Customer** | `customer@example.com` | `password` | Sample client account with appointment history |

---

## 🧪 Testing & Quality Assurance

Run the automated test suite with Pest:
```bash
php artisan test
```

Run code formatting checks with Laravel Pint:
```bash
composer lint
```

Run static analysis with PHPStan / Larastan:
```bash
composer types:check
```

---

## 📄 License

This project is open-sourced software licensed under the [MIT license](LICENSE).
