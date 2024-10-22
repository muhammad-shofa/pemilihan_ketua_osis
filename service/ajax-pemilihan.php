<?php
include "connection.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $kandidat_id = $_POST['kandidat_id'];

    $stmt = $connected->prepare("INSERT INTO votes (user_id, kandidat_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $user_id, $kandidat_id);
    if ($stmt->execute()) {
        echo "Berhasil memilih";
    } else {
        echo "Gagal Memilih" . $stmt->error;
    }

    $stmt->close();
}
