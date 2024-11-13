<?php
require_once('vendor/autoload.php');

use WebSocket\Client;

try {
    // Buat koneksi WebSocket client
    $client = new Client("ws://110.0.50.55:3001/websocket");

    // Pesan yang akan dikirim
    $message = "setr=0";

    // Kirim pesan
    $client->send($message);

    // Terima respons dari server
    $response = $client->receive();
    echo "Respons dari server: " . $response . "\n";

    // Tutup koneksi
    $client->close();
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
