<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ThemeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = storage_path('app/private/data_init/themes.sql');
        if (File::exists($path)) {
            $this->command->info('Iniciando la importación de configuración desde SQL...');

            // Leemos el contenido del archivo
            $sql = File::get($path);

            // 1. Obtenemos la URL del .env (ej: http://tienda-edelys.test)
            // Usamos parse_url para extraer solo el dominio si es necesario
            $appUrl = config('app.url');

            // 2. Reemplazamos el placeholder por el valor dinámico
            $sql = str_replace('{{APP_URL}}', $appUrl, $sql);

            try {
                // DB::unprepared es ideal para ejecutar bloques de SQL crudo (inserts)
                DB::unprepared($sql);

                $this->command->info('¡Configuración de Bagisto cargada correctamente!');
            } catch (\Exception $e) {
                $this->command->error('Error al ejecutar el SQL: '.$e->getMessage());
            }
        } else {
            $this->command->error('No se encontró el archivo SQL en: '.$path);
            $this->command->warn('Asegúrate de que el archivo exista en: storage/private/data_init/themes.sql');
        }
    }
}
