@extends('layouts.app')
@section('title', 'Licencias Defectuosas')
@section('content')
<div class="defectuosas-container">
    <!-- Header Section -->
    <div class="used-header">
        <div class="header-content">
            <div class="header-icon">
                <i class="bi bi-x-octagon-fill"></i>
            </div>
            <div class="header-info">
                <h4 class="header-title">LICENCIAS DEFECTUOSAS</h4>
                <div class="header-stats">
                    <span class="stat-item">
                        <i class="bi bi-collection"></i>
                        Total: <strong>{{ $licenciasDefectuosas->total() }}</strong>
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

    @if($licenciasDefectuosas->isEmpty())
        <div class="empty-state">
            <div class="empty-state-icon">
                <i class="bi bi-check-circle"></i>
            </div>
            <h3 class="empty-state-title">No hay licencias defectuosas</h3>
            <p class="empty-state-text">Todas las licencias están funcionando correctamente</p>
        </div>
    @else
        <!-- Table Container -->
        <div class="table-container">
            <div class="table-wrapper">
                <table class="table-used">
                    <thead>
                        <tr>
                            <th>Clave</th>
                            <th>Voucher</th>
                            <th>Orden</th>
                            <th>N° Ticket</th>
                            <th>Proveedor</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($licenciasDefectuosas as $defectuosa)
                        <tr>
                            <td>
                                <div class="code-cell">
                                    <span class="code-text">{{ $defectuosa->clave_key }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="text-muted">{{ $defectuosa->licencia->voucher_code ?? '---' }}</span>
                            </td>
                            <td>
                                <span class="text-muted">{{ $defectuosa->orden ?? '---' }}</span>
                            </td>
                            <td>
                                <span class="text-muted">{{ $defectuosa->numero_ticket ?? '---' }}</span>
                            </td>
                            <td>
                                <span class="provider-name">{{ $defectuosa->proveedor->nombreProveedor ?? '---' }}</span>
                            </td>
                            <td>
                                <span class="badge-defective">{{ $defectuosa->estado }}</span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <button 
                                        onclick="abrirModalLicenciaRecuperada(
                                            '{{ route('licencias.cambiar_estado', $defectuosa->licencia->voucher_code) }}',
                                            '{{ $defectuosa->orden }}',
                                            '{{ $defectuosa->clave_key }}',
                                            '{{ $defectuosa->numero_ticket }}',
                                            '{{ optional($defectuosa->proveedor)->idProveedor}}',
                                            '{{ optional($defectuosa->proveedor)->nombreProveedor}}'                               
                                        )"
                                        class="btn-recover">
                                        <i class="bi bi-arrow-clockwise"></i>
                                        <span>Recuperar</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Pagination -->
        <div class="pagination-container">
            {{ $licenciasDefectuosas->links() }}
        </div>
    @endif
</div>

<style>
/* ============================================
   VARIABLES CSS
   ============================================ */
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
.defectuosas-container {
    max-width: calc(100% - 100px);
    margin: 0 auto;
    padding: 2rem 0;
}

/* ============================================
   HEADER SECTION
   ============================================ */
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
/* ============================================
   EMPTY STATE
   ============================================ */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    background: var(--bg-white);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-md);
}

.empty-state-icon {
    font-size: 5rem;
    color: var(--success-color);
    margin-bottom: 1.5rem;
}

.empty-state-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 0.5rem;
}

.empty-state-text {
    font-size: 1rem;
    color: var(--text-secondary);
    margin: 0;
}

/* ============================================
   TABLE CONTAINER
   ============================================ */
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
/* ============================================
   TABLE STYLES
   ============================================ */
.licenses-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.95rem;
}

.licenses-table thead {
    position: sticky;
    top: 0;
    z-index: 10;
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);
}

.licenses-table thead th {
    padding: 1.25rem 1rem;
    text-align: left;
    font-weight: 600;
    font-size: 0.875rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: white;
    border-bottom: 3px solid var(--primary-dark);
}

.licenses-table tbody tr {
    border-bottom: 1px solid var(--border-color);
    transition: var(--transition);
}

.licenses-table tbody tr:hover {
    background: linear-gradient(to right, rgba(4, 62, 105, 0.03), transparent);
    transform: translateX(2px);
}

