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
