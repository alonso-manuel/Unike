@extends('layouts.app')
@section('title', 'Licencias Recuperadas')
@section('content')
<div class="recuperadas-container">
    <!-- Header Section -->
    <div class="used-header">
        <div class="header-content">
            <div class="header-icon">
                <i class="bi bi-x-octagon-fill"></i>
            </div>
            <div class="header-info">
                <h4 class="header-title">LICENCIAS RECUPERADAS</h4>
                <div class="header-stats">
                    <span class="stat-item">
                        <i class="bi bi-collection"></i>
                        Total: <strong>{{ $licenciasRecuperadas->total() }}</strong>
                    </span>
                    <span class="stat-separator">|</span>
                </div>
            </div>
        </div>
        <div class="header-actions">
            <a href="{{ route('licencias.index') }}" class="btn-back">
                <i class="bi bi-arrow-left"></i>
                Volver a Inventario
            </a>
        </div>
    </div>

    @if($licenciasRecuperadas->isEmpty())
        <div class="alert alert-info">
            No hay licencias recuperadas registradas.
        </div>
    @else
    <div class="table-wrapper">
        <ul class="list-group">
            {{-- Cabecera --}}
            <li class="list-group-item d-flex bg-dark text-light" style="position: sticky; top:0; z-index:800;">
                <div class="row w-100 align-items-center text-center">
                    <div class="col-md-2"><h6>Serial Recuperada</h6></div>
                    <div class="col-md-2"><h6>Serial Defectuosa</h6></div>
                    <div class="col-md-2"><h6>Voucher</h6></div>
                    <div class="col-md-1"><h6>Orden Compra</h6></div>
                    <div class="col-md-1"><h6>Estado</h6></div>
                    <div class="col-md-2"><h6>Proveedor</h6></div>
                    <div class="col-md-2"><h6>Acciones</h6></div>
                </div>
            </li>

            {{-- Datos --}}
            @foreach($licenciasRecuperadas as $recuperada)
            <li class="list-group-item">
                <div class="row w-100 align-items-center text-center">
                    <div class="col-md-2">
                        <small class="fw-bold">{{ $recuperada->serial_recuperada }}</small>
                    </div>
                    <div class="col-md-2">
                        <small>{{ $recuperada->serial_defectuosa }}</small>
                    </div>
                    <div class="col-md-2">
                        <small>{{ $recuperada->licencia->voucher_code ?? '---' }}</small>
                    </div>
                    <div class="col-md-1">
                        <small>{{ $recuperada->orden ?? '---' }}</small>
                    </div>
                    <div class="col-md-1">
                        <span class="badge bg-warning">{{ $recuperada->estado }}</span>
                    </div>
                    {{-- El cambio del proveedor fue un caso ;-; --}}
                    {{-- Proveedores --}}
                    <div class="col-md-2">
                        <Small>{{$recuperada->licencia->proveedor->razSocialProveedor ?? '---'}}</Small>
                    </div>
                    <div class="col-md-2 d-flex gap-1 justify-content-center">
                        {{--Marcar Usada --}}
                        <a href="javascript:void(0);"
                            onclick="abrirModalUsarLicenciaDesdeRecuperadas(
                                '{{ route('licencias.cambiar_estado', $recuperada->licencia->voucher_code) }}',
                                '{{ $recuperada->orden }}',
                                '{{ $recuperada->serial_recuperada }}',
                                '{{ $recuperada->id }}'
                            )"
                            class="btn btn-outline-info btn-sm">
                            Usar
                        </a>
                        {{-- Marcar Defectuosa --}}
                        <a href="javascript:void(0);" 
                          onclick="abrirModalLicenciaDefectuosa(
                            '{{ route('licencias.cambiar_estado', $recuperada->licencia->voucher_code) }}',
                            '{{ $recuperada->orden }}',
                            '{{ $recuperada->serial_recuperada }}',
                            '{{ $recuperada->licencia->proveedor?->idProveedor ?? '' }}', // ID
                            '{{ $recuperada->licencia->proveedor?->razSocialProveedor ?? '---' }}', // Nombre
                            '{{ $recuperada->id }}'
                          )"
                          class="btn btn-outline-danger btn-sm">
                          Defectuosa
                        </a>

                    </div>
                </div>
            </li>
            @endforeach
        </ul>
    </div>

    {{-- Paginación --}}
    <div class="d-flex justify-content-end mt-3">
        {{ $licenciasRecuperadas->links() }}
    </div>
    @endif
