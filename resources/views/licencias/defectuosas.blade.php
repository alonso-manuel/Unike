@extends('layouts.app')
@section('title', 'Licencias Defectuosas')
@section('content')
<div class="container">
    <h1 class="mb-4">Licencias Defectuosas</h1>

    <a href="{{ route('licencias.index') }}" class="btn btn-secondary mb-3">
        <i class="bi bi-arrow-left"></i> Volver a Licencias Nuevas
    </a>

    @if($licenciasDefectuosas->isEmpty())
        <div class="alert alert-info">
            No hay licencias Defectuosas registradas.
        </div>
    @else
    <div class="col-12" style="overflow-x: hidden; overflow-y: auto; height: 85vh;">
        <ul class="list-group">
            {{-- Cabecera --}}
            <li class="list-group-item d-flex bg-dark text-light" style="position: sticky; top:0; z-index:800;">
                <div class="row w-100 align-items-center text-center">
                    <div class="col-md-3"><h6>Clave</h6></div>
                    <div class="col-md-2"><h6>Voucher</h6></div>
                    <div class="col-md-1"><h6>Orden</h6></div>
                    <div class="col-md-1"><h6>N - Ticket</h6></div>
                    <div class="col-md-2">Proveedor</div>
                    <div class="col-md-2"><h6>Estado</h6></div>
                    <div class="col-md-1"><h6>Acciones</h6></div>
                </div>
            </li>

            {{-- Datos --}}
            @foreach($licenciasDefectuosas as $defectuosa)
            <li class="list-group-item">
                <div class="row w-100 align-items-center text-center">
                    <div class="col-md-3">
                        <small class="fw-bold">{{ $defectuosa->clave_key }}</small>
                    </div>
                    <div class="col-md-2">
                        <small>{{ $defectuosa->licencia->voucher_code ?? '---' }}</small>
                    </div>
                    <div class="col-md-1">
                        <small>{{ $defectuosa->orden ?? '---' }}</small>
                    </div>
                    
                    <div class="col-md-1">
                        <small>{{ $defectuosa->numero_ticket ?? '---' }}</small>
                    </div>
                    <div class="col-md-2">
                        <small>{{ $defectuosa->proveedor->nombreProveedor ?? '---' }}</small>
                    </div>
                    <div class="col-2">
                        <span class="badge bg-danger">{{ $defectuosa->estado }}</span>
                    </div>
                    <div class="col-1 d-flex gap-1 justify-content-center">
                        <a href="javascript:void(0);" 
                            onclick="abrirModalLicenciaRecuperada(
                                '{{ route('licencias.cambiar_estado', $defectuosa->licencia->voucher_code) }}',
                                '{{ $defectuosa->orden }}',
                                '{{ $defectuosa->clave_key }}',
                                '{{ $defectuosa->numero_ticket }}',
                                '{{ optional($defectuosa->proveedor)->idProveedor}}',
                                '{{ optional($defectuosa->proveedor)->nombreProveedor}}'                               
                            )"
                            class="btn btn-outline-warning btn-sm">
                            Recuperar
                        </a>
                    </div>
                </div>
            </li>
            @endforeach
        </ul>
    </div>
    
    {{-- Paginación --}}
    <div class="d-flex justify-content-end mt-3">
        {{ $licenciasDefectuosas->links() }}
    </div>
    @endif
</div>


{{-- Modal Licencias Recuperadas --}}
<div class="modal fade" id="modalLicenciaRecuperada" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <form id="formLicenciaRecuperada" method="POST" class="mx-auto" style="max-width: 500px;">
      @csrf
      <input type="hidden" name="nuevo_estado" value="RECUPERADA">
      <input type="hidden" name="idProveedor">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Marcar Licencia como Recuperada</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
         <div class="modal-body container">
          <div class="mb-3 text-start">
            <label class="form-label">Orden de Compra</label>
            <input type="text" name="orden" class="form-control form-control-sm" readonly>
          </div>
          <div class="mb-3 text-start">
            <label class="form-label">Serial Defectuosa</label>
            <input type="text" name="serial_defectuosa" class="form-control form-control-sm" readonly>
          </div>
          <div class="mb-3 text-start">
            <label class="form-label">Número de Ticket</label>
            <input type="text" name="numero_ticket" class="form-control form-control-sm" readonly>
          </div>
          <div class="mb-3 text-start">
            <label class="form-label">Serial Recuperada <span class="text-danger">*</span></label>
            <input type="text" name="serial_recuperada" class="form-control form-control-sm">
          </div>
          <div>
            <label class="form-label">Proveedor</label>
            <input type="text" name="razonSocialProveedor" class="form-control fotm-control-sm" readonly>
          </div>
          <div class="mb-3 text-start">
            <label class="form-label">Estado</label>
            <input type="text" class="form-control form-control-sm" value="RECUPERADA" readonly>
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
{{-- Fin Modal Licencias Recuperadas --}}
<script>
function abrirModalLicenciaRecuperada(actionUrl, orden, serialDefectuosa, numeroTicket, idProveedor, razonSocialProveedor) {
    const form = document.getElementById('formLicenciaRecuperada');
    form.reset();
    form.action = actionUrl;

    // Llenar valores visibles
    form.querySelector('input[name="orden"]').value = orden;
    form.querySelector('input[name="serial_defectuosa"]').value = serialDefectuosa;
    form.querySelector('input[name="numero_ticket"]').value = numeroTicket;
    form.querySelector('input[name="razonSocialProveedor"]').value = razonSocialProveedor ?? '';

    // Llenar ID oculto
    form.querySelector('input[name="idProveedor"]').value = idProveedor ?? '';

    // Abrir modal
    const modal = new bootstrap.Modal(document.getElementById('modalLicenciaRecuperada'));
    modal.show();
}
</script>

<script>
document.getElementById('formLicenciaRecuperada').addEventListener('submit', function(e) {
    const serialRecuperada = this.querySelector('input[name="serial_recuperada"]').value.trim();

    if (serialRecuperada === '') {
        e.preventDefault(); // Evita el envío del formulario

        Swal.fire({
            icon: 'error',
            title: 'Campo requerido',
            text: 'Debes ingresar el Serial Recuperada.',
        });
    }
});
</script>

@endsection
