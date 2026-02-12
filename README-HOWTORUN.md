Cara menjalankan program 

1.pastikan sudah menginstal
-Composer
-Php(versi minimal PHP 8.2.12)
-Xampp


2.jalankan ini terlebih dahulu
-composer install
-cp .env.example .env
-php artisan key:generate

3.buka file .env dan pastikan seperti ini
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE= gunakan nama database kamu
DB_USERNAME=root
DB_PASSWORD=

4.setelah itu migrasi database 
-php artisan migrate

5.kode bisa dijalankan menggunakan 
-php artisan migrate atau composer run dev