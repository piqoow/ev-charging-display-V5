<?php
$servername = "localhost";
$username = "rnd";
$password = "rahasia123";
$database = "ev_charging_db";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

date_default_timezone_set('Asia/Jakarta');

$id = $_POST['id'];
$selectQuery = "SELECT customer_id, energy FROM evgate WHERE customer_id = '$id'";
$result = $conn->query($selectQuery);
$data = json_decode(file_get_contents("php://input"), true);

if ($result->num_rows > 0) {
    // Iterasi hasil query SELECT
    while ($row = $result->fetch_assoc()) {
        $ev_id = $row['customer_id'];
        $energy = $row['energy'];
        $time = $_POST['time'];
        // $time = $data['time'];
        $savedate = date('Y-m-d H:i:s');

        $insertQuery = "INSERT INTO charging_log (ev_id, time, energy, savedate) VALUES ('$ev_id', '$time', '$energy', '$savedate')";
        
        if ($conn->query($insertQuery) === TRUE) {
            echo "Data berhasil ditambahkan ke charging_log.";
        } else {
            echo "Error: " . $insertQuery . "<br>" . $conn->error;
        }
    }
} else {
    echo "Tidak ada data yang ditemukan untuk diambil.";
}

$conn->close();
?>