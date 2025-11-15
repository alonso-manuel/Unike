<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class reclamoDevoluciones extends Model
{
    protected $table = 'reclamo_devoluciones';
    protected $primaryKey = 'id_reclamo';
    public $timestamps = false;
    protected $fillable = [
        'idUser',
        'idPlataforma',
        'idCuentaPlataforma',
        'idRegistro',
        'idCliente',
        'fecha_inicio',
        'fecha_limite',
        'numero_orden',
        'motivo_reclamo',
        'estado_reclamo'
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
