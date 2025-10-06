@extends('layouts.app')
@section('title', 'Licencias')
@section('content')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/index_licencias.css') }}">
@endpush
<div class="container" style="max-width: 1500px;">
    <h1>Licencias Nuevas</h1>
    {{-- Prototipo --}}

    {{-- Fin de prototipo--}}
    {{-- 
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    --}} 
    <a class="btn btn-primary gap-2 mb-3" href="#collapse-buttons" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="collapse-buttons">
      Opciones de licencias
    </a>
    <a class="btn btn-primary gap-2 mb-3" href="#collapse-buttons-ecxel" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="collapse-buttons-ecxel">
      Opciones para ecxel
    </a>
    <a class="btn btn-primary gap-2 mb-3" href="#collapse-filtros" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="collapse-filtros">
      Filtros
    </a>
    {{-- Collapse-Buttons-Licencias (Opciones de licencias(NUEVAS-USADAS-DEFECTUOSAS-RECUPERADAS)) --}}
    <div class="collapse gap-2 mb-3 " id="collapse-buttons">
      <div class="d-flex flex-wrap gap-2 mb-3">
          <a href="{{ route('licencias.create') }}" class="btn btn-primary">
              <i class="bi bi-plus-circle"></i> Agregar Licencia
          </a>
          <a href="{{ route('licencias.usadas') }}" class="btn btn-info">
              <i class="bi bi-list"></i> Ver Licencias Usadas
          </a>
          <a href="{{ route('licencias.defectuosas') }}" class="btn btn-danger">
              <i class="bi bi-list"></i> Ver Licencias Defectuosas
          </a>
          <a href="{{ route('licencias.recuperadas') }}" class="btn btn-warning">
              <i class="bi bi-list"></i> Ver Licencias Recuperadas
          </a>
      </div> 
    </div>
    {{-- Fin de Collapse-Buttons-Licencias --}}

    {{-- Collapse-Buttons-Ecxel (Ver Proveedores y Licencias) --}}
    <div class="collapse" id="collapse-buttons-ecxel">
      <div class="d-flex flex-wrap gap-2 mb-3">
          <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalProveedores">
            <i class="bi bi-list"></i> Ver Proveedores (Ecxel)
          </button>
          <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalTiposLicencias">
            <i class="bi bi-list"></i> Ver Tipos de Licencia (Ecxel)
          </button>
      </div>
    </div>
    {{-- Fin de Collapse-Buttons-Ecxel --}}

    {{-- Pruebas para los filtros --}}
    <div class="collapse" id="collapse-filtros">
      <div class="d-flex flex-wrap gap-2 mb-3">
        <button type="button" class="btn btn-sucess">
          <i class="bi bi-filter"></i>
        </button>
        <button type="button" class="btn btn-sucess">
          <i class="bi bi-filter"></i>
        </button>
      </div>
    </div>
    {{-- Fin de Pruebas de filtros --}}
    
    <form action="{{ route('licencias.import') }}" method="POST" enctype="multipart/form-data" class="mb-3">
        @csrf
        <div class="input-group">
            {{-- Input de archivo --}}
            <input type="file" name="archivo" class="form-control" required>
            
            {{-- Botón de importar --}}
            <button class="btn btn-success" type="submit">
                Importar Excel
            </button>
            
            {{-- Botón de descarga al final --}}
            <a href="{{ route('licencias.plantilla_excel') }}" 
            class="btn btn-secondary" 
            title="Descargar Plantilla">
                <i class="bi bi-download"></i>
            </a>
        </div>
        
        {{-- Error --}}
        @error('archivo')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </form>

    <div id="container-list-licencias" class="w-100">
        <x-lista_licencias :licencias="$licencias" :container="'container-list-licencias'" />
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
                       placeholder="Ej: 401372"
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
