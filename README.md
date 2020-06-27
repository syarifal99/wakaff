## WakafZakat

## Server Requirements

- PHP >= 7.1.3
- OpenSSL PHP Extension
- PDO PHP Extension
- Mbstring PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension
- Ctype PHP Extension-
- JSON PHP Extension
- Composer
- Git

## Development Setup

- Clone repository.
- Buat database baru dengan nama bebas.
- Copy .env.example menjadi .env.
- Konfigurasi koneksi database pada file .env.
- Buka terminal dan run 'composer update'.
- Run 'php artisan key:generate'.
- Run 'composer dump-autoload -o'. (Opsional, Jika sudah ada projek ini sebelumnya)
- Run 'php artisan migrate --seed'.
- Setup selesai, run 'php artisan serve' untuk menjalankan aplikasi.
- Buka browser dan akses localhost:8000.
- Selesai.