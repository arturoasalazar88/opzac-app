### Aplicación para Operadora Version 1.1.1

Aplicación renovada para **Operadora**, ahora en conjunto con **Maxibus**  
Escrita en laravel con los siguientes requerimientos

#### Laravel 5.7

* PHP >= 7.1.3
* OpenSSL PHP Extension
* PDO PHP Extension
* Mbstring PHP Extension
* Tokenizer PHP Extension
* XML PHP Extension
* Ctype PHP Extension
* JSON PHP Extension
* BCMath PHP Extension

### Ajustes en los directorios

> Los siguientes cambios en la estructura de directorios fueron hechos
para un mejor funcionamiento en hostings más allá de un localhost

La carpeta **public** fue renombrada a **public_html** para hacer relación
completa a su homologo en el hosting, y es llevada un nivel más arriba de donde está, esto es **../**

#### Estructura inicial

+ Laravel Project
    + app (operadora)
        + public

#### Nueva estructura

+ Laravel Project
    + app (operadora)
    + public_html


### Ajustes en el archivo .env

> Recuerde cambiar los datos del archivo .env a los requeridos para su entorno
 de desarrollo, como los siguientes datos para el uso de la base de datos.

 - DB_CONNECTION=mysql
 - DB_HOST=127.0.0.1
 - DB_PORT=3306
 - DB_DATABASE=
 - DB_USERNAME=root
 - DB_PASSWORD=

> En futuras referencias y un desarrollo más avanzado el uso de
 estás variables para el envío de mensajes

 - MAIL_DRIVER=smtp
 - MAIL_HOST=smtp.mailtrap.io
 - MAIL_PORT=2525
 - MAIL_USERNAME=null
 - MAIL_PASSWORD=null
 - MAIL_ENCRYPTION=null

### Database

Este proyecto contiene seeders para poblar la base de datos
se pueden encontrar en **/operadora/database/seeds**  

* CompaniesTableSeeder.php
* HotelsTableSeeder.php
* RolesTableSeeder.php
* ToursTableSeeder.php
* UsersTableSeeder.php
* ZonesTableSeeder.php

Si se desea se pueden ejecutar por separado mediante la consola a conveniencia
con **artisan**

`` php artisan db:seed --class=UsersTableSeeder``

O en conjunto con el siguiente comando, el cual llamaría a la clase DatabaseSeeder la cual
llama a todos los archivos individuales

`` php artisan db:seed``

### SQL

La versión de los datos de prueba, están almacenados en la carpeta DB del proyecto, ahí
se encuentra el archivo **operadora_db.sql** con la definición de las tablas e inserción
de algunos datos.

Lo malo de este enfoque a diferencia de los seeders, es que en los campos están las fechas fijas y en los seeders usan el helper de fechas **Carbon**

En los seeders se pueden revisar los datos de los usuarios, si se desea modificarlos.

### Migración

La aplicación tiene la base de datos dividida por migraciones las cuales están en la ruta **/operadora/database/migrations** una por cada modelo usado en la web.  
Para migrar la base de datos desde **artisan** se puede usar el siguiente comando

`` php artisan migrate``

Si se desea migrar la base de datos y al mismo tiempo poblarla con los datos de los seeders se
puede usar el siguiente comando de **artisan**

`` php artisan migrate:fresh --seed``

### Datos de Pruebas

Al hacer la migración, o importar el SQL, todos los usuarios llevan la contraseña **qwerty** exepto el usuario *admin@admin.com* que lleva de contraseña **admin123** por el momento.

Para pruebas y ver algunas diferencias, se puede acceder como **jon@gmail.com** un usuario que no es administrador, y con **jane@example.com** un usuario que sí lo es.

Al realizar las migraciones ya existen datos de prueba para las zonas, hoteles, reservaciones y tours, estos datos se pueden modificar a necesidad.

> los métodos de eliminación de datos, aún no están definidos por falta de
  lógica de negocio.
