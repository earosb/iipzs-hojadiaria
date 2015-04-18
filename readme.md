#Icil Icafal Proyecto Zona Sur S.A.
Sistema Icil Icafal Proyecto Zona Sur S.A.

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
- Instalar servidor web (LAMP, WAMP, XAMPP, etc.)
- Instalar [composer](http://getcomposer.org/)
- Clonar repositorio
- Crear virtual host ~/iipzs/public_html/

###Aplicación
- Dentro de app_core ejecutar
```
$ composer install
```
- Crear manualmente bbdd llamada icilicaf_db
```
$ mysql> CREATE DATABASE icilicaf_db;
```
- Migrar
```
$ php artisan migrate
```
- Poblar bbdd
```
$ php artisan db:seed
```
- Instalar Syntara
```
$ php artisan syntara:install
```
- Crear usuario administrador
```
$ php artisan create:user [username] [email] [password] Admin
```
```
$ php artisan syntara:update
```
`NOTA:`Por defecto el login se realiza con el email, leer manual de [syntara](https://github.com/MrJuliuss/syntara) para cambiar email por username.

<blockquote>
  <p>Enjoy!.</p>
</blockquote>
