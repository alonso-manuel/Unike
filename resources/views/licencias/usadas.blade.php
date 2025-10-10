@extends('layouts.app')
@section('title', 'Licencias Usadas')

@section('content')
<div class="usadas-container">
    {{-- Header Verde Separado --}}
    <div class="used-header">
        <div class="header-content">
            <div class="header-icon">
                <i class="bi bi-check-circle-fill"></i>
            </div>
            <div class="header-info">
                <h4 class="header-title">LICENCIAS USADAS</h4>
                <div class="header-stats">
                    <span class="stat-item">
                        <i class="bi bi-collection"></i>
                        Total: <strong>{{ $licenciasUsadas->total() }}</strong>
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

    {{-- Búsqueda --}}
    <div class="search-container">
        <form action="{{ route('licencias.usadas') }}" method="GET" class="search-form">
            <div class="search-input-group">
                <i class="bi bi-search search-icon"></i>
                <input type="text" 
                    name="search" 
                    class="search-input" 
                    placeholder="Buscar por Serial, Clave o Equipo..."
                    value="{{ old('search', $search) }}">
            </div>
            <button type="submit" class="btn-search">
                <i class="bi bi-search"></i>
                Buscar
            </button>
            @if($search)
                <a href="{{ route('licencias.usadas') }}" class="btn-clear">
                    <i class="bi bi-x-circle"></i>
                    Limpiar
                </a>
            @endif
        </form>
    </div>

    @if($licenciasUsadas->isEmpty())
        {{-- Estado Vacío --}}
        <div class="empty-state">
            <div class="empty-icon">
                <i class="bi bi-inbox"></i>
            </div>
            <h4 class="empty-title">
                @if($search)
                    No se encontraron resultados
                @else
                    Sin Licencias Usadas
                @endif
            </h4>
            <p class="empty-text">
                @if($search)
                    No hay licencias que coincidan con "{{ $search }}"
                @else
                    No hay licencias usadas registradas en el sistema.
                @endif
            </p>
        </div>
    @else
        {{-- Tabla Compacta Separada --}}
        <div class="table-wrapper">
            <div class="table-container">
                <table class="table-used">
                    <thead>
                        <tr>
                            <th><i class="bi bi-key"></i> CLAVE DE ACTIVACIÓN</th>
                            <th><i class="bi bi-qr-code"></i> VOUCHER</th>
                            <th><i class="bi bi-pc-display"></i> EQUIPO</th>
                            <th><i class="bi bi-tag"></i> TIPO</th>
                            <th><i class="bi bi-hash"></i> SERIAL EQUIPO</th>
                            <th><i class="bi bi-tools"></i> ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($licenciasUsadas as $usada)
                            <tr>
                                {{-- Clave --}}
                                <td>
                                    <span class="key-code">{{ $usada->clave_key }}</span>
                                </td>

                                {{-- Voucher --}}
                                <td>
                                    @if($usada->licencia && $usada->licencia->voucher_code)
                                        <span class="voucher-text">{{ $usada->licencia->voucher_code }}</span>
                                    @else
                                        <span class="text-muted">---</span>
                                    @endif
                                </td>

                                {{-- Equipo --}}
                                <td>
                                    @if($usada->equipo)
                                        <span class="equipment-text">{{ $usada->equipo }}</span>
                                    @else
                                        <span class="text-muted">No especificado</span>
                                    @endif
                                </td>

                                {{-- Tipo --}}
                                <td>
                                    @if($usada->tipo_equipo)
                                        <span class="type-badge">{{ $usada->tipo_equipo }}</span>
                                    @else
                                        <span class="text-muted">---</span>
                                    @endif
                                </td>

                                {{-- Serial --}}
                                <td>
                                    @if($usada->serial_equipo)
                                        <span class="serial-text">{{ Str::limit($usada->serial_equipo, 20) }}</span>
                                    @else
                                        <span class="text-muted">---</span>
                                    @endif
                                </td>

                                {{-- Acciones --}}
                                <td>
                                    <div class="action-btns">
                                        {{-- Botón Info --}}
                                        <button 
                                            type="button"
                                            class="btn-action btn-info"
                                            data-bs-toggle="modal"
                                            data-bs-target="#descripcionModal"
                                            data-descripcion="{{ $usada->descripcion ?? '' }}"
                                            data-proveedor="{{ optional($usada->licencia->proveedor)->nombreProveedor ?? 'Sin proveedor' }}"
                                            data-clave="{{ $usada->clave_key }}"
                                            data-equipo="{{ $usada->equipo ?? 'No especificado' }}"
                                            title="Ver descripción">
                                            <i class="bi bi-info-circle"></i>
                                        </button>

                                        {{-- Botón Descarga --}}
                                        @if($usada->archivo)
                                            <a href="{{ asset('storage/' . $usada->archivo) }}" 
                                               class="btn-action btn-download" 
                                               download="{{ basename($usada->archivo) }}"
                                               title="Descargar archivo">
                                                <i class="bi bi-download"></i>
                                            </a>
                                        @else
                                            <button class="btn-action btn-disabled" disabled title="Sin archivo">
                                                <i class="bi bi-download"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Paginación Separada --}}
        <div class="pagination-container">
            {{ $licenciasUsadas->appends(['search' => request('search')])->links() }}
        </div>
    @endif
