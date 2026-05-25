<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

function verifyUser() {
    if (!isset($_SESSION['USER_ID'])) {
        header('Location: index.php?action=login');
        exit();
    }
    return true;
}
?>