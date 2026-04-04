<?php
session_start();

/* Prevent browser cache */
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");

/* Helper function to send JSON */
function apiResponse($success, $message, $data = null) {
    header("Content-Type: application/json");
    echo json_encode([
        "success" => $success,
        "message" => $message,
        "data" => $data
    ]);
    exit;
}

/* Require login */
function requireLogin($isApi = false) {
    if (!isset($_SESSION['user_id'])) {
        if ($isApi) {
            apiResponse(false, "Not logged in");
        } else {
            header("Location: /Capturra/public/login.html");
            exit();
        }
    }
}

/* Require role */
function requireRole($role, $isApi = false) {
    requireLogin($isApi);

    if (!isset($_SESSION['role']) || $_SESSION['role'] !== $role) {
        if ($isApi) {
            apiResponse(false, "Access denied");
        } else {
            header("Location: /Capturra/public/login.html");
            exit();
        }
    }
}
