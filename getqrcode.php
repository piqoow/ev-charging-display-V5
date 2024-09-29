<?php
$servername = "localhost";
$username = "rnd";
$password = "rahasia123";
$dbname = "ev_charging_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$id = $_GET['id'];
$sql = "SELECT qr_code FROM evgate WHERE customer_id = '$id'"; 
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $qrCode = $row['qr_code'];
} else {
    $qrCode = '';
}

$conn->close();
?>
