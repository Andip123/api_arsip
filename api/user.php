<?php
header("Content-Type: application/json");
require_once '../config/database.php';
require_once '../models/User.php';
require_once '../vendor/autoload.php'; // Tambahkan autoload JWT
require_once '../middleware/jwt_middleware.php'; // Import middleware JWT

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$database = new Database();
$conn = $database->getConnection();

$user = new User($conn);

$method = $_SERVER['REQUEST_METHOD'];

// Kunci rahasia untuk JWT
$key = "your_secret_key";

switch ($method) {
    case 'POST': // Login User
        $input = json_decode(file_get_contents('php://input'), true);

        if (!isset($input['email'], $input['password'])) {
            http_response_code(400); // Bad Request
            echo json_encode([
                "status" => "error",
                "message" => "Email dan password diperlukan"
            ]);
            exit;
        }

        $user->email = $input['email'];
        $user->password = $input['password'];

        $isAuthenticated = $user->login();

        if ($isAuthenticated) {
            $userId = isset($isAuthenticated['id']) ? $isAuthenticated['id'] : null;

            // Buat payload JWT dengan data user
            $payload = [
                "iss" => "http://localhost", // Server issuer
                "iat" => time(), // Waktu token dibuat
                "exp" => time() + (60 * 60), // Kedaluwarsa dalam 1 jam
                "data" => [
                    "id" => $userId, // Tambahkan ID pengguna
                    "email" => $isAuthenticated['email'], // Email pengguna
                    "role" => $isAuthenticated['role'] // Role pengguna
                ]
            ];

            $jwt = JWT::encode($payload, $key, 'HS256'); // Generate token

            http_response_code(200); // OK
            echo json_encode([
                "id" => $userId,
                "status" => "success",
                "message" => "Login berhasil",
                "token" => $jwt
            ]);
        } else {
            http_response_code(404); // Not Found
            echo json_encode([
                "status" => "error",
                "message" => "Email atau password salah"
            ]);
        }
        break;

    case 'GET': // Validasi Token
        try {
            // Gunakan middleware untuk validasi token JWT
            $decodedData = validateJWT($key); // Memanggil fungsi dari jwt_middleware.php

            http_response_code(200); // OK
            echo json_encode([
                "status" => "success",
                "message" => "Token valid",
                "data" => $decodedData // Sertakan data dari token
            ]);
        } catch (Exception $e) {
            http_response_code(401); // Unauthorized
            echo json_encode([
                "status" => "error",
                "message" => "Token tidak valid",
                "error" => $e->getMessage()
            ]);
        }
        break;

    default:
        http_response_code(405); // Method Not Allowed
        echo json_encode([
            "status" => "error",
            "message" => "Metode tidak didukung"
        ]);
        break;
}

$conn->close();
?>
