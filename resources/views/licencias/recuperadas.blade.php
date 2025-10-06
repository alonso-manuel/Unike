@extends('layouts.app')
@section('title', 'Licencias Recuperadas')
@section('content')
<div class="container">
    <h1 class="mb-4">Licencias Recuperadas</h1>

    <a href="{{ route('licencias.index') }}" class="btn btn-secondary mb-3">
        <i class="bi bi-arrow-left"></i> Volver a Licencias Nuevas
    </a>

    @if($licenciasRecuperadas->isEmpty())
        <div class="alert alert-info">
            No hay licencias recuperadas registradas.
        </div>
    @else
    <div class="col-12" style="overflow-x: hidden; overflow-y: auto; height: 85vh;">
        <ul class="list-group">
            {{-- Cabecera --}}
            <li class="list-group-item d-flex bg-dark text-light" style="position: sticky; top:0; z-index:800;">
                <div class="row w-100 align-items-center text-center">
                    <div class="col-md-2"><h6>Serial Recuperada</h6></div>
                    <div class="col-md-2"><h6>Serial Defectuosa</h6></div>
                    <div class="col-md-2"><h6>Voucher</h6></div>
                    <div class="col-md-1"><h6>Orden Compra</h6></div>
                    <div class="col-md-1"><h6>Estado</h6></div>
                    <div class="col-md-2"><h6>Proveedor</h6></div>
                    <div class="col-md-2"><h6>Acciones</h6></div>
                </div>
            </li>

            {{-- Datos --}}
            @foreach($licenciasRecuperadas as $recuperada)
            <li class="list-group-item">
                <div class="row w-100 align-items-center text-center">
                    <div class="col-md-2">
                        <small class="fw-bold">{{ $recuperada->serial_recuperada }}</small>
                    </div>
                    <div class="col-md-2">
                        <small>{{ $recuperada->serial_defectuosa }}</small>
                    </div>
                    <div class="col-md-2">
                        <small>{{ $recuperada->licencia->voucher_code ?? '---' }}</small>
                    </div>
                    <div class="col-md-1">
                        <small>{{ $recuperada->orden ?? '---' }}</small>
                    </div>
                    <div class="col-md-1">
                        <span class="badge bg-warning">{{ $recuperada->estado }}</span>
                    </div>
                    {{-- El cambio del proveedor fue un caso ;-; --}}
                    {{-- Proveedores --}}
                    <div class="col-md-2">
                        <Small>{{$recuperada->licencia->proveedor->razSocialProveedor ?? '---'}}</Small>
                    </div>
                    <div class="col-md-2 d-flex gap-1 justify-content-center">
                        {{--Marcar Usada --}}
                        <a href="javascript:void(0);"
                            onclick="abrirModalUsarLicenciaDesdeRecuperadas(
                                '{{ route('licencias.cambiar_estado', $recuperada->licencia->voucher_code) }}',
                                '{{ $recuperada->orden }}',
                                '{{ $recuperada->serial_recuperada }}',
                                '{{ $recuperada->id }}'
                            )"
                            class="btn btn-outline-info btn-sm">
                            Usar
                        </a>
                        {{-- Marcar Defectuosa --}}
                        <a href="javascript:void(0);" 
                          onclick="abrirModalLicenciaDefectuosa(
                            '{{ route('licencias.cambiar_estado', $recuperada->licencia->voucher_code) }}',
                            '{{ $recuperada->orden }}',
                            '{{ $recuperada->serial_recuperada }}',
                            '{{ $recuperada->licencia->proveedor?->idProveedor ?? '' }}', // ID
                            '{{ $recuperada->licencia->proveedor?->razSocialProveedor ?? '---' }}', // Nombre
                            '{{ $recuperada->id }}'
                          )"
                          class="btn btn-outline-danger btn-sm">
                          Defectuosa
                        </a>

                    </div>
                </div>
            </li>
            @endforeach
        </ul>
    </div>

    {{-- Paginación --}}
    <div class="d-flex justify-content-end mt-3">
        {{ $licenciasRecuperadas->links() }}
    </div>
    @endif
