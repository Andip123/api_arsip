<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

function validateJWT($key) {
    $headers = getallheaders();

    // Pastikan header Authorization ada
    if (!isset($headers['Authorization'])) {
        http_response_code(401); // Unauthorized
        echo json_encode([
            "status" => "error",
            "message" => "Token tidak ditemukan"
        ]);
        exit;
    }

    // Ambil token dari header Authorization
    $authHeader = $headers['Authorization'];
    $jwt = str_replace('Bearer ', '', $authHeader); // Hapus "Bearer " dari header

    try {
        // Verifikasi token
        $decoded = JWT::decode($jwt, new Key($key, 'HS256'));
        return $decoded->data; // Return data dari token jika valid
    } catch (Exception $e) {
        http_response_code(401); // Unauthorized
        echo json_encode([
            "status" => "error",
            "message" => "Token tidak valid",
            "error" => $e->getMessage()
        ]);
        exit;
    }
}
