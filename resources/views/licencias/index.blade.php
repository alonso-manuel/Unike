
@extends('layouts.app')
@section('title', 'Licencias')
@section('content')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/index_licencias.css') }}">
@endpush
<div class="container" style="max-width: 1500px;">

  <!-- Header Principal -->
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

  <!-- Botones de Opciones Principales -->
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
  <!-- Modal de Información -->
    <div class="modal fade" id="modalInformation" tabindex="-1" aria-labelledby="modalInformationLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content shadow-lg border-0 rounded-3">

        <!-- Header -->
        <div class="modal-header bg-primary text-white">
            <h5 class="modal-title d-flex align-items-center gap-2" id="modalInformationLabel">
            <i class="bi bi-info-circle-fill fs-4"></i>
            Información importante sobre Pre-Claves
            </h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>

        <!-- Body -->
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

<!-- Fin Modal de informacion -->

  <!-- Pruebas de Stock-->
    <!-- 🧮 Modal Totales -->
    <div class="modal fade" id="modalTotales" tabindex="-1" aria-labelledby="modalTotalesLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
        <div class="modal-header bg-primary text-white">
            <h5 class="modal-title" id="modalTotalesLabel">
            <i class="bi bi-graph-up"></i> Totales por tipo de licencia
            </h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
            @if($totalesPorTipo->count())
            <div class="table-responsive">
                <table class="table table-striped align-middle text-center">
                <thead>
                    <tr>
                    <th>Tipo de licencia</th>
                    <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($totalesPorTipo as $tipo)
                    <tr>
                        <td>{{ $tipo->tipoLicencia->nombre ?? 'Sin nombre' }}</td>
                        <td><strong>{{ $tipo->total }}</strong></td>
                    </tr>
                    @endforeach
                </tbody>
                </table>
            </div>
            @else
            <div class="alert alert-warning text-center mb-0">
                No hay licencias registradas aún.
            </div>
            @endif
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            Cerrar
            </button>
        </div>
        </div>
    </div>
    </div>
  <!-- Fin Pruebas de Stock-->

  <!-- Collapse: Opciones de Licencias -->
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

  <!-- Collapse: Opciones para Excel -->
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

  <!-- Collapse: Filtros -->
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

  <!-- Formulario de Importación Excel -->
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

{{-- Modal Listado de Proveedores Referencias (Ecxel) --}}

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
{{-- Modal Listado de Tipos de licencias referencia (Excel) --}}
<div class="modal fade" id="modalTiposLicencias" tabindex="-1" aria-labelledby="modalTiposLicenciaLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header d-flex justify-content-between align-items-center">
        <h5 class="modal-title" id="modalTiposLicenciaLabel">Listado Tipos de Licencia</h5>
        <div>
          {{-- Botón para abrir modal de nuevo tipo --}}
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


{{-- Modal Nuevo Tipo de Licencia --}}
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

{{-- Modal Licencias Defectuosas --}}
<div class="modal fade" id="modalLicenciaDefectuosa" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form id="formLicenciaDefectuosa" method="POST">
            @csrf
            <input type="hidden" name="nuevo_estado" value="DEFECTUOSA">

            <div class="modal-content defective-modal">
                <!-- Header Logístico -->
                <div class="modal-header defective-header">
                    <div class="d-flex align-items-center">
                        <div class="header-icon me-3">
                            <i class="bi bi-exclamation-triangle-fill"></i>
                        </div>
                        <div>
                            <h5 class="modal-title mb-0">Licencia Defectuosa</h5>
                            <small class="opacity-75">Control de Calidad - Inventario</small>
                        </div>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <!-- Cuerpo del Modal -->
                <div class="modal-body defective-body">
                    <!-- Clave de Activación -->
                    <div class="form-group">
                        <label class="form-label">
                            <i class="bi bi-key-fill me-2"></i>
                            Clave de Activación <span class="text-danger">*</span>
                        </label>
                        <div class="input-container">
                            <input type="text"
                                   name="clave_key"
                                   class="form-control defective-input"
                                   placeholder="Ingrese la clave de activación"
                                   >
                        </div>
                    </div>

                    <!-- Orden Compra -->
                    <div class="form-group">
                        <label class="form-label">
                            <i class="bi bi-receipt me-2"></i>
                            Orden de Compra
                        </label>
                        <div class="input-container">
                            <input type="text"
                                   name="orden"
                                   class="form-control defective-input readonly-input"
                                   placeholder="No asignada"
                                   readonly>
                        </div>
                    </div>

                    <!-- Número de Ticket -->
                    <div class="form-group">
                        <label class="form-label">
                            <i class="bi bi-ticket-perforated me-2"></i>
                            Número de Ticket
                        </label>
                        <div class="input-container">
                            <input type="text"
                                   name="numero_ticket"
                                   class="form-control defective-input"
                                   placeholder="Ej: TK-2024-001">
                        </div>
                    </div>

                    <!-- Proveedor -->
                    <div class="form-group">
                        <label class="form-label">
                            <i class="bi bi-building me-2"></i>
                            Proveedor
                        </label>
                        <div class="input-container">
                            <input type="text"
                                   name="razSocialProveedor"
                                   class="form-control defective-input readonly-input"
                                   placeholder="Sin proveedor asignado"
                                   readonly>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="modal-footer defective-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-lg me-2"></i>Cancelar
                    </button>
                    <button type="submit" class="btn btn-warning defective-btn">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>Marcar como Defectuosa
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<style>
/* ============================================
   VARIABLES DE COLOR
   ============================================ */
