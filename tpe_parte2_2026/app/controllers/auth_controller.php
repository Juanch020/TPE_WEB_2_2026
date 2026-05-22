<?php

require_once __DIR__ . '/../models/user_model.php';
require_once __DIR__ . '/../views/auth_view.php';

class AuthController {

    private $model;
    private $view;

    public function __construct() {
        $this->model = new UserModel();
        $this->view = new AuthView();
    }

    public function showLogin($request) {
        $this->view->showLogin(null, $request->user);
    }

    public function doLogin($request) {

        if (empty($_POST['username']) || empty($_POST['password'])
        ) {
            $this->view->showLogin("Faltan datos obligatorios", $request->user);
            return;
        }

        $username = trim($_POST['username']);
        $password = $_POST['password'];

        $userFromDb = $this->model->getByUsername($username);

        if ($userFromDb && password_verify($password, $userFromDb->password)) {
            session_regenerate_id(true);

            $_SESSION['USER_ID'] = $userFromDb->id;
            $_SESSION['USER_NAME'] = $userFromDb->username;

            header("Location: " . BASE_URL . "admin_jugadores");
            exit;

        } else {

            $this->view->showLogin("Usuario o contraseña incorrectos", $request->user);
        }
    }

    public function logout($request) {

        $_SESSION = [];
        session_destroy();

        header("Location: " . BASE_URL . "home");
        exit;
    }
}