<?php
require_once __DIR__ . '/../models/jugador_model.php';

class JugadorApiController{
    private $model;

    public function __construct(){
        $this->model=new JugadorModel();
    }

    public function getJugadores($req, $res){
        $sort = $req->query->sort ?? null;
        $order = $req->query->order ?? null;

        $page = max(1, (int)($req->query->page ?? 1));
        $limit = max(1, min(100, (int)($req->query->limit ?? 10)));

        $filterField = $req->query->filterField ?? null;
        $filterValue = $req->query->filterValue ?? null;

        $allowedSorts = [
            'id',
            'nombre',
            'precio',
            'id_equipo',
            'id_posicion'
        ];

        $allowedFilters = [
            'id_equipo',
            'id_posicion',
            'nombre'
        ];

        if ($sort && !in_array($sort, $allowedSorts)) {
            return $res->json(['error' => 'Campo de ordenamiento inválido'], 400);
        }

        if (!in_array($order, ['ASC', 'DESC'])) {
            return $res->json([
                'error' => 'Orden inválido'
            ], 400);
        }

        if ($filterField && !in_array($filterField, $allowedFilters)) {
            return $res->json([
                'error' => 'Campo de filtro inválido'
            ], 400);
        }

        $offset = ($page - 1) * $limit;

        $jugadores = $this->model->getAll($sort, $order, $limit, $offset, $filterField, $filterValue);
        $total = $this->model->count($filterField, $filterValue);
        $totalPages = ceil($total/$limit);

        $result = [
            'data' => $jugadores,
            'pagination' => [
                'page' => (int)$page,
                'limit' => (int)$limit,
                'total' => (int)$total,
                'totalPages' => $totalPages,
                'hasNext' => $page < $totalPages,
                'hasPrev' => $page > 1
            ]
        ];

        if($filterField && $filterValue){
            $response['filter'] = [
                'field' => $filterField,
                'value' => $filterValue
            ];
        }

        return $res->json($result, 200);
    }

    public function getJugador($req, $res){
        $id_jugador = $req->params->id;
        $jugador = $this->model->getById($id_jugador);

        if(!$jugador){
            return $res->json("el jugador no existe", 404);
        }

        return $res->json($jugador);
    }

    public function update($req, $res){
        $id_jugador = $req->params->id;
        $jugador = $this->model->getById($id_jugador);

        if(!$jugador){
            $res->json("el jugador no existe", 404);
        }
        
        if(empty($req->body->nombre) || empty($req->body->precio) || empty($req->body->id_equipo) || empty($req->body->id_posicion)){
            return $res->json('faltan datos', 400);
        }

        if (!is_numeric($req->body->precio)) {
            return $res->json(['error' => 'El precio debe ser numérico'], 400);
        }

        $data =[
            $nombre = $req->body->nombre;
            $precio = $req->body->precio;
            $id_equipo = $req->body->id_equipo;
            $id_posicion = $req->body->id_posicion;
            $foto = $req->body->foto;
        ];
        
        $this->model->update($nombre, $data);

        $updated_jugador = $this->model->getById($id_jugador);

        return $res->json($updated_jugador);
    }

    public function delete($req, $res){
        $id_jugador = $req->params->id;

        if (!is_numeric($id_jugador)) {
            return $res->json(['error' => 'ID inválido'], 400);
        }

        $jugador = $this->model->getById($id_jugador);

        if(!$jugador){
            return $res->json("el jugador no existe", 404);
        }

        $this->model->delete($id_jugador);
        return $res->json(null, 204);
    }
}

?>