:root {
    --primary-color: #043e69;
    --primary-light: #0a5a94;
    --primary-dark: #022d4d;
    --secondary-color: #17a2b8;
    --success-color: #28a745;
    --danger-color: #dc3545;
    --warning-color: #ffc107;
    --light-bg: #f8f9fa;
    --white: #ffffff;
    --text-dark: #2c3e50;
    --text-muted: #6c757d;
    --border-color: #dee2e6;
    --shadow-sm: 0 2px 4px rgba(4, 62, 105, 0.08);
    --shadow-md: 0 4px 12px rgba(4, 62, 105, 0.12);
    --shadow-lg: 0 8px 24px rgba(4, 62, 105, 0.16);
}

/* ============================================
   HEADER PRINCIPAL
   ============================================ */
.licenses-header {
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);
    padding: 1rem 2rem;
    border-radius: 12px;
    margin-bottom: 2rem;
    margin-top: 2rem;
    box-shadow: var(--shadow-lg);
    color: var(--white);
    display: flex;
    justify-content: space-between;
}

.licenses-header h1 {
    font-size: 2rem;
    font-weight: 700;
    margin: 0;
    letter-spacing: -0.5px;
}
.header-stats {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 0.85rem;
    opacity: 0.95;
}
.options-container-general{
    display: flex;
    justify-content: space-between;
}
/* ============================================
   BOTONES DE OPCIONES PRINCIPALES
   ============================================ */
