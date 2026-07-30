<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


function isLoggedIn() {
    return isset($_SESSION['user_id']);
}


function isAdmin() {
    return isLoggedIn() && isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}


function requireLogin() {

    if (!isLoggedIn()) {
        header('Location: /digital-menu-system/login.php');
        exit;
    }

}


function requireAdmin() {

    requireLogin();

    if (!isAdmin()) {
        header('Location: /digital-menu-system/menu.php');
        exit;
    }

}


function loginUser($user) {

    session_regenerate_id(true);

    $_SESSION['user_id'] = $user['id'];
    $_SESSION['name']    = $user['name'];
    $_SESSION['role']    = $user['role'];

}


function logoutUser() {

    $_SESSION = [];

    if (ini_get("session.use_cookies")) {

        $params = session_get_cookie_params();

        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );

    }

    session_destroy();

}

?>