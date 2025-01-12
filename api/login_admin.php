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

$method = $_SERVER['REQUEST_METHOD'];

// Kunci rahasia untuk JWT
$key = "your_secret_key";

switch ($method) {
    case 'POST':
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
        break;

        case 'GET':
            // Ambil token dari header Authorization
            $headers = getallheaders();
            if (!isset($headers['Authorization'])) {
                http_response_code(400); // Bad Request
                echo json_encode([
                    "status" => "error",
                    "message" => "Token tidak ditemukan"
                ]);
                exit;
            }
        
            $authHeader = $headers['Authorization'];
            $jwt = str_replace('Bearer ', '', $authHeader); // Hapus "Bearer " dari header
        
            try {
                // Verifikasi token JWT
                $decoded = JWT::decode($jwt, new Key($key, 'HS256'));
                $adminId = $decoded->data->id; // Ambil ID dari token
        
                // Dapatkan data admin berdasarkan ID
                $adminData = $admin->getAdminById($adminId);
        
                if ($adminData) {
                    http_response_code(200); // OK
                    echo json_encode([
                        "status" => "success",
                        "message" => "Token valid",
                        "data" => $adminData
                    ]);
                } else {
                    http_response_code(404); // Not Found
                    echo json_encode([
                        "status" => "error",
                        "message" => "Admin tidak ditemukan"
                    ]);
                }
            } catch (Exception $e) {
                http_response_code(401); // Unauthorized
                echo json_encode([
                    "status" => "error",
                    "message" => "Token tidak valid",
                    "error" => $e->getMessage()
                ]);
            }
            break;        
}

$conn->close();
?>
