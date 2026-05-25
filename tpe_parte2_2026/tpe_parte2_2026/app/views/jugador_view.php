<?php

class JugadorView {

    public function showJugadores($jugadores, $user) {
        require_once './phtml/layouts/header.phtml';
        require_once './phtml/jugadores/jugador_list.phtml';
        require_once './phtml/layouts/footer.phtml';
    }

    public function showJugador($jugador, $user) {
        require_once './phtml/layouts/header.phtml';
        require_once './phtml/jugadores/jugador_detail.phtml';
        require_once './phtml/layouts/footer.phtml';
    }
    
    public function showAdminJugadores($jugadores, $user) {
        require_once './phtml/layouts/header.phtml';
        require_once './phtml/jugadores/admin_jugador_list.phtml';
        require_once './phtml/layouts/footer.phtml';
    }

    public function showJugadorForm($jugador, $equipos, $posiciones, $user, $error = null) {
        require_once './phtml/layouts/header.phtml';
        require_once './phtml/jugadores/jugador_form.phtml';
        require_once './phtml/layouts/footer.phtml';
    }

    public function showError($mensaje, $codigo_error, $user) {
        require_once './phtml/layouts/header.phtml';
        require_once './phtml/layouts/error.phtml';
        require_once './phtml/layouts/footer.phtml';
    }

    public function showJugadoresByEquipo($equipo, $jugadores, $user) {
    require_once './phtml/layouts/header.phtml';
    require_once './phtml/equipos/equipo_detail.phtml';
    require_once './phtml/layouts/footer.phtml';
    }

    public function showJugadoresByPosicion($posicion, $jugadores, $user) {
        require_once './phtml/layouts/header.phtml';
        require_once './phtml/posiciones/posicion_detail.phtml';
        require_once './phtml/layouts/footer.phtml';
    }
}
?>