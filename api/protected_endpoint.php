<?php
header("Content-Type: application/json");
require_once '../config/database.php';
require_once '../models/User.php';
require_once '../middleware/jwt_middleware.php'; // Import middleware

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$database = new Database();
$conn = $database->getConnection();

$key = "your_secret_key"; // Kunci rahasia untuk JWT

// Validasi token JWT
$decodedData = validateJWT($key);

// Lanjutkan logika endpoint setelah token tervalidasi
echo json_encode([
    "status" => "success",
    "message" => "Endpoint terlindungi berhasil diakses",
    "data" => $decodedData
]);

$conn->close();
