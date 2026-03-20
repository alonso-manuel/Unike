@extends('layouts.app')

@section('title', 'Registro masivo')
@section('content')
<div class="container">
    <div class="mt-4">
        <h4 class="mb-4">Importar licencias desde Excel</h4>
    </div>
    <form action="{{ route('licencias.importar.excel') }}"
          method="POST"
          enctype="multipart/form-data">

        @csrf

        <div class="card mb-4">
            <div class="card-header">Datos generales</div>
            <div class="card-body row g-3">

                <div class="col-md-4">
                    <label>Orden de compra</label>
                    <input type="text" name="orden_compra" class="form-control">
                </div>

                <div class="col-md-4">
                    <label>Tipo de licencia</label>
                    <select name="id_tipo" class="form-control" required>
                        <option value="">Seleccione</option>
                        @foreach($tiposLicencia as $tipo)
                            <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label>Proveedor</label>
                    <select name="idProveedor" class="form-control" required>
                        <option value="">Seleccione</option>
                        @foreach ($proveedores as $proveedor)
                            <option value="{{ $proveedor->idProveedor }}">
                                {{ $proveedor->nombreProveedor }} - {{ $proveedor->razSocialProveedor }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Categoría</label>
                    <select name="id_categoria" id="id_categoria" class="form-select" required>
                        <option value="">-- Seleccione una categoría --</option>
                        @foreach ($categorias as $cate)
                            <option value="{{ $cate->id_categoria }}"
                                    data-tipo="{{ $cate->tipo_categoria }}">
                                {{ $cate->tipo_categoria }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div id="usos-container" class="mb-3 d-none">
                    <label class="form-label">Cantidad máxima de usos</label>
                    <input type="number"
                        name="cantidad_usos"
                        id="cantidad_usos"
                        class="form-control"
                        min="1"
                        max="10"
                        value="1">
                </div>

            </div>
        </div>

        <div class="card">
            <div class="card-header">Archivo Excel</div>
            <div class="card-body">

                <div class="mb-3">
                    <label>Archivo (.xlsx)</label>
                    <input type="file" name="archivo" class="form-control" required>
                </div>

                <small class="text-muted">
                    El archivo debe contener únicamente la columna <strong>voucher_code</strong>
                </small>
            </div>
        </div>

        <div class="mt-4 text-end">
            <a href="{{ route('licencias.index') }}" class="btn btn-secondary">
                Cancelar
            </a>
            <a href="{{ route('licencias.plantilla_excel') }}"
                class="btn btn-primary"
                title="Descargar Plantilla">
                <i class="bi bi-download"></i>
                Descargar Plantilla
            </a>
            <button type="submit" class="btn btn-primary">
                Importar licencias
            </button>
        </div>

    </form>

    @if(isset($previewLicencias) && $previewLicencias->count())
    <div class="card mt-4 mb-5">
        <div class="card-header">
            Vista previa ({{ $previewLicencias->count() }} licencias encontradas)
        </div>
        <div class="card-body">

            <table class="table table-bordered table-sm">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Voucher Code</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($previewLicencias as $index => $licencia)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $licencia['voucher_code'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <form action="{{ route('licencias.confirmar.importacion') }}" method="POST">
                @csrf

                {{-- Pasamos las licencias codificadas --}}
                <input type="hidden"
                    name="licencias"
                    value="{{ base64_encode(json_encode($previewLicencias)) }}">

                {{-- Pasamos datos fijos --}}
                @foreach($datosFijos as $key => $value)
                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                @endforeach

                <div class="text-end mt-3">
                    <button type="submit" class="btn btn-success">
                        Confirmar Importación
                    </button>
                </div>
            </form>

        </div>
    </div>
@endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const categoriaSelect = document.getElementById('id_categoria');
    const usosContainer   = document.getElementById('usos-container');
    const usosInput       = document.getElementById('cantidad_usos');

    categoriaSelect.addEventListener('change', function () {
        const selected = this.options[this.selectedIndex];
        const tipo     = selected.getAttribute('data-tipo') || '';

        if (tipo.toLowerCase().includes('multiusuario')) {
            usosContainer.classList.remove('d-none');
            usosInput.required = true;

            if (!usosInput.value) {
                usosInput.value = 1;
            }
        } else {
            usosContainer.classList.add('d-none');
            usosInput.required = false;
            usosInput.value = 1;
        }
    });
});
</script>

@endsection
