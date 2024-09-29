<?php
// Konfigurasi database
$servername = "localhost";
$username = "rnd";
$password = "rahasia123";
$dbname = "ev_charging_db";

// Buat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$id = $_GET['id'];
// Ambil URL video dari database
$sql = "SELECT qr_code FROM evgate WHERE customer_id = '$id'"; // Sesuaikan dengan ID yang relevan
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Ambil URL video
    $row = $result->fetch_assoc();
    $qrCode = $row['qr_code'];
} else {
    $qrCode = ''; // URL default atau pesan kesalahan jika tidak ada hasil
}

$conn->close();
?>
