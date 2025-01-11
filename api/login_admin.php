<?php
header("Content-Type: application/json");
require_once '../config/database.php';
require_once '../models/Admin.php';
require_once '../vendor/autoload.php'; // JWT library

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$database = new Database();
$conn = $database->getConnection();

$admin = new Admin($conn);

$input = json_decode(file_get_contents("php://input"), true);

if (!isset($input['email'], $input['password'])) {
    echo json_encode([
        "status" => "error",
        "message" => "Email dan password diperlukan"
    ]);
    exit;
}

$admin->email = $input['email'];
$admin->password = $input['password'];

if ($adminData = $admin->login()) {
    // Tambahkan pengecekan untuk key "id"
    $adminId = isset($adminData['id']) ? $adminData['id'] : null;

    // Buat token JWT
    $key = "your_secret_key"; // Ganti dengan kunci rahasia Anda
    $payload = [
        "iss" => "http://localhost", // Issuer
        "iat" => time(), // Issued at
        "exp" => time() + (60 * 60), // Expiry (1 jam)
        "data" => [
            "id" => $adminId,
            "email" => $adminData['email']
        ]
    ];

    $jwt = JWT::encode($payload, $key, 'HS256');

    echo json_encode([
        "status" => "success",
        "message" => "Login berhasil",
        "token" => $jwt
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Email atau password salah"
    ]);
}

$conn->close();
?>
