<?php
session_start();

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function isAdmin() {
    return isLoggedIn() && $_SESSION['role'] === 'admin';
}

function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: /login.php');
        exit;
    }
}

function requireAdmin() {
    requireLogin();
    if (!isAdmin()) {
        header('Location: /menu.php');
        exit;
    }
}

function loginUser($user) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['name']    = $user['name'];
    $_SESSION['role']    = $user['role'];
}

function logoutUser() {
    session_unset();
    session_destroy();
}
