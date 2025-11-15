<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class casoDevolucion extends Model
{
    protected $table = 'caso_devolucion';
    protected $primaryKey = 'id_caso_devolucion';
    public $timestamps = false;
    protected $fillable = [
        'id_devolucion',
        'numero_caso',
        'tipo_caso',
        'detalle_caso'
    ];
    public function Devolucion (){
        return $this->belongsTo(Devolucion::class, 'id_devolucion', 'id_devolucion');
    }

}