</div>
<style>
    /* === VARIABLES === */
:root {
    --used-primary: #2c3e50;
    --used-secondary: #2c3e50;
    --used-accent: #3498db;
    --used-dark: #2c3e50;
    --used-light: #ecf0f1;
    --used-info: #17a2b8;
}

/* === CONTENEDOR PRINCIPAL CON MÁRGENES === */
.recuperadas-container {
    max-width: calc(100% - 100px);
    margin: 0 auto;
    padding: 2rem 0;
}

/* === HEADER VERDE SEPARADO === */
.used-header {
    background: linear-gradient(135deg, var(--used-primary) 0%, var(--used-secondary) 100%);
    padding: 1.25rem 1.5rem;
    border-radius: 8px;
    color: white;
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
    box-shadow: 0 2px 8px rgba(39, 174, 96, 0.2);
}

.header-content {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.header-icon {
    font-size: 2rem;
}

.header-title {
    font-size: 1.1rem;
    font-weight: 700;
    margin: 0 0 0.25rem 0;
    letter-spacing: 0.5px;
}

.header-stats {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 0.85rem;
    opacity: 0.95;
}

.stat-item {
    display: flex;
    align-items: center;
    gap: 0.4rem;
}

.stat-separator {
    color: rgba(255, 255, 255, 0.5);
}

.btn-back {
    background: rgba(255, 255, 255, 0.15);
    border: 1px solid rgba(255, 255, 255, 0.3);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 6px;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.9rem;
    transition: all 0.3s ease;
}

.btn-back:hover {
    background: rgba(255, 255, 255, 0.25);
    color: white;
}
/* === WRAPPER CON LÍMITE DE ALTURA === */
.table-wrapper {
    background: white;
    border: 1px solid #dee2e6;
    border-radius: 8px;
    overflow: hidden;
    margin-bottom: 1rem;
    max-height: 600px;
    display: flex;
    flex-direction: column;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

/* === TABLA COMPACTA CON SCROLL === */
.table-container {
    overflow-x: auto;
    overflow-y: auto;
    flex: 1;
}

.table-used {
    width: 100%;
    margin: 0;
    border-collapse: collapse;
}

.table-used thead {
    background: #f8f9fa;
    position: sticky;
    top: 0;
    z-index: 10;
}

.table-used thead th {
    padding: 0.75rem 1rem;
    text-align: left;
    font-size: 0.75rem;
    font-weight: 600;
    color: var(--used-dark);
    text-transform: uppercase;
    letter-spacing: 0.3px;
    white-space: nowrap;
    border-bottom: 2px solid #dee2e6;
}

.table-used thead th i {
    color: var(--used-primary);
    margin-right: 0.4rem;
    font-size: 0.85rem;
}

.table-used tbody tr {
    border-bottom: 1px solid #e9ecef;
    transition: background 0.2s ease;
}

.table-used tbody tr:hover {
    background: #f8f9fa;
}

.table-used tbody td {
    padding: 0.65rem 1rem;
    font-size: 0.85rem;
    color: var(--used-dark);
}
</style>

{{-- Modal Usar Licencia desde Recuperadas - MEJORADO --}}
<div class="modal fade" id="modalUsarLicencia" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <form id="formUsarLicencia" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="idRecuperada" id="inputIdRecuperadaUsada">
            <input type="hidden" name="nuevo_estado" value="USADA">
            <input type="hidden" name="serial_recuperada" id="inputSerialRecuperada">
            
            <div class="modal-content usar-modal">
                {{-- Header --}}
                <div class="modal-header usar-header">
                    <div class="d-flex align-items-center">
                        <div class="header-icon me-3">
                            <i class="bi bi-check-circle-fill"></i>
                        </div>
                        <div>
                            <h5 class="modal-title mb-0">Marcar Licencia como Usada</h5>
                            <small class="opacity-75">Asignar licencia recuperada a equipo</small>
                        </div>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                {{-- Body --}}
                <div class="modal-body usar-body">
                    {{-- Información de Licencia --}}
                    <div class="info-section">
                        <h6 class="section-title">
                            <i class="bi bi-key-fill me-2"></i>
                            Información de la Licencia
                        </h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="input-container">
                                    <label class="input-label">
                                        <i class="bi bi-cart-check me-1"></i>
                                        Orden de Compra
                                    </label>
                                    <input type="text" name="orden" class="form-input" readonly>
                                    <div class="input-icon">
                                        <i class="bi bi-lock-fill"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-container">
                                    <label class="input-label">
                                        <i class="bi bi-shield-lock me-1"></i>
                                        Clave de Activación
                                    </label>
                                    <input type="text" name="clave_key" class="form-input" readonly>
                                    <div class="input-icon">
                                        <i class="bi bi-lock-fill"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Información del Equipo --}}
                    <div class="info-section">
                        <h6 class="section-title">
                            <i class="bi bi-pc-display-horizontal me-2"></i>
                            Datos del Equipo
                        </h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="input-container">
                                    <label class="input-label required">
                                        <i class="bi bi-pc me-1"></i>
                                        Nombre del Equipo
                                    </label>
                                    <input type="text" name="equipo" class="form-input">
                                    <div class="input-icon">
                                        <i class="bi bi-asterisk"></i>
                                    </div>
                                    <small class="input-hint">Ej: PC-OFICINA-01</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-container">
                                    <label class="input-label required">
                                        <i class="bi bi-tag me-1"></i>
                                        Tipo de Equipo
                                    </label>
                                    <input type="text" name="tipo_equipo" class="form-input" >
                                    <div class="input-icon">
                                        <i class="bi bi-asterisk"></i>
                                    </div>
                                    <small class="input-hint">Ej: Desktop, Laptop, Server</small>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="input-container">
                                    <label class="input-label required">
                                        <i class="bi bi-fingerprint me-1"></i>
                                        Serial del Equipo
                                    </label>
                                    <input type="text" name="serial_equipo" class="form-input" >
                                    <div class="input-icon">
                                        <i class="bi bi-asterisk"></i>
                                    </div>
                                    <small class="input-hint">Identificador único del equipo</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Información Adicional --}}
                    <div class="info-section">
                        <h6 class="section-title">
                            <i class="bi bi-card-text me-2"></i>
                            Información Adicional
                        </h6>
                        <div class="input-container">
                            <label class="input-label">
                                <i class="bi bi-file-text me-1"></i>
                                Descripción / Notas
                            </label>
                            <textarea name="descripcion" class="form-textarea" rows="3" 
                                placeholder="Agregar comentarios o notas adicionales..."></textarea>
                            <small class="input-hint">Opcional: Información adicional sobre la asignación</small>
                        </div>
                    </div>

                    {{-- Archivo --}}
                    <div class="info-section">
                        <h6 class="section-title">
                            <i class="bi bi-paperclip me-2"></i>
                            Archivo de Licencia
                        </h6>
                        <div class="file-upload-container">
                            <input type="file" name="archivo" id="archivoUsada" class="file-input" 
                                accept=".rcf,.txt,.pdf">
                            <label for="archivoUsada" class="file-label">
                                <div class="file-icon">
                                    <i class="bi bi-cloud-upload"></i>
                                </div>
                                <div class="file-text">
                                    <span class="file-title">Seleccionar archivo</span>
                                    <span class="file-hint">Archivos .rcf, .txt, .pdf (Opcional)</span>
                                </div>
                            </label>
                            <div class="file-selected" id="fileSelectedUsada" style="display: none;">
                                <i class="bi bi-file-earmark-check me-2"></i>
                                <span class="file-name"></span>
                                <button type="button" class="file-remove">
                                    <i class="bi bi-x-lg"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Footer --}}
                <div class="modal-footer usar-footer">
                    <button type="button" class="btn-modal btn-cancel" data-bs-dismiss="modal">
                        <i class="bi bi-x-lg me-2"></i>
                        Cancelar
                    </button>
                    <button type="submit" class="btn-modal btn-usar">
                        <i class="bi bi-check-circle me-2"></i>
                        Marcar como Usada
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Modal Licencia Defectuosa - MEJORADO --}}
<div class="modal fade" id="modalLicenciaDefectuosa" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <form id="formLicenciaDefectuosa" method="POST">
            @csrf
            <input type="hidden" name="idRecuperada" id="inputIdRecuperadaDefectuosa">
            <input type="hidden" name="nuevo_estado" value="DEFECTUOSA">
            <input type="hidden" name="serial_recuperada" id="inputSerialRecuperadaDefectuosa">
            
            <div class="modal-content defectuosa-modal">
                {{-- Header --}}
                <div class="modal-header defectuosa-header">
                    <div class="d-flex align-items-center">
                        <div class="header-icon me-3">
                            <i class="bi bi-exclamation-triangle-fill"></i>
                        </div>
                        <div>
                            <h5 class="modal-title mb-0">Marcar Licencia como Defectuosa</h5>
                            <small class="opacity-75">Registrar licencia con problemas</small>
                        </div>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                {{-- Body --}}
                <div class="modal-body defectuosa-body">
                    {{-- Advertencia --}}
                    <div class="alert-warning-box">
                        <i class="bi bi-exclamation-circle-fill me-2"></i>
                        <div>
                            <strong>Atención:</strong> Esta acción marcará la licencia como defectuosa y será retirada del inventario disponible.
                        </div>
                    </div>

                    {{-- Información de Licencia --}}
                    <div class="info-section">
                        <h6 class="section-title">
                            <i class="bi bi-key-fill me-2"></i>
                            Información de la Licencia
                        </h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="input-container">
                                    <label class="input-label">
                                        <i class="bi bi-shield-lock me-1"></i>
                                        Clave de Activación
                                    </label>
                                    <input type="text" name="clave_key" class="form-input" readonly required>
                                    <div class="input-icon">
                                        <i class="bi bi-lock-fill"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-container">
                                    <label class="input-label">
                                        <i class="bi bi-cart-check me-1"></i>
                                        Orden de Compra
                                    </label>
                                    <input type="text" name="orden" class="form-input" readonly>
                                    <div class="input-icon">
                                        <i class="bi bi-lock-fill"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Información del Proveedor --}}
                    <div class="info-section">
                        <h6 class="section-title">
                            <i class="bi bi-building me-2"></i>
                            Información del Proveedor
                        </h6>
                        <div class="input-container">
                            <label class="input-label">
                                <i class="bi bi-person-badge me-1"></i>
                                Proveedor
                            </label>
                            <input type="text" name="proveedor" class="form-input" readonly>
                            <div class="input-icon">
                                <i class="bi bi-lock-fill"></i>
                            </div>
                        </div>
                    </div>

                    {{-- Información del Incidente --}}
                    <div class="info-section">
                        <h6 class="section-title">
                            <i class="bi bi-ticket-detailed me-2"></i>
                            Información del Incidente
                        </h6>
                        <div class="input-container">
                            <label class="input-label required">
                                <i class="bi bi-hash me-1"></i>
                                Número de Ticket
                            </label>
                            <input type="text" name="numero_ticket" class="form-input">
                            <div class="input-icon">
                                <i class="bi bi-asterisk"></i>
                            </div>
                            <small class="input-hint">Ticket de soporte</small>
                        </div>
                    </div>
                </div>

                {{-- Footer --}}
                <div class="modal-footer defectuosa-footer">
                    <button type="button" class="btn-modal btn-cancel" data-bs-dismiss="modal">
                        <i class="bi bi-x-lg me-2"></i>
                        Cancelar
                    </button>
                    <button type="submit" class="btn-modal btn-defectuosa">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        Marcar como Defectuosa
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Estilos CSS --}}
<style>
/* === VARIABLES === */
:root {
    --usar-primary: #27ae60;
    --usar-secondary: #229954;
    --defectuosa-primary: #e74c3c;
    --defectuosa-secondary: #c0392b;
    --dark: #2c3e50;
    --light: #ecf0f1;
}

