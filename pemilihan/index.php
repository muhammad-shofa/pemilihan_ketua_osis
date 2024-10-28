<?php
session_start();

if ($_SESSION['is_login'] != true) {
    header('location: ../index.php');
}

if (isset($_POST['logoutBtn'])) {
    session_unset();
    session_destroy();
    header('location: ../index.php');
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
    <img src="../assets/img/book.png" alt="Book" class="book">
    <img src="../assets/img/toga.png" alt="Book" class="toga">
    <!-- <img src="../assets/img/penggaris.png" alt="Book" class="penggaris"> -->
    <div class="container-xl py-2 px-2 text-center">
        <!-- <php include "navbar.php" ?> -->

        <h2 class="judul">Pemilihan Ketua dan Wakil ketua Osis <br> SMK Taruna Jaya Prawira Tuban Tahun 2024</h2>
        <div class="d-flex flex-wrap justify-content-evenly">
            <!-- kandidat 1 -->
            <form action="" method="POST" id="kandidat1">
                <div class="card card-orange ani1" style="width: 380px;" id="ya1">
                    <img src="../assets/img/1.png" class="card-img-top" alt="Calon 1">
                    <div class="card-body">
                        <input type="hidden" name="kandidat_id" value="1">
                        <h4 class="card-title ketua">Shyallom Christian Y.P</h4>
                        <h4 class="card-title wakil">Cintya Putri Dzulfianendi</h4>
                        <h6 class="nomor">Paslon Nomor 1</h6>
                        <button type="button" class="btn btn-custom">
                            Pilih Paslon
                        </button>
                    </div>
                </div>
            </form>
            <!-- kandidat 2 -->
            <form action="" method="POST" id="kandidat2">
                <div class="card card-orange ani2" style="width: 380px;" id="ya2">
                    <img src="../assets/img/2.png" class="card-img-top" alt="Calon 2">
                    <div class="card-body">
                        <input type="hidden" name="kandidat_id" value="2">
                        <h4 class="card-title ketua">Eka Yoansa</h4>
                        <h4 class="card-title wakil">Ahmad Wahyu Anafi</h4>
                        <h6 class="nomor">Paslon Nomor 2</h6>
                        <button type="button" class="btn btn-custom">
                            Pilih Paslon
                        </button>
                    </div>
                </div>
            </form>

            <!-- Modal countdown -->
            <div class="modal" id="modalCountdown" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                role="dialog">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Menunggu Konfirmasi</h5>
                        </div>
                        <div class="modal-body">
                            <p>Memproses pilihan anda. Tunggu <span id="countdown">10</span> detik...</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal berhasil -->
            <div class="modal" id="modalStatusPemilihan" data-bs-backdrop="static" data-bs-keyboard="false"
                tabindex="-1" role="dialog">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Status Pemilihan</h5>
                        </div>
                        <div class="modal-body">
                            <p id="statusPemilihan"></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Elemen audio untuk suara -->
            <audio id="clickSound" src="../assets/cashier.mp3"></audio>

        </div>
    </div>
    <!-- bootstrap js -->
    <script src="../assets/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="../assets/jquery/jquery.js"></script>
    <script src="../assets/jquery/jquery.min.js"></script>
    <script src="../assets/js/main.js"></script>

    <script>


        // Insert Pilihan Kandidat 1
        $('#ya1').click(function () {
            let pilihSound = document.getElementById("clickSound");
            pilihSound.play();
            // $('#modalKonfirmasi1').modal('hide');
            $('#modalCountdown').modal('show');

            // Hitungan mundur dari 10 detik
            var countdown = 10;
            countdownInterval = setInterval(function () {
                $('#countdown').text(countdown);
                countdown--;

                if (countdown < 0) {
                    clearInterval(countdownInterval); // Hentikan interval saat countdown selesai
                    // Kirim data ke server setelah countdown selesai
                    var data = $('#kandidat1').serialize();
                    $.ajax({
                        url: '../service/ajax-pemilihan.php',
                        type: 'POST',
                        data: data,
                        success: function (response) {
                            // Sembunyikan modal countdown setelah selesai
                            $('#modalCountdown').modal('hide');

                            $('#modalStatusPemilihan').modal('show');
                            $('#statusPemilihan').text(response);
                            setTimeout(function () {
                                $('#modalStatusPemilihan').modal('hide');
                            }, 1500);
                        }
                    });
                }
            }, 1000);
        });

        var countdownInterval;

        // Insert Pilihan Kandidat 2
        $('#ya2').click(function () {
            let pilihSound = document.getElementById("clickSound");
            pilihSound.play();
            // $('#modalKonfirmasi2').modal('hide');
            $('#modalCountdown').modal('show');

            // Hitungan mundur dari 10 detik
            var countdown = 10;
            countdownInterval = setInterval(function () {
                $('#countdown').text(countdown);
                countdown--;

                if (countdown < 0) {
                    clearInterval(countdownInterval); // Hentikan interval saat countdown selesai
                    // Kirim data ke server setelah countdown selesai
                    var data = $('#kandidat2').serialize();
                    $.ajax({
                        url: '../service/ajax-pemilihan.php',
                        type: 'POST',
                        data: data,
                        success: function (response) {
                            // Sembunyikan modal countdown setelah selesai
                            $('#modalCountdown').modal('hide');

                            $('#modalStatusPemilihan').modal('show');
                            $('#statusPemilihan').text(response);
                            setTimeout(function () {
                                $('#modalStatusPemilihan').modal('hide');
                            }, 1500);
                        }
                    });
                }
            }, 1000);
        });


    </script>
</body>

</html>