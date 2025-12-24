{{-- resources/views/licencias/partials/listado.blade.php --}}
<div class="lista_licencias">
    @if(!$licencias->isEmpty())
    <div class="table-container">
        <table class="licenses-table">
            <thead>
                <tr>
                    <th class="text-start">Pre-Clave</th>
                    <th>Orden Compra</th>
                    <th>Tipo</th>
                    <th>Proveedor</th>
                    <th>Categoria</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($licencias as $licencia)
                <tr>
                    <td class="text-start">
                        <div class="preclave-container">
                            <span class="preclave-text">{{ $licencia->voucher_code }}</span>
                            <button 
                                class="copy-btn" 
                                onclick="copiarPreClave('{{ $licencia->voucher_code }}')"
                                title="Copiar Pre-Clave"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                                    <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                                </svg>
                            </button>
                        </div>
                    </td>
                    <td>{{ $licencia->orden_compra }}</td>
                    <td>{{ $licencia->tipoLicencia->nombre }}</td>
                    <td>
                        <div class="proveedor-info">
                            <span class="proveedor-nombre">{{ optional($licencia->proveedor)->nombreProveedor ?? 'Sin proveedor' }}</span>
                            @if(optional($licencia->proveedor)->razSocialProveedor)
                            <span class="proveedor-razon">{{ $licencia->proveedor->razSocialProveedor }}</span>
                            @endif
                        </div>
                    </td>
                    <td>
                        <span class="badge badge-success">{{ optional($licencia->categoriaLicencia)->tipo_categoria ?? 'Sale'}}</span>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <button 
                                onclick="abrirModalUsarLicencia('{{ route('licencias.cambiar_estado', $licencia->voucher_code) }}', '{{ $licencia->orden_compra }}')" 
                                class="btn-action btn-usar"
                                title="Usar licencia"
                            >
                                Usar
                            </button>
                            <button 
                                onclick="abrirModalLicenciaDefectuosa('{{ route('licencias.cambiar_estado', $licencia->voucher_code) }}', '{{ $licencia->orden_compra }}', '{{ optional($licencia->proveedor)->idProveedor ?? '' }}', '{{ optional($licencia->proveedor)->razSocialProveedor ?? '' }}')"
                                class="btn-action btn-defectuosa"
                                title="Marcar como defectuosa"
                            >
                                Marcar Defectuosa
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <div class="pagination-wrapper">
        <x-paginacion :justify="'end'" :coleccion="$licencias" :container="$container"/>
    </div>
    
    @else
    <div class="empty-state">
        <x-aviso_no_encontrado :mensaje="'No se encontraron licencias.'" />
    </div>
    @endif
</div>

<style>
/* ============================================
   VARIABLES CSS
   ============================================ */
:root {
    --primary-color: #043e69;
    --primary-hover: #032d4d;
    --primary-light: #0a5a94;
    --success-color: #10b981;
    --success-hover: #059669;
    --danger-color: #ef4444;
    --danger-hover: #dc2626;
    --info-color: #3b82f6;
    --info-hover: #2563eb;
    --border-color: #e5e7eb;
    --text-primary: #1f2937;
    --text-secondary: #6b7280;
    --bg-hover: #f9fafb;
    --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    --radius-sm: 4px;
    --radius-md: 8px;
    --radius-lg: 12px;
}

/* ============================================
   CONTENEDOR PRINCIPAL
   ============================================ */
.lista_licencias {
    width: 100%;
    margin: 0 auto;
}

/* ============================================
   CONTENEDOR DE TABLA
   ============================================ */
.table-container {
    background: white;
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-md);
    overflow: hidden;
    margin-bottom: 1.5rem;
}

/* ============================================
   TABLA
   ============================================ */
.licenses-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.875rem;
}

.licenses-table thead {
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);
    color: white;
    position: sticky;
    top: 0;
    z-index: 10;
    box-shadow: var(--shadow-sm);
}

.licenses-table th {
    padding: 1rem;
    text-align: center;
    font-weight: 600;
    font-size: 0.875rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    white-space: nowrap;
}

.licenses-table tbody tr {
    border-bottom: 1px solid var(--border-color);
    transition: all 0.2s ease;
}

.licenses-table tbody tr:hover {
    background-color: var(--bg-hover);
    transform: translateY(-1px);
    box-shadow: var(--shadow-sm);
}

.licenses-table tbody tr:last-child {
    border-bottom: none;
}

.licenses-table td {
    padding: 1rem;
    text-align: center;
    color: var(--text-primary);
    vertical-align: middle;
}

/* ============================================
   PRE-CLAVE CON BOTÓN COPIAR
   ============================================ */
.preclave-container {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.375rem 0.75rem;
    background: #f3f4f6;
    border-radius: var(--radius-md);
    transition: all 0.2s ease;
}

.preclave-container:hover {
    background: #e5e7eb;
}

.preclave-text {
    font-family: 'Courier New', monospace;
    font-weight: 600;
    font-size: 0.875rem;
    color: var(--primary-color);
    letter-spacing: 0.025em;
}

.copy-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0.25rem;
    background: transparent;
    border: none;
    color: var(--text-secondary);
    cursor: pointer;
    border-radius: var(--radius-sm);
    transition: all 0.2s ease;
}

.copy-btn:hover {
    color: var(--primary-color);
    background: white;
    transform: scale(1.1);
}

.copy-btn:active {
    transform: scale(0.95);
}

.copy-btn svg {
    width: 16px;
    height: 16px;
}

/* ============================================
   INFORMACIÓN DE PROVEEDOR
   ============================================ */
.proveedor-info {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
    align-items: center;
}

.proveedor-nombre {
    font-weight: 600;
    color: var(--text-primary);
}

