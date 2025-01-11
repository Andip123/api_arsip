<?php
header("Content-Type: application/json");
require_once '../config/database.php';
require_once '../models/Admin.php';

$database = new Database();
$conn = $database->getConnection();

$admin = new Admin($conn);

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'POST':
        $input = json_decode(file_get_contents('php://input'), true);

        if (!isset($input['nama'], $input['email'], $input['password'])) {
            echo json_encode([
                "status" => "error",
                "message" => "Data tidak lengkap"
            ]);
            exit;
        }

        // Validasi email
        if (!filter_var($input['email'], FILTER_VALIDATE_EMAIL)) {
            echo json_encode([
                "status" => "error",
                "message" => "Format email tidak valid"
            ]);
            exit;
        }

        $admin->nama = $input['nama'];
        $admin->email = $input['email'];
        $admin->password = password_hash($input['password'], PASSWORD_DEFAULT);

        // Cek apakah email sudah terdaftar
        if ($admin->emailExists()) {
            echo json_encode([
                "status" => "error",
                "message" => "Email sudah terdaftar"
            ]);
            exit;
        }

        // Buat admin baru
        if ($admin->create()) {
            echo json_encode([
                "status" => "success",
                "message" => "Admin berhasil didaftarkan"
            ]);
        } else {
            echo json_encode([
                "status" => "error",
                "message" => "Gagal mendaftarkan admin"
            ]);
        }
        break;

    default:
        echo json_encode([
            "status" => "error",
            "message" => "Metode tidak didukung"
        ]);
        break;
}

$conn->close();
?>
