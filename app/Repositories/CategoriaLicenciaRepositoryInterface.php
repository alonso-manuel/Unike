<?php

namespace App\Repositories;

interface CategoriaLicenciaRepositoryInterface {

    public function all ();
    public function getOne ($column, $data);
    public function getAllByColumn ($column, $data);
    public function searchOne ($column, $data);
    public function SearchList($column, $data);
    public function create(array $data);
    public function update ($id, array $data);
}