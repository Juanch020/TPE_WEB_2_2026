<?php
require_once __DIR__ . '/../models/jugador_model.php';
require_once __DIR__ . '/../views/jugador_view.php';
require_once __DIR__ . '/../models/equipo_model.php';
require_once __DIR__ . '/../models/posicion_model.php';

class JugadorController {

    private $model;
    private $view;
    private $equipoModel;
    private $posicionModel;

    public function __construct() {
        $this->model = new JugadorModel();
        $this->view = new JugadorView();
        $this->equipoModel = new EquipoModel();
        $this->posicionModel = new PosicionModel();
    }

    public function showJugadores($request) {
        $jugadores = $this->model->getAll();

        $this->view->showJugadores($jugadores, $request->user);
    }

    public function showJugador($request) {
        $jugador = $this->model->getById($request->id);

        if (!$jugador) {
            $this->view->showError("Jugador no encontrado", 404, $request->user);
            return;
        }

        $this->view->showJugador($jugador, $request->user);
    }

    public function showJugadoresByEquipo($request) {
        $id_equipo = $request->id;

        if (!is_numeric($id_equipo)) {
            $this->view->showError("ID de equipo inválido", 400, $request->user);
            return;
        }

        $equipo = $this->equipoModel->getById($id_equipo);

        if (!$equipo) {
            $this->view->showError("Equipo no encontrado", 404, $request->user);
            return;
        }

        $jugadores = $this->model->getByEquipo($id_equipo);

        $this->view->showJugadoresByEquipo($equipo, $jugadores, $request->user);
    }

    public function showJugadoresByPosicion($request) {
        $id_posicion = $request->id;

        if (!is_numeric($id_posicion)) {
            $this->view->showError("ID de posición inválido", 400, $request->user);
            return;
        }

        $posicion = $this->posicionModel->getById($id_posicion);

        if (!$posicion) {
            $this->view->showError("Posición no encontrada", 404, $request->user);
            return;
        }

        $jugadores = $this->model->getByPosicion($id_posicion);

        $this->view->showJugadoresByPosicion($posicion, $jugadores, $request->user);
    }

    public function adminJugadores($request) {
        $jugadores = $this->model->getAll();

        $this->view->showAdminJugadores($jugadores, $request->user);
    }

    public function showAddJugador($request) {
        $equipos = $this->equipoModel->getAll();
        $posiciones = $this->posicionModel->getAll();

        $this->view->showJugadorForm(null, $equipos, $posiciones, $request->user);
    }

    public function addJugador($request) {

        if (empty($_POST['nombre']) || empty($_POST['precio']) || empty($_POST['id_equipo']) || empty($_POST['id_posicion'])) {

            $this->view->showError("Complete todos los campos", 400, $request->user);
            return;
        }

        if (!is_numeric($_POST['precio']) || $_POST['precio'] <= 0 || !is_numeric($_POST['id_equipo']) || !is_numeric($_POST['id_posicion'])
        ) {

            $this->view->showError("Datos numéricos inválidos", 400, $request->user);
            return;
        }

        $equipo = $this->equipoModel->getById($_POST['id_equipo']);
        $posicion = $this->posicionModel->getById($_POST['id_posicion']);

        if (!$equipo || !$posicion) {

            $this->view->showError("Equipo o posición inválidos", 400, $request->user);
            return;
        }

        $data = [
            'nombre' => $_POST['nombre'],
            'precio' => $_POST['precio'],
            'id_equipo' => $_POST['id_equipo'],
            'id_posicion' => $_POST['id_posicion'],
            'foto' => !empty($_POST['foto']) ? $_POST['foto'] : null
        ];

        $this->model->create($data);

        header("Location: " . BASE_URL . "admin_jugadores");
        exit;
    }

    public function deleteJugador($request) {

        if (!is_numeric($request->id)) {
            $this->view->showError("ID inválido", 400, $request->user);
            return;
        }

        $jugador = $this->model->getById($request->id);

        if (!$jugador) {
            $this->view->showError("Jugador no encontrado", 404, $request->user);
            return;
        }

        $this->model->delete($request->id);

        header("Location: " . BASE_URL . "admin_jugadores");
        exit;
    }

    public function showEditJugador($request) {

        if (!is_numeric($request->id)) {
            $this->view->showError("ID inválido", 400, $request->user);
            return;
        }

        $jugador = $this->model->getById($request->id);

        if (!$jugador) {
            $this->view->showError("Jugador no encontrado", 404, $request->user);
            return;
        }

        $equipos = $this->equipoModel->getAll();
        $posiciones = $this->posicionModel->getAll();

        $this->view->showJugadorForm($jugador, $equipos, $posiciones, $request->user);
    }

    public function editJugador($request) {

        if (!is_numeric($request->id)) {
            $this->view->showError("ID inválido", 400, $request->user);
            return;
        }

        $jugador = $this->model->getById($request->id);

        if (!$jugador) {
            $this->view->showError("Jugador no encontrado", 404, $request->user);
            return;
        }

        if (empty($_POST['nombre']) || empty($_POST['precio']) || empty($_POST['id_equipo']) || empty($_POST['id_posicion'])
        ) {

            $this->view->showError("Complete todos los campos", 400, $request->user);
            return;
        }

        if (!is_numeric($_POST['precio']) || $_POST['precio'] <= 0 || !is_numeric($_POST['id_equipo']) || !is_numeric($_POST['id_posicion'])
        ) {

            $this->view->showError("Datos numéricos inválidos", 400, $request->user);
            return;
        }

        $equipo = $this->equipoModel->getById($_POST['id_equipo']);
        $posicion = $this->posicionModel->getById($_POST['id_posicion']);

        if (!$equipo || !$posicion) {

            $this->view->showError("Equipo o posición inválidos", 400, $request->user);
            return;
        }

        $data = [
            'nombre' => $_POST['nombre'],
            'precio' => $_POST['precio'],
            'id_equipo' => $_POST['id_equipo'],
            'id_posicion' => $_POST['id_posicion'],
            'foto' => !empty($_POST['foto']) ? $_POST['foto'] : null
        ];

        $this->model->update($request->id, $data);

        header("Location: " . BASE_URL . "admin_jugadores");
        exit;
    }
}
?>