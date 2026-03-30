/**
 * Manejo de filtros AJAX para lista_producto.blade.php
 * Permite actualizar la lista de productos sin recargar la página
 */

document.addEventListener('DOMContentLoaded', function() {
    inicializarFiltrosAjax();
});

function inicializarFiltrosAjax() {
    const form = document.getElementById('form-filtro-componente');
    
    if (!form || form.dataset.ajax === 'false') {
        return;
    }

    const selects = form.querySelectorAll('.filtro-componente');
    
    selects.forEach(select => {
        select.addEventListener('change', function() {
            cargarProductosAjax(form);
        });
    });
}

function cargarProductosAjax(form) {
    const container = document.getElementById('lista-producto-container');
    const contentDiv = document.getElementById('productos-lista-content');
    
    if (!container || !contentDiv) {
        form.submit();
        return;
    }

    const url = container.dataset.url || form.action;
    const tc = container.dataset.tc || '';
    
    // Mostrar indicador de carga
    mostrarLoading(contentDiv);

    // Serializar datos del formulario
    const formData = new FormData(form);
    const params = new URLSearchParams(formData);
    
    // Obtener parámetro 'search' de la URL actual si existe
    const currentUrl = new URL(window.location.href);
    const searchParam = currentUrl.searchParams.get('search');
    if (searchParam) {
        params.append('search', searchParam);
    }

    // Construir URL con parámetros
    const separator = url.includes('?') ? '&' : '?';
    const requestUrl = `${url}${separator}${params.toString()}`;

    // Realizar petición fetch
    fetch(requestUrl, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json, text/html',
        },
        credentials: 'same-origin'
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Error en la respuesta del servidor');
        }
        return response.json();
    })
    .then(data => {
        // El controlador devuelve { html: '...' }
        if (data.html) {
            actualizarContenidoProductos(data.html, contentDiv);
        } else {
            throw new Error('Respuesta HTML no encontrada');
        }
    })
    .catch(error => {
        console.error('Error al cargar productos:', error);
        ocultarLoading(contentDiv);
        // Fallback: enviar formulario tradicional
        form.submit();
    });
}

function mostrarLoading(element) {
    element.style.opacity = '0.5';
    element.style.pointerEvents = 'none';
    
    const existingLoader = element.querySelector('.ajax-loading-spinner');
    if (!existingLoader) {
        const spinner = document.createElement('div');
        spinner.className = 'ajax-loading-spinner';
        spinner.style.cssText = `
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1000;
        `;
        spinner.innerHTML = `
            <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
                <span class="visually-hidden">Cargando...</span>
            </div>
        `;
        element.parentElement.style.position = 'relative';
        element.parentElement.appendChild(spinner);
    }
}

function ocultarLoading(element) {
    element.style.opacity = '1';
    element.style.pointerEvents = 'auto';
    
    const spinner = element.parentElement.querySelector('.ajax-loading-spinner');
    if (spinner) {
        spinner.remove();
    }
}

function actualizarContenidoProductos(html, contentDiv) {
    // Crear un elemento temporal para parsear el HTML
    const tempDiv = document.createElement('div');
    tempDiv.innerHTML = html;
    
    // Buscar el contenido de productos en la respuesta
    const nuevoContenido = tempDiv.querySelector('#productos-lista-content');
    
    if (nuevoContenido) {
        // Reemplazar contenido
        contentDiv.innerHTML = nuevoContenido.innerHTML;
        
        // Re-inicializar tooltips de Bootstrap si existen
        if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
            const tooltipTriggerList = [].slice.call(contentDiv.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        }
    } else {
        // Si no se encuentra el contenedor, reemplazar todo el contenido
        contentDiv.innerHTML = html;
    }
    
    ocultarLoading(contentDiv);
    
    // Disparar evento personalizado para que otros scripts puedan reaccionar
    const event = new CustomEvent('productosActualizados', {
        detail: { contentDiv: contentDiv }
    });
    document.dispatchEvent(event);
}

// Función para recargar productos desde fuera (útil para otras interacciones)
function recargarProductos() {
    const form = document.getElementById('form-filtro-componente');
    if (form) {
        cargarProductosAjax(form);
    }
}
