@extends('layouts.app')
@section('title', 'Licencias Usadas')
@section('content')
<div class="container">
    <h1 class="mb-4">Licencias Usadas</h1>

    <a href="{{ route('licencias.index') }}" class="btn btn-secondary mb-3">
        <i class="bi bi-arrow-left"></i> Volver a Licencias Nuevas
    </a>

    @if($licenciasUsadas->isEmpty())
        <div class="alert alert-info">
            No hay licencias usadas registradas.
        </div>
    @else
    <div class="col-12" style="overflow-x: hidden; overflow-y: auto; height: 85vh;">
        <ul class="list-group">
            {{-- Cabecera --}}
            <li class="list-group-item d-flex bg-dark text-light" style="position: sticky; top:0; z-index:800;">
                <div class="row w-100 align-items-center text-center">
                    <div class="col-md-3"><h6>Clave</h6></div>
                    <div class="col-md-2"><h6>Voucher</h6></div>
                    <div class="col-md-2"><h6>Equipo</h6></div>
                    <div class="col-md-1"><h6>Tipo Equipo</h6></div>
                    <div class="col-md-2"><h6>Serial Equipo</h6></div>
                    <div class="col-md-1"><h6>Descripción</h6></div>
                    <div class="col-md-1"><h6>Archivo</h6></div>
                </div>
            </li>

            {{-- Datos --}}
            @foreach($licenciasUsadas as $usada)
            <li class="list-group-item">
                <div class="row w-100 align-items-center text-center">
                    <div class="col-md-3">
                        <small class="fw-bold">{{ $usada->clave_key }}</small>
                    </div>
                    <div class="col-md-2">
                        <small>{{ $usada->licencia->voucher_code ?? '---' }}</small>
                    </div>
                    <div class="col-md-2">
                        <small>{{ $usada->equipo ?? '---' }}</small>
                    </div>
                    <div class="col-md-1">
                        <small>{{ $usada->tipo_equipo ?? '---' }}</small>
                    </div>
                    <div class="col-md-2">
                        <small>{{ $usada->serial_equipo ?? '---' }}</small>
                    </div>
                    <div class="col-md-1">
                        <button 
                            type="button"
                            class="btn btn-outline-primary btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#descripcionModal"
                            data-descripcion="{{ $usada->descripcion ?? '' }}"
                            data-proveedor="{{ optional($usada->licencia->proveedor)->nombreProveedor ?? 'Sin proveedor' }}">
                            <i class="bi bi-info-circle"></i>
                        </button>
                    </div>
                    <div class="col-md-1">
                        {{-- Me quede Aqui para dar descargas a los archivos--}}
                        {{-- Retomando --}}
                        <div class="col-md-1">
                            @if($usada->archivo)
                                <a href="{{ asset('storage/' . $usada->archivo) }}" 
                                class="btn btn-sm btn-primary" 
                                download="{{ basename($usada->archivo) }}">
                                    <i class="bi bi-download"></i>
                                </a>
                            @else
                                <button class="btn btn-sm btn-secondary" disabled>
                                    <i class="bi bi-download"></i>
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </li>
            @endforeach
        </ul>
    </div>
    
    {{-- Paginación --}}
    <div class="d-flex justify-content-end mt-3">
        {{ $licenciasUsadas->links() }}
    </div>
    @endif
</div>

{{-- Modal de Descripción --}}
<div class="modal fade" id="descripcionModal" tabindex="-1" aria-labelledby="descripcionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Descripción de la Licencia Usada</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <p id="descripcionContenido" class="text-muted" style="word-break: break-word; white-space: pre-wrap;"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

{{-- Script para mostrar descripción --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const descripcionModal = document.getElementById('descripcionModal');
        descripcionModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const descripcion = (button.getAttribute('data-descripcion') || '').trim();
            const proveedor = (button.getAttribute('data-proveedor') || 'Sin proveedor').trim();

            const contenido = descripcion
                .replace(/\n/g, '<br>') // cambia saltos de línea por <br>
                .replace(/ {2,}/g, '&nbsp;&nbsp;'); // conserva espacios múltiples

            document.getElementById('descripcionContenido').innerHTML = `
                <div class="mt-2"><strong>Proveedor:</strong> ${proveedor}</div>
                <div><strong>Descripción:</strong><br>${contenido}</div>               
            `;
        });
    });
</script>

@endsection