.options-container {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.option-toggle-btn {
    background: var(--white);
    color: var(--primary-color);
    border: 2px solid var(--primary-color);
    padding: 0.60rem 1.5rem;
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.95rem;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    box-shadow: var(--shadow-sm);
    text-decoration: none;
}

.option-toggle-btn:hover {
    background: var(--primary-color);
    color: var(--white);
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

.option-toggle-btn i {
    font-size: 1.1rem;
}

/* ============================================
   SECCIONES COLAPSABLES
   ============================================ */
.collapse-section {
    background: var(--white);
    border: 1px solid var(--border-color);
    border-radius: 10px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    box-shadow: var(--shadow-sm);
    animation: slideDown 0.3s ease;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* ============================================
   BOTONES DE ACCIÓN
   ============================================ */
.action-buttons-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
}

.action-btn {
    padding: 0.875rem 1.25rem;
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.9rem;
    border: none;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    box-shadow: var(--shadow-sm);
    text-decoration: none;
    justify-content: center;
}

.action-btn:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

.action-btn i {
    font-size: 1.1rem;
}

.btn-primary-custom {
    background: var(--primary-color);
    color: var(--white);
}

.btn-primary-custom:hover {
    background: var(--primary-dark);
    color: var(--white);
}

.btn-info-custom {
    background: var(--secondary-color);
    color: var(--white);
}

.btn-info-custom:hover {
    background: #138496;
    color: var(--white);
}

.btn-danger-custom {
    background: var(--danger-color);
    color: var(--white);
}

.btn-danger-custom:hover {
    background: #c82333;
    color: var(--white);
}

.btn-warning-custom {
    background: var(--warning-color);
    color: var(--text-dark);
}

.btn-warning-custom:hover {
    background: #e0a800;
    color: var(--text-dark);
}

.btn-success-custom {
    background: var(--success-color);
    color: var(--white);
}

.btn-success-custom:hover {
    background: #218838;
    color: var(--white);
}

/* ============================================
   FILTROS
   ============================================ */
.filter-container {
    background: var(--light-bg);
    padding: 1.25rem;
    border-radius: 8px;
    border-left: 4px solid var(--primary-color);
}

.filter-label {
    font-weight: 600;
    color: var(--primary-color);
    margin: 0;
    font-size: 0.95rem;
}

.filter-select {
    border: 2px solid var(--border-color);
    border-radius: 6px;
    padding: 0.5rem 1rem;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    min-width: 200px;
}

.filter-select:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(4, 62, 105, 0.1);
    outline: none;
}

/* ============================================
   FORMULARIO DE IMPORTACIÓN
   ============================================ */
.import-form-container {
    background: var(--white);
    border: 2px dashed var(--primary-color);
    border-radius: 10px;
    padding: 1rem;
    margin-bottom: 1rem;
    box-shadow: var(--shadow-sm);
}

.import-form-title {
    color: var(--primary-color);
    font-weight: 700;
    font-size: 1.1rem;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.import-form-title i {
    font-size: 1.3rem;
}

.file-input-group {
    display: flex;
    gap: 0.75rem;
    flex-wrap: wrap;
}

.file-input-custom {
    flex: 1;
    min-width: 250px;
    border: 2px solid var(--border-color);
    border-radius: 8px;
    padding: 0.625rem;
    transition: all 0.3s ease;
}

.file-input-custom:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(4, 62, 105, 0.1);
    outline: none;
}

.import-btn {
    background: var(--success-color);
    color: var(--white);
    border: none;
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: var(--shadow-sm);
}

.import-btn:hover {
    background: #218838;
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

.download-template-btn {
    background: var(--text-muted);
    color: var(--white);
    border: none;
    padding: 0.75rem 1.25rem;
    border-radius: 8px;
    transition: all 0.3s ease;
    box-shadow: var(--shadow-sm);
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.download-template-btn:hover {
    background: #5a6268;
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
    color: var(--white);
}

.error-message {
    color: var(--danger-color);
    font-size: 0.875rem;
    margin-top: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

/* ============================================
   RESPONSIVE
   ============================================ */
@media (max-width: 768px) {
    .licenses-header {
        padding: 1.5rem 1rem;
    }

    .licenses-header h1 {
        font-size: 1.5rem;
    }

    .options-container {
        flex-direction: column;
    }

    .option-toggle-btn {
        width: 100%;
        justify-content: center;
    }

    .action-buttons-grid {
        grid-template-columns: 1fr;
    }

    .file-input-group {
        flex-direction: column;
    }

    .file-input-custom {
        min-width: 100%;
    }

    .filter-select {
        min-width: 100%;
    }
}

@media (max-width: 480px) {
    .collapse-section {
        padding: 1rem;
    }

    .import-form-container {
        padding: 1rem;
    }
}
</style>
{{-- Estilos CSS Logísticos --}}
<style>
/* === VARIABLES === */
:root {
    --defective-primary: #e74c3c;
    --defective-warning: #f39c12;
    --defective-dark: #2c3e50;
    --defective-light: #ecf0f1;
}

/* === MODAL === */
.defective-modal {
    border: none;
    border-radius: 12px;
    box-shadow: 0 15px 35px rgba(231, 76, 60, 0.15);
    overflow: hidden;
}

/* === HEADER === */
.defective-header {
    background: linear-gradient(135deg, var(--defective-primary) 0%, #c0392b 100%);
    border: none;
    padding: 1.5rem;
    color: white;
}

.header-icon {
    background: rgba(255, 255, 255, 0.15);
    border-radius: 50%;
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
}

.modal-title {
    font-weight: 700;
    font-size: 1.2rem;
    text-transform: uppercase;
}

/* === CUERPO === */
.defective-body {
    padding: 2rem;
    background: #fafafa;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-label {
    display: flex;
    align-items: center;
    font-weight: 600;
    color: var(--defective-dark);
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
}

.form-label i {
    color: var(--defective-primary);
}

/* === INPUTS === */
.defective-input {
    border: 2px solid #e9ecef;
    border-radius: 8px;
    padding: 0.75rem;
    font-size: 0.9rem;
    transition: all 0.3s ease;
}

.defective-input:focus {
    border-color: var(--defective-primary);
    box-shadow: 0 0 0 0.2rem rgba(231, 76, 60, 0.15);
    outline: none;
}

.readonly-input {
    background: #f8f9fa;
    color: #6c757d;
    cursor: not-allowed;
}

/* === FOOTER === */
.defective-footer {
    background: var(--defective-light);
    border-top: 1px solid #dee2e6;
    padding: 1rem 2rem;
}

.defective-btn {
    background: linear-gradient(135deg, var(--defective-warning) 0%, #e67e22 100%);
    border: none;
    font-weight: 600;
    border-radius: 8px;
    padding: 0.75rem 1.5rem;
    transition: all 0.3s ease;
}

.defective-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(243, 156, 18, 0.3);
}

/* === RESPONSIVE === */
@media (max-width: 768px) {
    .defective-header {
        padding: 1rem;
        flex-direction: column;
        text-align: center;
        gap: 1rem;
    }

    .defective-body {
        padding: 1.5rem;
    }

    .defective-footer {
        flex-direction: column;
        gap: 1rem;
    }

    .defective-footer .btn {
        width: 100%;
    }
}
</style>

{{-- JavaScript con SweetAlert2 --}}
<script>
function abrirModalLicenciaDefectuosa(actionUrl, ordenCompra, idProveedor, razonSocialProveedor) {
    const form = document.getElementById('formLicenciaDefectuosa');
    form.reset();
    form.action = actionUrl;

    // Llenar campos
    form.querySelector('input[name="orden"]').value = ordenCompra ?? '';
    form.querySelector('input[name="razSocialProveedor"]').value = razonSocialProveedor ?? '';

    // Campo oculto para idProveedor
    let hiddenIdField = form.querySelector('input[name="idProveedor"]');
    if (!hiddenIdField) {
        hiddenIdField = document.createElement('input');
        hiddenIdField.type = 'hidden';
        hiddenIdField.name = 'idProveedor';
        form.appendChild(hiddenIdField);
    }
    hiddenIdField.value = idProveedor ?? '';

    // Mostrar modal
    const modal = new bootstrap.Modal(document.getElementById('modalLicenciaDefectuosa'));
    modal.show();

    // Focus en primer campo
    setTimeout(() => {
        form.querySelector('input[name="clave_key"]').focus();
    }, 300);
}

// Validaciones con SweetAlert2
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('formLicenciaDefectuosa');

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        const claveKey = form.querySelector('input[name="clave_key"]').value.trim();
        const numeroTicket = form.querySelector('input[name="numero_ticket"]').value.trim();

        // Validar clave requerida
        if (!claveKey) {
            Swal.fire({
                icon: 'error',
                title: 'Campo Requerido',
                text: 'La Clave de Activación es obligatoria',
                confirmButtonText: 'Entendido',
                confirmButtonColor: '#e74c3c'
            });
            form.querySelector('input[name="clave_key"]').focus();
            return;
        }

        // Validar longitud mínima
        if (claveKey.length < 8) {
            Swal.fire({
                icon: 'error',
                title: 'Clave Inválida',
                text: 'La clave debe tener al menos 8 caracteres',
                confirmButtonText: 'Corregir',
                confirmButtonColor: '#e74c3c'
            });
            form.querySelector('input[name="clave_key"]').focus();
            return;
        }

        // Advertencia si no hay ticket
        if (!numeroTicket) {
            Swal.fire({
                icon: 'question',
                title: '¿Continuar sin Ticket?',
                text: 'No se ha ingresado un número de ticket. ¿Desea continuar?',
                showCancelButton: true,
                confirmButtonText: 'Sí, continuar',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#f39c12',
                cancelButtonColor: '#6c757d'
            }).then((result) => {
                if (result.isConfirmed) {
                    confirmarAccion();
                }
            });
            return;
        }

        // Si todo está bien, confirmar
        confirmarAccion();
    });

    function confirmarAccion() {
        const claveKey = form.querySelector('input[name="clave_key"]').value.trim();

        Swal.fire({
            icon: 'warning',
            title: 'Confirmar Acción',
            html: `¿Está seguro de marcar la licencia <strong>${claveKey}</strong> como defectuosa?<br><br><small class="text-muted">Esta acción no se puede deshacer</small>`,
            showCancelButton: true,
            confirmButtonText: 'Sí, marcar como defectuosa',
            cancelButtonText: 'Cancelar',
            confirmButtonColor: '#e74c3c',
            cancelButtonColor: '#6c757d'
        }).then((result) => {
            if (result.isConfirmed) {
                // Mostrar loading
                Swal.fire({
                    title: 'Procesando...',
                    text: 'Marcando licencia como defectuosa',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Enviar formulario
                form.submit();
            }
        });
    }
});
</script>


{{-- Modal Licencias_Usadas - Con Validación Completa --}}
<div class="modal fade" id="modalUsarLicencia" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <form id="formUsarLicencia" method="POST" enctype="multipart/form-data" class="mx-auto">
      @csrf
      <input type="hidden" name="nuevo_estado" value="USADA">

      <div class="modal-content border-0 shadow-lg">
        <!-- Header con diseño mejorado -->
        <div class="modal-header bg-sistema-uno text-white border-0 position-relative overflow-hidden">
          <div class="d-flex align-items-center">
            <div class="header-icon-container me-3">
              <i class="bi bi-key-fill fs-3"></i>
            </div>
            <div>
              <h5 class="modal-title mb-0 fw-bold">Usar Licencia</h5>
              <small class="opacity-75">Registrar nueva licencia en el sistema</small>
            </div>
          </div>
          <!-- Botón cerrar arreglado -->
          <button type="button"
                  class="btn-close btn-close-white"
                  onclick="cerrarModal()"
                  aria-label="Cerrar">
          </button>

          <!-- Elemento decorativo de fondo -->
          <div class="position-absolute top-0 end-0 opacity-10">
            <i class="bi bi-shield-check" style="font-size: 6rem; transform: translate(1.5rem, -1.5rem);"></i>
          </div>
        </div>

        <div class="modal-body p-4">
          <!-- Primera fila: Clave y Orden -->
          <div class="row g-3 mb-4">
            <div class="col-md-7">
              <label class="form-label fw-semibold text-dark">
                <i class="bi bi-key text-primary me-2"></i>
                Clave de Activación
                <span class="text-danger">*</span>
              </label>
              <div class="input-group input-group-modern">
                <span class="input-group-text bg-light border-end-0">
                  <i class="bi bi-shield-lock text-primary"></i>
                </span>
                <input type="text"
                       name="clave_key"
                       id="clave_key"
                       class="form-control border-start-0 font-monospace"
                       placeholder="Ingrese la clave de activación">
                <button type="button"
                        class="btn btn-outline-info"
                        id="btnVerificarClave"
                        title="Verificar si la clave ya existe">
                  <i class="bi bi-search" id="iconVerificar"></i>
                  <span class="spinner-border spinner-border-sm d-none" id="spinnerVerificar"></span>
                </button>
              </div>
              <div class="invalid-feedback" id="clave-error" style="display: none;">
                <i class="bi bi-exclamation-circle me-1"></i>
                <span id="clave-error-text">La clave de activación es obligatoria</span>
              </div>
              <div class="valid-feedback" id="clave-success" style="display: none;">
                <i class="bi bi-check-circle me-1"></i>
                Clave disponible para usar
              </div>
            </div>
            <div class="col-md-5">
              <label class="form-label fw-semibold text-dark">
                <i class="bi bi-receipt text-success me-2"></i>
                Orden de Compra
              </label>
              <div class="input-group input-group-modern">
                <span class="input-group-text bg-light border-end-0">
                  <i class="bi bi-file-text text-success"></i>
                </span>
                <input type="text"
                       name="orden"
                       id="orden"
                       class="form-control border-start-0"
                       placeholder="Ej: 421852"
                       readonly>
              </div>
            </div>
          </div>

          <!-- Sección de Información del Equipo -->
          <div class="equipment-section">
            <div class="section-header mb-3">
              <h6 class="section-title mb-0">
                <i class="bi bi-pc-display text-info me-2"></i>
                Información del Equipo
              </h6>
              <div class="section-line"></div>
            </div>

            <!-- Segunda fila: Equipo y Tipo -->
            <div class="row g-3 mb-3">
              <div class="col-md-6">
                <label class="form-label fw-semibold text-dark">
                  <i class="bi bi-laptop me-1 text-info"></i>
                  Equipo
                </label>
                <div class="input-group input-group-modern">
                  <span class="input-group-text bg-light border-end-0">
                    <i class="bi bi-pc text-info"></i>
                  </span>
                  <input type="text"
                         name="equipo"
                         id="equipo"
                         class="form-control border-start-0"
                         placeholder="Nombre del equipo">
                </div>
              </div>
              <div class="col-md-6">
                <label class="form-label fw-semibold text-dark">
                  <i class="bi bi-tags me-1 text-info"></i>
                  Tipo de Equipo
                </label>
                <div class="input-group input-group-modern">
                  <span class="input-group-text bg-light border-end-0">
                    <i class="bi bi-collection text-info"></i>
                  </span>
                  <input type="text"
                         name="tipo_equipo"
                         id="tipo_equipo"
                         class="form-control border-start-0"
                         placeholder="Tipo de equipo">
                </div>
              </div>
            </div>

            <!-- Tercera fila: Serial -->
            <div class="row g-3 mb-3">
              <div class="col-12">
                <label class="form-label fw-semibold text-dark">
                  <i class="bi bi-upc-scan me-1 text-warning"></i>
                  Serial del Equipo
                </label>
                <div class="input-group input-group-modern">
                  <span class="input-group-text bg-light border-end-0">
                    <i class="bi bi-hash text-warning"></i>
                  </span>
                  <input type="text"
                         name="serial_equipo"
                         id="serial_equipo"
                         class="form-control border-start-0 font-monospace"
                         placeholder="Serial único del equipo">
                </div>
              </div>
            </div>
          </div>

          <!-- Descripción -->
          <div class="description-section">
            <div class="section-header mb-3">
              <h6 class="section-title mb-0">
                <i class="bi bi-card-text text-secondary me-2"></i>
                Información Adicional
              </h6>
              <div class="section-line"></div>
            </div>

            <div class="mb-3">
              <label class="form-label fw-semibold text-dark">
                <i class="bi bi-chat-text me-1 text-secondary"></i>
                Descripción
              </label>
              <div class="textarea-container">
                <textarea name="descripcion"
                          id="descripcion"
                          class="form-control modern-textarea"
                          rows="3"
                          placeholder="Información adicional sobre el equipo, ubicación, usuario asignado, etc."></textarea>
              </div>
            </div>
          </div>
          <!--Archivo de recuperacion-->
          <div class="mb-3">
            <label class="form-label fw-semibold text-dark">
              <i class="bi bi-file-earmark-arrow-up me-1 text-primary"></i>
              Archivo de licencia (opcional)
            </label>
            <input type="file"
                  name="archivo"
                  id="archivo"
                  class="form-control"
                  accept=".rcf,.txt,.pdf">
            <div class="form-text">Solo archivos pequeños (ej. .rcf)</div>
          </div>
          <!-- Información importante -->
          <div class="alert alert-info-modern border-0 mt-4" role="alert">
            <div class="d-flex align-items-center">
              <div class="alert-icon me-3">
                <i class="bi bi-info-circle-fill"></i>
              </div>
              <div class="alert-content">
                <strong>Información:</strong> Esta licencia será marcada como "USADA" y quedará registrada permanentemente en el sistema.
              </div>
            </div>
          </div>
        </div>

        <!-- Footer mejorado -->
        <div class="modal-footer bg-light-subtle border-0 p-4">
          <div class="d-flex justify-content-between w-100">
            <button type="button"
                    class="btn btn-outline-secondary btn-modern px-4"
                    data-bs-dismiss="modal">
              <i class="bi bi-x-lg me-2"></i>
              Cancelar
            </button>
            <button type="submit"
                    class="btn btn-success btn-modern px-4"
                    id="btnGuardar">
              <span class="spinner-border spinner-border-sm me-2 d-none" id="loadingSpinner"></span>
              <i class="bi bi-save me-2" id="saveIcon"></i>
              <span id="btnText">Guardar Licencia</span>
            </button>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
{{-- JavaScript con Validación Completa --}}
<script>
// Variables globales para el estado de validación
let claveValidada = false;
let verificandoClave = false;

// Función original mantenida
function abrirModalUsarLicencia(actionUrl, ordenCompra) {
    const form = document.getElementById('formUsarLicencia');
    form.reset();
    form.action = actionUrl;

    //Campos visibles
    form.querySelector('input[name="orden"]').value = ordenCompra ?? '';

    // Limpiar estados de validación
    limpiarValidacion();
    claveValidada = false;

    const modal = new bootstrap.Modal(document.getElementById('modalUsarLicencia'));
    modal.show();
}

// Función para limpiar estados de validación
function limpiarValidacion() {
    const claveInput = document.getElementById('clave_key');
    const claveError = document.getElementById('clave-error');
    const claveSuccess = document.getElementById('clave-success');
    const inputGroup = claveInput.closest('.input-group-modern');

    claveInput.classList.remove('is-invalid', 'is-valid');
    inputGroup.classList.remove('is-invalid', 'is-valid');
    claveError.style.display = 'none';
    claveSuccess.style.display = 'none';
}

// Función para verificar clave duplicada
async function verificarClaveDuplicada(clave) {
    try {
        const response = await fetch('/verificar-clave-duplicada', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ clave_key: clave })
        });

        const data = await response.json();
        return data.existe;
    } catch (error) {
        console.error('Error verificando clave:', error);
        throw error;
    }
}

