<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Devolucion extends Model
{
    // Define el nombre de la tabla en la base de datos
    protected $table = 'devolucion';

    // Especifica la clave primaria de la tabla
    protected $primaryKey = 'idDevolucion';

    // Desactiva los timestamps (created_at y updated_at) ya que no están en la tabla
    public $timestamps = false;

    /**
     * Campos que se pueden asignar masivamente (fillable).
     * Estos son los atributos de la tabla que se pueden modificar al crear o actualizar un registro.
     */
    protected $fillable = [
        'idEgreso',       // ID del egreso relacionado con la devolución
        'idRegistro',     // ID del registro del producto asociado a la devolución
        'numero_orden',   // Número de orden de la devolución
        'detalle',        // Detalle o descripción de la devolución
        'fechaInicio',    // Fecha en la que inicia la devolución
        'fechaFin',        // Fecha en la que finaliza la devolución (calculada automáticamente)
        'idUser' // Usuario Responsable
    ];

    /**
     * Relación con la tabla 'RegistroProducto'.
     * Indica que cada devolución pertenece a un único registro de producto.
     */
    public function registro()
    {
        return $this->belongsTo(RegistroProducto::class, 'idRegistro', 'idRegistro');
    }

    /**
     * Relación con la tabla 'Egreso'.
     * Indica que cada devolución está asociada a un egreso de productos.
     */
    public function egreso()
    {
        return $this->belongsTo(EgresoProducto::class, 'idEgreso', 'idEgreso');
    }
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'idUser', 'idUser');
    }
}
