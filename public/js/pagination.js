function loadProducts(url) {
    let loader = document.getElementById('hidden-loader-paginate');
    let containerValue = document.getElementById('hidden-container').value;
    let fullUrl = url + (url.includes('?') ? '&' : '?') + 'container=' + containerValue;

    if(loader){
        loader.style.display = 'block';
    }

    fetch(fullUrl)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            document.getElementById(containerValue).innerHTML = data.html;
            if(loader){
                loader.style.display = 'none';
            }
        })
        .catch(error => console.error('Error al cargar los productos:', error));
}

function linkEvent(element) {
    const url = element.getAttribute('data-link');
    const container = document.getElementById('hidden-container').value;

    if (!url) return;

    // La URL ya viene con los parámetros de Laravel (search, filtro, etc.) gracias a appends()
    // Solo agregamos el container
    const separator = url.includes('?') ? '&' : '?';
    const fullUrl = `${url}${separator}container=${container}`;

    const target = document.getElementById(container);
    const loader = document.getElementById('hidden-loader-paginate');
    if (loader) loader.style.display = 'block';

    fetch(fullUrl)
        .then(res => res.json())
        .then(data => {
            target.innerHTML = data.html;
        })
        .catch(err => console.error('Error en paginación AJAX:', err))
        .finally(() => {
            if (loader) loader.style.display = 'none';
        });
}