</div>

{{-- Modal de Descripción --}}
<div class="modal fade" id="descripcionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-file-text me-2"></i>
                    Detalles de Licencia
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="detail-section">
                    <label>Clave de Activación:</label>
                    <p id="claveInfo">---</p>
                </div>
                <div class="detail-section">
                    <label>Equipo:</label>
                    <p id="equipoInfo">---</p>
                </div>
                <div class="detail-section">
                    <label>Proveedor:</label>
                    <p id="proveedorInfo">---</p>
                </div>
                <div class="detail-section">
                    <label>Descripción:</label>
                    <div class="description-box" id="descripcionContenido">
                        Sin descripción disponible.
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

{{-- Estilos CSS --}}
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
.usadas-container {
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

/* === BÚSQUEDA === */
.search-container {
    background: white;
    padding: 1rem 1.5rem;
    border-radius: 8px;
    margin-bottom: 1.5rem;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.search-form {
    display: flex;
    gap: 0.75rem;
    align-items: center;
}

.search-input-group {
    flex: 1;
    position: relative;
}

.search-icon {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: #6c757d;
    font-size: 1rem;
}

.search-input {
    width: 100%;
    padding: 0.75rem 1rem 0.75rem 2.75rem;
    border: 2px solid #dee2e6;
    border-radius: 8px;
    font-size: 0.9rem;
    transition: all 0.3s ease;
}

.search-input:focus {
    outline: none;
    border-color: var(--used-primary);
    box-shadow: 0 0 0 3px rgba(39, 174, 96, 0.1);
}

.btn-search,
.btn-clear {
    padding: 0.75rem 1.25rem;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.9rem;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    text-decoration: none;
    white-space: nowrap;
}

.btn-search {
    background: var(--used-primary);
    color: white;
}

.btn-search:hover {
    background: var(--used-secondary);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(39, 174, 96, 0.3);
}

.btn-clear {
    background: #6c757d;
    color: white;
}

.btn-clear:hover {
    background: #5a6268;
    color: white;
}

/* === ESTADO VACÍO === */
.empty-state {
    text-align: center;
    padding: 3rem 2rem;
    background: white;
    border-radius: 8px;
    border: 1px solid #dee2e6;
}

.empty-icon {
    font-size: 4rem;
    color: #bdc3c7;
    margin-bottom: 1rem;
}

.empty-title {
    color: var(--used-dark);
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.empty-text {
    color: #6c757d;
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

/* === CONTENIDO DE CELDAS === */
.key-code {
    font-family: 'Courier New', monospace;
    font-weight: 600;
    color: var(--used-dark);
    font-size: 0.8rem;
}

.voucher-text {
    color: #0066cc;
    font-weight: 500;
}

.equipment-text {
    color: var(--used-dark);
}

.type-badge {
    background: #fff3cd;
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
    font-size: 0.75rem;
    font-weight: 600;
    color: #856404;
    display: inline-block;
}

.serial-text {
    font-family: 'Courier New', monospace;
    font-size: 0.75rem;
    color: #495057;
}

.text-muted {
    color: #6c757d;
    font-style: italic;
}

/* === BOTONES DE ACCIÓN === */
.action-btns {
    display: flex;
    gap: 0.4rem;
}

.btn-action {
    border: none;
    width: 32px;
    height: 32px;
    border-radius: 4px;
    cursor: pointer;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    font-size: 0.9rem;
}

.btn-info {
    background: #17a2b8;
    color: white;
}

.btn-info:hover {
    background: #138496;
}

.btn-download {
    background: var(--used-primary);
    color: white;
}

.btn-download:hover {
    background: var(--used-secondary);
}

.btn-disabled {
    background: #e9ecef;
    color: #adb5bd;
    cursor: not-allowed;
}

/* === PAGINACIÓN SEPARADA === */
.pagination-container {
    background: white;
    padding: 1rem 1.5rem;
    border: 1px solid #dee2e6;
    border-radius: 8px;
    display: flex;
    justify-content: center;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

/* === SCROLLBAR PERSONALIZADO === */
.table-container::-webkit-scrollbar {
    width: 8px;
    height: 8px;
}

.table-container::-webkit-scrollbar-track {
    background: #f1f1f1;
}

.table-container::-webkit-scrollbar-thumb {
    background: var(--used-primary);
    border-radius: 4px;
}

.table-container::-webkit-scrollbar-thumb:hover {
    background: var(--used-secondary);
}

/* === MODAL === */
.modal-content {
    border-radius: 8px;
}

.modal-header {
    background: var(--used-primary);
    color: white;
    border-radius: 8px 8px 0 0;
}

.modal-header .btn-close {
    filter: brightness(0) invert(1);
}

.detail-section {
    margin-bottom: 1rem;
}

.detail-section label {
    font-weight: 600;
    color: var(--used-dark);
    font-size: 0.85rem;
    margin-bottom: 0.25rem;
    display: block;
}

.detail-section p {
    margin: 0;
    color: #495057;
    font-family: 'Courier New', monospace;
}

.description-box {
    background: #f8f9fa;
    border: 1px solid #dee2e6;
    border-radius: 6px;
    padding: 0.75rem;
    min-height: 80px;
    max-height: 200px;
    overflow-y: auto;
    color: #495057;
    line-height: 1.6;
    white-space: pre-wrap;
}

/* === RESPONSIVE === */
@media (max-width: 1400px) {
    .usadas-container {
        max-width: calc(100% - 60px);
    }
}

@media (max-width: 992px) {
    .usadas-container {
        max-width: calc(100% - 40px);
    }
}

@media (max-width: 768px) {
    .usadas-container {
        max-width: calc(100% - 20px);
        padding: 1rem 0;
    }
    
    .used-header {
        flex-direction: column;
        gap: 1rem;
    }
    
    .header-stats {
        flex-direction: column;
        gap: 0.5rem;
        align-items: flex-start;
    }
    
    .search-form {
        flex-direction: column;
    }
    
    .btn-search,
    .btn-clear {
        width: 100%;
        justify-content: center;
    }
    
    .table-wrapper {
        max-height: 500px;
    }
    
    .table-container {
        overflow-x: auto;
    }
    
    .table-used {
        min-width: 900px;
    }
}
</style>

{{-- Script para modal --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const descripcionModal = document.getElementById('descripcionModal');
    
    descripcionModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const descripcion = (button.getAttribute('data-descripcion') || '').trim();
        const proveedor = (button.getAttribute('data-proveedor') || 'Sin proveedor').trim();
        const clave = (button.getAttribute('data-clave') || '---').trim();
        const equipo = (button.getAttribute('data-equipo') || 'No especificado').trim();

        document.getElementById('claveInfo').textContent = clave;
        document.getElementById('equipoInfo').textContent = equipo;
        document.getElementById('proveedorInfo').textContent = proveedor;

        const contenidoFormateado = descripcion
            ? descripcion.replace(/\n/g, '<br>').replace(/ {2,}/g, '&nbsp;&nbsp;')
            : 'Sin descripción disponible.';
        
        document.getElementById('descripcionContenido').innerHTML = contenidoFormateado;

        if (!descripcion) {
            document.getElementById('descripcionContenido').style.fontStyle = 'italic';
            document.getElementById('descripcionContenido').style.color = '#6c757d';
        } else {
            document.getElementById('descripcionContenido').style.fontStyle = 'normal';
            document.getElementById('descripcionContenido').style.color = '#2c3e50';
        }
    });
});
</script>

@endsection