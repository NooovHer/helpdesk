<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Whoops\Run;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{
    public function run()
    {
        Department::insert([
            ['name' => 'Administracion y Finanzas'],
            ['name' => 'Aseguramiento de Calidad'],
            ['name' => 'Asuntos Regulatorios'],
            ['name' => 'Calidad'],
            ['name' => 'Control de Calidad'],
            ['name' => 'Documentacion'],
            ['name' => 'Mantenimiento e Ingenieria'],
            ['name' => 'Operaciones'],
            ['name' => 'Produccion'],
            ['name' => 'Tecnologias de la Informacion'],
            ['name' => 'Validacion'],
        ]);
    }
}
