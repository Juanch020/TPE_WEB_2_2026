<?php

const MYSQL_USER = 'root';
const MYSQL_PASS = '';
const MYSQL_DB = 'equipo_de_futbol';
const MYSQL_HOST = '127.0.0.1';

define(
    'BASE_URL',
    '//' .
    $_SERVER['SERVER_NAME'] .
    ':' .
    $_SERVER['SERVER_PORT'] .
    dirname($_SERVER['PHP_SELF']) .
    '/'
);
?>