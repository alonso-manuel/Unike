
document.addEventListener('DOMContentLoaded', function() {
    // Efecto de loading en el botón de submit
    const form = document.getElementById('licenseForm');
    const submitBtn = form.querySelector('button[type="submit"]');

    form.addEventListener('submit', function() {
        submitBtn.classList.add('loading');
        submitBtn.disabled = true;

        // Restaurar el botón después de 3 segundos como fallback
        setTimeout(() => {
            submitBtn.classList.remove('loading');
            submitBtn.disabled = false;
        }, 3000);
    });

    // Efecto de focus mejorado para inputs
    const inputs = document.querySelectorAll('.form-input, .form-select');
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('focused');
        });

        input.addEventListener('blur', function() {
            this.parentElement.classList.remove('focused');
        });
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const categoriaSelect = document.getElementById('id_categoria');
    const usosContainer = document.getElementById('usos-container');
    const usosInput = document.getElementById('cantidad_usos');
    const usosText = document.getElementById('usos-text');
    const usosPreview = document.getElementById('usos-preview');
    const usosRestantes = document.getElementById('usos-restantes');
    const usosProgress = document.getElementById('usos-progress');
    const MAX_USOS = 9999;

    // Configurar evento de cambio de categoría
    categoriaSelect.addEventListener('change', toggleUsosField);

    // Configurar eventos del input
    usosInput.addEventListener('input', actualizarVisualizacion);
    usosInput.addEventListener('blur', validarUsosEnBlur);

    // Inicializar si hay valor seleccionado
    if (categoriaSelect.value) {
        toggleUsosField();
    }

    // Función principal para mostrar/ocultar
    function toggleUsosField() {
        const selectedOption = categoriaSelect.options[categoriaSelect.selectedIndex];
        const tipoCategoria = selectedOption.getAttribute('data-tipo') || '';
        const esMultifuncional = tipoCategoria.toLowerCase().includes('multiusuario');

        if (esMultifuncional) {
            // Mostrar con animación
            usosContainer.classList.remove('d-none');
            setTimeout(() => usosContainer.classList.add('show'), 10);

            // Configurar requerido
            usosInput.required = true;

            // Enfocar si no tiene valor
            if (!usosInput.value || usosInput.value < 1) {
                usosInput.value = 1;
                usosInput.focus();
            }

            // Actualizar visualización
            actualizarVisualizacion();
        } else {
            // Ocultar con animación
            usosContainer.classList.remove('show');
            setTimeout(() => usosContainer.classList.add('d-none'), 300);

            // Limpiar
            usosInput.required = false;
            usosInput.value = '';
        }
    }

    // Validación en tiempo real
    function validarUsos(input) {
        let value = parseInt(input.value) || 0;

        if (value < 1) {
            input.value = 1;
            input.classList.add('is-invalid');
        } else if (value > MAX_USOS) {
            input.value = MAX_USOS;
            input.classList.add('is-invalid');
        } else {
            input.classList.remove('is-invalid');
            input.classList.add('is-valid');
        }

        // Actualizar visualización
        actualizarVisualizacion();
    }

    // Validación al perder foco
    function validarUsosEnBlur() {
        const input = this;
        if (!input.value || input.value < 1) {
            input.value = 1;
            input.classList.add('is-invalid');
            setTimeout(() => input.classList.remove('is-invalid'), 2000);
        }
    }

    // Actualizar elementos visuales
    function actualizarVisualizacion() {
        const cantidad = parseInt(usosInput.value) || 1;

        // Actualizar texto
        usosPreview.textContent = cantidad;
        usosRestantes.textContent = 10 - cantidad;

        // Actualizar texto singular/plural
        usosText.textContent = cantidad === 1 ? 'uso' : 'usos';

        // Actualizar barra de progreso (máximo 50% para mejor visualización)
        const porcentaje = Math.min((cantidad / 10) * 100, 100);
        usosProgress.style.width = porcentaje + '%';

        // Cambiar color según cantidad
        if (cantidad >= 10) {
            usosProgress.className = 'progress-bar bg-danger';
        } else if (cantidad > 5 ) {
            usosProgress.className = 'progress-bar bg-warning';
        } else {
            usosProgress.className = 'progress-bar bg-success';
        }
    }

    // Función global para botones rápidos
    window.setUsos = function(cantidad) {
        if (usosContainer.classList.contains('d-none')) {
            alert('Primero seleccione "Multifuncional" como categoría');
            return;
        }
        
        usosInput.value = cantidad;
        validarUsos(usosInput);
        usosInput.focus();
    };
});
