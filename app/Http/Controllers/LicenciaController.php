<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\LicenciaServiceInterface;
use App\Services\HeaderServiceInterface;
use App\Exports\PlantillaLicenciaExport;
use App\Models\Licencia;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Preveedor;
use App\Models\TipoLicencia;
use Illuminate\Support\Facades\DB;


class LicenciaController extends Controller
{
    protected $licenciaService;
    protected $headerService;

    public function __construct(
        LicenciaServiceInterface $licenciaService,
        HeaderServiceInterface $headerService
    ) {
        $this->licenciaService = $licenciaService;
        $this->headerService = $headerService;
    }
    public function descargarPlantilla()
    {
        return Excel::download(new PlantillaLicenciaExport, 'plantilla_licencias.xlsx');
    }

    public function index(Request $request)
    {
        $tiposLicencias = TipoLicencia::all();
        $proveedores = Preveedor::all();
        $user = $this->headerService->getModelUser();
        $search = $request->input('search');
        $tipo = $request->input('tipo'); // nuevo filtro

        $licencias = $this->licenciaService->getLicenciasNuevasQuery()
            ->when($search, function ($query) use ($search) {
                $query->where('voucher_code', 'like', "%{$search}%");
            })
            ->when($tipo, function ($query, $tipo) {
                $query->where('id_tipo', $tipo);
            })
            ->with('tipoLicencia')
            ->orderByDesc('id')
            ->paginate(10)
            ->appends($request->all()); // mantiene todos los filtros al paginar
        //Totales por tipo de licencia
        
        $totalesPorTipo = \App\Models\Licencia::select('id_tipo', DB::raw('COUNT(*) as total'))
            ->where('estado', 'NUEVA')
            ->groupBy('id_tipo')
            ->with('tipoLicencia')
            ->get();
        // Si es AJAX (paginación o recarga parcial)
        if ($request->query('page') || $request->query('container')) {
            $view = view('components.lista_licencias', [
                'licencias' => $licencias,
                'container' => $request->query('container', 'container-list-licencias')
            ])->render();

            return response()->json(['html' => $view]);
        }
        // Carga inicial de la vista completa
        return view('licencias.index', [
            'licencias' => $licencias,
            'user' => $user,
            'search' => $search,
            'proveedores' => $proveedores,
            'tiposLicencias' => $tiposLicencias,
            'tipoSeleccionado' => $tipo,
            'totalesPorTipo' => $totalesPorTipo 
        ]);
    }

    /**
     * Mostrar formulario de registro de licencia.
     */
    public function create()
    {
        $user = $this->headerService->getModelUser();
        $tiposLicencia = \App\Models\TipoLicencia::all(); // Trae todos los tipos
        $proveedores = Preveedor::all(); // Trae todos los proveedores
        return view('licencias.create', compact('user', 'tiposLicencia', 'proveedores'));
    }


    /**
     * Registrar una nueva licencia.
     */
    public function store(Request $request)
    {
        
            $request->validate([
            'voucher_code' => 'required|string|max:100|unique:licencias,voucher_code',
            'id_tipo'      => 'required|exists:tipo_licencia,id',
            'idProveedor'  => 'required|exists:preveedor,idProveedor', // 👈 validar proveedor
            'orden_compra' => 'nullable|string|max:100',
        ], [
            'voucher_code.required' => 'Debes ingresar el código de la licencia.',
            'voucher_code.unique'   => 'Este código ya existe.',
            'id_tipo.required'      => 'Debes seleccionar el tipo de licencia.',
            'idProveedor.required'  => 'Debes seleccionar un proveedor.',
        ]);
        
        $this->licenciaService->crearLicencia($request->all());

        return redirect()->route('licencias.index')->with('success', 'Licencia registrada correctamente.');
    }

