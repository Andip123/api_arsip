<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Autoload PHPMailer
require_once '../vendor/autoload.php';

/**
 * Fungsi untuk mengirim email menggunakan PHPMailer
 *
 * @param string $toEmail - Alamat email penerima
 * @param string $toName - Nama penerima
 * @param string $subject - Subjek email
 * @param string $body - Isi email dalam format HTML
 * @return bool - True jika email berhasil dikirim, False jika gagal
 */
function sendEmail($toEmail, $toName, $subject, $body)
{
    try {
        $mail = new PHPMailer(true);

        // Debugging level (Opsional, matikan di production)
        $mail->SMTPDebug = 0; // 0 = no output, 1 = commands, 2 = data
        $mail->Debugoutput = function ($str, $level) {
            error_log("Debug level $level: $str"); // Output debug ke log PHP
        };

        // Konfigurasi SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Ganti sesuai SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'your-email@gmail.com'; // Email pengirim
        $mail->Password = 'your-app-password'; // Gunakan App Password Gmail
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Gunakan TLS
        $mail->Port = 587; // Port SMTP untuk TLS

        // Pengaturan email pengirim
        $mail->setFrom('your-email@gmail.com', 'Arsip Digital Polres Demak'); // Ganti nama pengirim
        $mail->addAddress($toEmail, $toName); // Tambahkan penerima

        // Konten email
        $mail->isHTML(true); // Kirim dalam format HTML
        $mail->Subject = $subject;
        $mail->Body = $body;

        // Kirim email
        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("PHPMailer Error: " . $mail->ErrorInfo); // Log error jika terjadi masalah
        return false;
    }
}
