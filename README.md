<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

# Beruf Management System

A simple Laravel-based application for managing professions (Berufe).
The system allows users to create, edit, delete, and search professions using an AJAX-powered table.

## 🚀 Features

- ✅ Create new professions
- ✅ Edit existing professions
- ✅ Delete professions with confirmation
- ✅ Live search with debounced input
- ✅ AJAX table with pagination and sorting
- ✅ Toast notifications
- ✅ Clean UI with dark theme
- ✅ No authentication required (open access)

## 🛠️ Technologies Used

- **Backend:** Laravel 10.x
- **Database:** MySQL
- **Frontend:** jQuery, Bootstrap 5
- **AJAX:** Custom AjaxTable plugin
- **Styling:** Bootstrap 5 with custom CSS

## 📦 Installation

### Prerequisites
- PHP 8.1 or higher
- Composer
- MySQL
- Node.js & NPM (for assets)

### Setup Steps

1. **Clone the repository:**
   ```bash
   git clone https://github.com/MustafaAL-Gburi/test-laravel
   cd test-laravel
   ```

2. **Install PHP dependencies:**
   ```bash
   composer install
   ```

3. **Install Node dependencies:**
   ```bash
   npm install
   ```

4. **Environment setup:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Database configuration:**
   - Update `.env` file with your database credentials
   - Create database in MySQL

6. **Run migrations:**
   ```bash
   php artisan migrate
   ```

7. **Build assets (optional):**
   ```bash
   npm run build
   ```

8. **Start the development server:**
   ```bash
   php artisan serve
   ```

## 📖 Usage

### Accessing the Application
Open your browser and navigate to: `http://127.0.0.1:8000/berufe`

### Available Operations

- **View Professions:** Browse all professions in a paginated table
- **Search:** Use the search bar for real-time filtering (debounced)
- **Add New:** Click "Neuer Beruf" button to create new profession
- **Edit:** Click edit icon to modify existing profession
- **Delete:** Click delete icon with confirmation dialog

### Form Fields

- **Beruf Name:** Main profession name (required)
- **Status:** Active/Inactive/Old profession
- **BA ID:** Business association ID (numeric)
- **Gender variants:** Masculine and feminine forms
- **BA Zustand:** Business association status (E/A)
- **Keywords:** Search keywords
- **Fragebogen ID:** Questionnaire ID

## 🏗️ Code Structure

```
app/
├── Http/Controllers/
│   └── BerufController.php          # Main CRUD controller
├── Http/Requests/
│   ├── StoreBerufRequest.php        # Validation for creation
│   └── UpdateBerufRequest.php       # Validation for updates
├── Models/
│   └── Beruf.php                    # Eloquent model
├── Services/
│   └── AjaxTableService.php         # AJAX table handling
└── Helpers/
    └── helper.php                   # Utility functions

resources/views/
├── berufe/
│   ├── index.blade.php             # Main page
│   ├── edit.blade.php              # Create/Edit form
│   └── list.blade.php              # AJAX table template
└── layouts/
    └── master.blade.php            # Main layout

routes/
└── web.php                         # Route definitions
```

### Key Components

- **Controller:** Handles all CRUD operations with proper validation
- **Form Requests:** Separate validation logic for create/update
- **AJAX Service:** Handles table operations, search, and pagination
- **Helper Functions:** Permission checks (simplified for open access)
- **Blade Templates:** Clean separation of concerns

## 🔧 Configuration

### Validation Rules

The application uses strict validation:

- **ba_id:** Integer between 0-999999999
- **ba_zustand:** Must be 'E' or 'A' only
- **beruf:** Required, max 255 characters
- **status:** Integer 0-255
- **Other fields:** Appropriate string lengths and types

### AJAX Configuration

- Debounced search (300ms delay)
- Server-side pagination
- Toast notifications
- CSRF protection enabled

## 📝 Notes

- ✅ Clean code principles applied
- ✅ No authentication required (open access system)
- ✅ AJAX-powered for better UX
- ✅ Form validation with detailed error messages
- ✅ Responsive Bootstrap UI
- ✅ German language interface

## 👨‍💻 Author

**Mustafa AL-Gburi**

---

*Built with Laravel 10 - Clean Code Edition*
