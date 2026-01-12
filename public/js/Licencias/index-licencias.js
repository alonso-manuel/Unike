function abrirModalLicenciaDefectuosa(actionUrl, ordenCompra, idProveedor, razonSocialProveedor) {
    const form = document.getElementById('formLicenciaDefectuosa');
    form.reset();
    form.action = actionUrl;

    form.querySelector('input[name="orden"]').value = ordenCompra ?? '';
    form.querySelector('input[name="razSocialProveedor"]').value = razonSocialProveedor ?? '';

    let hiddenIdField = form.querySelector('input[name="idProveedor"]');
    if (!hiddenIdField) {
        hiddenIdField = document.createElement('input');
        hiddenIdField.type = 'hidden';
        hiddenIdField.name = 'idProveedor';
        form.appendChild(hiddenIdField);
    }
    hiddenIdField.value = idProveedor ?? '';

    const modal = new bootstrap.Modal(document.getElementById('modalLicenciaDefectuosa'));
    modal.show();

    setTimeout(() => {
        form.querySelector('input[name="clave_key"]').focus();
    }, 300);
}

document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('formLicenciaDefectuosa');

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        const claveKey = form.querySelector('input[name="clave_key"]').value.trim();
        const numeroTicket = form.querySelector('input[name="numero_ticket"]').value.trim();

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
                Swal.fire({
                    title: 'Procesando...',
                    text: 'Marcando licencia como defectuosa',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                form.submit();
            }
        });
    }
});

//
let claveValidada = false;
let verificandoClave = false;
function abrirModalUsarLicencia(actionUrl, ordenCompra) {
    const form = document.getElementById('formUsarLicencia');
    form.reset();
    form.action = actionUrl;
    form.querySelector('input[name="orden"]').value = ordenCompra ?? '';
    limpiarValidacion();
    claveValidada = false;

    const modal = new bootstrap.Modal(document.getElementById('modalUsarLicencia'));
    modal.show();
}
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
async function verificarClaveManual(clave) {
    const btnVerificar = document.getElementById('btnVerificarClave');
    const iconVerificar = document.getElementById('iconVerificar');
    const spinnerVerificar = document.getElementById('spinnerVerificar');
    const claveInput = document.getElementById('clave_key');
    const claveError = document.getElementById('clave-error');
    const claveSuccess = document.getElementById('clave-success');
    const claveErrorText = document.getElementById('clave-error-text');
    const inputGroup = claveInput.closest('.input-group-modern');

    verificandoClave = true;
    btnVerificar.disabled = true;
    iconVerificar.classList.add('d-none');
    spinnerVerificar.classList.remove('d-none');
    limpiarValidacion();

    try {
        const existe = await verificarClaveDuplicada(clave);

        if (existe) {
            claveValidada = false;
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
            });
        } else {
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
        verificandoClave = false;
        btnVerificar.disabled = false;
        iconVerificar.classList.remove('d-none');
        spinnerVerificar.classList.add('d-none');
    }
}

document.getElementById('clave_key').addEventListener('input', function() {
    if (claveValidada) {
        claveValidada = false;
        limpiarValidacion();
    }
});

document.getElementById('formUsarLicencia').addEventListener('submit', async function(e) {
    e.preventDefault();

    const claveInput = document.getElementById('clave_key');
    const claveValue = claveInput.value.trim();
    const claveError = document.getElementById('clave-error');
    const claveErrorText = document.getElementById('clave-error-text');
    const inputGroup = claveInput.closest('.input-group-modern');
    const btnGuardar = document.getElementById('btnGuardar');
    const loadingSpinner = document.getElementById('loadingSpinner');
    const saveIcon = document.getElementById('saveIcon');
    const btnText = document.getElementById('btnText');
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
    if (!claveValidada && !verificandoClave) {
        try {
            btnGuardar.disabled = true;
            loadingSpinner.classList.remove('d-none');
            saveIcon.classList.add('d-none');
            btnText.textContent = 'Verificando clave...';

            const existe = await verificarClaveDuplicada(claveValue);

            if (existe) {
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
            btnGuardar.disabled = false;
            loadingSpinner.classList.add('d-none');
            saveIcon.classList.remove('d-none');
            btnText.textContent = 'Guardar Licencia';
        }
    }
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
            btnGuardar.disabled = true;
            loadingSpinner.classList.remove('d-none');
            saveIcon.classList.add('d-none');
            btnText.textContent = 'Guardando...';
            this.submit();
        }
    });
});

document.getElementById('modalUsarLicencia').addEventListener('hidden.bs.modal', function() {
    const form = document.getElementById('formUsarLicencia');
    const btnGuardar = document.getElementById('btnGuardar');
    const loadingSpinner = document.getElementById('loadingSpinner');
    const saveIcon = document.getElementById('saveIcon');
    const btnText = document.getElementById('btnText');
    form.reset();
    limpiarValidacion();
    claveValidada = false;
    btnGuardar.disabled = false;
    loadingSpinner.classList.add('d-none');
    saveIcon.classList.remove('d-none');
    btnText.textContent = 'Guardar Licencia';
});
