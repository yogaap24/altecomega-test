<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400">
  </a>
</p>

## Instalasi Laravel

Langkah pertama, **clone repository** Laravel dari [https://github.com/yogaap24/altecomega-test](https://github.com/yogaap24/altecomega-test). Setelah berhasil clone, masuk ke direktori proyek dan pastikan **web server Anda aktif**.

Langkah kedua, pastikan **Composer terinstal** di sistem Anda. Untuk menginstal semua dependensi PHP yang dibutuhkan, jalankan perintah `composer install --ignore-platform-reqs` atau ika gagal run `composer update`.

Langkah ketiga, duplikat file `.env.example` dan ubah namanya menjadi `.env`, atau buat file `.env` baru dengan mengcopy isi dari `.env.example`.

Langkah keempat, **generate kunci aplikasi Laravel** dengan perintah `php artisan key:generate`. Pastikan file `.env` terkonfigurasi dengan benar, khususnya untuk setup database sesuai kebutuhan aplikasi Anda.

Langkah kelima, untuk memastikan koneksi database, jalankan `php artisan db:monitor` dan lakukan **migrasi database** dengan perintah `php artisan migrate --seed` untuk melakukan migrasi database dan seeder.

Apabila ingin melakukan test jalankan `php artisan test` (jika di Windows dan tidak pakai WSL jalankan `php artisan test --without-tty`). Dan jangan lupa untuk uncomment baris kode berikut di `phpunit.xml`:

```xml
<!-- <env name="DB_CONNECTION" value="sqlite"/> -->
<!-- <env name="DB_DATABASE" value=":memory:"/> -->
```

Atau buat file .env.testing dengan nilai:
```
DB_CONNECTION=sqlite
DB_DATABASE=:memory:
```
> **⚠️ Penting:** Pastikan php anda memiliki extension sqlite3 dan pdo_sqlite agar bisa melakukan koneksi ke sqlite.

Sisanya bisa diabaikan. Anda bisa memverifikasi apakah database pengujian digunakan dengan menjalankan pengujian di awal sebelum langkah `ke enam` atau sebelum anda menjalankan ```php artisan migrate --seed```.

Jika Anda ingin mencoba API, Anda bisa melihat dokumentasi di [Postman Documentation](https://documenter.getpostman.com/view/4450235/2sAYBSispJ) untuk lebih detailnya.

Jika Anda ingin menggunakan Docker, kami telah menyiapkan `docker-compose` dan `Dockerfile`. Anda hanya perlu mengisi konfigurasi berikut pada file `.env`:

```env
APP_URL=
APP_HOST=
IMAGE_NAME=
```
Serta jangan lupa ubah email pada ```/traefik/acme.json``` dengan email anda.
> **ℹ️ Info:** untuk login traefik anda bisa mengaksesnya dengan cara ``traefik.app_host``, kemudian usernya adalah ``admin`` dan passwordnya ```passadmin```


Setelah itu, jalankan perintah berikut untuk memulai layanan Docker:
```docker-compose up -d```