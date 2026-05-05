<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sindicato;
use App\Models\SindicatoRadiotaxi;
use App\Models\Trufi;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard', [
            'stats' => [
                'total_trufis' => Trufi::query()->count(),
                'trufis_activos' => Trufi::query()->where('estado', true)->count(),
                'total_rutas' => DB::table('trufi_rutas')->select('idtrufi')->distinct()->count('idtrufi'),
                'total_sindicatos' => Sindicato::query()->count(),
                'total_radiotaxis' => SindicatoRadiotaxi::query()->count(),
            ],
        ]);
    }
}
