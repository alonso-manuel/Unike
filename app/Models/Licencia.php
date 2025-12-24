<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Licencia extends Model {
    
    protected $table = 'licencias';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    public $timestamps = false;
    protected $casts = [ 
        'id' => 'int',
        'id_tipo' => 'int',
        'id_categoria' => 'int'
    ];
    /**
     * Relación con TipoLicencia
     * Una licencia pertenece a un tipo de licencia.
     */
    public function tipoLicencia()
    {
        return $this->belongsTo(TipoLicencia::class, 'id_tipo');
    }

    /**
     * Relación con Licencias Usadas
     * Una licencia puede tener muchas licencias usadas.
     */
    public function licenciasUsadas()
    {
        return $this->hasMany(LicenciaUsada::class, 'id_licencia');
    }

    /**
     * Relación con Licencias Defectuosas
     * Una licencia puede tener muchas licencias defectuosas.
     */
    public function licenciasDefectuosas()
    {
        return $this->hasMany(LicenciaDefectuosa::class, 'id_licencia');
    }

    /**
     * Relación con Licencias Recuperadas
     * Una licencia puede tener muchas licencias recuperadas.
     */
    public function licenciasRecuperadas()
    {
        return $this->hasMany(LicenciaRecuperada::class, 'id_licencia');
    }
    /**
     * Accessor: nombre legible del estado.
     */
    public function getEstadoTextoAttribute()
    {
        return match($this->estado) {
            'NUEVA' => 'Licencia Nueva',
            'USADA' => 'Licencia Usada',
            'DEFECTUOSA' => 'Licencia Defectuosa',
            'RECUPERADA' => 'Licencia Recuperada',
            default => 'Desconocido',
        };
    }
    public function proveedor()
    {
        return $this->belongsTo(Preveedor::class, 'idProveedor', 'idProveedor');
    }
    public function categoriaLicencia()
    {
        return $this->hasMany(CategoriaLicencia::class, 'id_categoria');
    }

}