## Installation
1. Install ekstensi GD PHP yang diperlukan untuk Intervention Image
```bash
sudo apt-get install php8.x-gd  # Ganti 8.x dengan versi PHP Anda (8.1, 8.2, dll)r
```

## Requirements
> Instal Laravel Reverb, WebSocket bawaan Laravel untuk real-time features (chat, notif, dsb).
```bash
composer require laravel/reverb
```

> Meng-setup Reverb: membuat config, service provider, dan mempersiapkan environment WebSocket.
```bash
php artisan reverb:install
```
> Instal Intervention Image (v3), pustaka manipulasi gambar di Laravel seperti resize, crop, encode.

```bash
composer require intervention/image
```