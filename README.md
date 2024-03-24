# Sepatu Bersih
Instalasi:
```sh
git clone https://github.com/rico-r/sepatu-bersih.git
cd sepatu-bersih
composer install
cp .env.example .env
php artisan key:generate
```
Buat database kosong dengan nama terserah. Kemudian isi username, password dan nama database pada file `.env` sesuai dengan database yang telah dibuat.
```sh
php artisan migrate
php artisan db:seed
php artisan serve
```