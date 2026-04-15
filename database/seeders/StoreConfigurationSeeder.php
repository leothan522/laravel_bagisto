<?php

namespace Database\Seeders;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class StoreConfigurationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @throws FileNotFoundException
     */
    public function run(): void
    {

        $path = storage_path('app/private/data_init/core_config.sql');
        if (File::exists($path)) {
            $this->command->info('Iniciando la importación de configuración desde SQL...');
            // Leemos el contenido del archivo
            $sql = File::get($path);

            $copyrigth = config('app.name').' '.date('Y');

            $sql = str_replace('{{APP_NAME}}', $copyrigth, $sql);

            try {
                // DB::unprepared es ideal para ejecutar bloques de SQL crudo (inserts)
                DB::unprepared($sql);

                $this->command->info('¡Configuración de Bagisto cargada correctamente!');
            } catch (\Exception $e) {
                $this->command->error('Error al ejecutar el SQL: '.$e->getMessage());
            }
        } else {
            $this->command->error('No se encontró el archivo SQL en: '.$path);
            $this->command->warn('Asegúrate de que el archivo exista en: storage/private/data_init/core_config.sql');
        }
    }
}
