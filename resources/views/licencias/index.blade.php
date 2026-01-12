
@extends('layouts.app')
@section('title', 'Licencias')
@section('content')
<link rel="stylesheet" href="{{ asset(path:'css/licencias/index-licencias.css') }}">
<div class="container" style="max-width: 1500px;">

    <div class="licenses-header">
        <div class="titulo-header">
            <h1><i class="bi bi-key-fill me-2"></i>Licencias Nuevas</h1>
        </div>
        <div class="header-stats">
            <span class="stat-item">
            <i class="bi bi-collection"></i>
            Total: <strong>{{ $licencias->total() }}</strong>
            </span>
            <span class="stat-separator">|</span>
        </div>
    </div>

    <div class="options-container-general">
        <div class="options-container">
            <a class="option-toggle-btn" href="#collapse-buttons" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="collapse-buttons">
                <i class="bi bi-gear-fill"></i>
                Opciones de Licencias
            </a>
            <a class="option-toggle-btn" href="#collapse-buttons-ecxel" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="collapse-buttons-ecxel">
                <i class="bi bi-file-earmark-excel-fill"></i>
                Opciones para Excel
            </a>
            <a class="option-toggle-btn" href="#collapse-filtros" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="collapse-filtros">
                <i class="bi bi-funnel-fill"></i>
                Filtros
            </a>
        </div>
        <div class="options-container">
            <button class="btn option-toggle-btn" data-bs-toggle="modal" data-bs-target="#modalTotales">
                <i class="bi bi-graph-up"></i> Ver Totales
            </button>
            <button class="btn option-toggle-btn" data-bs-toggle="modal" data-bs-target="#modalInformation" title="Information">
                <i class="bi bi-info-square"></i>
            </button>
        </div>
    </div>

    <div class="collapse" id="collapse-buttons">
        <div class="collapse-section">
            <div class="action-buttons-grid">
                <a href="{{ route('licencias.create') }}" class="action-btn btn-primary-custom">
                    <i class="bi bi-plus-circle-fill"></i>
                    Agregar Licencia
                </a>
                <a href="{{ route('licencias.usadas') }}" class="action-btn btn-info-custom">
                    <i class="bi bi-check-circle-fill"></i>
                    Ver Licencias Usadas
                </a>
                <a href="{{ route('licencias.defectuosas') }}" class="action-btn btn-danger-custom">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    Ver Licencias Defectuosas
                </a>
                <a href="{{ route('licencias.recuperadas') }}" class="action-btn btn-warning-custom">
                    <i class="bi bi-arrow-clockwise"></i>
                    Ver Licencias Recuperadas
                </a>
            </div>
        </div>
    </div>

    <div class="collapse" id="collapse-buttons-ecxel">
        <div class="collapse-section">
            <div class="action-buttons-grid">
                <button type="button" class="action-btn btn-success-custom" data-bs-toggle="modal" data-bs-target="#modalProveedores">
                    <i class="bi bi-building"></i>
                    Ver Proveedores (Excel)
                </button>
                <button type="button" class="action-btn btn-success-custom" data-bs-toggle="modal" data-bs-target="#modalTiposLicencias">
                    <i class="bi bi-tags-fill"></i>
                    Ver Tipos de Licencia (Excel)
                </button>
            </div>
        </div>
    </div>

    <div class="collapse" id="collapse-filtros">
        <div class="collapse-section">
            <div class="filter-container">
                <div class="d-flex align-items-center gap-3 flex-wrap">
                    <label for="filtro-tipo" class="filter-label">
                        <i class="bi bi-filter-circle-fill me-1"></i>
                        Filtrar por tipo:
                    </label>
                    <select id="filtro-tipo" class="filter-select" onchange="filtrarPorTipo()">
                        <option value="">-- Todos los tipos --</option>
                        @foreach ($tiposLicencias as $tipo)
                            <option value="{{ $tipo->id }}"
                                {{ (request('tipo') == $tipo->id || $tipoSeleccionado == $tipo->id) ? 'selected' : '' }}>
                                {{ $tipo->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="import-form-container">
        <div class="import-form-title">
            <i class="bi bi-cloud-upload-fill"></i>
            Importar Licencias desde Excel
        </div>
        <form action="{{ route('licencias.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="file-input-group">
                <input type="file" name="archivo" class="file-input-custom" required accept=".xlsx,.xls">

                <button class="import-btn" type="submit">
                    <i class="bi bi-upload me-1"></i>
                    Importar Excel
                </button>

                <a href="{{ route('licencias.plantilla_excel') }}"
                    class="download-template-btn"
                    title="Descargar Plantilla">
                    <i class="bi bi-download"></i>
                    Descargar Plantilla
                </a>
            </div>

            @error('archivo')
                <div class="error-message">
                    <i class="bi bi-exclamation-circle-fill"></i>
                    {{ $message }}
                </div>
            @enderror
        </form>
    </div>

    <div id="container-list-licencias" class="w-100">
        <x-licencias.lista_licencias :licencias="$licencias" :container="'container-list-licencias'" />
    </div>

    @if(session('success'))
    <script>
    Swal.fire({
        title: '¡Éxito!',
        text: '{{ session('success') }}',
        icon: 'success',
        confirmButtonText: 'Aceptar'
    });
    </script>
    @endif

    @if(session('error'))
    <script>
    Swal.fire({
        title: 'Error',
        text: '{{ session('error') }}',
        icon: 'error',
        confirmButtonText: 'Aceptar'
    });
    </script>
    @endif
    </div>
</div>
<div class="modal fade" id="modalProveedores" tabindex="-1" aria-labelledby="modalProveedoresLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalProveedoresLabel">Listado de Proveedores</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($proveedores as $proveedor)
                    <tr>
                        <td>{{ $proveedor->idProveedor }}</td>
                        <td>{{ $proveedor->nombreProveedor }}</td>
                    </tr>
                    @endforeach
                </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTiposLicencias" tabindex="-1" aria-labelledby="modalTiposLicenciaLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between align-items-center">
                <h5 class="modal-title" id="modalTiposLicenciaLabel">Listado Tipos de Licencia</h5>
                <div>

                <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalNuevoTipoLicencia">
                    + Agregar Tipo
                </button>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-hover">
                <thead class="table-ligth">
                    <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tiposLicencias as $tipos)
                    <tr>
                        <td>{{ $tipos->id }}</td>
                        <td>{{ $tipos->nombre }}</td>
                    </tr>
                    @endforeach
                </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalNuevoTipoLicencia" tabindex="-1" aria-labelledby="modalNuevoTipoLicenciaLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('tiposLicencia.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre del Tipo</label>
                        <input type="text" name="nombre" id="nombre" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalInformation" tabindex="-1" aria-labelledby="modalInformationLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content shadow-lg border-0 rounded-3">

                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title d-flex align-items-center gap-2" id="modalInformationLabel">
                    <i class="bi bi-info-circle-fill fs-4"></i>
                    Información importante sobre Pre-Claves
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>

                <div class="modal-body">
                    <section>
                    <h5 class="fw-bold mb-3">
                        <i class="bi bi-receipt text-primary me-2"></i> ¿Qué es la Pre-Clave o Voucher?
                    </h5>
                    <p class="text-muted">
                        La <strong>Pre-Clave</strong> o <strong>Voucher</strong> es un código temporal que debe
                        ser <span class="text-primary fw-semibold">canjeado</span> para obtener la clave de activación
                        real de un producto.
                    </p>
                    <p>
                        El formulario para canjear la clave le solicitara el numero de orden el cual puede visualizar en la tabla,
                        le pedira el codigo que tambien se encuentra en la tabla (Pre-Clave), el correo siempre sera el siguiente: <span class="text-primary fw-semibold">unik_store_peru@hotmail.com</span>
                    </p>

                    <div class="alert alert-info d-flex align-items-center gap-2" role="alert">
                        <i class="bi bi-link-45deg fs-4"></i>
                        <div>
                        Puedes canjear tu código en:
                        <a href="https://code4redeem.com/" target="_blank" class="fw-bold text-decoration-underline">https://code4redeem.com/</a>
                        </div>
                    </div>
                    </section>

                    <hr class="my-4">

                    <section>
                    <h5 class="fw-bold mb-3">
                        <i class="bi bi-building text-primary me-2"></i> Proveedor: Wincdkey Ltd
                    </h5>
                    <p class="text-muted">
                        Este método de canje <strong>solo aplica</strong> cuando el proveedor es
                        <strong>“Wincdkey Ltd”</strong>.
                    </p>

                    <ul class="list-unstyled ms-3">
                        <li><i class="bi bi-check-circle-fill text-success me-2"></i>
                        Si el código tiene <strong>18 caracteres</strong> ➝ Es una <span class="fw-bold">Pre-Clave</span>.
                        </li>
                        <li><i class="bi bi-check-circle-fill text-success me-2"></i>
                        Si la clave ya está disponible ➝ Se trata de la <span class="fw-bold">clave real</span>.
                        </li>
                    </ul>

                    <div class="alert alert-warning mt-3" role="alert">
                        Recuerda: Para otros proveedores, la clave real se carga directamente y no requiere canje.
                    </div>
                    </section>
                </div>

            </div>
        </div>
</div>

<script src="{{ asset('js/Licencias/index-licencias.js') }}"> </script>
<x-licencias.nueva.modal-usar/>
<x-licencias.nueva.modal-defectuosa/>

<script>
    @if(session('success'))
    Swal.fire({
        icon: 'success',
        title: '¡Éxito!',
        text: '{{ session('success') }}',
        confirmButtonColor: '#28a745',
        timer: 3000,
        timerProgressBar: true
    });
    @endif

    @if($errors->any())
    Swal.fire({
        icon: 'error',
        title: 'Error al procesar',
        html: `{!! implode('<br>', $errors->all()) !!}`,
        confirmButtonColor: '#dc3545'
    });
    @endif
</script>

@endsection
