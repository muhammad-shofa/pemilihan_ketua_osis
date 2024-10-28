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


// Ambil jumlah semua votes
$query = "SELECT COUNT(*) as total_votes FROM votes";
$result = $connected->query($query);
$value_semua_votes = "";
$value_persentase_votes = "";

if ($result) {
    $data = $result->fetch_assoc();
    $total_votes = $data['total_votes'];

    $target_votes = 1714;

    // Hitung persentase suara yang terkumpul
    $percentage = ($total_votes / $target_votes) * 100;

    $value_semua_votes = "Jumlah suara yang terkumpul: $total_votes<br>";
    $value_persentase_votes = "Persentase siswa yang memilih: " . round($percentage, 2) . "%";
} else {
    echo "Gagal mengambil data suara.";
}
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
    <button id="fullscreenBtn" title="Fullscreen">
        <i class="fas fa-expand"></i>
    </button>
    <div class="container-xl py-3 px-2 text-center">
        <!-- <php include "navbar.php" ?> -->
        <h2 class="mt-3 judul">Pemilihan Ketua dan Wakil ketua Osis <br> SMK Taruna Jaya Prawira Tuban Tahun 2024</h2>
        <div class="main-bar">
            <div class="kandidat1" id="barKandidat1">
                <span class="kandidat-label label1" id="persentaseKandidat1"></span>
            </div>
            <div class="kandidat2" id="barKandidat2">
                <span class="kandidat-label label2" id="persentaseKandidat2"></span>
            </div>
        </div>
        <div class="jumlah-semua-suara p-2 text-center judul-2">
            <?= $value_semua_votes ?>
            <?= $value_persentase_votes ?>
        </div>

        <div class="d-flex flex-wrap justify-content-evenly py-3">

            <div class="card card-orange ani1" style="width: 380px;" id="ya1">
                <img src="../assets/img/1.png" class="card-img-top" alt="Calon 1">
                <div class="card-body">
                    <h4 class="card-title ketua">Shyallom Christian Y.P</h4>
                    <h4 class="card-title wakil">Cintya Putri Dzulfianendi</h4>
                    <h6 class="nomor">Paslon Nomor 1</h6>
                </div>
            </div>

            <!-- kandidat 2 -->
            <div class="card card-orange ani2" style="width: 380px;" id="ya2">
                <img src="../assets/img/2.png" class="card-img-top" alt="Calon 2">
                <div class="card-body">
                    <input type="hidden" name="kandidat_id" value="2">
                    <h4 class="card-title ketua">Eka Yoansa</h4>
                    <h4 class="card-title wakil">Ahmad Wahyu Anafi</h4>
                    <h6 class="nomor">Paslon Nomor 2</h6>
                </div>
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
        });
    </script>
</body>

</html>