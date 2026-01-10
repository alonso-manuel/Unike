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
