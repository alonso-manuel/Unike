<?php
// app/Models/CategoriaLicencia.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoriaLicencia extends Model
{
    protected $table = 'categoria_licencia';

    protected $guarded = ['id_categoria'];
    
    protected $fillable = ['id_categoria',
                            'tipo_categoria',
                            ];
    protected $hidden = [
        
    ];
    protected $casts = [
        'id_categoria' => 'int'
    ];
    public function CategoriaLicencia() {
        return $this->belongsTo(Licencia::class,'id_categoria', 'id_categoria');        
    }
}