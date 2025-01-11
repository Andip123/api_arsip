<?php
header("Content-Type: application/json");
require_once '../config/database.php';
require_once '../models/User.php';
require_once '../vendor/autoload.php'; // Tambahkan autoload JWT

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$database = new Database();
$conn = $database->getConnection();

$user = new User($conn);

$method = $_SERVER['REQUEST_METHOD'];

// Kunci rahasia untuk JWT
$key = "your_secret_key";

switch ($method) {
    case 'POST':
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
            // Tambahkan pengecekan untuk key "id"
            $userId = isset($isAuthenticated['id']) ? $isAuthenticated['id'] : null;

            // Jika login berhasil, buat JWT token
            $payload = [
                "iss" => "http://localhost", // Server issuer
                "iat" => time(), // Waktu token dibuat
                "exp" => time() + (60 * 60), // Waktu token kedaluwarsa (1 jam)
                "data" => [
                    "id" => $userId, // ID pengguna
                    "email" => $isAuthenticated['email'], // Email pengguna
                    "role" => $isAuthenticated['role'] // Role pengguna
                ]
            ];

            $jwt = JWT::encode($payload, $key, 'HS256'); // Generate token

            http_response_code(200); // OK
            echo json_encode([
                "status" => "success",
                "message" => "Login berhasil",
                "token" => $jwt, // Tambahkan token ke respon
                "data" => $isAuthenticated
            ]);
        } else {
            http_response_code(404); // Not Found
            echo json_encode([
                "status" => "error",
                "message" => "Email atau password salah"
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