</div>

  {{-- Modal Usar Licencia desde Recuperadas --}}
  <div class="modal fade" id="modalUsarLicencia" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <form id="formUsarLicencia" method="POST" enctype="multipart/form-data" class="mx-auto" style="max-width:500px;">
        @csrf

       <input type="hidden" name="idRecuperada" id="inputIdRecuperadaUsada">

        <input type="hidden" name="nuevo_estado" value="USADA">
        <input type="hidden" name="serial_recuperada" id="inputSerialRecuperada">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Marcar Licencia como Usada</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
          </div>
          <div class="modal-body container">
              <div class="row">
                  <div class="mb-3 text-start col">
                      <label class="form-label">Orden de Compra</label>
                      <input type="text" name="orden" class="form-control form-control-sm" readonly>
                  </div>
                  <div class="mb-3 text-start col">
                      <label class="form-label">Clave de Activación (Serial Recuperada)</label>
                      <input type="text" name="clave_key" class="form-control form-control-sm" readonly>
                  </div>
              </div>
              <div class="row">
                  <div class="mb-3 text-start col">
                      <label class="form-label">Equipo</label>
                      <input type="text" name="equipo" class="form-control form-control-sm">
                  </div>
                  <div class="mb-3 text-start col">
                      <label class="form-label">Tipo de Equipo</label>
                      <input type="text" name="tipo_equipo" class="form-control form-control-sm">
                  </div>
              </div>
            <div class="mb-3 text-start">
              <label class="form-label">Serial del Equipo</label>
              <input type="text" name="serial_equipo" class="form-control form-control-sm">
            </div>
            <div class="mb-3 text-start">
              <label class="form-label">Descripción</label>
              <textarea name="descripcion" class="form-control form-control-sm" rows="2"></textarea>
            </div>
            <!-- Archivo de recuperacion -->
            <div>
              <label class="form-label fw-smibold text-dark">
                <i class="bi bi-file-earmark-arrow-up me-1 text-primary"></i>
                Archivo de licencia (opcional)
              </label>
              <input type="file"
                name="archivo"
                id="archivo"
                class="form-control"
                accept=".rcf,.txt,.pdf">
                <div class="form-text"> Solo archivos pequeños (ej. .rcf)</div>
            </div>
          </div>
          <div class="modal-footer d-flex justify-content-between">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
              <i class="bi bi-x-lg"></i> Cancelar
            </button>
            <button type="submit" class="btn btn-success">
              <i class="bi bi-save"></i> Guardar
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>


{{-- Modal Licencias Defectuosas --}}
<div class="modal fade" id="modalLicenciaDefectuosa" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <form id="formLicenciaDefectuosa" method="POST" class="mx-auto" style="max-width: 500px;">
      @csrf
      <input type="hidden" name="idRecuperada" id="inputIdRecuperadaDefectuosa">
      
      <input type="hidden" name="nuevo_estado" value="DEFECTUOSA">
      <input type="hidden" name="serial_recuperada" id="inputSerialRecuperada">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Marcar Licencia como Defectuosa</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>

        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Clave de Activación</label>
            <input type="text" name="clave_key" class="form-control form-control-sm" readonly required>
          </div>

          <div class="mb-3">
            <label class="form-label">Orden Compra</label>
            <input type="text" name="orden" class="form-control" readonly>
          </div>

          <div class="mb-3">
            <label class="form-label">Número de Ticket</label>
            <input type="text" name="numero_ticket" class="form-control">
          </div>

          <div class="mb-3">
            <label for="proveedor" class="form-label">Proveedor</label>
            <input type="text" name="proveedor" class="form-control" readonly>
        </div>
        </div>
        
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-warning">Marcar como Defectuosa</button>
        </div>
      </div>
    </form>
  </div>
</div>
{{-- Fin Modal Licencias Defectuosas --}}

{{-- Scrip Modal Licencias Usadas --}}
<script>
function abrirModalUsarLicenciaDesdeRecuperadas(actionUrl, orden, serialRecuperada, idRecuperada ) {
    const form = document.getElementById('formUsarLicencia');
    form.reset();
    form.action = actionUrl;
    document.getElementById('inputIdRecuperadaUsada').value = idRecuperada ?? '';

    form.querySelector('input[name="orden"]').value = orden || '';
    form.querySelector('input[name="clave_key"]').value = serialRecuperada || '';
    form.querySelector('input[name="serial_recuperada"]').value = serialRecuperada ?? '';


    const modal = new bootstrap.Modal(document.getElementById('modalUsarLicencia'));
    modal.show();
}
</script>

{{-- Scrip Modal Licencias Defectuosas --}}
<script>
function abrirModalLicenciaDefectuosa(actionUrl, orden, serialRecuperada, idProveedor, proveedor, idRecuperada) {
    const form = document.getElementById('formLicenciaDefectuosa');
    form.reset();
    form.action = actionUrl;

    document.getElementById('inputIdRecuperadaDefectuosa').value = idRecuperada ?? '';
    
    form.querySelector('input[name="orden"]').value = orden ?? '';
    form.querySelector('input[name="clave_key"]').value = serialRecuperada ?? '';
    form.querySelector('input[name="serial_recuperada"]').value = serialRecuperada ?? '';
    form.querySelector('input[name="proveedor"]').value = proveedor ?? '---';

    // asegúrate de tener este input hidden en el form
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
}
</script>

@endsection
