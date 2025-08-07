<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SystemStatus;

class SystemStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'service_name' => 'Plataforma Principal',
                'status' => 'operational',
                'description' => 'Sistema principal de gestión de tickets y soporte técnico'
            ],
            [
                'service_name' => 'Base de Datos',
                'status' => 'operational',
                'description' => 'Servidor de base de datos MySQL'
            ],
            [
                'service_name' => 'Servicios Web',
                'status' => 'operational',
                'description' => 'Servicios web y APIs del sistema'
            ],
            [
                'service_name' => 'Sistema de Notificaciones',
                'status' => 'operational',
                'description' => 'Sistema de envío de correos y notificaciones'
            ],
            [
                'service_name' => 'Servidor de Archivos',
                'status' => 'operational',
                'description' => 'Almacenamiento y gestión de archivos adjuntos'
            ]
        ];

        foreach ($services as $service) {
            SystemStatus::create($service);
        }
    }
}