.licenses-table tbody td {
    padding: 1rem;
    color: var(--text-primary);
    vertical-align: middle;
}

/* ============================================
   CODE CELL WITH COPY BUTTON
   ============================================ */
.code-cell {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.code-text {
    font-family: 'Courier New', monospace;
    font-weight: 600;
    color: var(--primary-color);
    font-size: 0.9rem;
}

.btn-copy {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    padding: 0;
    background: var(--bg-light);
    border: 1px solid var(--border-color);
    border-radius: var(--radius-sm);
    color: var(--text-secondary);
    cursor: pointer;
    transition: var(--transition);
}

.btn-copy:hover {
    background: var(--primary-color);
    border-color: var(--primary-color);
    color: white;
    transform: scale(1.1);
}

.btn-copy.copied {
    background: var(--success-color);
    border-color: var(--success-color);
    color: white;
}

.btn-copy i {
    font-size: 0.9rem;
}

/* ============================================
   BADGES
   ============================================ */
.badge-defective {
    display: inline-block;
    padding: 0.5rem 1rem;
    background: var(--danger-light);
    color: var(--danger-color);
    border: 1px solid var(--danger-color);
    border-radius: var(--radius-md);
    font-weight: 600;
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* ============================================
   ACTION BUTTONS
   ============================================ */
.action-buttons {
    display: flex;
    gap: 0.5rem;
    justify-content: center;
}

.btn-recover {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    background: linear-gradient(135deg, var(--warning-color), #ffb300);
    color: #000;
    border: none;
    border-radius: var(--radius-sm);
    font-weight: 600;
    font-size: 0.875rem;
    cursor: pointer;
    transition: var(--transition);
    box-shadow: var(--shadow-sm);
}

.btn-recover:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
    background: linear-gradient(135deg, #ffb300, var(--warning-color));
}

.btn-recover i {
    font-size: 1rem;
}

/* ============================================
   PAGINATION
   ============================================ */
.pagination-container {
    display: flex;
    justify-content: flex-end;
    padding: 1.5rem;
    background: var(--bg-white);
    border-radius: var(--radius-lg);
    margin-top: 1rem;
    box-shadow: var(--shadow-sm);
}

/* ============================================
   TEXT UTILITIES
   ============================================ */
.text-muted {
    color: var(--text-muted);
}

.provider-name {
    color: var(--text-primary);
    font-weight: 500;
}

/* ============================================
   COPY NOTIFICATION
   ============================================ */
.copy-notification {
    position: fixed;
    top: 20px;
    right: 20px;
    background: var(--success-color);
    color: white;
    padding: 1rem 1.5rem;
    border-radius: var(--radius-md);
    box-shadow: var(--shadow-lg);
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-weight: 600;
    z-index: 9999;
    animation: slideInRight 0.3s ease, slideOutRight 0.3s ease 2.7s;
}

.copy-notification i {
    font-size: 1.5rem;
}

@keyframes slideInRight {
    from {
        transform: translateX(400px);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

@keyframes slideOutRight {
    from {
        transform: translateX(0);
        opacity: 1;
    }
    to {
        transform: translateX(400px);
        opacity: 0;
    }
}

/* ============================================
   RESPONSIVE DESIGN
   ============================================ */
@media (max-width: 1200px) {
    .licenses-table {
        font-size: 0.875rem;
    }
    
    .licenses-table thead th,
    .licenses-table tbody td {
        padding: 0.875rem 0.75rem;
    }
}

@media (max-width: 768px) {
    .header-content {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .header-title {
        font-size: 1.5rem;
    }
    
    .header-subtitle {
        font-size: 0.875rem;
    }
    
    .btn-back {
        width: 100%;
        justify-content: center;
    }
    
    .table-wrapper {
        max-height: 60vh;
    }
    
    .licenses-table {
        font-size: 0.8rem;
    }
    
    .licenses-table thead th,
    .licenses-table tbody td {
        padding: 0.75rem 0.5rem;
    }
    
    .code-text {
        font-size: 0.75rem;
    }
    
    .btn-copy {
        width: 28px;
        height: 28px;
    }
    
    .btn-recover span {
        display: none;
    }
    
    .action-buttons {
        justify-content: flex-start;
    }
}

@media (max-width: 480px) {
    .defectuosas-header {
        padding: 1.5rem;
    }
    
    .header-title-section > i {
        font-size: 2rem;
    }
    
    .header-title {
        font-size: 1.25rem;
    }
    
    .table-wrapper {
        max-height: 50vh;
    }
}
</style>

<script>
/**
 * Copia el código al portapapeles y muestra notificación
 */
function copiarCodigo(codigo, button) {
    // Copiar al portapapeles
    navigator.clipboard.writeText(codigo).then(function() {
        // Cambiar icono temporalmente
        const icon = button.querySelector('i');
        const originalClass = icon.className;
        icon.className = 'bi bi-check2';
        button.classList.add('copied');
        
        // Mostrar notificación
        mostrarNotificacionCopia(codigo);
        
        // Restaurar después de 2 segundos
        setTimeout(function() {
            icon.className = originalClass;
            button.classList.remove('copied');
        }, 2000);
    }).catch(function(err) {
        console.error('Error al copiar:', err);
        alert('No se pudo copiar el código');
    });
}

/**
 * Muestra una notificación elegante cuando se copia
 */
function mostrarNotificacionCopia(codigo) {
    // Crear elemento de notificación
    const notification = document.createElement('div');
    notification.className = 'copy-notification';
    notification.innerHTML = `
        <i class="bi bi-check-circle-fill"></i>
        <span>Clave copiada: <strong>${codigo}</strong></span>
    `;
    
    // Agregar al body
    document.body.appendChild(notification);
    
    // Eliminar después de 3 segundos
    setTimeout(function() {
        notification.remove();
    }, 3000);
}
</script>
{{-- Modal Licencia Recuperada - MEJORADO --}}
<div class="modal fade" id="modalLicenciaRecuperada" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <form id="formLicenciaRecuperada" method="POST">
            @csrf
            <input type="hidden" name="nuevo_estado" value="RECUPERADA">
            <input type="hidden" name="idProveedor">
            
            <div class="modal-content recuperada-modal">
                {{-- Header --}}
                <div class="modal-header recuperada-header">
                    <div class="d-flex align-items-center">
                        <div class="header-icon me-3">
                            <i class="bi bi-arrow-clockwise"></i>
                        </div>
                        <div>
                            <h5 class="modal-title mb-0">Marcar Licencia como Recuperada</h5>
                            <small class="opacity-75">Registrar nueva licencia recuperada del proveedor</small>
                        </div>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                {{-- Body --}}
                <div class="modal-body recuperada-body">
                    {{-- Información --}}
                    <div class="info-banner">
                        <i class="bi bi-info-circle-fill me-2"></i>
                        <div>
                            <strong>Información:</strong> Esta licencia reemplaza a una defectuosa previamente reportada.
                        </div>
                    </div>

                    {{-- Datos de la Licencia Defectuosa --}}
                    <div class="info-section">
                        <h6 class="section-title">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            Licencia Defectuosa Original
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
                                        <i class="bi bi-x-circle me-1"></i>
                                        Serial Defectuosa
                                    </label>
                                    <input type="text" name="serial_defectuosa" class="form-input serial-defectuosa" readonly>
                                    <div class="input-icon">
                                        <i class="bi bi-lock-fill"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-container">
                                    <label class="input-label">
                                        <i class="bi bi-hash me-1"></i>
                                        Número de Ticket
                                    </label>
                                    <input type="text" name="numero_ticket" class="form-input" readonly>
                                    <div class="input-icon">
                                        <i class="bi bi-lock-fill"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-container">
                                    <label class="input-label">
                                        <i class="bi bi-building me-1"></i>
                                        Proveedor
                                    </label>
                                    <input type="text" name="razonSocialProveedor" class="form-input" readonly>
                                    <div class="input-icon">
                                        <i class="bi bi-lock-fill"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Nueva Licencia Recuperada --}}
                    <div class="info-section">
                        <h6 class="section-title">
                            <i class="bi bi-key-fill me-2"></i>
                            Nueva Licencia Recuperada
                        </h6>
                        <div class="row g-3">
                            <div class="col-md-8">
                                <div class="input-container">
                                    <label class="input-label required">
                                        <i class="bi bi-shield-check me-1"></i>
                                        Serial Recuperada
                                    </label>
                                    <input 
                                        type="text" 
                                        name="serial_recuperada" 
                                        id="serialRecuperadaInput"
                                        class="form-input" 
                                        required
                                        placeholder="Ej: XXXXX-XXXXX-XXXXX-XXXXX">
                                    <div class="input-icon">
                                        <i class="bi bi-asterisk"></i>
                                    </div>
                                    <small class="input-hint">Nuevo serial proporcionado por el proveedor</small>
                                    <div class="validation-feedback"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Indicador de verificación --}}
                    <div class="verification-status" id="verificationStatus" style="display: none;">
                        <div class="verification-spinner">
                            <div class="spinner-border spinner-border-sm text-primary me-2" role="status">
                                <span class="visually-hidden">Verificando...</span>
                            </div>
                            <span>Verificando serial...</span>
                        </div>
                    </div>
                </div>

                {{-- Footer --}}
                <div class="modal-footer recuperada-footer">
                    <button type="button" class="btn-modal btn-cancel" data-bs-dismiss="modal">
                        <i class="bi bi-x-lg me-2"></i>
                        Cancelar
                    </button>
                    <button type="submit" class="btn-modal btn-recuperada" id="btnSubmitRecuperada">
                        <i class="bi bi-check-circle me-2"></i>
                        Guardar Licencia
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
    --recuperada-primary: #3498db;
    --recuperada-secondary: #2980b9;
    --recuperada-success: #27ae60;
    --recuperada-danger: #e74c3c;
    --dark: #2c3e50;
    --light: #ecf0f1;
}

/* === MODAL RECUPERADA === */
.recuperada-modal {
    border: none;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 10px 40px rgba(52, 152, 219, 0.15);
}

.recuperada-header {
    background: linear-gradient(135deg, var(--recuperada-primary) 0%, var(--recuperada-secondary) 100%);
    border: none;
    padding: 1.5rem;
    color: white;
}

.recuperada-body {
    padding: 2rem;
    background: #fafafa;
}

.recuperada-footer {
    background: var(--light);
    border-top: 2px solid #dee2e6;
    padding: 1rem 2rem;
}

/* === HEADER === */
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

@keyframes rotate {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

/* === INFO BANNER === */
.info-banner {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
    background: #e8f4fd;
    border: 1px solid #bbdefb;
    border-left: 4px solid var(--recuperada-primary);
    border-radius: 8px;
    padding: 1rem;
    margin-bottom: 1.5rem;
    color: #0d47a1;
}

.info-banner i {
    color: var(--recuperada-primary);
    font-size: 1.25rem;
    flex-shrink: 0;
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
    margin-bottom: 0;
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

.form-input {
    width: 100%;
    padding: 0.75rem 2.5rem 0.75rem 0.75rem;
    border: 2px solid #dee2e6;
    border-radius: 8px;
    font-size: 0.9rem;
    color: var(--dark);
    transition: all 0.3s ease;
    background: white;
}

.form-input:focus {
    outline: none;
    border-color: var(--recuperada-primary);
    box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
}

.form-input:read-only {
    background: #f8f9fa;
    cursor: not-allowed;
    color: #6c757d;
}

.serial-defectuosa {
    background: #fdf2f2 !important;
    border-color: #fadbd8 !important;
    text-decoration: line-through;
    color: #e74c3c !important;
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

/* === VALIDACIÓN === */
.input-container.valid .form-input {
    border-color: var(--recuperada-success);
    background: #f0f8f0;
}

.input-container.valid .input-icon {
    color: var(--recuperada-success);
}

.input-container.invalid .form-input {
    border-color: var(--recuperada-danger);
    background: #fdf2f2;
}

.input-container.invalid .input-icon {
    color: var(--recuperada-danger);
}

.validation-feedback {
    margin-top: 0.5rem;
    font-size: 0.8rem;
    display: none;
}

.validation-feedback.show {
    display: block;
}

.validation-feedback.success {
    color: var(--recuperada-success);
}

.validation-feedback.error {
    color: var(--recuperada-danger);
}

/* === ESTADO BADGE === */
.estado-badge {
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #e8f4fd 0%, #f0f8ff 100%);
    border: 2px solid var(--recuperada-primary);
    border-radius: 8px;
    padding: 0.75rem;
    color: var(--recuperada-primary);
    font-weight: 700;
    font-size: 0.85rem;
    margin-top: 26px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* === VERIFICATION STATUS === */
.verification-status {
    background: #fff8e1;
    border: 1px solid #ffe0b2;
    border-radius: 8px;
    padding: 0.75rem 1rem;
    margin-top: 1rem;
}

.verification-spinner {
    display: flex;
    align-items: center;
    color: #ff9800;
    font-size: 0.85rem;
    font-weight: 600;
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

.btn-recuperada {
    background: linear-gradient(135deg, var(--recuperada-primary) 0%, var(--recuperada-secondary) 100%);
    color: white;
}

.btn-recuperada:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(52, 152, 219, 0.3);
}

.btn-recuperada:disabled {
    opacity: 0.5;
    cursor: not-allowed;
    pointer-events: none;
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
    
    .recuperada-body {
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
// === ABRIR MODAL ===
function abrirModalLicenciaRecuperada(actionUrl, orden, serialDefectuosa, numeroTicket, idProveedor, razonSocialProveedor) {
    const form = document.getElementById('formLicenciaRecuperada');
    const submitBtn = document.getElementById('btnSubmitRecuperada');
    
    form.reset();
    submitBtn.classList.remove('loading');
    submitBtn.disabled = false;
    
    form.action = actionUrl;
    
    // Llenar valores
    form.querySelector('input[name="orden"]').value = orden || '';
    form.querySelector('input[name="serial_defectuosa"]').value = serialDefectuosa || '';
    form.querySelector('input[name="numero_ticket"]').value = numeroTicket || '';
    form.querySelector('input[name="razonSocialProveedor"]').value = razonSocialProveedor || '';
    form.querySelector('input[name="idProveedor"]').value = idProveedor || '';
    
    // Limpiar validación
    const container = form.querySelector('#serialRecuperadaInput').closest('.input-container');
    container.classList.remove('valid', 'invalid');
    const feedback = container.querySelector('.validation-feedback');
    feedback.classList.remove('show', 'success', 'error');
    feedback.textContent = '';
    
    const modal = new bootstrap.Modal(document.getElementById('modalLicenciaRecuperada'));
    modal.show();
    
    // Focus en serial recuperada
    setTimeout(() => {
        document.getElementById('serialRecuperadaInput').focus();
    }, 500);
}

// === VALIDACIONES ===
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('formLicenciaRecuperada');
    const submitBtn = document.getElementById('btnSubmitRecuperada');
    const serialInput = document.getElementById('serialRecuperadaInput');
    const verificationStatus = document.getElementById('verificationStatus');
    
    let debounceTimer;
    
    // Validación en tiempo real con debounce
    serialInput.addEventListener('input', function() {
        clearTimeout(debounceTimer);
        const container = this.closest('.input-container');
        const feedback = container.querySelector('.validation-feedback');
        
        if (this.value.trim().length < 3) {
            container.classList.remove('valid', 'invalid');
            feedback.classList.remove('show');
            return;
        }
        
        debounceTimer = setTimeout(() => {
            verificarSerial(this.value.trim());
        }, 800);
    });
    
    // Verificar serial en servidor
    async function verificarSerial(serial) {
        const container = serialInput.closest('.input-container');
        const feedback = container.querySelector('.validation-feedback');
        
        verificationStatus.style.display = 'block';
        
        try {
            const response = await fetch('/verificar-serial-recuperada', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ serial_recuperada: serial })
            });
            
            const data = await response.json();
            
            verificationStatus.style.display = 'none';
            
            if (data.existe) {
                container.classList.remove('valid');
                container.classList.add('invalid');
                feedback.classList.add('show', 'error');
                feedback.classList.remove('success');
                feedback.innerHTML = '<i class="bi bi-x-circle me-1"></i>Este serial ya está registrado';
                submitBtn.disabled = true;
            } else {
                container.classList.remove('invalid');
                container.classList.add('valid');
                feedback.classList.add('show', 'success');
                feedback.classList.remove('error');
                feedback.innerHTML = '<i class="bi bi-check-circle me-1"></i>Serial disponible';
                submitBtn.disabled = false;
            }
        } catch (error) {
            console.error('Error en la validación:', error);
            verificationStatus.style.display = 'none';
            container.classList.remove('valid', 'invalid');
            feedback.classList.add('show', 'error');
            feedback.innerHTML = '<i class="bi bi-exclamation-triangle me-1"></i>Error al verificar serial';
        }
    }
    
    // Submit con validación
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const serial = serialInput.value.trim();
        const serialDefectuosa = form.querySelector('input[name="serial_defectuosa"]').value.trim();
        const orden = form.querySelector('input[name="orden"]').value.trim();
        
        // Validar campo vacío
        if (serial === '') {
            Swal.fire({
                icon: 'error',
                title: 'Campo Requerido',
                text: 'Debe ingresar el serial de la licencia recuperada',
                confirmButtonColor: '#3498db'
            });
            serialInput.focus();
            return;
        }
        
        // Validar longitud mínima
        if (serial.length < 8) {
            Swal.fire({
                icon: 'error',
                title: 'Serial Inválido',
                text: 'El serial debe tener al menos 8 caracteres',
                confirmButtonColor: '#3498db'
            });
            serialInput.focus();
            return;
        }
        
        // Verificar duplicado
        try {
            submitBtn.classList.add('loading');
            submitBtn.disabled = true;
            
            const response = await fetch('/verificar-serial-recuperada', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ serial_recuperada: serial })
            });
            
            const data = await response.json();
            
            if (data.existe) {
                submitBtn.classList.remove('loading');
                submitBtn.disabled = false;
                
                Swal.fire({
                    icon: 'error',
                    title: 'Serial Duplicado',
                    text: 'Este serial ya fue registrado como recuperado',
                    confirmButtonColor: '#e74c3c'
                });
                return;
            }
            
            // Confirmación final
            const result = await Swal.fire({
                icon: 'question',
                title: '¿Confirmar Licencia Recuperada?',
                html: `
                    <div class="text-start">
                        <div class="mb-3">
                            <p class="mb-2"><strong>Licencia Defectuosa:</strong></p>
                            <p style="text-decoration: line-through; color: #e74c3c;">${serialDefectuosa}</p>
                        </div>
                        <div class="mb-3">
                            <p class="mb-2"><strong>Nueva Licencia:</strong></p>
                            <p style="color: #27ae60; font-weight: 600;">${serial}</p>
                        </div>
                        <div>
                            <p class="mb-2"><strong>Orden:</strong> ${orden}</p>
                        </div>
                    </div>
                `,
                showCancelButton: true,
                confirmButtonText: '<i class="bi bi-check-circle me-2"></i>Confirmar',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#3498db',
                cancelButtonColor: '#6c757d',
                customClass: {
                    popup: 'recuperada-confirm-popup'
                }
            });
            
            if (result.isConfirmed) {
                // Mostrar mensaje de procesamiento
                Swal.fire({
                    icon: 'info',
                    title: 'Procesando...',
                    text: 'Guardando licencia recuperada',
                    timer: 1500,
                    timerProgressBar: true,
                    showConfirmButton: false,
                    toast: true,
                    position: 'top-end'
                });
                
                form.submit();
            } else {
                submitBtn.classList.remove('loading');
                submitBtn.disabled = false;
            }
            
        } catch (error) {
            console.error('Error en la validación:', error);
            submitBtn.classList.remove('loading');
            submitBtn.disabled = false;
            
            Swal.fire({
                icon: 'error',
                title: 'Error en el Servidor',
                text: 'No se pudo verificar el serial. Intente nuevamente.',
                confirmButtonColor: '#e74c3c'
            });
        }
    });
});
</script>

<style>
/* Estilos para SweetAlert personalizado */
.recuperada-confirm-popup {
    border-radius: 12px !important;
}

.recuperada-confirm-popup .swal2-html-container {
    padding: 1rem !important;
}
</style>
@endsection