@props(['marcas' => [], 'estados' => [], 'almacenes' => []])

<form action="{{ request()->url() }}" method="get" id="form-filtro-componente">
    @foreach(request()->except('filtro') as $key => $value)
        @if(is_array($value))
            @foreach($value as $k => $v)
                <input type="hidden" name="{{ $key }}[{{ $k }}]" value="{{ $v }}">
            @endforeach
        @else
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endif
    @endforeach
    <div class="row mb-2 mt-3">
        <div class="col-4 col-lg-2">
            <small>Marca</small>
            <select class="form-select form-select-sm filtro-componente" name="filtro[marca]">
                <option value="">Todos</option>
                @foreach ($marcas as $marca)
                <option value="{{ data_get($marca, 'idMarca') ?? data_get($marca, 'id') ?? '' }}">
                    {{ data_get($marca, 'MarcaProducto.nombreMarca') ?? data_get($marca, 'nombreMarca') ?? data_get($marca, 'nombre') ?? '' }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="col-4 col-lg-2">
            <small>Estado</small>
            <select class="form-select form-select-sm filtro-componente" name="filtro[estado]">
                <option value="">Todos</option>
                @foreach ($estados as $estado)
                <option value="{{ data_get($estado, 'estadoProductoWeb') ?? data_get($estado, 'id') ?? '' }}">
                    {{ data_get($estado, 'estadoProductoWeb') ?? data_get($estado, 'nombre') ?? '' }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="col-4 col-lg-2">
            <small>Almacén</small>
            <select class="form-select form-select-sm filtro-componente" name="filtro[almacen]">
                <option value="">Todos</option>
                @foreach ($almacenes as $almacen)
                <option value="{{ $almacen->idAlmacen }}">
                    {{ $almacen->descripcion }}
                </option>
                @endforeach
            </select>
        </div>
    </div>
</form>