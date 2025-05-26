## Project Structure (Redesigned & Explained)

Below is the hierarchical structure of the VisualImpairedAssistance Laravel project, showing the main folders and files:

```
VisualImpairedAssistance/
│
├── app/
│   ├── Console/
│   ├── Exceptions/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/
│   │   │   │   ├── DashboardController.php
│   │   │   │   ├── UserController.php
│   │   │   │   ├── DeviceController.php
│   │   │   │   ├── RoleController.php
│   │   │   │   ├── DangerZoneController.php
│   │   │   │   └── ReportController.php
│   │   │   └── Auth/
│   │   │       └── LoginController.php
│   │   ├── Middleware/
│   │   └── Requests/
│   ├── Models/
│   │   ├── User.php
│   │   ├── Device.php
│   │   ├── Role.php
│   │   ├── Permission.php
│   │   └── DangerZone.php
│   ├── Policies/
│   ├── Providers/
│   └── ...
│
├── bootstrap/
│   └── cache/
│
├── config/
│   ├── app.php
│   ├── auth.php
│   ├── database.php
│   └── ...
│
├── database/
│   ├── factories/
│   ├── migrations/   <!-- All migration files are stored in this folder -->
│   └── seeders/
│
├── public/
│   ├── index.php
│   ├── favicon.ico
│   └── ...
│
├── resources/
│   ├── css/
│   │   └── app.css
│   ├── js/
│   │   └── app.js
│   ├── sass/
│   │   └── app.scss
│   └── views/
│       ├── admin/
│       │   ├── dashboard/
│       │   │   └── index.blade.php
│       │   ├── users/
│       │   ├── devices/
│       │   ├── roles/
│       │   ├── danger-zones/
│       │   └── reports/
│       ├── auth/
│       │   └── login.blade.php
│       └── layouts/
│           ├── admin.blade.php
│           └── app.blade.php
│
├── routes/
│   ├── api.php
│   ├── channels.php
│   ├── console.php
│   └── web.php
│
├── storage/
│   ├── app/
│   ├── framework/
│   └── logs/
│
├── tests/
│   ├── Feature/
│   └── Unit/
│
├── vendor/
│   └── ... (Composer dependencies)
│
├── .env
├── .env.example
├── .gitignore
├── artisan
├── composer.json
├── composer.lock
├── package.json
├── phpunit.xml
├── vite.config.js
├── README.md
└── PROJECT_DESCRIPTION.md
```

**Key Points:**
- All business logic and models are in `app/`.
- All web assets and Blade templates are in `resources/`.
- All HTTP routes are in `routes/`.
- All configuration is in `config/`.
- All database migrations, factories, and seeders are in `database/` (the `migrations` folder contains all migration files).
- All static/public files are in `public/`.
- Documentation and project description are in `README.md` and `PROJECT_DESCRIPTION.md`.

This structure follows Laravel best practices and makes it easy to maintain, extend, and integrate with AI/IoT devices and mobile apps.
