<?php

class PosicionView {

    public function showPosiciones($posiciones, $user) {
        require_once './phtml/layouts/header.phtml';
        require_once './phtml/posiciones/posicion_list.phtml';
        require_once './phtml/layouts/footer.phtml';
    }

    public function showPosicion($posicion, $user) {
        require_once './phtml/layouts/header.phtml';
        require_once './phtml/posiciones/posicion_detail.phtml';
        require_once './phtml/layouts/footer.phtml';
    }

    public function showAdminPosiciones($posiciones, $user) {
        require_once './phtml/layouts/header.phtml';
        require_once './phtml/posiciones/admin_list_posicion.phtml';
        require_once './phtml/layouts/footer.phtml';
    }

    public function showPosicionForm($posicion, $user, $error = null) {
        require_once './phtml/layouts/header.phtml';
        require_once './phtml/posiciones/posicion_form.phtml';
        require_once './phtml/layouts/footer.phtml';
    }

    public function showError($mensaje, $codigo_error, $user) {
        require_once './phtml/layouts/header.phtml';
        require_once './phtml/layouts/error.phtml';
        require_once './phtml/layouts/footer.phtml';
    }
}
?>