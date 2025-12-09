# EcoProvider

EcoProvider adalah layanan API sederhana untuk menyajikan berita lingkungan (EcoNews) yang dikonsumsi oleh aplikasi Green Saving.

Dokumentasi ini berisi langkah cepat untuk men-setup project di mesin lokal, menjalankan server, dan testing API.

## Persiapan (clone & dependency)

1. Clone repository dan masuk ke direktori project:

```powershell
git clone <repo-url> EcoProvider
cd EcoProvider
```

2. Install dependency PHP (Composer):

```powershell
composer install
```

## Konfigurasi environment

1. Salin file contoh `.env` dan generate app key:

```powershell
copy .env.example .env
php artisan key:generate
```

2. Atur koneksi database di `.env`.

- Untuk cepat, Anda bisa memakai SQLite (tidak perlu MySQL):

	- Buat file database:

		```powershell
		New-Item storage\database.sqlite -ItemType File
		```

	- Edit `.env` dan set:

		```dotenv
		DB_CONNECTION=sqlite
		DB_DATABASE=storage/database.sqlite
		```

3. (Jika pakai MySQL) isi `DB_HOST`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` sesuai konfigurasi lokal.

## Migrasi & Seed

Jalankan migrasi dan seeder agar tabel `news` terisi dengan data dummy:

```powershell
php artisan migrate
php artisan db:seed --class=NewsSeeder
```

## Storage link

Untuk membuat thumbnail dapat diakses dari browser, jalankan:

```powershell
php artisan storage:link
```

## Menjalankan server

Jalankan server development Laravel:

```powershell
php artisan serve --port=8001
```

Jika ingin membuat server dapat diakses dari komputer lain di jaringan lokal, jalankan:

```powershell
php artisan serve --host=0.0.0.0 --port=8001
```

Lalu berikan teman Anda URL `http://<your-ip>:8001/api/news`.

> Catatan: `localhost` atau `127.0.0.1` mengacu ke mesin yang sedang digunakan — pastikan teman menjalankan server di mesin mereka atau akses mesin Anda via IP/ngrok.

## Endpoint API

- `GET /api/news` — daftar semua berita
- `GET /api/news/{id}` — detail berita
- `GET /api/news-search?q=keyword` — pencarian berita

Contoh response (singkat):

```json
{
	"success": true,
	"data": [
		{
			"id": 1,
			"title": "Program Bank Sampah Nasional Tingkatkan Partisipasi Warga",
			"slug": "program-bank-sampah-nasional-tingkatkan-partisipasi-warga",
			"excerpt": "Program Bank Sampah Nasional berhasil...",
			"content": "Berita lengkap...",
			"thumbnail_url": "http://127.0.0.1:8001/storage/news/abc.jpg",
			"category": "Pengelolaan Sampah",
			"tags": [],
			"author": "Admin",
			"published_at": "2025-12-06T13:38:54.000000Z"
		}
	]
}
```

## Troubleshooting cepat

- Tidak ada berita setelah pull:
	- Pastikan teman menjalankan `composer install` lalu `php artisan migrate` dan `php artisan db:seed --class=NewsSeeder`.
	- Jika menggunakan SQLite, pastikan file `storage/database.sqlite` ada dan `.env` telah mengarah ke file tersebut.

- Endpoint `404` atau `routes` kosong:
	- Jalankan `php artisan route:clear` dan `php artisan optimize:clear`.
	- Pastikan `routes/api.php` benar dan `bootstrap/app.php` sudah memuat `api` routing (project ini sudah diperbarui untuk memuat `api.php`).

- Thumbnail tampil aneh (contoh: `storage/https://picsum...`):
	- Beberapa seed menggunakan absolute URL (picsum). Controller sekarang mencoba menambahkan `asset('storage/...')` untuk path relatif. Jika thumbnail sudah URL absolut, controller akan mengembalikan URL apa adanya. Jika Anda ingin memperbaiki data, edit `thumbnail_url` di database atau update seeder.

- GreenSaving tidak menampilkan berita:
	- Periksa apakah GreenSaving mengarah ke URL API yang tepat (`http://127.0.0.1:8001/api/news`) — ingat `localhost` berbeda di tiap mesin.
	- Jika GreenSaving berjalan di browser dan API berada di host berbeda, pastikan CORS diaktifkan. Untuk development cepat, tambahkan header `Access-Control-Allow-Origin: *` pada response API, atau gunakan package `fruitcake/laravel-cors`.

## Tips untuk berbagi ke tim

- Opsi cepat: beri teman script singkat dalam README (migrasi + seeder). Mereka harus menjalankan perintah di atas.
- Atau gunakan `ngrok` untuk expose server lokal Anda ke internet:

```powershell
ngrok http 8001
```

Copy URL ngrok dan bagikan kepada teman.

## Perbaikan yang sudah dilakukan di repo

- Menambahkan controller API (`app/Http/Controllers/Api/NewsApiController.php`) dengan format JSON `success/data`.
- Menambahkan logic untuk menghindari `storage/https://...` ketika `thumbnail_url` sudah absolute URL.
- Menambahkan views admin & frontend sederhana dan route `web.php`.

Jika Anda mau, saya bisa menambahkan `README` langkah untuk men-setup GreenSaving agar mengarah ke EcoProvider dengan mudah.

--
Jika perlu saya commit perubahan README ke branch `main` sekarang, konfirmasi dan saya akan melakukannya.
