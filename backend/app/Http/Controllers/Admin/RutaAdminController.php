<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Trufi;
use App\Models\TrufiRutaUbicacion;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class RutaAdminController extends Controller
{
    public function listarRutas(Request $request): View|RedirectResponse
    {
        $usuario = $request->user();
        if (! $usuario) {
            return redirect()->route('admin.login');
        }

        $trufiId = $request->query('trufi_id');

        $query = DB::table('trufi_rutas')
            ->select(
                'idtrufi',
                DB::raw('MIN(orden) as orden_inicio'),
                DB::raw('MAX(orden) as orden_fin'),
                DB::raw('COUNT(*) as total_puntos')
            )
            ->groupBy('idtrufi')
            ->orderBy('idtrufi');

        if ($trufiId) {
            $query->where('idtrufi', $trufiId);
        }

        return view('admin.rutas.index', [
            'rutas' => $query->paginate(20),
            'trufis' => Trufi::query()->orderBy('nom_linea')->get(),
            'trufiId' => $trufiId,
            'usuario' => $usuario,
        ]);
    }

    public function mostrarCrearRuta(): View
    {
        $trufis = DB::table('trufis as t')
            ->leftJoin('trufi_rutas as r', 'r.idtrufi', '=', 't.idtrufi')
            ->whereNull('r.idtrufi')
            ->select('t.idtrufi', 't.nom_linea')
            ->orderBy('t.nom_linea')
            ->get();

        return view('admin.rutas.create', compact('trufis'));
    }

    public function guardarRuta(Request $request): RedirectResponse
    {
        $request->validate([
            'idtrufi' => ['required', 'integer', 'exists:trufis,idtrufi'],
            'geojson' => ['required', 'string'],
        ]);

        $coords = $this->extractCoordinates($request->input('geojson'));
        if ($coords === null) {
            return back()->withInput()->with('error', 'Debes dibujar una línea válida con al menos 2 puntos.');
        }

        $idtrufi = (int) $request->input('idtrufi');

        DB::beginTransaction();

        try {
            DB::table('trufi_rutas')->where('idtrufi', $idtrufi)->delete();

            $rows = [];
            $orden = 1;
            foreach ($coords as [$lng, $lat]) {
                $rows[] = [
                    'idtrufi' => $idtrufi,
                    'latitud' => $lat,
                    'longitud' => $lng,
                    'orden' => $orden,
                    'puntos' => false,
                    'es_parada' => false,
                    'estado' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                $orden++;
            }
            DB::table('trufi_rutas')->insert($rows);

            TrufiRutaUbicacion::query()->where('idtrufi', $idtrufi)->delete();
            $ordenUbicacion = 1;
            foreach ($coords as [$lng, $lat]) {
                TrufiRutaUbicacion::create([
                    'idtrufi' => $idtrufi,
                    'orden' => $ordenUbicacion,
                    'nombre_via' => 'Punto '.$ordenUbicacion,
                    'latitud' => $lat,
                    'longitud' => $lng,
                    'meta' => ['lat' => $lat, 'lon' => $lng],
                    'estado' => true,
                ]);
                $ordenUbicacion++;
            }

            DB::commit();

            return redirect()
                ->route('admin.rutas.index')
                ->with('success', 'Ruta y paradas guardadas correctamente.');
        } catch (\Throwable $e) {
            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', 'Ocurrió un error al guardar la ruta: '.$e->getMessage());
        }
    }

    public function mostrarEditarRuta(int $idtrufi): View|RedirectResponse
    {
        if (! request()->user()) {
            return redirect()->route('admin.login');
        }

        $trufis = DB::table('trufis')
            ->select('idtrufi', 'nom_linea')
            ->orderBy('nom_linea')
            ->get();

        $puntos = DB::table('trufi_rutas')
            ->where('idtrufi', $idtrufi)
            ->orderBy('orden')
            ->get(['latitud', 'longitud'])
            ->map(fn ($punto) => [(float) $punto->longitud, (float) $punto->latitud])
            ->values()
            ->all();

        $geojsonRuta = [
            'type' => 'FeatureCollection',
            'features' => count($puntos) > 0
                ? [[
                    'type' => 'Feature',
                    'geometry' => [
                        'type' => 'LineString',
                        'coordinates' => $puntos,
                    ],
                    'properties' => new \stdClass,
                ]]
                : [],
        ];

        $ubicaciones = TrufiRutaUbicacion::query()
            ->where('idtrufi', $idtrufi)
            ->orderBy('orden')
            ->get();

        return view('admin.rutas.edit', compact(
            'trufis',
            'idtrufi',
            'ubicaciones',
            'geojsonRuta'
        ));
    }

    public function actualizarRuta(Request $request, int $idtrufi): RedirectResponse
    {
        if (! $request->user()) {
            return redirect()->route('admin.login');
        }

        $request->validate([
            'geojson' => ['required', 'string'],
        ]);

        $coords = $this->extractCoordinates($request->input('geojson'));
        if ($coords === null) {
            return back()->withInput()->with('error', 'Debes dibujar una línea válida con al menos 2 puntos.');
        }

        DB::beginTransaction();

        try {
            DB::table('trufi_rutas')->where('idtrufi', $idtrufi)->delete();

            $rows = [];
            $orden = 1;
            foreach ($coords as [$lng, $lat]) {
                $rows[] = [
                    'idtrufi' => $idtrufi,
                    'latitud' => $lat,
                    'longitud' => $lng,
                    'orden' => $orden,
                    'puntos' => false,
                    'es_parada' => false,
                    'estado' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                $orden++;
            }
            DB::table('trufi_rutas')->insert($rows);

            TrufiRutaUbicacion::query()->where('idtrufi', $idtrufi)->delete();
            $ordenUbicacion = 1;
            foreach ($coords as [$lng, $lat]) {
                TrufiRutaUbicacion::create([
                    'idtrufi' => $idtrufi,
                    'orden' => $ordenUbicacion,
                    'nombre_via' => 'Punto '.$ordenUbicacion,
                    'latitud' => $lat,
                    'longitud' => $lng,
                    'meta' => ['lat' => $lat, 'lon' => $lng],
                    'estado' => true,
                ]);
                $ordenUbicacion++;
            }

            DB::commit();

            return redirect()
                ->route('admin.rutas.index')
                ->with('success', 'Ruta y paradas actualizadas correctamente.');
        } catch (\Throwable $e) {
            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', 'Ocurrió un error al actualizar la ruta: '.$e->getMessage());
        }
    }

    public function verUbicaciones(int $idtrufi): View|RedirectResponse
    {
        if (! request()->user()) {
            return redirect()->route('admin.login');
        }

        $trufi = Trufi::query()->where('idtrufi', $idtrufi)->firstOrFail();

        $puntos = DB::table('trufi_rutas')
            ->where('idtrufi', $idtrufi)
            ->orderBy('orden')
            ->get(['latitud', 'longitud'])
            ->map(fn ($punto) => [(float) $punto->longitud, (float) $punto->latitud])
            ->toArray();

        $ubicaciones = TrufiRutaUbicacion::query()
            ->where('idtrufi', $idtrufi)
            ->orderBy('orden')
            ->get();

        return view('admin.rutas.ver_ubicaciones', compact('trufi', 'puntos', 'ubicaciones', 'idtrufi'));
    }

    public function eliminarRuta(int $idtrufi): RedirectResponse
    {
        if (! request()->user()) {
            return redirect()->route('admin.login');
        }

        DB::beginTransaction();

        try {
            DB::table('trufi_rutas')->where('idtrufi', $idtrufi)->delete();
            TrufiRutaUbicacion::query()->where('idtrufi', $idtrufi)->delete();
            DB::commit();

            return redirect()->route('admin.rutas.index')->with('success', 'Ruta eliminada correctamente.');
        } catch (\Throwable $e) {
            DB::rollBack();

            return redirect()->route('admin.rutas.index')
                ->with('error', 'No se pudo eliminar la ruta: '.$e->getMessage());
        }
    }

    private function extractCoordinates(string $geojsonRaw): ?array
    {
        $geojson = json_decode($geojsonRaw, true);
        if (! is_array($geojson) || empty($geojson['features'][0])) {
            return null;
        }

        $feature = $geojson['features'][0];
        if (($feature['geometry']['type'] ?? '') !== 'LineString') {
            return null;
        }

        $coords = $feature['geometry']['coordinates'] ?? [];
        if (! is_array($coords) || count($coords) < 2) {
            return null;
        }

        $normalized = [];
        foreach ($coords as $coord) {
            if (! is_array($coord) || count($coord) < 2) {
                return null;
            }
            $lng = (float) $coord[0];
            $lat = (float) $coord[1];
            $normalized[] = [$lng, $lat];
        }

        return $normalized;
    }
}
