<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard.index', [
            'stats' => [
                'usuarios_activos' => User::query()->where('activo', true)->count(),
                'sindicatos' => DB::table('sindicatos')->count(),
                'trufis' => DB::table('trufis')->count(),
            ],
        ]);
    }
}