/* === MODAL USAR LICENCIA === */
.usar-modal {
    border: none;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 10px 40px rgba(39, 174, 96, 0.15);
}

.usar-header {
    background: linear-gradient(135deg, var(--usar-primary) 0%, var(--usar-secondary) 100%);
    border: none;
    padding: 1.5rem;
    color: white;
}

.usar-body {
    padding: 2rem;
    background: #fafafa;
}

.usar-footer {
    background: var(--light);
    border-top: 2px solid #dee2e6;
    padding: 1rem 2rem;
}

/* === MODAL DEFECTUOSA === */
.defectuosa-modal {
    border: none;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 10px 40px rgba(231, 76, 60, 0.15);
}

.defectuosa-header {
    background: linear-gradient(135deg, var(--defectuosa-primary) 0%, var(--defectuosa-secondary) 100%);
    border: none;
    padding: 1.5rem;
    color: white;
}

.defectuosa-body {
    padding: 2rem;
    background: #fafafa;
}

.defectuosa-footer {
    background: var(--light);
    border-top: 2px solid #dee2e6;
    padding: 1rem 2rem;
}

/* === HEADER COMPONENTS === */
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

/* === SECCIONES === */
.info-section {
    background: white;
    border-radius: 10px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    border: 1px solid #e9ecef;
}

