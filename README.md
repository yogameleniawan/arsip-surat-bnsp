# Laravel Arsip Surat

## Daftar Isi
- [Laravel Arsip Surat](#laravel-arsip-surat)
  - [Daftar Isi](#daftar-isi)
  - [Setup pertama kali](#setup-pertama-kali)
  - [Requirements](#requirements)
  - [Copyright](#copyright)


## Setup pertama kali
1. Clone repository
	```bash
	# Clone dengan SSH
	git clone git@github.com/yogameleniawan/arsip-surat-bnsp.git
	# Clone dengan HTTPS
	git clone https://github.com/yogameleniawan/arsip-surat-bnsp.git
	```
2. Install laravel dan php dependency
	```
	composer install
	```
3. Setup konfigurasi  
Buat file `.env` di root project dan copy isi file `.env.example` ke `.env`  
Ubah konfigurasi sesuai keperluan. Pastikan `APP_URL_BASE` sudah benar
	```bash
	# Unix/Linux/Windows Powershell
	cp .env.example .env
	# Windows CMD
	copy .env.example .env
	```
4. Generate application key
	```
	php artisan key:generate
	```
5. Migrasi database  
Pastikan konfigurasi database di `.env` sudah benar
	```
	php artisan migrate
	```
6. Seed database _[opsional]_
	```
	php artisan db:seed
	```
7. Install node dependency
	```
	npm install
	```
8. Running Aplikasi
    Jalankan perintah dibawah ini :
    ```
	php artisan serve
    ```
    
## Requirements
- PHP >= 8.0
- MySQL >= 8.0
- [NodeJs >= 14.0](https://nodejs.org/en/download/)
- Apache >= 2.4.26 / Nginx >= 1.18
- [Laravel Requirements](https://laravel.com/docs/8.x/installation)

## Copyright
2022 [Yoga Meleniawan Pamungkas](https://www.linked.in/id/yogameleniawan)
