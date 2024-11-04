# NT CMS Backend

## How to use

- Clone the repository with __git clone__
- Copy __.env.example__ file to __.env__ with __cp .env.example .env__
- Edit database credentials in __.env__
- Run __composer install__
- Run __php artisan key:generate__
- Run __php artisan migrate --seed__
- Run __php artisan serve__ (if you want to use other port add __--port=90__)