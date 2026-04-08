/**
 * Obtiene todos los filtros activos del formulario
 */
function getActiveFilters() {
    const filters = {};

    // Capturar todos los selects con clase .filtro-componente
    document.querySelectorAll('.filtro-componente').forEach(select => {
        if (select.name && select.value) {
            filters[select.name] = select.value;
        }
    });

    return filters;
}

/**
 * Construye URL con parámetros de búsqueda, contenedor y filtros
 */
function buildPaginationUrl(baseUrl) {
    const container = document.getElementById('hidden-container')?.value || '';
    const search = document.querySelector('[name="search"]')?.value || '';
    const activeFilters = getActiveFilters();

    const url = new URL(baseUrl, window.location.origin);
    const params = new URLSearchParams(url.search);

    // Agregar/actualizar parámetros solo si tienen valor
    if (container) params.set('container', container);
    if (search) params.set('search', search);

    // Agregar filtros activos (mantienen la estructura filtro[estado], filtro[marca])
    Object.keys(activeFilters).forEach(key => {
        if (activeFilters[key]) {
            params.set(key, activeFilters[key]);
        }
    });

    url.search = params.toString();
    return url.toString();
}

/**
 * Muestra u oculta el loader de paginación
 */
function toggleLoader(show) {
    const loader = document.getElementById('hidden-loader-paginate');
    if (loader) {
        loader.style.display = show ? 'block' : 'none';
    }
}

/**
 * Carga productos vía AJAX manteniendo los filtros activos
 * Función unificada para paginación con búsqueda
 */
function loadProductsViaPagination(element) {
    const url = element.getAttribute('data-link');
    const container = document.getElementById('hidden-container')?.value || '';

    if (!url || !container) {
        console.error('URL o contenedor no válido para paginación');
        return;
    }

    const fullUrl = buildPaginationUrl(url);
    const target = document.getElementById(container);

    if (!target) {
        console.error('Contenedor de destino no encontrado:', container);
        return;
    }

    toggleLoader(true);

    fetch(fullUrl)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP ${response.status}: ${response.statusText}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.html) {
                target.innerHTML = data.html;
            } else {
                console.error('La respuesta no contiene propiedad html');
            }
        })
        .catch(error => {
            console.error('Error en paginación AJAX:', error);
        })
        .finally(() => {
            toggleLoader(false);
        });
}

/**
 * Evento para enlaces de paginación (reemplaza la función duplicada)
 */
function linkEvent(element) {
    loadProductsViaPagination(element);
}

// Mantener compatibilidad con la función loadProducts original
function loadProducts(url) {
    const fakeElement = { getAttribute: () => url };
    loadProductsViaPagination(fakeElement);
}