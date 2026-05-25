<?php

class EquipoView {

    public function showEquipos($equipos, $user) {
        require_once './phtml/layouts/header.phtml';
        require_once './phtml/equipos/equipo_list.phtml';
        require_once './phtml/layouts/footer.phtml';
    }

    public function showEquipo($equipo, $jugadores, $user) {
        require_once './phtml/layouts/header.phtml';
        require_once './phtml/equipos/equipo_detail.phtml';
        require_once './phtml/layouts/footer.phtml';
    }

    public function showAdminEquipos($equipos, $user) {
        require_once './phtml/layouts/header.phtml';
        require_once './phtml/equipos/admin_equipo_list.phtml';
        require_once './phtml/layouts/footer.phtml';
    }

    public function showEquipoForm($equipo, $user, $error = null) {
        require_once './phtml/layouts/header.phtml';
        require_once './phtml/equipos/equipo_form.phtml';
        require_once './phtml/layouts/footer.phtml';
    }

    public function showError($mensaje, $codigo_error, $user) {
        require_once './phtml/layouts/header.phtml';
        require_once './phtml/layouts/error.phtml';
        require_once './phtml/layouts/footer.phtml';
    }
}
?>