
# Sistema de formulación del Plan Operativo Anual UPEA

Sistema web para la planificación y formulacion del POA de la Universidad Pública de El Alto
## Instalación

Instalar proyecto

```bash
git clone https://github.com/garycdev/upea_poa.git

cd upea_poa

composer install && composer update
```


Configurar proyecto
```bash
cp .env.example .env

php artisan key:generate
```

Configurar base de datos (mysql)
```bash
mysql -u <usuario> -p
# Ingresar contraseña del usuario con permisos de create base de datos
```
Importar desde shell (opcional)
```bash
create database bd_poa;

use bd_poa;

# linux
source /ruta/del/archivo.sql
```

Ejecutar
```bash
php artisan serve
```