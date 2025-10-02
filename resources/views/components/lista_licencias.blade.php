{{-- resources/views/licencias/partials/listado.blade.php --}}
<div class="lista_licencias">    @if(!$licencias->isEmpty())    
    <div class="row">        
        <div class="col-12">            
            <ul class="list-group">                
            {{-- Cabecera --}}                
            <li class="list-group-item bg-sistema-uno text-light">                    
                <div class="row text-center fw-bold">                        
                    <div class="col-3 text-start">Voucher Code</div>                        
                    <div class="col-2">Orden Compra</div>                        
                    <div class="col-1">Tipo</div>
                    <div class="col-2">Proveedor</div>                        
                    <div class="col-2">Estado</div>                        
                    <div class="col-2">Acciones</div>                    
                </div>                
            </li>                
            {{-- Filas --}}                
            @foreach ($licencias as $licencia)                    
            <li class="list-group-item">                        
                <div class="row text-center align-items-center">
                    <div class="col-3 text-start">                                
                        <small class="fw-bold">{{ $licencia->voucher_code }}</small>                            
                    </div>                            
                    <div class="col-2">                                
                        <small>{{ $licencia->orden_compra }}</small>                            
                    </div>                            
                    <div class="col-1">
                        <small>{{ $licencia->tipoLicencia->nombre }}</small>                            
                    </div>
                    <div class="col-2">
                        <small>
                            {{ optional($licencia->proveedor)->nombreProveedor ?? 'Sin proveedor' }} - 
                            {{ optional($licencia->proveedor)->razSocialProveedor ?? '' }}
                        </small>
                    </div>                           
                    <div class="col-2">                                
                        <span class="badge bg-success">{{ $licencia->estado }}</span>                            
                    </div>                            
                    <div class="col-2 d-flex gap-1 justify-content-center">                                
                        <a href="javascript:void(0);" 
                            onclick="abrirModalUsarLicencia(
                            '{{ route('licencias.cambiar_estado', $licencia->voucher_code) }}')" 
                            class="btn btn-outline-info btn-sm"> 
                            Usar
                        </a>                                
                        <a href="javascript:void(0);"                                    
                            onclick="abrirModalLicenciaDefectuosa(                                            
                                '{{ route('licencias.cambiar_estado', $licencia->voucher_code) }}',
                                '{{ $licencia->orden_compra }}',
                                '{{ optional($licencia->proveedor)->idProveedor ?? '' }}',
                                '{{ optional($licencia->proveedor)->razSocialProveedor ?? '' }}'
                            )"
                            class="btn btn-outline-danger btn-sm">
                            Marcar Defectuosa
                        </a>                   
                        </div>                        
                    </div>                      
                </li>                
                @endforeach            
            </ul>        
        </div>    
    </div>    
    <br>    
    @else    
        <div class="row align-items-center" style="height:50vh">        
            <x-aviso_no_encontrado :mensaje="'No se encontraron licencias.'" />    
        </div>    
    @endif    
    <x-paginacion :justify="'end'" :coleccion="$licencias" :container="$container"/>
</div>