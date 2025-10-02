<?php
namespace App\Repositories;


interface LicenciaRepositoryInterface
{
    public function getByEstado(string $estado);
    public function allNuevas();
    public function crear(array $data);
    public function storeFromExcel(array $rows);
    public function cambiarEstado(string $serial, string $nuevoEstado, array $datosAdicionales);
    public function findBySerial(string $serial);
    public function getNuevasQuery();
}
