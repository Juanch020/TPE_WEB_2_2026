<?php
require_once __DIR__ . '/database_model.php';

 class UserModel extends DatabaseModel{
    public function __construct() {
        parent::__construct();
    }

    public function getByUsername($username){
        $query = $this->db->prepare("SELECT * FROM usuario WHERE username = ?");
        $query->execute([$username]);
        return $query->fetch();
    }
 }
?>