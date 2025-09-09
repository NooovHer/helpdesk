<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;

class CompanyLogoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $companies = Company::all();

        foreach ($companies as $company) {
            // Por ahora dejamos el logo como null para que use el logo por defecto
            // Los logos se pueden subir manualmente a través de la interfaz de administración
            $company->update([
                'logo' => null
            ]);
        }
    }
}
