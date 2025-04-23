<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        Category::insert([
            ['name' => 'Soporte General'],
            ['name' => 'Problemas con Mi Computadora'],
            ['name' => 'Problemas con Internet o Red'],
            ['name' => 'Correo Electrónico y Comunicaciones'],
            ['name' => 'Accesos a Sistemas y Permisos'],
            ['name' => 'Accesos Físicos y Control de Ingreso'],
            ['name' => 'Instalación de Software'],
            ['name' => 'SAP y Sistemas Empresariales'],
            ['name' => 'Seguridad Informática'],
        ]);
    }
}
