@extends('layouts.app')

@section('title', 'Registrar Licencia')

@section('content')
<div class="register-container">
    <div class="register-panel">
        <!-- Header del Formulario -->
        <div class="form-header">
            <div class="header-icon">
                <i class="bi bi-plus-circle-fill"></i>
            </div>
            <div class="header-content">
                <h3 class="form-title">Registrar Nueva Licencia</h3>
                <p class="form-subtitle">Ingrese los datos de la licencia en el sistema de inventario</p>
            </div>
        </div>

        <!-- Formulario -->
        <div class="form-body">
            <form action="{{ route('licencias.store') }}" method="POST" id="licenseForm">
                @csrf

                <!-- Código de Licencia -->
                <div class="form-group">
                    <label for="voucher_code" class="form-label">
                        <i class="bi bi-qr-code label-icon"></i>
                        Código de Licencia
                        <span class="required-indicator">*</span>
                    </label>
                    <div class="input-container">
                        <div class="input-icon">
                            <i class="bi bi-key-fill"></i>
                        </div>
                        <input type="text"
                               name="voucher_code"
                               id="voucher_code"
                               value="{{ old('voucher_code') }}"
                               class="form-input @error('voucher_code') is-invalid @enderror"
                               placeholder="Ej: R1OV67FVN23UDSZYCX"
                               autocomplete="off">
                        <div class="input-border"></div>
                    </div>
                    <small class="input-help">Ingrese el código único de la licencia</small>
                </div>

                <!-- Orden de Compra -->
                <div class="form-group">
                    <label for="orden_compra" class="form-label">
                        <i class="bi bi-receipt label-icon"></i>
                        Orden de Compra
                        <span class="optional-indicator">(opcional)</span>
                    </label>
                    <div class="input-container">
                        <div class="input-icon">
                            <i class="bi bi-file-text"></i>
                        </div>
                        <input type="text"
                               name="orden_compra"
                               id="orden_compra"
                               value="{{ old('orden_compra') }}"
                               class="form-input @error('orden_compra') is-invalid @enderror"
                               placeholder="N° de orden"
                               autocomplete="off">
                        <div class="input-border"></div>
                    </div>
                    <small class="input-help">Número de orden de compra asociada</small>
                </div>

                <!-- Tipo de Licencia -->
                <div class="form-group">
                    <label for="id_tipo" class="form-label">
                        <i class="bi bi-tags label-icon"></i>
                        Tipo de Licencia
                        <span class="required-indicator">*</span>
                    </label>
                    <div class="select-container">
                        <div class="select-icon">
                            <i class="bi bi-collection"></i>
                        </div>
                        <select name="id_tipo"
                                id="id_tipo"
                                class="form-select @error('id_tipo') is-invalid @enderror">
                            <option value="">-- Seleccione el tipo de licencia --</option>
                            @foreach($tiposLicencia as $tipo)
                                <option value="{{ $tipo->id }}" {{ old('id_tipo') == $tipo->id ? 'selected' : '' }}>
                                    {{ $tipo->nombre }}
                                </option>
                            @endforeach
                        </select>
                        <div class="select-arrow">
                            <i class="bi bi-chevron-down"></i>
                        </div>
                        <div class="input-border"></div>
                    </div>
                    <small class="input-help">Categoría de la licencia a registrar</small>
                </div>
                <!-- proveedor -->
                <div class="mb-3">
                    <label for="idProveedor" class="form-label">Proveedor</label>
                    <select name="idProveedor" id="idProveedor" class="form-select" required>
                        <option value="">-- Seleccione un proveedor --</option>
                        @foreach ($proveedores as $proveedor)
                            <option value="{{ $proveedor->idProveedor }}">
                                {{ $proveedor->nombreProveedor }} - {{ $proveedor->razSocialProveedor }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <!-- Información Adicional -->
                <div class="info-panel">
                    <div class="info-icon">
                        <i class="bi bi-info-circle"></i>
                    </div>
                    <div class="info-content">
                        <strong>Información:</strong> La licencia será registrada con estado "DISPONIBLE" y podrá ser asignada posteriormente a equipos específicos.
                    </div>
                </div>

                <!-- Botones de Acción -->
                <div class="form-actions">
                    <a href="{{ route('licencias.index') }}" class="btn-action btn-secondary">
                        <i class="bi bi-arrow-left"></i>
                        <span>Volver al Inventario</span>
                    </a>
                    <button type="submit" class="btn-action btn-primary">
                        <i class="bi bi-save"></i>
                        <span>Registrar Licencia</span>
                        <div class="btn-loading">
                            <div class="spinner"></div>
                        </div>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Mantener exactamente la misma funcionalidad de errores --}}
@if ($errors->any())
<script>
    let errorMessages = '';
    @foreach ($errors->all() as $error)
        errorMessages += '• {{ $error }}\n';
    @endforeach
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        html: `<pre style="text-align:left;">${errorMessages}</pre>`,
        confirmButtonColor: '#d33',
        confirmButtonText: 'Cerrar'
    });
