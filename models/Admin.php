<?php
class Admin {
    private $conn;
    private $table = "admin";

    public $id;
    public $nama;
    public $email;
    public $password;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Method untuk membuat admin baru
    public function create() {
        $query = "INSERT INTO " . $this->table . " (nama, email, password) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        if (!$stmt) {
            throw new Exception("Prepare statement failed: " . $this->conn->error);
        }
        $stmt->bind_param("sss", $this->nama, $this->email, $this->password);
        return $stmt->execute();
    }

    // Method untuk mengecek apakah email sudah ada
    public function emailExists() {
        $query = "SELECT email FROM " . $this->table . " WHERE LOWER(email) = LOWER(?)";
        $stmt = $this->conn->prepare($query);
        if (!$stmt) {
            throw new Exception("Prepare statement failed: " . $this->conn->error);
        }
        $stmt->bind_param("s", $this->email);
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows > 0;
    }

    // Method untuk login admin
    public function login() {
        $query = "SELECT id, email, password, nama FROM " . $this->table . " WHERE LOWER(email) = LOWER(?)"; // Tambahkan 'id' dalam SELECT
        $stmt = $this->conn->prepare($query);
        if (!$stmt) {
            throw new Exception("Prepare statement failed: " . $this->conn->error);
        }

        $stmt->bind_param("s", $this->email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            // Verifikasi password
            if (password_verify($this->password, $row['password'])) {
                return [
                    "id" => $row['id'], // Pastikan 'id' diambil dari hasil query
                    "email" => $row['email'],
                    "nama" => $row['nama']
                ];
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    // Method untuk mendapatkan data admin berdasarkan ID
    public function getAdminById($id) {
        $query = "SELECT id, nama, email FROM " . $this->table . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        if (!$stmt) {
            throw new Exception("Prepare statement failed: " . $this->conn->error);
        }

        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return null; // Jika admin tidak ditemukan
        }
    }
}
