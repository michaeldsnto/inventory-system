<<<<<<< HEAD
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

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
=======
# Inventory Management System

A comprehensive web-based inventory management system built with Laravel, designed to help businesses track and manage their inventory efficiently.

## Features

### Core Functionality
- **User Authentication & Authorization**: Role-based access control (Admin/Staff)
- **Dashboard**: Overview of inventory statistics and recent activities
- **Item Management**: CRUD operations for inventory items with categories and suppliers
- **Supplier Management**: Manage supplier information and relationships
- **Category Management**: Organize items into categories
- **Transaction Tracking**: Record stock in/out transactions with detailed logging
- **Reporting**: Generate inventory and transaction reports in PDF and Excel formats

### Advanced Features
- **Low Stock Alerts**: Automatic notifications for items below minimum stock levels
- **Search & Filtering**: Advanced search and filtering capabilities
- **Image Upload**: Support for item images
- **Export Functionality**: Export data to Excel format
- **PDF Reports**: Generate printable reports
- **Responsive Design**: Mobile-friendly interface

## Technology Stack

- **Backend**: Laravel 12 (PHP 8.2+)
- **Frontend**: Blade Templates, Tailwind CSS
- **Database**: MySQL
- **Authentication**: Laravel Sanctum
- **File Storage**: Laravel Storage (Local/Public)
- **PDF Generation**: DomPDF
- **Excel Export**: Maatwebsite Excel
- **JavaScript**: Vite, Alpine.js

## Prerequisites

Before you begin, ensure you have met the following requirements:

- PHP 8.2 or higher
- Composer
- Node.js & NPM
- MySQL or another supported database
- Web server (Apache/Nginx) or PHP built-in server

## Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/your-username/inventory-system.git
   cd inventory-system
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node.js dependencies**
   ```bash
   npm install
   ```

4. **Environment Configuration**
   ```bash
   cp .env.example .env
   ```

   Update the `.env` file with your database credentials:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=inventory_system
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

5. **Generate Application Key**
   ```bash
   php artisan key:generate
   ```

6. **Run Database Migrations**
   ```bash
   php artisan migrate
   ```

7. **Seed the Database** (Optional - creates sample data)
   ```bash
   php artisan db:seed
   ```

8. **Build Assets**
   ```bash
   npm run build
   ```

9. **Start the Development Server**
   ```bash
   php artisan serve
   ```

   The application will be available at `http://localhost:8000`

## Usage

### Default Login Credentials

After seeding the database, you can log in with:

- **Admin User**:
  - Email: `admin@admin.com`
  - Password: `password`

- **Staff User**:
  - Email: `staff@staff.com`
  - Password: `password`

### Key Routes

- `/` - Redirects to login
- `/dashboard` - Main dashboard
- `/items` - Item management
- `/suppliers` - Supplier management
- `/categories` - Category management
- `/transactions` - Transaction history
- `/reports/inventory` - Inventory reports
- `/reports/transactions` - Transaction reports

## Database Schema

The system uses the following main tables:

- `users` - User accounts with role-based access
- `roles` - User roles (admin, staff)
- `items` - Inventory items
- `categories` - Item categories
- `suppliers` - Supplier information
- `transactions` - Stock movement records

## API Endpoints

The application provides RESTful API endpoints for programmatic access:

- `GET /api/items` - List items
- `POST /api/items` - Create item
- `GET /api/items/{id}` - Get item details
- `PUT /api/items/{id}` - Update item
- `DELETE /api/items/{id}` - Delete item

## Development

### Running Tests
```bash
php artisan test
```

### Code Formatting
```bash
./vendor/bin/pint
```

### Development Server with Hot Reload
```bash
npm run dev
```

## Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## Security

This application includes several security measures:

- CSRF protection on all forms
- Input validation and sanitization
- Role-based access control
- Secure password hashing
- XSS protection

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Support

If you encounter any issues or have questions:

1. Check the [Issues](https://github.com/your-username/inventory-system/issues) page
2. Create a new issue with detailed information
3. Contact the maintainers

## Acknowledgments

- [Laravel Framework](https://laravel.com/) - The PHP framework used
- [Tailwind CSS](https://tailwindcss.com/) - For styling
- [DomPDF](https://github.com/barryvdh/laravel-dompdf) - PDF generation
- [Maatwebsite Excel](https://github.com/Maatwebsite/Laravel-Excel) - Excel export functionality
>>>>>>> 5c77bf6155329fa35a4f5094544a8d66aa6f2288
