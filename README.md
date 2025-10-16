
---

## Prasyarat

Sebelum memulai, pastikan sudah menginstall:

```bash
php -v
composer -v
npm -v # jika menggunakan frontend
node -v
```
### Clone Repository
```bash
git clone https://github.com/Akbaresa/api-sendpick-test.git
```

### Masuk Kedalam Folder
```bash
cd api-sendpick-test
```

### Instalasi Composer
```bash
composer install
```

### Karena .env saya upload bisa langsung
```bash
php artisan key:generate
```

### buat database
```bash
php artisan migrate
```

### seed database
```bash
php artisan db:seed
```

### jalankan program
```bash
php artisan serve
```
### Arsitektur Aplikasi
```bash
├─ app/ # Logic utama aplikasi, model, controller, middleware
│ ├─ Console/
│ ├─ Exceptions/
│ ├─ Traits/
│ ├─ Http/
│ │ ├─ Controllers/ # Controller
│ │ └─ Middleware/ # Middleware
│ │ └─ Request/ 
│ ├─ Models/
│ └─ Providers/ 
│ └─ Service/ 
├─ bootstrap/ # File bootstrap aplikasi
├─ config/ # File konfigurasi aplikasi (database, mail, etc)
├─ database/
│ ├─ factories/ # Model factories
│ ├─ migrations/ # Migration untuk tabel database
│ └─ seeders/ # Seeder data awal
├─ public/ # File publik (index.php, asset, storage link)
├─ resources/
│ ├─ views/ # Blade template
│ ├─ js/ # JS frontend
│ └─ css/ # CSS frontend
├─ routes/ # Semua route aplikasi
│ ├─ web.php
│ └─ api.php
├─ storage/ # File cache, logs, dan upload
├─ tests/ # Unit test / Feature test
├─ vendor/ # Package composer
├─ artisan # Command-line Laravel
├─ composer.json # Dependensi PHP
├─ package.json # Dependensi frontend
├─ .env.example # Contoh environment file
└─ .env # Environment file
```

