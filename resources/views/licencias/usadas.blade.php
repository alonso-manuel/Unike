@extends('layouts.app')
@section('title', 'Licencias Usadas')
@section('content')
<link rel="stylesheet" href="{{ asset('css/licencias/table-licencias.css') }}">
<link rel="stylesheet" href="{{ asset(path: 'css/licencias/licencias-usadas.css') }}">
<div class="licencias-container">
    <div class="used-header">
        <div class="header-content">
            <div class="header-icon">
                <i class="bi bi-check-circle-fill"></i>
            </div>
            <div class="header-info">
                <h4 class="header-title">LICENCIAS USADAS</h4>
                <div class="header-stats">
                    <span class="stat-item">
                        <i class="bi bi-collection"></i>
                        Total: <strong>{{ $licenciasUsadas->total() }}</strong>
                    </span>
                    <span class="stat-separator">|</span>
                </div>
            </div>
        </div>
        <div class="header-actions">
            <a href="{{ route('licencias.index') }}" class="btn-back">
                <i class="bi bi-arrow-left"></i>
                Volver a Inventario
            </a>
        </div>
    </div>

    <div class="search-container">
        <form action="{{ route('licencias.usadas') }}" method="GET" class="search-form">
            <div class="search-input-group">
                <i class="bi bi-search search-icon"></i>
                <input type="text"
                    name="search"
                    class="search-input"
                    placeholder="Buscar por Serial, Clave o Equipo..."
                    value="{{ old('search', $search) }}">
            </div>
            <button type="submit" class="btn-search">
                <i class="bi bi-search"></i>
                Buscar
            </button>
            @if($search)
                <a href="{{ route('licencias.usadas') }}" class="btn-clear">
                    <i class="bi bi-x-circle"></i>
                    Limpiar
                </a>
            @endif
        </form>
    </div>

    @if($licenciasUsadas->isEmpty())
        <div class="empty-state">
            <div class="empty-icon">
                <i class="bi bi-inbox"></i>
            </div>
            <h4 class="empty-title">
                @if($search)
                    No se encontraron resultados
                @else
                    Sin Licencias Usadas
                @endif
            </h4>
            <p class="empty-text">
                @if($search)
                    No hay licencias que coincidan con "{{ $search }}"
                @else
                    No hay licencias usadas registradas en el sistema.
                @endif
            </p>
        </div>
    @else
        <div class="table-wrapper">
            <div class="table-container">
                <table class="table-used">
                    <thead>
                        <tr>
                            <th><i class="bi bi-key"></i> CLAVE DE ACTIVACIÓN</th>
                            <th><i class="bi bi-qr-code"></i> VOUCHER</th>
                            <th><i class="bi bi-pc-display"></i> EQUIPO</th>
                            <th><i class="bi bi-tag"></i> TIPO</th>
                            <th><i class="bi bi-hash"></i> SERIAL EQUIPO</th>
                            <th><i class="bi bi-tools"></i> ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($licenciasUsadas as $usada)
                            <tr>
                                <td>
                                    <span class="key-code">{{ $usada->clave_key }}</span>
                                </td>
                                <td>
                                    @if($usada->licencia && $usada->licencia->voucher_code)
                                        <span class="voucher-text">{{ $usada->licencia->voucher_code }}</span>
                                    @else
                                        <span class="text-muted">---</span>
                                    @endif
                                </td>
                                <td>
                                    @if($usada->equipo)
                                        <span class="equipment-text">{{ $usada->equipo }}</span>
                                    @else
                                        <span class="text-muted">No especificado</span>
                                    @endif
                                </td>
                                <td>
                                    @if($usada->tipo_equipo)
                                        <span class="type-badge">{{ $usada->tipo_equipo }}</span>
                                    @else
                                        <span class="text-muted">---</span>
                                    @endif
                                </td>
                                <td>
                                    @if($usada->serial_equipo)
                                        <span class="serial-text">{{ Str::limit($usada->serial_equipo, 20) }}</span>
                                    @else
                                        <span class="text-muted">---</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="action-btns">
                                        <button
                                            type="button"
                                            class="btn-action btn-info"
                                            data-bs-toggle="modal"
                                            data-bs-target="#descripcionModal"
                                            data-descripcion="{{ $usada->descripcion ?? '' }}"
                                            data-proveedor="{{ optional($usada->licencia->proveedor)->nombreProveedor ?? 'Sin proveedor' }}"
                                            data-clave="{{ $usada->clave_key }}"
                                            data-equipo="{{ $usada->equipo ?? 'No especificado' }}"
                                            title="Ver descripción">
                                            <i class="bi bi-info-circle"></i>
                                        </button>
                                        @if($usada->archivo)
                                            <a href="{{ route('licencia.descargar', $usada->id) }}"
                                            class="btn-action btn-download"
                                            title="Descargar archivo">
                                                <i class="bi bi-download"></i>
                                            </a>
                                        @else
                                            <button class="btn-action btn-disabled" disabled title="Sin archivo">
                                                <i class="bi bi-download"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="pagination-container">
            {{ $licenciasUsadas->appends(['search' => request('search')])->links() }}
        </div>
    @endif
</div>
<x-Licencias.Usadas.modal-descripcion/>
<script src="{{ asset('js/Licencias/licencias-usadas.js') }}"></script>
@endsection
