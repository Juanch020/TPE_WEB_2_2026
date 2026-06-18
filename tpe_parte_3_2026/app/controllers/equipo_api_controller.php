<?php
require_once __DIR__ . '/../models/equipo_model.php';

class EquipoApiController{
    private $model;

    public function __construct(){
        $this->model = new EquipoModel();
    }

    public function getAll($response){
        $equipos = $this->model->getAll();
        $response->json($equipos);
    }

    public function getEquipos($request, $response){
        $id = $request->params->id;
        $equipo = $this->model->getById($id);

        if (!is_numeric($id)) {
            return $response->json(['error' => 'ID inválido'], 400);
        }

        if($equipo){
            return $response->json($equipo, 200);
        }else{
            $response->json(['error' =>'equipo no encontrado'], 404);
        }
    }
}
?>