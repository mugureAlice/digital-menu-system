<?php

function sanitize($str) {
    return htmlspecialchars(trim($str), ENT_QUOTES, 'UTF-8');
}


function redirect($path) {
    header("Location: $path");
    exit;
}


function handleImageUpload($fileField) {

    if (!isset($_FILES[$fileField]) || $_FILES[$fileField]['error'] !== UPLOAD_ERR_OK) {
        return null;
    }


    $allowed = ['jpg', 'jpeg', 'png', 'webp'];

    $ext = strtolower(pathinfo($_FILES[$fileField]['name'], PATHINFO_EXTENSION));


    if (!in_array($ext, $allowed)) {
        return null;
    }


    $newName = uniqid('menu_', true) . '.' . $ext;


    $destination = __DIR__ . '/../uploads/' . $newName;


    if (move_uploaded_file($_FILES[$fileField]['tmp_name'], $destination)) {
        return $newName;
    }


    return null;
}

?>