.proveedor-razon {
    font-size: 0.75rem;
    color: var(--text-secondary);
}

/* ============================================
   BADGES DE ESTADO
   ============================================ */
.badge {
    display: inline-block;
    padding: 0.375rem 0.75rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.badge-success {
    background: var(--success-color);
    color: white;
}

/* ============================================
   BOTONES DE ACCIÓN
   ============================================ */
.action-buttons {
    display: flex;
    gap: 0.5rem;
    justify-content: center;
    flex-wrap: wrap;
}

.btn-action {
    padding: 0.5rem 1rem;
    border: none;
    border-radius: var(--radius-md);
    font-size: 0.813rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
    white-space: nowrap;
}

.btn-usar {
    background: var(--info-color);
    color: white;
}

.btn-usar:hover {
    background: var(--info-hover);
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

.btn-defectuosa {
    background: var(--danger-color);
    color: white;
}

.btn-defectuosa:hover {
    background: var(--danger-hover);
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

.btn-action:active {
    transform: translateY(0);
}

/* ============================================
   ESTADO VACÍO
   ============================================ */
.empty-state {
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 50vh;
    background: white;
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-md);
}

/* ============================================
   PAGINACIÓN
   ============================================ */
.pagination-wrapper {
    display: flex;
    justify-content: flex-end;
    margin-top: 1rem;
}

/* ============================================
   NOTIFICACIÓN DE COPIADO
   ============================================ */
.copy-notification {
    position: fixed;
    bottom: 2rem;
    right: 2rem;
    background: var(--primary-color);
    color: white;
    padding: 1rem 1.5rem;
    border-radius: var(--radius-md);
    box-shadow: var(--shadow-lg);
    display: flex;
    align-items: center;
    gap: 0.75rem;
    animation: slideIn 0.3s ease, slideOut 0.3s ease 2.7s;
    z-index: 1000;
}

@keyframes slideIn {
    from {
        transform: translateX(400px);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

@keyframes slideOut {
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
        font-size: 0.813rem;
    }
    
    .licenses-table th,
    .licenses-table td {
        padding: 0.75rem 0.5rem;
    }
}

@media (max-width: 992px) {
    .table-container {
        overflow-x: auto;
    }
    
    .licenses-table {
        min-width: 900px;
    }
    
    .action-buttons {
        flex-direction: column;
    }
}

@media (max-width: 768px) {
    .licenses-table {
        font-size: 0.75rem;
    }
    
    .licenses-table th,
    .licenses-table td {
        padding: 0.625rem 0.375rem;
    }
    
    .btn-action {
        padding: 0.375rem 0.75rem;
        font-size: 0.75rem;
    }
    
    .copy-notification {
        bottom: 1rem;
        right: 1rem;
        left: 1rem;
    }
}

/* ============================================
   SCROLLBAR PERSONALIZADO
   ============================================ */
.table-container::-webkit-scrollbar {
    height: 8px;
}

.table-container::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: var(--radius-sm);
}

.table-container::-webkit-scrollbar-thumb {
    background: var(--primary-color);
    border-radius: var(--radius-sm);
}

.table-container::-webkit-scrollbar-thumb:hover {
    background: var(--primary-hover);
}
</style>

<script>
/**
 * Copia la Pre-Clave al portapapeles
 * @param {string} preClave - El código de la pre-clave a copiar
 */
function copiarPreClave(preClave) {
    // Crear un elemento temporal para copiar
    const tempInput = document.createElement('input');
    tempInput.value = preClave;
    document.body.appendChild(tempInput);
    tempInput.select();
    
    try {
        // Intentar copiar usando el API moderno
        if (navigator.clipboard && window.isSecureContext) {
            navigator.clipboard.writeText(preClave).then(() => {
                mostrarNotificacionCopiado(preClave);
            }).catch(() => {
                // Fallback al método antiguo
                document.execCommand('copy');
                mostrarNotificacionCopiado(preClave);
            });
        } else {
            // Método antiguo para navegadores sin soporte
            document.execCommand('copy');
            mostrarNotificacionCopiado(preClave);
        }
    } catch (err) {
        console.error('Error al copiar:', err);
        alert('No se pudo copiar la Pre-Clave');
    } finally {
        document.body.removeChild(tempInput);
    }
}

/**
 * Muestra una notificación temporal cuando se copia una Pre-Clave
 * @param {string} preClave - El código copiado
 */
function mostrarNotificacionCopiado(preClave) {
    // Remover notificación existente si hay
    const existingNotification = document.querySelector('.copy-notification');
    if (existingNotification) {
        existingNotification.remove();
    }
    
    // Crear nueva notificación
    const notification = document.createElement('div');
    notification.className = 'copy-notification';
    notification.innerHTML = `
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="20 6 9 17 4 12"></polyline>
        </svg>
        <span><strong>Pre-Clave copiada:</strong> ${preClave}</span>
    `;
    
    document.body.appendChild(notification);
    
    // Remover después de 3 segundos
    setTimeout(() => {
        notification.remove();
    }, 3000);
}
</script>

<script>
  function filtrarPorTipo() {
      const tipo = document.getElementById('filtro-tipo').value;
      const search = document.querySelector('[name="search"]')?.value || '';
      const containerName = 'container-list-licencias';
      const url = `${window.location.pathname}?tipo=${tipo}&search=${search}&container=${containerName}`;

      const container = document.getElementById(containerName);
      container.innerHTML = `
          <div class="text-center p-3">
              <div class="spinner-border text-primary" role="status">
                  <span class="visually-hidden">Cargando...</span>
              </div>
          </div>
      `;

      fetch(url)
          .then(res => res.json()) 
          .then(data => {
              container.innerHTML = data.html;
          })
          .catch(err => console.error('Error al cargar filtro:', err));
  }
</script>   
