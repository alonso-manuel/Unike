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

    setTimeout(() => {
        form.querySelector('input[name="equipo"]').focus();
    }, 500);
}

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

    setTimeout(() => {
        form.querySelector('input[name="numero_ticket"]').focus();
    }, 500);
}

//validaciones
document.addEventListener('DOMContentLoaded', function() {
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
