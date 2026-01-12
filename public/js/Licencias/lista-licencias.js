function copiarPreClave(preClave) {
    const tempInput = document.createElement('input');
    tempInput.value = preClave;
    document.body.appendChild(tempInput);
    tempInput.select();

    try {
        if (navigator.clipboard && window.isSecureContext) {
            navigator.clipboard.writeText(preClave).then(() => {
                mostrarNotificacionCopiado(preClave);
            }).catch(() => {
                document.execCommand('copy');
                mostrarNotificacionCopiado(preClave);
            });
        } else {
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

function mostrarNotificacionCopiado(preClave) {
    const existingNotification = document.querySelector('.copy-notification');
    if (existingNotification) {
        existingNotification.remove();
    }

    const notification = document.createElement('div');
    notification.className = 'copy-notification';
    notification.innerHTML = `
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="20 6 9 17 4 12"></polyline>
        </svg>
        <span><strong>Pre-Clave copiada:</strong> ${preClave}</span>
    `;

    document.body.appendChild(notification);

    setTimeout(() => {
        notification.remove();
    }, 3000);
}
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
