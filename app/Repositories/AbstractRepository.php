<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class AbstractRepository
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function selectAtributosRegistros($atributos)
    {
        $this->model = $this->model->with($atributos);
    }

    public function filtro($filtros)
    {

        $filtros = explode(';', $filtros);

        foreach ($filtros as $key => $condicao) {
            $condicaoPesquisa = explode(':', $condicao);
            $this->model = $this->model->where($condicaoPesquisa[0], $condicaoPesquisa[1], $condicaoPesquisa[2]);
        }
    }

    public function selectAtributosCliente($atributos)
    {
        $this->model = $this->model->selectRaw($atributos);
    }

    public function getResultado()
    {
        return $this->model->get();
    }
}