</script>
@endif

{{-- Estilos CSS Mejorados --}}
<style>
/* === VARIABLES === */
:root {
    --primary-color: #2c3e50;
    --secondary-color: #34495e;
    --accent-color: #3498db;
    --success-color: #27ae60;
    --warning-color: #f39c12;
    --danger-color: #e74c3c;
    --light-color: #ecf0f1;
    --dark-color: #2c3e50;
    --border-color: #bdc3c7;
    --text-muted: #6c757d;
    --bg-light: #f8f9fa;
}

/* === CONTENEDOR PRINCIPAL === */
.register-container {
    min-height: 80vh;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 2rem 1rem;
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
}

/* === PANEL PRINCIPAL === */
.register-panel {
    width: 100%;
    max-width: 600px;
    background: white;
    border-radius: 20px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    border: 1px solid var(--border-color);
}

/* === HEADER DEL FORMULARIO === */
.form-header {
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
    padding: 2rem;
    color: white;
    display: flex;
    align-items: center;
    gap: 1.5rem;
}

.header-icon {
    background: rgba(255, 255, 255, 0.15);
    border: 2px solid rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    width: 70px;
    height: 70px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    backdrop-filter: blur(10px);
}

.header-content {
    flex: 1;
}

.form-title {
    font-size: 1.5rem;
    font-weight: 700;
    margin: 0 0 0.5rem 0;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.form-subtitle {
    margin: 0;
    opacity: 0.9;
    font-size: 0.95rem;
    line-height: 1.4;
}

/* === CUERPO DEL FORMULARIO === */
.form-body {
    padding: 2.5rem;
}

/* === GRUPOS DE FORMULARIO === */
.form-group {
    margin-bottom: 2rem;
}

.form-group:last-of-type {
    margin-bottom: 2.5rem;
}

/* === LABELS === */
.form-label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-weight: 600;
    color: var(--dark-color);
    margin-bottom: 0.75rem;
    font-size: 0.95rem;
}

.label-icon {
    color: var(--accent-color);
    font-size: 1.1rem;
}

.required-indicator {
    color: var(--danger-color);
    font-weight: 700;
    margin-left: 0.25rem;
}

.optional-indicator {
    color: var(--text-muted);
    font-weight: 400;
    font-size: 0.85rem;
    font-style: italic;
}

/* === CONTENEDORES DE INPUT === */
.input-container {
    position: relative;
    margin-bottom: 0.5rem;
}

.input-icon {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: var(--text-muted);
    font-size: 1.1rem;
    z-index: 2;
    transition: all 0.3s ease;
}

.form-input {
    width: 100%;
    padding: 1rem 1rem 1rem 3rem;
    border: 2px solid #e9ecef;
    border-radius: 12px;
    font-size: 0.95rem;
    background: #fff;
    transition: all 0.3s ease;
    position: relative;
    z-index: 1;
}

.form-input:focus {
    outline: none;
    border-color: var(--accent-color);
    box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.15);
    transform: translateY(-2px);
}

.form-input:focus + .input-border {
    transform: scaleX(1);
}

.form-input:focus ~ .input-icon {
    color: var(--accent-color);
    transform: translateY(-50%) scale(1.1);
}

.input-border {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 2px;
    background: linear-gradient(90deg, var(--accent-color) 0%, var(--success-color) 100%);
    transform: scaleX(0);
    transition: transform 0.3s ease;
    border-radius: 0 0 12px 12px;
}

.form-input.is-invalid {
    border-color: var(--danger-color);
    background: #fdf2f2;
}

.form-input.is-invalid:focus {
    border-color: var(--danger-color);
    box-shadow: 0 0 0 0.2rem rgba(231, 76, 60, 0.15);
}

/* === SELECT === */
.select-container {
    position: relative;
    margin-bottom: 0.5rem;
}

.select-icon {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: var(--text-muted);
    font-size: 1.1rem;
    z-index: 2;
    transition: all 0.3s ease;
    pointer-events: none;
}

.form-select {
    width: 100%;
    padding: 1rem 3rem 1rem 3rem;
    border: 2px solid #e9ecef;
    border-radius: 12px;
    font-size: 0.95rem;
    background: #fff;
    transition: all 0.3s ease;
    appearance: none;
    cursor: pointer;
}

.form-select:focus {
    outline: none;
    border-color: var(--accent-color);
    box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.15);
    transform: translateY(-2px);
}

.form-select:focus + .select-arrow {
    color: var(--accent-color);
    transform: translateY(-50%) rotate(180deg);
}

.form-select:focus ~ .input-border {
    transform: scaleX(1);
}

.form-select:focus ~ .select-icon {
    color: var(--accent-color);
    transform: translateY(-50%) scale(1.1);
}

