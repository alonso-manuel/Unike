<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class detalleDevolucion extends Model
{
    protected $table = 'detalle_devolucion';
    protected $primarykey = 'id_detalle_devolucion';
    public $timestamps = false;
    protected $fillable = [
        'idUser',
        'idPLtaforma',
        'idCuentaPlataforma',
        'idRegistro',
        'idCliente',
        'motivo_real',
        'enlace_pruebas'
    ];
    public function usuario (){
        return $this->belongsTo(Usuario::class, 'idUser', 'idUser');
    }
    public function plataforma (){
        return $this->belongsTo(Plataforma::class, 'idPlataforma', 'idPlataforma');
    }
    public function cuentaPlataforma (){
        return $this->belongsTo(CuentasPlataforma::class, 'idCuentaPlataforma', 'idCuentaPlatforma');
    }
    public function registro (){
        return $this->belongsTo(RegistroProducto::class, 'idRegistro', 'idRegistro');
    }
    public function cliente (){
        return $this->belongsTo(Cliente::class, 'idCliente', 'idCliente');
    }
    public function Devolucion(){
      return $this->belongsTo(Devolucion::class, 'id_devolucion', 'id_devolucion');
    }
   
}