    /**
     * Importar licencias desde un archivo Excel.
     */
    public function importExcel(Request $request)
    {
        $request->validate([
            'archivo' => 'required|file|mimes:xlsx,xls',
        ]);

        try {
            $this->licenciaService->importarDesdeExcel($request->file('archivo'));

            return redirect()
                ->route('licencias.index')
                ->with('success', 'Licencias importadas correctamente.');

        } catch (\Illuminate\Database\QueryException $e) {
            // Si es por duplicado
            if ($e->getCode() === '23000') {
                return redirect()
                    ->route('licencias.index')
                    ->with('error', 'Licencias repetidas, verificar');
            }

            // Otro error inesperado
            return redirect()
                ->route('licencias.index')
                ->with('error', 'Ocurrió un error al importar las licencias.');
        }
    }

    /**
     * Mostrar formulario de cambio de estado con datos actuales.
     */
    public function showFormularioEstado($serial, $nuevoEstado)
    {
        $user = $this->headerService->getModelUser();
        $licencia = $this->licenciaService->buscarLicenciaPorCodigo($serial);

        return view("licencias.estados.formulario_{$nuevoEstado}", compact('licencia', 'user'));
    }

    /**
     * Procesar cambio de estado de la licencia.
     */
    public function cambiarEstado(Request $request, $serial)
    {
        //dd($request->all()); 
        $request->validate([
            'nuevo_estado' => 'required|in:USADA,DEFECTUOSA,RECUPERADA',
        ]);

        $datosForm = $request->except('nuevo_estado');
        if ($request->hasFile('archivo')) {
            $datosForm['archivo'] = $request->file('archivo');
        }
        $nuevoEstado = $request->input('nuevo_estado');

        $this->licenciaService->cambiarEstadoConFormulario($serial, $nuevoEstado, $datosForm);

        // Mensaje dinámico
        $mensaje = match($nuevoEstado) {
            'USADA' => 'Licencia marcada como usada correctamente.',
            'DEFECTUOSA' => 'Licencia marcada como defectuosa correctamente.',
            'RECUPERADA' => 'Licencia marcada como recuperada correctamente.',
            default => 'Estado de licencia actualizado.'
        };

        return redirect()->route('licencias.index')->with('success', $mensaje);
    }

    public function usadas(Request $request)
    {
        $user = $this->headerService->getModelUser();
        $search = $request->input('search');

        $licenciasUsadas = \App\Models\LicenciaUsada::with('licencia.tipoLicencia')
            ->when($search, function ($query, $search) {
                $query->where('serial_equipo', 'like', "%{$search}%")
                    ->orWhere('clave_key', 'like', "%{$search}%");
            })
            ->orderByDesc('id')
            ->paginate(15);

        return view('licencias.usadas', [
            'licenciasUsadas' => $licenciasUsadas,
            'user' => $user,
            'search' => $search
        ]);
    }




    public function defectuosas()
    {
        $user = $this->headerService->getModelUser();

        $licenciasDefectuosas = \App\Models\LicenciaDefectuosa::with('licencia.tipoLicencia','licencia.proveedor')
            ->where('estado', 'DEFECTUOSA') 
            ->orderByDesc('id')
            ->paginate(10);

        return view('licencias.defectuosas', [
            'licenciasDefectuosas' => $licenciasDefectuosas,
            'user' => $user
        ]);
    }
    public function recuperadas()
    {
        $user = $this->headerService->getModelUser();

        $licenciasRecuperadas = \App\Models\LicenciaRecuperada::with('licencia','licencia.proveedor')
            ->where('estado', 'RECUPERADA') 
            ->orderByDesc('id')
            ->paginate(10);

        return view('licencias.recuperadas', [
            'licenciasRecuperadas' => $licenciasRecuperadas,
            'user' => $user
        ]);
    }
    
    public function storeTipoLicencia(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:tipo_licencia,nombre',
        ]);

        \App\Models\TipoLicencia::create([
            'nombre' => $request->nombre,
        ]);

        return redirect()->back()->with('success', 'Tipo de licencia agregado correctamente');
    }

}