// Event listener para el botón de verificar clave
document.getElementById('btnVerificarClave').addEventListener('click', async function() {
    const claveInput = document.getElementById('clave_key');
    const clave = claveInput.value.trim();

    if (!clave) {
        Swal.fire({
            icon: 'warning',
            title: 'Campo vacío',
            text: 'Ingrese una clave para verificar',
            confirmButtonColor: '#667eea'
        });
        claveInput.focus();
        return;
    }

    await verificarClaveManual(clave);
});

// Función para verificar clave manualmente
async function verificarClaveManual(clave) {
    const btnVerificar = document.getElementById('btnVerificarClave');
    const iconVerificar = document.getElementById('iconVerificar');
    const spinnerVerificar = document.getElementById('spinnerVerificar');
    const claveInput = document.getElementById('clave_key');
    const claveError = document.getElementById('clave-error');
    const claveSuccess = document.getElementById('clave-success');
    const claveErrorText = document.getElementById('clave-error-text');
    const inputGroup = claveInput.closest('.input-group-modern');

    // Mostrar loading
    verificandoClave = true;
    btnVerificar.disabled = true;
    iconVerificar.classList.add('d-none');
    spinnerVerificar.classList.remove('d-none');

    // Limpiar estados previos
    limpiarValidacion();

    try {
        const existe = await verificarClaveDuplicada(clave);

        if (existe) {
            // La clave ya existe
            claveValidada = false;
            claveInput.classList.add('is-invalid');
            inputGroup.classList.add('is-invalid', 'shake');
            claveErrorText.textContent = 'Esta clave ya está registrada en el sistema';
            claveError.style.display = 'block';

            // Remover animación
            setTimeout(() => {
                inputGroup.classList.remove('shake');
            }, 500);

            Swal.fire({
                icon: 'error',
                title: 'Clave Duplicada',
                text: 'Esta clave de activación ya está registrada en el sistema',
                confirmButtonColor: '#dc3545'
            });
        } else {
            // La clave está disponible
            claveValidada = true;
            claveInput.classList.add('is-valid');
            inputGroup.classList.add('is-valid');
            claveSuccess.style.display = 'block';

            Swal.fire({
                icon: 'success',
                title: 'Clave Disponible',
                text: 'La clave está disponible para usar',
                timer: 2000,
                timerProgressBar: true,
                confirmButtonColor: '#28a745'
            });
        }
    } catch (error) {
        Swal.fire({
            icon: 'error',
            title: 'Error de Conexión',
            text: 'No se pudo verificar la clave. Intente nuevamente.',
            confirmButtonColor: '#dc3545'
        });
    } finally {
        // Restaurar botón
        verificandoClave = false;
        btnVerificar.disabled = false;
        iconVerificar.classList.remove('d-none');
        spinnerVerificar.classList.add('d-none');
    }
}

