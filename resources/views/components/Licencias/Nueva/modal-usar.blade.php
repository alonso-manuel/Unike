<div class="modal fade" id="modalUsarLicencia" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <form id="formUsarLicencia" method="POST" enctype="multipart/form-data" class="mx-auto">
        @csrf
        <input type="hidden" name="nuevo_estado" value="USADA">

        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-sistema-uno text-white border-0 position-relative overflow-hidden">
                <div class="d-flex align-items-center">
                    <div class="header-icon-container me-3">
                    <i class="bi bi-key-fill fs-3"></i>
                    </div>
                    <div>
                    <h5 class="modal-title mb-0 fw-bold">Usar Licencia</h5>
                    <small class="opacity-75">Registrar nueva licencia en el sistema</small>
                    </div>
                </div>
                <button type="button"
                        class="btn-close btn-close-white"
                        onclick="cerrarModal()"
                        aria-label="Cerrar">
                </button>
                <div class="position-absolute top-0 end-0 opacity-10">
                    <i class="bi bi-shield-check" style="font-size: 6rem; transform: translate(1.5rem, -1.5rem);"></i>
                </div>
            </div>

            <div class="modal-body p-4">
                <div class="row g-3 mb-4">
                    <div class="col-md-7">
                        <label class="form-label fw-semibold text-dark">
                            <i class="bi bi-key text-primary me-2"></i>
                            Clave de Activación
                            <span class="text-danger">*</span>
                        </label>
                        <div class="input-group input-group-modern">
                            <span class="input-group-text bg-light border-end-0">
                            <i class="bi bi-shield-lock text-primary"></i>
                            </span>
                            <input type="text"
                                name="clave_key"
                                id="clave_key"
                                class="form-control border-start-0 font-monospace"
                                placeholder="Ingrese la clave de activación">
                            <button type="button"
                                    class="btn btn-outline-info"
                                    id="btnVerificarClave"
                                    title="Verificar si la clave ya existe">
                            <i class="bi bi-search" id="iconVerificar"></i>
                            <span class="spinner-border spinner-border-sm d-none" id="spinnerVerificar"></span>
                            </button>
                        </div>
                        <div class="invalid-feedback" id="clave-error" style="display: none;">
                            <i class="bi bi-exclamation-circle me-1"></i>
                            <span id="clave-error-text">La clave de activación es obligatoria</span>
                        </div>
                        <div class="valid-feedback" id="clave-success" style="display: none;">
                            <i class="bi bi-check-circle me-1"></i>
                            Clave disponible para usar
                        </div>
                    </div>
                    <div class="col-md-5">
                        <label class="form-label fw-semibold text-dark">
                            <i class="bi bi-receipt text-success me-2"></i>
                            Orden de Compra
                        </label>
                        <div class="input-group input-group-modern">
                            <span class="input-group-text bg-light border-end-0">
                            <i class="bi bi-file-text text-success"></i>
                            </span>
                            <input type="text"
                                name="orden"
                                id="orden"
                                class="form-control border-start-0"
                                placeholder="Ej: 421852"
                                readonly>
                        </div>
                    </div>
                </div>
                <div class="equipment-section">
                    <div class="section-header mb-3">
                        <h6 class="section-title mb-0">
                            <i class="bi bi-pc-display text-info me-2"></i>
                            Información del Equipo
                        </h6>
                        <div class="section-line"></div>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark">
                            <i class="bi bi-laptop me-1 text-info"></i>
                            Equipo
                            </label>
                            <div class="input-group input-group-modern">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="bi bi-pc text-info"></i>
                            </span>
                            <input type="text"
                                    name="equipo"
                                    id="equipo"
                                    class="form-control border-start-0"
                                    placeholder="Nombre del equipo">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark">
                            <i class="bi bi-tags me-1 text-info"></i>
                            Tipo de Equipo
                            </label>
                            <div class="input-group input-group-modern">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="bi bi-collection text-info"></i>
                            </span>
                            <input type="text"
                                    name="tipo_equipo"
                                    id="tipo_equipo"
                                    class="form-control border-start-0"
                                    placeholder="Tipo de equipo">
                            </div>
                        </div>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold text-dark">
                            <i class="bi bi-upc-scan me-1 text-warning"></i>
                            Serial del Equipo
                            </label>
                            <div class="input-group input-group-modern">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="bi bi-hash text-warning"></i>
                            </span>
                            <input type="text"
                                    name="serial_equipo"
                                    id="serial_equipo"
                                    class="form-control border-start-0 font-monospace"
                                    placeholder="Serial único del equipo">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="description-section">
                    <div class="section-header mb-3">
                        <h6 class="section-title mb-0">
                            <i class="bi bi-card-text text-secondary me-2"></i>
                            Información Adicional
                        </h6>
                        <div class="section-line"></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark">
                            <i class="bi bi-chat-text me-1 text-secondary"></i>
                            Descripción
                        </label>
                        <div class="textarea-container">
                            <textarea name="descripcion"
                                    id="descripcion"
                                    class="form-control modern-textarea"
                                    rows="3"
                                    placeholder="Información adicional sobre el equipo, ubicación, usuario asignado, etc."></textarea>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">
                    <i class="bi bi-file-earmark-arrow-up me-1 text-primary"></i>
                    Archivo de licencia (opcional)
                    </label>
                    <input type="file"
                        name="archivo"
                        id="archivo"
                        class="form-control"
                        accept=".rcf,.txt,.pdf">
                    <div class="form-text">Solo archivos pequeños (ej. .rcf)</div>
                </div>
                <div class="alert alert-info-modern border-0 mt-4" role="alert">
                    <div class="d-flex align-items-center">
                        <div class="alert-icon me-3">
                            <i class="bi bi-info-circle-fill"></i>
                        </div>
                        <div class="alert-content">
                            <strong>Información:</strong> Esta licencia será marcada como "USADA" y quedará registrada permanentemente en el sistema.
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer bg-light-subtle border-0 p-4">
            <div class="d-flex justify-content-between w-100">
                <button type="button"
                        class="btn btn-outline-secondary btn-modern px-4"
                        data-bs-dismiss="modal">
                <i class="bi bi-x-lg me-2"></i>
                Cancelar
                </button>
                <button type="submit"
                        class="btn btn-success btn-modern px-4"
                        id="btnGuardar">
                <span class="spinner-border spinner-border-sm me-2 d-none" id="loadingSpinner"></span>
                <i class="bi bi-save me-2" id="saveIcon"></i>
                <span id="btnText">Guardar Licencia</span>
                </button>
            </div>
            </div>
        </div>
        </form>
    </div>
</div>
