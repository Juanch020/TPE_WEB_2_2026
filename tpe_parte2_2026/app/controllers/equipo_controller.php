<?php
require_once __DIR__ . '/../models/equipo_model.php';
require_once __DIR__ . '/../views/equipo_view.php';
require_once __DIR__ . '/../models/jugador_model.php';

class EquipoController{
    private $model; 
    private $view;
    private $jugadorModel;

    public function __construct(){
        $this->model = new EquipoModel();
        $this->view = new EquipoView();
        $this->jugadorModel=new JugadorModel();
    }

    public function showEquipos($request){
        $equipos = $this->model->getAll();
        $this->view->showEquipos($equipos, $request->user);
    }

    public function adminEquipos($request){
        $equipos = $this->model->getAll();
        $this->view->showAdminEquipos($equipos, $request->user);
    }

    public function showEditEquipo($request){
        if (!is_numeric($request->id)) {
            $this->view->showError("ID inválido", 400, $request->user);
            return;
        }

        $equipo = $this->model->getById($request->id);

        if (!$equipo) {
            $this->view->showError("equipo no encontrado", 404, $request->user);
            return;
        }
        $this->view->showEquipoForm($equipo, $request->user);
    }

    public function editEquipo($request){
        if (!is_numeric($request->id)) {
            $this->view->showError("ID inválido", 400, $request->user);
            return;
        }

        $equipo = $this->model->getById($request->id);

        if (!$equipo) {
            $this->view->showError("Equipo no encontrado", 404, $request->user);
            return;
        }

        if(empty($_POST['nombre']) || empty($_POST['descripcion']) || empty($_POST['fecha_creacion'])){
            $equipo = $this->model->getById($request->id);
            $this->view->showEquipoForm($equipo, $request->user, "Complete todos los campos");
            return;    
        }

        $data = [
            'nombre' => $_POST['nombre'],
            'descripcion' => $_POST['descripcion'],
            'fecha_creacion' => $_POST['fecha_creacion'],
            'foto' => $_POST['foto'] ?? null
        ];

        $this->model->update($request->id, $data);
        header("Location: " . BASE_URL . "admin_equipos");
        exit;
    }

    public function showAddEquipo($request){
        $this->view->showEquipoForm(null, $request->user);
    }

    public function addEquipo($request){
        if(empty($_POST['nombre']) || empty($_POST['descripcion']) || empty($_POST['fecha_creacion'])){
            $this->view->showEquipoForm(null, $request->user, "Complete todos los campos");
            return;    
        }

        $data = [
            'nombre' => $_POST['nombre'],
            'descripcion' => $_POST['descripcion'],
            'fecha_creacion' => $_POST['fecha_creacion'],
            'foto' => $_POST['foto'] ?? null
        ];

        $this->model->create($data);
        header("Location: " . BASE_URL . "admin_equipos");
        exit;
    }
    public function deleteEquipo($request){
        if (!is_numeric($request->id)) {
            $this->view->showError("ID inválido", 400, $request->user);
            return;
        }    

        $equipo = $this->model->getById($request->id);

        if (!$equipo) {
            $this->view->showError("equipo no encontrado", 404, $request->user);
            return;
        }

        $jugadores = $this->jugadorModel->getByEquipo($request->id);

        if (!empty($jugadores)) {

            $this->view->showError("No se puede eliminar el equipo porque tiene jugadores asociados", 400, $request->user);
            
            return;
        }

        $this->model->delete($request->id);

        header("Location: " . BASE_URL . "admin_equipos");
        exit;
    }
}

?>