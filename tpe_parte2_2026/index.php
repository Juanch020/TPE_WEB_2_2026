<?php
require_once __DIR__ . '/config.php';

require_once __DIR__ . '/app/controllers/jugador_controller.php';
require_once __DIR__ . '/app/controllers/equipo_controller.php';
require_once __DIR__ . '/app/controllers/posicion_controller.php';
require_once __DIR__ . '/app/controllers/auth_controller.php';

require_once __DIR__ . '/app/views/jugador_view.php';

require_once __DIR__ . '/app/middlewares/session_middleware.php';
require_once __DIR__ . '/app/middlewares/guard_middleware.php';

session_start();

/*
| Helpers
*/

function showRouterError($mensaje, $codigo, $request) {

    http_response_code($codigo);

    $view = new JugadorView();
    $view->showError($mensaje, $codigo, $request);

    exit;
}

function requireId($params, $request, $mensaje = 'ID inválido') {

    if (
        !isset($params[1]) ||
        !is_numeric($params[1])
    ) {
        showRouterError($mensaje, 400, $request);
    }

    return (int) $params[1];
}

function requireAuth($request) {
    return (new GuardMiddleware())->run($request);
}

/*
| Request
*/

$action = 'home';

if (!empty($_GET['action'])) {
    $action = $_GET['action'];
}

$params = explode('/', $action);

$request = new stdClass();

$request = (new SessionMiddleware())->run($request);

/*
| Router
*/

switch ($params[0]) {

    /*
    | Público
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

        $controller = new JugadorController();

        $request->id = requireId($params,$request,"ID de jugador inválido");

        $controller->showJugador($request);

    break;

    case 'equipos':

        $controller = new EquipoController();
        $controller->showEquipos($request);

    break;

    case 'equipo':

        $controller = new EquipoController();
        
        $request->id = requireId( $params, $request, "ID de equipo inválido");
        
        $controller->showEquipo($request);

    break;

    case 'posiciones':

        $controller = new PosicionController();
        $controller->showPosiciones($request);

    break;

    case 'posicion':

        $controller = new JugadorController();

        $request->id = requireId($params, $request, "ID de posición inválido");

        $controller->showJugadoresByPosicion($request);

    break;

    /*
    | Auth
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

        $request = requireAuth($request);

        $controller = new AuthController();
        $controller->logout($request);

    break;

    /*
    | Admin Jugadores
    */

    case 'admin_jugadores':

        $request = requireAuth($request);

        $controller = new JugadorController();
        $controller->adminJugadores($request);

    break;

    case 'admin_jugador_add':

        $request = requireAuth($request);

        $controller = new JugadorController();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $controller->addJugador($request);

        } else {

            $controller->showAddJugador($request);
        }

    break;

    case 'admin_jugador_edit':

        $request = requireAuth($request);

        $controller = new JugadorController();

        $request->id = requireId($params, $request, "ID de jugador inválido");

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $controller->editJugador($request);

        } else {

            $controller->showEditJugador($request);
        }

    break;

    case 'admin_jugador_delete':

        $request = requireAuth($request);

        $controller = new JugadorController();

        $request->id = requireId($params, $request, "ID de jugador inválido");

        $controller->deleteJugador($request);

    break;

    /*
    | Admin Equipos
    */

    case 'admin_equipos':

        $request = requireAuth($request);

        $controller = new EquipoController();
        $controller->adminEquipos($request);

    break;

    case 'admin_equipo_add':

        $request = requireAuth($request);

        $controller = new EquipoController();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $controller->addEquipo($request);

        } else {

            $controller->showAddEquipo($request);
        }

    break;

    case 'admin_equipo_edit':

        $request = requireAuth($request);

        $controller = new EquipoController();

        $request->id = requireId($params, $request, "ID de equipo inválido");

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $controller->editEquipo($request);

        } else {

            $controller->showEditEquipo($request);
        }

    break;

    case 'admin_equipo_delete':

        $request = requireAuth($request);

        $controller = new EquipoController();

        $request->id = requireId($params, $request, "ID de equipo inválido");

        $controller->deleteEquipo($request);

    break;

    /*
    | Admin Posiciones
    */

    case 'admin_posiciones':

        $request = requireAuth($request);

        $controller = new PosicionController();
        $controller->adminPosiciones($request);

    break;

    case 'admin_posicion_add':

        $request = requireAuth($request);

        $controller = new PosicionController();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $controller->addPosicion($request);

        } else {

            $controller->showAddPosicion($request);
        }

    break;

    case 'admin_posicion_edit':

        $request = requireAuth($request);

        $controller = new PosicionController();

        $request->id = requireId($params, $request, "ID de posición inválido");

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $controller->editPosicion($request);

        } else {

            $controller->showEditPosicion($request);
        }

    break;

    case 'admin_posicion_delete':

        $request = requireAuth($request);

        $controller = new PosicionController();

        $request->id = requireId(
            $params,
            $request,
            "ID de posición inválido"
        );

        $controller->deletePosicion($request);

    break;

    /*
    | 404
    */

    default:

        showRouterError("404 - Página no encontrada", 404, $request);

    break;
}
?>