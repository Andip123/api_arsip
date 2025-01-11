<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$mail = new PHPMailer(true);

try {
    $mail->SMTPDebug = 2; // Aktifkan debugging
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'your-email@gmail.com'; // Ganti dengan email pengirim
    $mail->Password = 'your-app-password'; // Ganti dengan App Password Gmail
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->setFrom('your-email@gmail.com', 'Nama Pengirim');
    $mail->addAddress('recipient@gmail.com', 'Nama Penerima'); // Ganti dengan email penerima

    $mail->isHTML(true);
    $mail->Subject = 'Test Email';
    $mail->Body = 'Ini adalah email percobaan menggunakan PHPMailer.';

    $mail->send();
    echo 'Email berhasil dikirim.';
} catch (Exception $e) {
    echo "Email gagal dikirim. Error: {$mail->ErrorInfo}";
}