.select-arrow {
    position: absolute;
    right: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: var(--text-muted);
    font-size: 1rem;
    transition: all 0.3s ease;
    pointer-events: none;
}

.form-select.is-invalid {
    border-color: var(--danger-color);
    background: #fdf2f2;
}

/* === AYUDA DE INPUT === */
.input-help {
    color: var(--text-muted);
    font-size: 0.8rem;
    margin-top: 0.5rem;
    display: block;
    font-style: italic;
}

/* === PANEL DE INFORMACIÓN === */
.info-panel {
    background: linear-gradient(135deg, #e3f2fd 0%, #f0f8ff 100%);
    border: 1px solid #bbdefb;
    border-left: 4px solid var(--accent-color);
    border-radius: 12px;
    padding: 1.25rem;
    margin-bottom: 2rem;
    display: flex;
    align-items: flex-start;
    gap: 1rem;
}

.info-icon {
    background: rgba(52, 152, 219, 0.1);
    border-radius: 50%;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--accent-color);
    font-size: 1.2rem;
    flex-shrink: 0;
}

.info-content {
    color: #1565c0;
    font-size: 0.9rem;
    line-height: 1.5;
}

/* === ACCIONES DEL FORMULARIO === */
.form-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 1rem;
    margin-top: 2rem;
}

.btn-action {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.875rem 1.5rem;
    border: none;
    border-radius: 12px;
    font-size: 0.95rem;
    font-weight: 600;
    text-decoration: none;
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
    min-width: 160px;
    justify-content: center;
}

.btn-secondary {
    background: #6c757d;
    color: white;
    border: 2px solid #6c757d;
}

.btn-secondary:hover {
    background: #5a6268;
    border-color: #5a6268;
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(108, 117, 125, 0.3);
    color: white;
}

.btn-primary {
    background: linear-gradient(135deg, var(--success-color) 0%, #2ecc71 100%);
    color: white;
    border: 2px solid var(--success-color);
}

.btn-primary:hover {
    background: linear-gradient(135deg, #229954 0%, #27ae60 100%);
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(39, 174, 96, 0.3);
}

.btn-primary:active {
    transform: translateY(0);
}

/* === LOADING SPINNER === */
.btn-loading {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.btn-action.loading .btn-loading {
    opacity: 1;
}

.btn-action.loading span,
.btn-action.loading i {
    opacity: 0;
}

.spinner {
    width: 20px;
    height: 20px;
    border: 2px solid rgba(255, 255, 255, 0.3);
    border-top: 2px solid white;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* === ANIMACIONES === */
@keyframes slideInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.register-panel {
    animation: slideInUp 0.6s ease-out;
}

.form-group {
    animation: slideInUp 0.6s ease-out;
    animation-fill-mode: both;
}

.form-group:nth-child(1) { animation-delay: 0.1s; }
.form-group:nth-child(2) { animation-delay: 0.2s; }
.form-group:nth-child(3) { animation-delay: 0.3s; }
.info-panel { animation-delay: 0.4s; }
.form-actions { animation-delay: 0.5s; }

/* === RESPONSIVE === */
@media (max-width: 768px) {
    .register-container {
        padding: 1rem;
        min-height: 100vh;
    }

    .register-panel {
        max-width: 100%;
        border-radius: 15px;
    }

    .form-header {
        padding: 1.5rem;
        flex-direction: column;
        text-align: center;
        gap: 1rem;
    }

    .header-icon {
        width: 60px;
        height: 60px;
        font-size: 1.8rem;
    }

    .form-title {
        font-size: 1.3rem;
    }

    .form-body {
        padding: 1.5rem;
    }

    .form-actions {
        flex-direction: column;
        gap: 1rem;
    }

    .btn-action {
        width: 100%;
        min-width: auto;
    }

    .info-panel {
        flex-direction: column;
        text-align: center;
        gap: 0.75rem;
    }
}

@media (max-width: 480px) {
    .form-header {
        padding: 1rem;
    }

    .form-body {
        padding: 1rem;
    }

    .form-input,
    .form-select {
        padding: 0.875rem 0.875rem 0.875rem 2.5rem;
    }

    .input-icon,
    .select-icon {
        left: 0.75rem;
        font-size: 1rem;
    }

    .select-arrow {
        right: 0.75rem;
    }
}

/* === FOCUS STATES === */
.form-input:focus::placeholder {
    color: transparent;
}

.form-select:focus {
    color: var(--dark-color);
}

/* === HOVER EFFECTS === */
.input-container:hover .form-input {
    border-color: #ced4da;
    transform: translateY(-1px);
}

.select-container:hover .form-select {
    border-color: #ced4da;
    transform: translateY(-1px);
}

.input-container:hover .input-icon,
.select-container:hover .select-icon {
    color: var(--accent-color);
}
</style>

{{-- JavaScript para efectos adicionales --}}
<script>
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
</script>

@endsection