.section-title {
    color: var(--dark);
    font-weight: 600;
    margin-bottom: 1.25rem;
    padding-bottom: 0.75rem;
    border-bottom: 2px solid #e9ecef;
    display: flex;
    align-items: center;
    font-size: 0.95rem;
}

/* === INPUTS === */
.input-container {
    position: relative;
    margin-bottom: 1rem;
}

.input-label {
    display: block;
    font-weight: 600;
    color: var(--dark);
    margin-bottom: 0.5rem;
    font-size: 0.85rem;
    display: flex;
    align-items: center;
}

.input-label.required::after {
    content: "*";
    color: #e74c3c;
    margin-left: 0.25rem;
    font-weight: 700;
}

.form-input,
.form-textarea {
    width: 100%;
    padding: 0.75rem 2.5rem 0.75rem 0.75rem;
    border: 2px solid #dee2e6;
    border-radius: 8px;
    font-size: 0.9rem;
    color: var(--dark);
    transition: all 0.3s ease;
    background: white;
}

.form-input:focus,
.form-textarea:focus {
    outline: none;
    border-color: var(--usar-primary);
    box-shadow: 0 0 0 3px rgba(39, 174, 96, 0.1);
}

.form-input:read-only {
    background: #f8f9fa;
    cursor: not-allowed;
    color: #6c757d;
}

