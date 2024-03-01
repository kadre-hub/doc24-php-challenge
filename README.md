# Doc24 > CRUD de turnos médicos

## Requerimientos

- PHP (Slim Framework)
- Composer
- PostgreSQL

## instalación

1. Clonar el repositorio: 
git clone 'repository-url'
2. Ingresar a la carpeta del proyecto: 
cd 'project-directory'
3. Instalar las dependencias: 
composer install
4. Crear la base de datos
5. Crear y configurar archivo .env en el raíz del proyecto, que incluya la siguiente configuración: DATABASE_DRIVER,DATABASE_PORT,DATABASE_NAME,DATABASE_USER,DATABASE_PASSWD,DATABASE_CHARSET,DATABASE_COLLATION,DATABASE_PREFIX

ENTITY_DIR = './src/Entity/'
DEBUG      = 0

## Post instalación

1. Instalar psr7: 
composer require slim/psr7
2. Instalación del ORM (Eloquent):
composer require illuminate/database "~5.1"
3. Instalar dependencia para validaciones: 
composer require respect/validation
4. Instalación de dependencia para el manejo del .env: 
composer require vlucas/phpdotenv
5. Instalar el phinx para crear y correr las migrations y seeds: 
composer require robmorgan/phinx
6. Correr migraciones: 
vendor/bin/phinx migrate
7. Correr seeds:
vendor/bin/phinx seed:run

## Corriendo la app

php -S localhost:[PORT] -t public

## Postman

Descargar la colección de Postman en la carpeta /api e importarla en Postman

## Aclaración

Falta:
Lo que es Auth (login, logout, configuración de usuario, JWT) 
Terminar de configurar el actualizarTurno, el método PUT en postman y en codigo


