# <p align="center">DESA TRAINER<a href="https://laravel.com" target="_blank"><img src="public\vendor\adminlte\dist\img\desa-heart.png" width="35" alt="Laravel Logo"></a></p>

### <p align="center">Contributors</p>
<p align="center">
<a href="https://github.com/imAko097"><img src="https://avatars.githubusercontent.com/u/123725691?s=64&v=4" alt="Acoidán"></a>
<a href="https://github.com/PhilipYang89"><img src="https://avatars.githubusercontent.com/u/108484470?s=64&v=4" alt="Felipe"></a>
<a href="https://github.com/GitAntonioHub"><img src="https://avatars.githubusercontent.com/u/181963079?s=64&v=4" alt="Antonio"></a>
<a href="https://github.com/MiguelAngel18"><img src="https://avatars.githubusercontent.com/u/156090548?s=64&v=4" alt="Miguel"></a>
</p>

## About

This project has the main goal of simulating what would be a real-life scenario with a DESA device, in a way that it is more accessible for everybody to understand without the need of a physical device.

Done with:
- <a href="https://laravel.com" rel="nofollow"><img src="https://camo.githubusercontent.com/839c2b7156d9a4e8f021ae6c539331e84ea18bf0fd0ee15835f0695a838b292e/68747470733a2f2f696d672e736869656c64732e696f2f62616467652f4c61726176656c2d4646324432303f7374796c653d666f722d7468652d6261646765266c6f676f3d6c61726176656c266c6f676f436f6c6f723d7768697465" alt="Laravel" data-canonical-src="https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&amp;logo=laravel&amp;logoColor=white" style="max-width: 50%;"></a>
- Jetstream , Livewire and many other libraries.

## Requirements

- PHP 8.2 +
- MySQL 5.7+ or MariaDB 10.3+
- Composer 2.x+
- Node.js 18+

## Setup

Clone this repository. Install Composer.
```bash
composer install
```
Clone the .env template and edit parameters.
```bash
cp .env.example .env
```
Generate an APP_KEY for security reasons.
```bash
php artisan key:generate
```
Create an empty database file.
```bash
touch database/database.sqlite
```
Execute database migrations.
```bash
php artisan migrate
```
Execute these commands to install needed packages.
```bash
npm install
npm run build
```
Finally, we need to associate storage pathing in order to save all the images.
```bash
php artisan storage:link
```

## Contributions

Thanks to our teacher Sergio Ramos and Inventia for all the documentation given to us which helped us considerably on making progress with this project.

## Production Site
https://desatrainer7.elnucleo.org/

#### README made by Philip