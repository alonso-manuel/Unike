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
    let url = element.getAttribute('data-link');
    if (!url) return;

    let container = document.getElementById('hidden-container').value;
    let tipo = document.getElementById('filtro-tipo')?.value || '';
    let search = document.querySelector('[name="search"]')?.value || '';

    const params = new URLSearchParams();
    if (tipo) params.append('tipo', tipo);
    if (search) params.append('search', search);

    const fullUrl = url + (url.includes('?') ? '&' : '?') + params.toString();

    document.getElementById('hidden-loader-paginate').style.display = 'block';

    fetch(fullUrl)
        .then(res => res.text()) // ✅ texto, no JSON
        .then(html => {
            document.getElementById(container).innerHTML = html;
        })
        .finally(() => {
            document.getElementById('hidden-loader-paginate').style.display = 'none';
        });
}
function linkEvent(element) {
    const url = element.getAttribute('data-link');
    const container = document.getElementById('hidden-container').value;
    const tipo = document.getElementById('filtro-tipo')?.value || '';
    const search = document.querySelector('[name="search"]')?.value || '';

    if (!url) return;

    const finalUrl = `${url}&container=${container}&tipo=${tipo}&search=${search}`;

    const target = document.getElementById(container);
    const loader = document.getElementById('hidden-loader-paginate');
    if (loader) loader.style.display = 'block';

    fetch(finalUrl)
        .then(res => res.json()) // 👈 backend devuelve JSON con { html: ... }
        .then(data => {
            target.innerHTML = data.html;
        })
        .catch(err => console.error('Error en paginación AJAX:', err))
        .finally(() => {
            if (loader) loader.style.display = 'none';
        });
}