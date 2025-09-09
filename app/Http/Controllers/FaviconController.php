<?php

namespace App\Http\Controllers;

use App\Helpers\CompanyHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FaviconController extends Controller
{
    /**
     * Servir el favicon dinámico según la empresa del usuario
     */
    public function show(Request $request)
    {
        try {
            $faviconUrl = CompanyHelper::getCurrentUserCompanyFavicon();

            // Redirigir directamente a la URL del favicon
            return redirect($faviconUrl);

        } catch (\Exception $e) {
            // Si hay error, servir el favicon por defecto
            return redirect(asset('favicon.ico'));
        }
    }
}
