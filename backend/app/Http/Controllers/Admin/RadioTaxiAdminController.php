<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SindicatoRadiotaxi;
use App\Models\SindicatoRadiotaxiParada;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RadioTaxiAdminController extends Controller
{
    public function index(Request $request)
    {
        $usuario = $request->user();
        if (! $usuario) {
            return redirect()->route('admin.login');
        }

        $radiotaxis = SindicatoRadiotaxi::with('parada')
            ->orderBy('nombre_comercial')
            ->paginate(20);

        return view('admin.radiotaxis.index', compact('radiotaxis', 'usuario'));
    }

    public function create(Request $request)
    {
        $usuario = $request->user();
        if (! $usuario) {
            return redirect()->route('admin.login');
        }

        return view('admin.radiotaxis.create', compact('usuario'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre_comercial' => ['required', 'string', 'max:255'],
            'telefono_base' => ['required', 'string', 'max:255'],
            'latitud' => ['required', 'numeric'],
            'longitud' => ['required', 'numeric'],
        ]);

        DB::beginTransaction();

        try {
            $radiotaxi = SindicatoRadiotaxi::create([
                'nombre_comercial' => $data['nombre_comercial'],
                'telefono_base' => $data['telefono_base'],
            ]);

            SindicatoRadiotaxiParada::updateOrCreate(
                ['sindicato_radiotaxi_id' => $radiotaxi->id],
                [
                    'latitud' => $data['latitud'],
                    'longitud' => $data['longitud'],
                    'estado' => true,
                ]
            );

            DB::commit();

            return redirect()->route('admin.radiotaxis.index')
                ->with('success', 'RadioTaxi y parada registrados correctamente.');
        } catch (\Throwable $e) {
            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', 'Ocurrió un error al guardar el radiotaxi: '.$e->getMessage());
        }
    }

    public function edit(Request $request, $id)
    {
        $usuario = $request->user();
        if (! $usuario) {
            return redirect()->route('admin.login');
        }

        $radiotaxi = SindicatoRadiotaxi::with('parada')->findOrFail($id);

        return view('admin.radiotaxis.edit', compact('radiotaxi', 'usuario'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'nombre_comercial' => ['required', 'string', 'max:255'],
            'telefono_base' => ['required', 'string', 'max:255'],
            'latitud' => ['required', 'numeric'],
            'longitud' => ['required', 'numeric'],
        ]);

        DB::beginTransaction();

        try {
            $radiotaxi = SindicatoRadiotaxi::findOrFail($id);

            $radiotaxi->update([
                'nombre_comercial' => $data['nombre_comercial'],
                'telefono_base' => $data['telefono_base'],
            ]);

            SindicatoRadiotaxiParada::updateOrCreate(
                ['sindicato_radiotaxi_id' => $radiotaxi->id],
                [
                    'latitud' => $data['latitud'],
                    'longitud' => $data['longitud'],
                    'estado' => true,
                ]
            );

            DB::commit();

            return redirect()->route('admin.radiotaxis.index')
                ->with('success', 'RadioTaxi actualizado correctamente.');
        } catch (\Throwable $e) {
            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', 'Ocurrió un error al actualizar el radiotaxi: '.$e->getMessage());
        }
    }

    public function destroy(Request $request, $id)
    {
        SindicatoRadiotaxiParada::where('sindicato_radiotaxi_id', $id)->delete();
        SindicatoRadiotaxi::where('id', $id)->delete();

        return redirect()->route('admin.radiotaxis.index')
            ->with('success', 'RadioTaxi eliminado correctamente.');
    }
}
