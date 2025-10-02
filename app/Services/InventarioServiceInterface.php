<?php
namespace App\Services;

interface InventarioServiceInterface
{
    
    public function addStock($idProducto,$idAlmacen);
}