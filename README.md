# Bus Booking System
The goal of this project is to implement a building a fleet-management system (bus-booking system) using the latest version of the Laravel Framework

## Framework

    Laravel - V.^10.10

## Packages And Main dependancies Used
<pre>
    <ul>
        <li>php              : ^8.1</li>
        <li>laravel/framework: ^10.10</li>
        <li>laravel/ui       : ^4.2</li>
        <li>tucker-eric/eloquentfilter  : ^3.2</li>
        <li>tymon/jwt-auth  : ^2.0</li>
        <li>yoeunes/toastr  : ^2.3</li>
        <li>infyomlabs/laravel-ui-adminlte  : ^5.2</li>
        <li>darkaonline/l5-swagger  : ^8.5</li>
    </ul>
</pre>

## Project Environment
<pre>
<code> copy .env.example .env</code>
set Your database local Config.,and set credentials to your Docker Config.
For Example:
    DB_CONNECTION=mysql
    DB_HOST=mysql
    DB_PORT=3306
    DB_DATABASE=homestead
    DB_USERNAME=homestead
    DB_PASSWORD=homestead
</pre>

## deployment

   after copping .env file and seeting your Database Credentials

   1- install composer with required dependancies
   
<pre><code>composer install</code></pre>

2- run npm install & npm run dev
    for using dashboard ui
   
<pre><code>run npm install & npm run dev</code></pre>

2- Serve Project on your port
   
<pre><code>php artisan serve --port=1234</code></pre>

## Dashboard link
    {APP_URL}/dashboard
### dashboard credentials
    Email   : admin@admin.com
    Password: 123456
## Api Swagger Documentation Route
    {APP_URL}/api/documentation

## Api link
    {APP_URL}/api
