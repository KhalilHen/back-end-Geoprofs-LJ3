# back-end-Geoprofs-LJ3

For realese change 'allowed_origins' in back-end-geoprofs\config\cors.php and change 'Access-Control-Allow-Origin' in back-end-geoprofs\app\Http\Middleware\Cors.php to the url of the front-end.

if logging in doesn't work try 
php artisan config:clear 
php artisan cache:clear
php artisan route:clear  