// Limpiar validación cuando el usuario cambie la clave
document.getElementById('clave_key').addEventListener('input', function() {
    if (claveValidada) {
        claveValidada = false;
        limpiarValidacion();
    }
});

// Validación del formulario
document.getElementById('formUsarLicencia').addEventListener('submit', async function(e) {
    e.preventDefault(); // Siempre prevenir el envío inicial

    const claveInput = document.getElementById('clave_key');
    const claveValue = claveInput.value.trim();
    const claveError = document.getElementById('clave-error');
    const claveErrorText = document.getElementById('clave-error-text');
    const inputGroup = claveInput.closest('.input-group-modern');
    const btnGuardar = document.getElementById('btnGuardar');
    const loadingSpinner = document.getElementById('loadingSpinner');
    const saveIcon = document.getElementById('saveIcon');
    const btnText = document.getElementById('btnText');

    // Validar que la clave no esté vacía
    if (claveValue === '') {
        limpiarValidacion();
        claveInput.classList.add('is-invalid');
        inputGroup.classList.add('is-invalid', 'shake');
        claveErrorText.textContent = 'La clave de activación es obligatoria';
        claveError.style.display = 'block';

        setTimeout(() => {
            inputGroup.classList.remove('shake');
        }, 500);

        Swal.fire({
            icon: 'error',
            title: 'Campo Requerido',
            text: 'Debes ingresar la Clave de Activación.',
            confirmButtonColor: '#667eea'
        }).then(() => {
            claveInput.focus();
        });

        return false;
    }

    // Si la clave no ha sido validada, verificarla automáticamente
    if (!claveValidada && !verificandoClave) {
        try {
            // Mostrar loading en el botón de guardar
            btnGuardar.disabled = true;
            loadingSpinner.classList.remove('d-none');
            saveIcon.classList.add('d-none');
            btnText.textContent = 'Verificando clave...';

            const existe = await verificarClaveDuplicada(claveValue);

            if (existe) {
                // La clave ya existe
                limpiarValidacion();
                claveInput.classList.add('is-invalid');
                inputGroup.classList.add('is-invalid', 'shake');
                claveErrorText.textContent = 'Esta clave ya está registrada en el sistema';
                claveError.style.display = 'block';

                setTimeout(() => {
                    inputGroup.classList.remove('shake');
                }, 500);

                Swal.fire({
                    icon: 'error',
                    title: 'Clave Duplicada',
                    text: 'Esta clave de activación ya está registrada en el sistema',
                    confirmButtonColor: '#dc3545'
                }).then(() => {
                    claveInput.focus();
                });

                return false;
            } else {
                // La clave está disponible, continuar con el envío
                claveValidada = true;
            }
        } catch (error) {
            Swal.fire({
                icon: 'error',
                title: 'Error de Conexión',
                text: 'No se pudo verificar la clave. Intente nuevamente.',
                confirmButtonColor: '#dc3545'
            });
            return false;
        } finally {
            // Restaurar botón
            btnGuardar.disabled = false;
            loadingSpinner.classList.add('d-none');
            saveIcon.classList.remove('d-none');
            btnText.textContent = 'Guardar Licencia';
        }
    }

    // Si llegamos aquí, la clave es válida, mostrar confirmación
    Swal.fire({
        title: '¿Confirmar registro?',
        text: 'Se registrará esta licencia como usada',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, registrar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Mostrar estado de carga
            btnGuardar.disabled = true;
            loadingSpinner.classList.remove('d-none');
            saveIcon.classList.add('d-none');
            btnText.textContent = 'Guardando...';

            // Enviar formulario
            this.submit();
        }
    });
});

// Limpiar formulario al cerrar modal
document.getElementById('modalUsarLicencia').addEventListener('hidden.bs.modal', function() {
    const form = document.getElementById('formUsarLicencia');
    const btnGuardar = document.getElementById('btnGuardar');
    const loadingSpinner = document.getElementById('loadingSpinner');
    const saveIcon = document.getElementById('saveIcon');
    const btnText = document.getElementById('btnText');

    // Reset formulario
    form.reset();

    // Limpiar validación
    limpiarValidacion();
    claveValidada = false;

    // Restaurar botón
    btnGuardar.disabled = false;
    loadingSpinner.classList.add('d-none');
    saveIcon.classList.remove('d-none');
    btnText.textContent = 'Guardar Licencia';
});

// Mensajes de éxito y error con SweetAlert2
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
{{-- Fin Modal Licencias Usadas --}}

@endsection
