## Installation

Use the package manager [Composer](https://getcomposer.org/) to require RetechAdmin.

```bash
composer require default64bit/ratech-admin
```

## Usage

First publish the necessary files

```bash
php artisan vendor:publish Default64bit\RatechAdmin\RatechAdminServiceProvider
```

Then run the install command to configure settings and file systems

```bash
php artisan ratech-admin:install
```

Feel free to edit migration and models and after migrating run the seed command to make default super admin

```bash
php artisan migrate
php artisan db:seed
```

## License
[MIT](https://choosealicense.com/licenses/mit/)