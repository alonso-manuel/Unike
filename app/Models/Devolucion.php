<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Devolucion extends Model
{
    protected $table = 'devolucion';
    protected $primaryKey = 'id_devolucion';
    public $timestamps = false;
    protected $fillable = [
        'id_reclamo',
        'id_detalle_devolucion',
        'id_garantia',
        'fecha_inicio',
        'fecha_fin',
        'estado_devolucion'
    ];
    public function reclamoDevoluciones(){
        return $this->belongsTo(reclamoDevoluciones::class, 'id_reclamo', 'id_reclamo');
    }
    public function detalleDevolucion(){
        return $this->belongsTo(detalleDevolucion::class, 'id_detalle_devolucion', 'id_detalle_devolucion');
    }
    public function Garantia(){
        return $this->belongsTo(Garantia::class, 'id_garantia', 'id_garantia');
    }
    public function Devolucion (){
        return $this->hasMany(Devolucion::class, 'id_devolucion', 'id_devolucion');
    }
}
