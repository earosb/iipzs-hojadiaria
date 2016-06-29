#Icil Icafal Proyecto Zona Sur S.A.
Sistema Icil Icafal Proyecto Zona Sur S.A.

- Laravel 4.2.x
##Librerías utilizadas
###Backend

- <https://github.com/JeffreyWay/Laravel-4-Generators>
- <https://github.com/cartalyst/sentry>
- <https://github.com/barryvdh/laravel-debugbar>
- <https://github.com/MrJuliuss/syntara>
- <https://github.com/briannesbitt/Carbon>
- <https://github.com/fitztrev/laravel-html-minify>
- <https://github.com/Maatwebsite/Laravel-Excel>

###Fontend

- <https://github.com/jquery/jquery>
- <https://github.com/twbs/bootstrap>
- <http://bootswatch.com/yeti/>
- <http://jqueryui.com/>
- <https://github.com/fabien-d/alertify.js>
- <https://datatables.net/>
- <https://github.com/flatlogic/awesome-bootstrap-checkbox>

##Instalación
###Ecosistema
- PHP >= 5.4
- MCrypt PHP Extension
- JSON PHP Extension
- MySQL / PostgreSQL
- Apache / Nginx
- [composer](http://getcomposer.org/)
- [nodejs](https://nodejs.org/), [npm](https://www.npmjs.com) y [bower](https://bower.io)
- Clonar repositorio
- Crear host virtual ~/iipzs/public_html/

###Aplicación
- Dentro de app_core ejecutar
```
~/iipzs/app_core$ composer install
```
- Crear manualmente bbdd llamada icilicaf_db (iipzs en homestead)
```
~/iipzs/app_core$ mysql> CREATE DATABASE icilicaf_db;
```
- Instalar Syntara
```
~/iipzs/app_core$ php artisan syntara:install
```
- Crear usuario administrador
```
~/iipzs/app_core$ php artisan create:user [username] [email] [password] Admin
```
```
~/iipzs/app_core$ php artisan syntara:update
```
`nota:`Por defecto el login se realiza con el email, leer manual de [syntara](https://github.com/MrJuliuss/syntara) para cambiar email por username.
- Migrar base de datos
```
~/iipzs/app_core$ php artisan migrate
```
- Poblar bbdd
```
~/iipzs/app_core$ php artisan db:seed
```
- Instalar dependencias node
```
~/iipzs/app_core$ npm install
```
- Instalar dependencias bower
```
~/iipzs/app_core$ bower install
```
- Compilar assets
```
~/iipzs/app_core$ gulp default
```

Enjoy!