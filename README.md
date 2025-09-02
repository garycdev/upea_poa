
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
php artisan migrate:fresh --seed
```

Ejecutar
```bash
php artisan serve
```