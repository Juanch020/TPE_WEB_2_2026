<?php

require_once __DIR__ . '/../models/posicion_model.php';
require_once __DIR__ . '/../views/posicion_view.php';
require_once __DIR__ . '/../models/jugador_model.php';

class PosicionController {

    private $model;
    private $view;
    private $jugadorModel;

    public function __construct() {
        $this->model = new PosicionModel();
        $this->view = new PosicionView();
        $this->jugadorModel = new JugadorModel();
    }

    public function showPosiciones($request) {
        $posiciones = $this->model->getAll();

        $this->view->showPosiciones($posiciones, $request->user);
    }

    public function adminPosiciones($request) {
        $posiciones = $this->model->getAll();

        $this->view->showAdminPosiciones($posiciones, $request->user);
    }

    public function showAddPosicion($request) {

        $this->view->showPosicionForm(null, $request->user);
    }

    public function addPosicion($request) {
        if (empty($_POST['nombre'])) {
            $this->view->showError("Complete el nombre de la posición", 400, $request->user);
            
            return;
        }

        $nombre = $_POST['nombre'];

        $this->model->create($nombre);

        header("Location: " . BASE_URL . "admin_posiciones");
        exit;
    }

    public function showPosicion($request) {

        $id = $request->id;

        $posicion = $this->model->getById($id);

        if (!$posicion) {
            $this->view->showError("Equipo no encontrado", 404, $request->user);
            return;
        }

        $jugadores = $this->jugadorModel->getByPosicion($id);

        $this->view->showPosicion($posicion, $jugadores, $request->user);
    }
    public function showEditPosicion($request) {
        if (!is_numeric($request->id)) {

            $this->view->showError("ID inválido", 400, $request->user);
            return;
        }

        $posicion = $this->model->getById($request->id);

        if (!$posicion) {

            $this->view->showError("Posición no encontrada", 404, $request->user);
            return;
        }

        $this->view->showPosicionForm($posicion, $request->user);
    }

    public function editPosicion($request) {
        if (!is_numeric($request->id)) {

            $this->view->showError("ID inválido", 400, $request->user);
            return;
        }

        $posicion = $this->model->getById($request->id);

        if (!$posicion) {

            $this->view->showError("Posición no encontrada", 404, $request->user);
            return;
        }

        if (empty($_POST['nombre'])) {

            $this->view->showError("Complete el nombre de la posición", 400, $request->user);
            return;
        }

        $nombre = $_POST['nombre'];

        $this->model->update($request->id, $nombre);

        header("Location: " . BASE_URL . "admin_posiciones");
        exit;
    }

    public function deletePosicion($request) {
        if (!is_numeric($request->id)) {

            $this->view->showError("ID inválido", 400, $request->user);
            return;
        }

        $posicion = $this->model->getById($request->id);

        if (!$posicion) {

            $this->view->showError("Posición no encontrada", 404, $request->user);
            return;
        }

        $jugadores = $this->jugadorModel->getByPosicion($request->id);

        if (!empty($jugadores)) {

            $this->view->showError("No se puede eliminar la posición porque tiene jugadores asociados", 400, $request->user);

            return;
        }

        $this->model->delete($request->id);

        header("Location: " . BASE_URL . "admin_posiciones");
        exit;
    }
}
?>