.input-icon {
    position: absolute;
    right: 0.75rem;
    top: 38px;
    color: #6c757d;
    font-size: 0.85rem;
}

.input-hint {
    display: block;
    color: #6c757d;
    font-size: 0.75rem;
    margin-top: 0.25rem;
    font-style: italic;
}

/* === VALIDACIÓN EN TIEMPO REAL === */
.input-container.valid .form-input {
    border-color: var(--usar-primary);
    background: #f0f8f0;
}

.input-container.valid .input-icon {
    color: var(--usar-primary);
}

.input-container.invalid .form-input {
    border-color: var(--defectuosa-primary);
    background: #fdf2f2;
}

.input-container.invalid .input-icon {
    color: var(--defectuosa-primary);
}

/* === FILE UPLOAD === */
.file-upload-container {
    position: relative;
}

.file-input {
    position: absolute;
    width: 0.1px;
    height: 0.1px;
    opacity: 0;
    overflow: hidden;
    z-index: -1;
}

.file-label {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    border: 2px dashed #dee2e6;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
    background: white;
}

.file-label:hover {
    border-color: var(--usar-primary);
    background: #f0f8f0;
}

.file-icon {
    width: 50px;
    height: 50px;
    background: var(--usar-primary);
    color: white;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
}

.file-text {
    flex: 1;
    display: flex;
    flex-direction: column;
}

.file-title {
    font-weight: 600;
    color: var(--dark);
    font-size: 0.9rem;
}

.file-hint {
    font-size: 0.75rem;
    color: #6c757d;
}

.file-selected {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem;
    background: #e8f4fd;
    border: 1px solid #bbdefb;
    border-radius: 8px;
    margin-top: 0.75rem;
    color: var(--dark);
}

.file-name {
    flex: 1;
    font-weight: 600;
    font-size: 0.85rem;
}

.file-remove {
    border: none;
    background: #e74c3c;
    color: white;
    width: 28px;
    height: 28px;
    border-radius: 50%;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.file-remove:hover {
    background: #c0392b;
}

/* === ALERT WARNING === */
.alert-warning-box {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
    background: #fff8e1;
    border: 1px solid #ffe0b2;
    border-left: 4px solid #ff9800;
    border-radius: 8px;
    padding: 1rem;
    margin-bottom: 1.5rem;
    color: #663c00;
}

.alert-warning-box i {
    color: #ff9800;
    font-size: 1.25rem;
    flex-shrink: 0;
}

/* === BOTONES === */
.btn-modal {
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.9rem;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
}

.btn-cancel {
    background: #6c757d;
    color: white;
}

.btn-cancel:hover {
    background: #5a6268;
    transform: translateY(-2px);
}

.btn-usar {
    background: linear-gradient(135deg, var(--usar-primary) 0%, var(--usar-secondary) 100%);
    color: white;
}

.btn-usar:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(39, 174, 96, 0.3);
}

