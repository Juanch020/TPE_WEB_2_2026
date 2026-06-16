<?php

class DatabaseModel {

    protected $db;

    public function __construct() {

        try {

            $this->db = new PDO('mysql:host=localhost;dbname=equipo_de_futbol;charset=utf8', 'root', '', [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
            ]);
        
        } catch (PDOException $e) {

            die('Error de conexión: ' . $e->getMessage());
        }
    }
}