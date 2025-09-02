<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder{
    public function run(){

        $this->call([
            Permiso_seeder::class,
            Rol_seeder::class,
            Usuario_seeder::class,
            GestionSeeder::class,
            Seeder_articulacion_pdes::class,
            Seeder_areas_estrategicas::class,
            Seeder_plan_foda::class,
            Seeder_foda_pei::class,
            Seeder_foda_pdu::class,
            Seeder_politica_desarrollo_pdu::class,
            Seeder_politica_desarrollo_pei::class,
            Seeder_configuracion::class,
            Seeder_indicador::class,
            Seeder_configuracion_tipo::class,
            Seeder_clasificador::class,
            Seeder_Detalles_clasificador::class,
            Seeder_medida::class,
        ]);
    }
}
