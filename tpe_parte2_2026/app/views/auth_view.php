<?php

class AuthView {

    public function showLogin($error, $user) {
        require_once './phtml/layouts/header.phtml';
        require_once './phtml/auth/login_form.phtml';
        require_once './phtml/layouts/footer.phtml';
    }
}
?>