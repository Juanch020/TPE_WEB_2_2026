<?php

require_once __DIR__ . '/../../config.php';

class DatabaseModel {

    protected $db;

    public function __construct() {

        try {
            
            $this->db = new PDO(
                "mysql:host=" . MYSQL_HOST . ";charset=utf8mb4",
                MYSQL_USER,
                MYSQL_PASS,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                ]
            );

            $this->deploy();

            $this->db = new PDO(
                "mysql:host=" . MYSQL_HOST .
                ";dbname=" . MYSQL_DB .
                ";charset=utf8mb4",

                MYSQL_USER,
                MYSQL_PASS,

                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                ]
            );

        } catch (PDOException $e) {

            die("Error de base de datos: " . $e->getMessage());
        }
    }

    private function deploy() {
        $this->db->exec(
            "CREATE DATABASE IF NOT EXISTS " . MYSQL_DB . "
            CHARACTER SET utf8mb4
            COLLATE utf8mb4_unicode_ci"
        );
        $this->db->exec("USE " . MYSQL_DB);
        $query = $this->db->query(
            "SHOW TABLES LIKE 'usuario'"
        );

        $tableExists = $query->fetchColumn();

        if (!$tableExists) {

            $sql = file_get_contents(
                __DIR__ . '/../../equipo_de_futbol.sql'
            );

            $this->db->exec($sql);
        }
    }
}