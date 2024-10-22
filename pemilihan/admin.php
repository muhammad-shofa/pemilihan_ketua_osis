<?php
include "../service/connection.php";
session_start();

if ($_SESSION['is_login'] != true) {
    header('location: ../index.php');
} else if ($_SESSION['role'] != 'admin') {
    header('location: index.php');
}

if (isset($_POST['logoutBtn'])) {
    session_unset();
    session_destroy();
    header('location: ../index.php');
}

// Ambil jumlah suara untuk kandidat
// $query = "SELECT kandidat_id, COUNT(*) as jumlah FROM votes GROUP BY kandidat_id";
// $result = $connected->query($query);

// $kandidat_votes = [
//     1 => 0,
//     2 => 0
// ];

// while ($row = $result->fetch_assoc()) {
//     $kandidat_votes[$row['kandidat_id']] = $row['jumlah'];
// }

// // Hitung total suara
// $total_votes = $kandidat_votes[1] + $kandidat_votes[2];

// // Hitung persentase
// $persentase_kandidat_1 = $total_votes > 0 ? ($kandidat_votes[1] / $total_votes) * 100 : 0;
// $persentase_kandidat_2 = $total_votes > 0 ? ($kandidat_votes[2] / $total_votes) * 100 : 0;

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemilihan Ketua Osis SMK TJP 2024</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <!-- bootstrap -->
    <link rel="stylesheet" href="../assets/bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <div class="container-xl py-3 px-2 text-center">
        <?php include "navbar.php" ?>

        <h2 class="mt-3">Pemilihan Ketua Osis SMK Taruna Jaya Prawira Tuban Tahun 2024</h2>
        <div class="main-bar">
            <div class="kandidat1" id="barKandidat1">
                <span class="kandidat-label label1" id="persentaseKandidat1"></span>
            </div>
            <div class="kandidat2" id="barKandidat2">
                <span class="kandidat-label label2" id="persentaseKandidat2"></span>
            </div>
        </div>

        <div class="d-flex flex-wrap justify-content-evenly py-3">
            <!-- kandidat 1 -->
            <div class="card" style="width: 380px;">
                <div class="card-body">
                    <h4><b id="jumlah_suara1"></b></h4>
                    <h3 class="card-title">Andreas Al Andreas</h3>
                </div>
                <img src="../assets/img/calon-1.jpg" class="card-img-top" alt="Calon 1">
            </div>
            <!-- kandidat 2 -->
            <div class="card" style="width: 380px;">
                <div class="card-body">
                    <h4><b id="jumlah_suara2"></b></h4>
                    <h3 class="card-title">Thomas Slebew</h3>
                </div>
                <img src="../assets/img/calon-2.jpg" class="card-img-top" alt="Calon 2">
            </div>
        </div>
    </div>

    <!-- bootstrap js -->
    <script src="../assets/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="../assets/jquery/jquery.js"></script>
    <script src="../assets/jquery/jquery.min.js"></script>
    <!-- costume js -->
    <script src="../assets/js/main.js"></script>

    <script>
        function updateVotes() {
            $.ajax({
                url: '../service/ajax-admin.php',
                method: 'GET',
                dataType: 'json',
                success: function (data) {
                    // Update persentase dan bar
                    $('#persentaseKandidat1').text(data.persentase_kandidat_1.toFixed(2));
                    $('#persentaseKandidat2').text(data.persentase_kandidat_2.toFixed(2));

                    $('#jumlah_suara1').text(data.jumlah_suara1);
                    $('#jumlah_suara2').text(data.jumlah_suara2);

                    // Update bar width sesuai dengan persentase
                    $('#barKandidat1').css('width', data.persentase_kandidat_1 + '%');
                    $('#barKandidat2').css('width', data.persentase_kandidat_2 + '%');
                }
            });
        }

        // Panggil fungsi updateVotes setiap 5 detik
        setInterval(updateVotes, 5000);

        // Panggil fungsi untuk pertama kali saat halaman dimuat
        $(document).ready(function () {
            updateVotes();

            // Tampilankan tombol logout saat halaman dimuat
            updateLogoutButtonVisibility();
        });
    </script>
</body>

</html>