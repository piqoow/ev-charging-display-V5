<?php
require_once('../db/connection.php'); // Include the connection file

$id = $_GET['id'];

// Use prepared statements to prevent SQL injection
$sql = $conn->prepare("SELECT video_iklan FROM evgate WHERE customer_id = ?");
$sql->bind_param("s", $id);
$sql->execute();
$result = $sql->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $videoUrl = $row['video_iklan'];
} else {
    $videoUrl = ''; 
}

$sql->close();
$conn->close();

// Output the video URL (optional)
echo json_encode(array("videoUrl" => $videoUrl));
?>
