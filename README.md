# 2024 - Aplikasi Inventaris Gudang

Backend untuk aplikasi Inventaris Gudang


## Installation

1. Clone this repository
```
git clone https://github.com/defrindr/2024-pengajuan-barang.git
```
2. Goto application folder and install dependecies
```
composer install
```
3. copy .env & setup database connection
4. Generate laravel key & jwt secret
```
php arisan key:generate
php artisan jwt:secret
```
5. Running Seeder
```
php artisan migrate:fresh --seed
```
7. Serve application
```
php artisan serve
```