.btn-defectuosa {
    background: linear-gradient(135deg, var(--defectuosa-primary) 0%, var(--defectuosa-secondary) 100%);
    color: white;
}

.btn-defectuosa:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(231, 76, 60, 0.3);
}

/* === LOADING STATE === */
.btn-modal.loading {
    position: relative;
    pointer-events: none;
    opacity: 0.7;
}

.btn-modal.loading::after {
    content: "";
    position: absolute;
    width: 16px;
    height: 16px;
    top: 50%;
    left: 50%;
    margin-left: -8px;
    margin-top: -8px;
    border: 2px solid transparent;
    border-top-color: white;
    border-radius: 50%;
    animation: spin 0.8s linear infinite;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

/* === RESPONSIVE === */
@media (max-width: 768px) {
    .modal-lg {
        margin: 0.5rem;
    }
    
    .usar-body,
    .defectuosa-body {
        padding: 1.5rem;
    }
    
    .info-section {
        padding: 1rem;
    }
}
</style>

{{-- Scripts --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// === SCRIPT MODAL USAR LICENCIA ===
function abrirModalUsarLicenciaDesdeRecuperadas(actionUrl, orden, serialRecuperada, idRecuperada) {
    const form = document.getElementById('formUsarLicencia');
    const submitBtn = form.querySelector('button[type="submit"]');
    
    form.reset();
    submitBtn.classList.remove('loading');
    submitBtn.disabled = false;
    
    form.action = actionUrl;
    document.getElementById('inputIdRecuperadaUsada').value = idRecuperada ?? '';
    document.getElementById('inputSerialRecuperada').value = serialRecuperada ?? '';
    
    form.querySelector('input[name="orden"]').value = orden || '';
    form.querySelector('input[name="clave_key"]').value = serialRecuperada || '';
    
    const modal = new bootstrap.Modal(document.getElementById('modalUsarLicencia'));
    modal.show();
    
    // Focus en primer campo editable
    setTimeout(() => {
        form.querySelector('input[name="equipo"]').focus();
    }, 500);
}

// === SCRIPT MODAL DEFECTUOSA ===
function abrirModalLicenciaDefectuosa(actionUrl, orden, serialRecuperada, idProveedor, proveedor, idRecuperada) {
    const form = document.getElementById('formLicenciaDefectuosa');
    const submitBtn = form.querySelector('button[type="submit"]');
    
    form.reset();
    submitBtn.classList.remove('loading');
    submitBtn.disabled = false;
    
    form.action = actionUrl;
    document.getElementById('inputIdRecuperadaDefectuosa').value = idRecuperada ?? '';
    document.getElementById('inputSerialRecuperadaDefectuosa').value = serialRecuperada ?? '';
    
    form.querySelector('input[name="orden"]').value = orden ?? '';
    form.querySelector('input[name="clave_key"]').value = serialRecuperada ?? '';
    form.querySelector('input[name="proveedor"]').value = proveedor ?? '---';
    
    let hidden = form.querySelector('input[name="idProveedor"]');
    if (!hidden) {
        hidden = document.createElement("input");
        hidden.type = "hidden";
        hidden.name = "idProveedor";
        form.appendChild(hidden);
    }
    hidden.value = idProveedor ?? '';
    
    const modal = new bootstrap.Modal(document.getElementById('modalLicenciaDefectuosa'));
    modal.show();
    
    // Focus en ticket
    setTimeout(() => {
        form.querySelector('input[name="numero_ticket"]').focus();
    }, 500);
}

// === VALIDACIONES Y CONFIRMACIONES ===
document.addEventListener('DOMContentLoaded', function() {
    // MODAL USAR LICENCIA - Validaciones
    const formUsar = document.getElementById('formUsarLicencia');
    const submitBtnUsar = formUsar.querySelector('button[type="submit"]');
    
    formUsar.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const equipo = formUsar.querySelector('input[name="equipo"]').value.trim();
        const tipoEquipo = formUsar.querySelector('input[name="tipo_equipo"]').value.trim();
        const serialEquipo = formUsar.querySelector('input[name="serial_equipo"]').value.trim();
        
        let errores = [];
        
        if (!equipo) errores.push('• El <strong>Nombre del Equipo</strong> es obligatorio');
        if (!tipoEquipo) errores.push('• El <strong>Tipo de Equipo</strong> es obligatorio');
        if (!serialEquipo) errores.push('• El <strong>Serial del Equipo</strong> es obligatorio');
        
        if (errores.length > 0) {
            Swal.fire({
                icon: 'error',
                title: 'Datos Incompletos',
                html: `<div class="text-start"><p class="mb-2">Por favor complete:</p>${errores.join('<br>')}</div>`,
                confirmButtonText: 'Entendido',
                confirmButtonColor: '#27ae60'
            });
            return;
        }
        
        Swal.fire({
            icon: 'question',
            title: '¿Confirmar asignación?',
            html: `
                <div class="text-start">
                    <p><strong>Equipo:</strong> ${equipo}</p>
                    <p><strong>Tipo:</strong> ${tipoEquipo}</p>
                    <p><strong>Serial:</strong> ${serialEquipo}</p>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: '<i class="bi bi-check-circle me-2"></i>Confirmar',
            cancelButtonText: 'Cancelar',
            confirmButtonColor: '#27ae60',
            cancelButtonColor: '#6c757d'
        }).then((result) => {
            if (result.isConfirmed) {
                submitBtnUsar.classList.add('loading');
                submitBtnUsar.disabled = true;
                formUsar.submit();
            }
        });
    });
    
    // MODAL DEFECTUOSA - Validaciones
    const formDefectuosa = document.getElementById('formLicenciaDefectuosa');
    const submitBtnDefectuosa = formDefectuosa.querySelector('button[type="submit"]');
    
    formDefectuosa.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const ticket = formDefectuosa.querySelector('input[name="numero_ticket"]').value.trim();
        const clave = formDefectuosa.querySelector('input[name="clave_key"]').value.trim();
        
        if (!ticket) {
            Swal.fire({
                icon: 'error',
                title: 'Ticket Requerido',
                text: 'Debe ingresar un número de ticket para reportar la licencia defectuosa',
                confirmButtonColor: '#e74c3c'
            });
            return;
        }
        
        Swal.fire({
            icon: 'warning',
            title: '¿Marcar como Defectuosa?',
            html: `
                <div class="text-start">
                    <div class="alert alert-danger">
                        <strong>Advertencia:</strong> Esta acción no se puede deshacer
                    </div>
                    <p><strong>Clave:</strong> ${clave}</p>
                    <p><strong>Ticket:</strong> ${ticket}</p>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: '<i class="bi bi-exclamation-triangle me-2"></i>Marcar Defectuosa',
            cancelButtonText: 'Cancelar',
            confirmButtonColor: '#e74c3c',
            cancelButtonColor: '#6c757d'
        }).then((result) => {
            if (result.isConfirmed) {
                submitBtnDefectuosa.classList.add('loading');
                submitBtnDefectuosa.disabled = true;
                formDefectuosa.submit();
            }
        });
    });
    
    // File Upload Handler
    const fileInput = document.getElementById('archivoUsada');
    const fileSelected = document.getElementById('fileSelectedUsada');
    
    if (fileInput) {
        fileInput.addEventListener('change', function() {
            if (this.files.length > 0) {
                const fileName = this.files[0].name;
                fileSelected.querySelector('.file-name').textContent = fileName;
                fileSelected.style.display = 'flex';
            }
        });
        
        const removeBtn = fileSelected.querySelector('.file-remove');
        if (removeBtn) {
            removeBtn.addEventListener('click', function() {
                fileInput.value = '';
                fileSelected.style.display = 'none';
            });
        }
    }
    
    // Validación en tiempo real
    const inputs = document.querySelectorAll('.form-input[required]');
    inputs.forEach(input => {
        input.addEventListener('input', function() {
            const container = this.closest('.input-container');
            if (this.value.trim()) {
                container.classList.remove('invalid');
                container.classList.add('valid');
            } else {
                container.classList.remove('valid');
                container.classList.add('invalid');
            }
        });
    });
});
</script>

@endsection
