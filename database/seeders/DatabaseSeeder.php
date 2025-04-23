<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
// Asegúrate de importar los seeders
use Database\Seeders\CategorySeeder;
use Database\Seeders\DepartmentSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        // Llama a los seeders de Categorías y Departamentos
        $this->call(CategorySeeder::class);
        $this->call(DepartmentSeeder::class);
    }
}
