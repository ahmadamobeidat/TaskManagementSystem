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

## Setting Up the Project

Follow these steps to set up and run the project on your local development environment:

### Prerequisites

1. **Install PHP (8.0 or higher)**: Ensure you have PHP installed on your system.
2. **Install Composer**: Composer is required to manage Laravel dependencies. You can download it from [getcomposer.org](https://getcomposer.org).
3. **Install Node.js and npm**: Required for front-end asset compilation. You can download it from [nodejs.org](https://nodejs.org).
4. **Install a Database**: Use MySQL, PostgreSQL, SQLite, or any supported database system.

### Installation Steps

1. **Clone the Repository**:
   ```bash
   git clone <repository-url>
   cd <project-folder>
2. **Install Dependencies**:
composer install
npm install
3. **Set Up Environment**:
cp .env.example .env
Update .env with your database and application configurations:
env
Copy
Edit
APP_NAME=Laravel
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password

4.**Generate Application Key**:
php artisan key:generate

5.**Run Migrations**:
php artisan migrate

6.**Seed the Database (Optional): Populate the database with demo data**:
php artisan db:seed

7.**Compile Front-End Assets: If your project has front-end assets, run**:
npm run dev
8.**Run the Development Server: Start the application**:
php artisan serve
Open your browser and navigate to http://localhost:8000

**Routes**
Public Pages
Route::get('/', [HomePageController::class, 'index'])->name('welcome');
Route::get('register', [RegisterController::class, 'register'])->name('register');
Route::post('storeUser', [RegisterController::class, 'storeUser'])->name('storeUser');
Route::get('login', [LoginController::class, 'login'])->name('login');
Route::post('userLoginRequest', [LoginController::class, 'userLoginRequest'])->name('userLoginRequest');

Authenticated User Routes
Route::middleware(['auth.user'])->group(function () {
    Route::post('/logout', [LoginController::class, 'userLogout'])->name('logout');
    
    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    });

    Route::prefix('myProfile')->name('myProfile.')->group(function () {
        Route::get('/userProfile', [MyProfileController::class, 'userProfile'])->name('userProfile');
        Route::get('/editUserProfile', [MyProfileController::class, 'editUserProfile'])->name('editUserProfile');
        Route::put('updateProfile', [MyProfileController::class, 'updateUserProfile'])->name('updateProfile');
    });

    Route::prefix('tasks')->name('tasks.')->group(function () {
        Route::get('index', [TasksController::class, 'index'])->name('index');
        Route::post('/updateStatus', [TasksController::class, 'updateStatus'])->name('updateStatus');
        Route::post('/updatePriority', [TasksController::class, 'updatePriority'])->name('updatePriority');
        Route::get('create', [TasksController::class, 'create'])->name('create');
        Route::post('store', [TasksController::class, 'store'])->name('store');
        Route::get('show/{task}', [TasksController::class, 'show'])->name('show');
        Route::get('edit/{task}', [TasksController::class, 'edit'])->name('edit');
        Route::put('update/{task}', [TasksController::class, 'update'])->name('update');
        Route::delete('destroy/{task}', [TasksController::class, 'destroy'])->name('destroy');
        Route::get('/search', [TasksController::class, 'search'])->name('search');
    });
});


**Contributing**:
Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the Laravel documentation.

**Code of Conduct**
In order to ensure that the Laravel community is welcoming to all, please review and abide by the Code of Conduct.

Security Vulnerabilities
If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via taylor@laravel.com. All security vulnerabilities will be promptly addressed.

License
The Laravel framework is open-sourced software licensed under the MIT license.



