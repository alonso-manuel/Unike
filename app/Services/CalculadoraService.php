<?php
namespace App\Services;

use App\Models\Calculadora;
use App\Repositories\CalculadoraRepositoryInterface;
use App\Repositories\PlataformaRepositoryInterface;
use App\Repositories\CategoriaProductoRepositoryInterface;
use App\Repositories\ComisionRepositoryInterface;
use Illuminate\Support\Facades\DB;

class CalculadoraService implements CalculadoraServiceInterface
{
    protected $calcRepository;
    protected $plataformaRepository;
    protected $categoriaRepository;
    protected $comisionRepository;

    public function __construct(CalculadoraRepositoryInterface $calcRepository,
                                PlataformaRepositoryInterface $plataformaRepository,
                                CategoriaProductoRepositoryInterface $categoriaRepository,
                                ComisionRepositoryInterface $comisionRepository)
    {
        $this->calcRepository = $calcRepository;
        $this->plataformaRepository = $plataformaRepository;
        $this->categoriaRepository = $categoriaRepository;
        $this->comisionRepository = $comisionRepository;
    }
    //Get al primer registro con el api de la sunat para el cambio del dolar
    public function get(){
        return $this->calcRepository->get();
    }
    //Get al registro con el id(2) con una tasa de cambio fija(editable) 
    public function getTasaFija(){
        return $this->calcRepository->findById();
    }
    public function allComision(){
        return $this ->comisionRepository->all();
    }
    public function getTasaCambio(){
        $tc = $this->calcRepository->get()->value('tasaCambio');
        return $tc;
    }
    public function getIgv(){
        $igv = $this->calcRepository->get()->value('igv');
        return ($igv / 100) +1;
    }
    public function getComisionByRelation($table){
        return $this->plataformaRepository->getByRelation($table);
    }
    public function getAllLabelCategory(){
        $categoriaModel = $this->categoriaRepository->all();
        $categoria = $categoriaModel->map(function ($cat) {
        return [
                    'idCategoria' => $cat->idCategoria,
                    'nombreCategoria' => $cat->nombreCategoria,
                    'GrupoProducto' => $cat->GrupoProducto
                ];
            });
        return $categoria;
    }

}
