<?php
namespace App\Services;

use App\Repositories\InventarioRepositoryInterface;

class InventarioService implements InventarioServiceInterface
{
    protected $inventarioRepository;

    public function __construct(InventarioRepositoryInterface $inventarioRepository)
    {
        $this->inventarioRepository = $inventarioRepository;
    }
    
    public function addStock($idProducto,$idAlmacen){
        $this->inventarioRepository->addStock($idProducto,$idAlmacen);
    }
}