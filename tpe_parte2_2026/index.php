<?php
require_once __DIR__ . '/config.php';

require_once __DIR__ . '/app/controllers/jugador_controller.php';
require_once __DIR__ . '/app/controllers/equipo_controller.php';
require_once __DIR__ . '/app/controllers/posicion_controller.php';
require_once __DIR__ . '/app/controllers/auth_controller.php';

require_once __DIR__ . '/app/middlewares/session_middleware.php';
require_once __DIR__ . '/app/middlewares/guard_middleware.php';

session_start();

$action = 'home';

if (!empty($_GET['action'])) {
    $action = $_GET['action'];
}

$params = explode('/', $action);

$request = new stdClass();

$request = (new SessionMiddleware())->run($request);

switch ($params[0]) {

    /*
    Público
    */

    case 'home':

        $controller = new JugadorController();
        $controller->showJugadores($request);

    break;

    case 'jugadores':

        $controller = new JugadorController();
        $controller->showJugadores($request);

    break;

    case 'jugador':

        if (!isset($params[1]) || !is_numeric($params[1])
        ) {
            http_response_code(400);
            echo "ID de jugador inválido";
            break;
        }

        $controller = new JugadorController();

        $request->id = (int) $params[1];

        $controller->showJugador($request);

    break;

    case 'equipos':

        $controller = new EquipoController();
        $controller->showEquipos($request);

    break;

    case 'equipo':

        if (!isset($params[1]) || !is_numeric($params[1])
        ) {
            http_response_code(400);
            echo "ID de equipo inválido";
            break;
        }

        $controller = new JugadorController();

        $request->id = (int) $params[1];

        $controller->showJugadoresByEquipo($request);

    break;

    case 'posiciones':

        $controller = new PosicionController();
        $controller->showPosiciones($request);

    break;

    case 'posicion':

        if (
            !isset($params[1]) ||
            !is_numeric($params[1])
        ) {
            http_response_code(400);
            echo "ID de posición inválido";
            break;
        }

        $controller = new JugadorController();

        $request->id = (int) $params[1];

        $controller->showJugadoresByPosicion($request);

    break;

    /*
    Auth
    */

    case 'login':

        $controller = new AuthController();
        $controller->showLogin($request);

    break;

    case 'do_login':

        $controller = new AuthController();
        $controller->doLogin($request);

    break;

    case 'logout':

        $request = (new GuardMiddleware())->run($request);

        $controller = new AuthController();
        $controller->logout($request);

    break;

    /*
    Admin Jugadores
    */

    case 'admin_jugadores':

        $request = (new GuardMiddleware())->run($request);

        $controller = new JugadorController();
        $controller->adminJugadores($request);

    break;

    case 'admin_jugador_add':

        $request = (new GuardMiddleware())->run($request);

        $controller = new JugadorController();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $controller->addJugador($request);

        } else {

            $controller->showAddJugador($request);
        }

    break;

    case 'admin_jugador_edit':

        $request = (new GuardMiddleware())->run($request);

        if (
            !isset($params[1]) ||
            !is_numeric($params[1])
        ) {
            http_response_code(400);
            echo "ID de jugador inválido";
            break;
        }

        $controller = new JugadorController();

        $request->id = (int) $params[1];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $controller->editJugador($request);

        } else {

            $controller->showEditJugador($request);
        }

    break;

    case 'admin_jugador_delete':

        $request = (new GuardMiddleware())->run($request);

        if (
            !isset($params[1]) ||
            !is_numeric($params[1])
        ) {
            http_response_code(400);
            echo "ID de jugador inválido";
            break;
        }

        $controller = new JugadorController();

        $request->id = (int) $params[1];

        $controller->deleteJugador($request);

    break;

    /*
    Admin Equipos
    */

    case 'admin_equipos':

        $request = (new GuardMiddleware())->run($request);

        $controller = new EquipoController();
        $controller->adminEquipos($request);

    break;

    case 'admin_equipo_add':

        $request = (new GuardMiddleware())->run($request);

        $controller = new EquipoController();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $controller->addEquipo($request);

        } else {

            $controller->showAddEquipo($request);
        }

    break;

    case 'admin_equipo_edit':

        $request = (new GuardMiddleware())->run($request);

        if (!isset($params[1]) || !is_numeric($params[1])
        ) {
            http_response_code(400);
            echo "ID de equipo inválido";
            break;
        }

        $controller = new EquipoController();

        $request->id = (int) $params[1];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $controller->editEquipo($request);

        } else {

            $controller->showEditEquipo($request);
        }

    break;

    case 'admin_equipo_delete':

        $request = (new GuardMiddleware())->run($request);

        if (!isset($params[1]) || !is_numeric($params[1])
        ) {
            http_response_code(400);
            echo "ID de equipo inválido";
            break;
        }

        $controller = new EquipoController();

        $request->id = (int) $params[1];

        $controller->deleteEquipo($request);

    break;

    /*
    Admin Posiciones
    */

    case 'admin_posiciones':

        $request = (new GuardMiddleware())->run($request);

        $controller = new PosicionController();
        $controller->adminPosiciones($request);

    break;

    case 'admin_posicion_add':

        $request = (new GuardMiddleware())->run($request);

        $controller = new PosicionController();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $controller->addPosicion($request);

        } else {

            $controller->showAddPosicion($request);
        }

    break;

    case 'admin_posicion_edit':

        $request = (new GuardMiddleware())->run($request);

        if (!isset($params[1]) || !is_numeric($params[1])
        ) {
            http_response_code(400);
            echo "ID de posición inválido";
            break;
        }

        $controller = new PosicionController();

        $request->id = (int) $params[1];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $controller->editPosicion($request);

        } else {

            $controller->showEditPosicion($request);
        }

    break;

    case 'admin_posicion_delete':

        $request = (new GuardMiddleware())->run($request);

        if (
            !isset($params[1]) ||
            !is_numeric($params[1])
        ) {
            http_response_code(400);
            echo "ID de posición inválido";
            break;
        }

        $controller = new PosicionController();

        $request->id = (int) $params[1];

        $controller->deletePosicion($request);

    break;

    /*
    404
    */

    default:

        http_response_code(404);

        echo "404 - Página no encontrada";

    break;
}
?>