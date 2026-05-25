<?php

const MYSQL_USER = 'root';
const MYSQL_PASS = '';
const MYSQL_DB = 'equipo_de_futbol';
const MYSQL_HOST = '127.0.0.1';

/*
| BASE_URL
*/

define(
    'BASE_URL',
    '//' .
    $_SERVER['SERVER_NAME'] .
    (
        ($_SERVER['SERVER_PORT'] != 80)
            ? ':' . $_SERVER['SERVER_PORT']
            : ''
    ) .
    rtrim(dirname($_SERVER['PHP_SELF']), '/\\') .
    '/'
);

/*
| AUTO DEPLOY DATABASE
*/

try {

    /*
    Conexión inicial sin seleccionar base de datos
    */

    $pdo = new PDO(
        "mysql:host=" . MYSQL_HOST . ";charset=utf8mb4",
        MYSQL_USER,
        MYSQL_PASS,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]
    );

    /*
    Crea la base de datos si no existe
    */

    $pdo->exec(
        "CREATE DATABASE IF NOT EXISTS `" . MYSQL_DB . "`
        CHARACTER SET utf8mb4
        COLLATE utf8mb4_general_ci"
    );

    /*
    Selecciona la base
    */

    $pdo->exec("USE `" . MYSQL_DB . "`");

    /*
    Verificar si ya existen tablas
    */

    $result = $pdo->query("SHOW TABLES LIKE 'usuario'");

    /*
    Si no existe la tabla usuario, importa el SQL inicial
    */

    if ($result->rowCount() == 0) {

        $sql = file_get_contents(
            __DIR__ . '/equipo_de_futbol.sql'
        );

        $pdo->exec($sql);
    }

} catch (PDOException $e) {

    die(
        "Error de base de datos: " .
        $e->getMessage()
    );
}
?>