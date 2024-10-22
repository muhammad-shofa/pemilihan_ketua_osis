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
    <div class="container-xl py-3 px-2 text-center">
        <?php include "navbar.php" ?>

        <h2 class="mt-3">Pemilihan Ketua Osis SMK Taruna Jaya Prawira Tuban Tahun 2024</h2>
        <div class="d-flex flex-wrap justify-content-evenly py-3">
            <!-- kandidat 1 -->
            <div class="card" style="width: 380px;">
                <img src="../assets/img/calon-1.jpg" class="card-img-top" alt="Calon 1">
                <div class="card-body">
                    <h4 class="card-title">Andreas Al Andreas</h4>
                    <h6>Kandidat Nomor 1</h6>
                    <button type="button" class="btn btn-success" data-bs-toggle="modal"
                        data-bs-target="#modalKonfirmasi1">
                        Pilih Kandidat
                    </button>
                </div>
            </div>
            <!-- kandidat 2 -->
            <div class="card" style="width: 380px;">
                <img src="../assets/img/calon-2.jpg" class="card-img-top" alt="Calon 2">
                <div class="card-body">
                    <h4 class="card-title">Thomas Slebew</h4>
                    <h6>Kandidat Nomor 2</h6>
                    <button type="button" class="btn btn-success" data-bs-toggle="modal"
                        data-bs-target="#modalKonfirmasi2">
                        Pilih Kandidat
                    </button>
                </div>
            </div>

            <!-- Modal Konfirmasi 1 Start -->
            <div class="modal fade" id="modalKonfirmasi1" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form action="" id="formKonfirmasi1">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5">Konfirmasi Pilihan</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="kandidat_id" value="1">
                                <p>Kamu yakin ingin memilih calon Nomor 1?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="button" id="ya1" class="btn btn-primary">Ya</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Modal Konfirmasi 1 End -->

            <!-- Modal Konfirmasi 2 Start -->
            <div class="modal fade" id="modalKonfirmasi2" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form action="" id="formKonfirmasi2">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5">Konfirmasi Pilihan</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="kandidat_id" value="2">
                                <p>Kamu yakin ingin memilih calon Nomor 2?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="button" id="ya2" class="btn btn-primary">Ya</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Modal Konfirmasi 2 End -->

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

        </div>
    </div>
    <!-- bootstrap js -->
    <script src="../assets/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="../assets/jquery/jquery.js"></script>
    <script src="../assets/jquery/jquery.min.js"></script>

    <script>
        // Insert Pilihan Kandidat 1
        // Insert Pilihan Kandidat 2
        $('#ya1').click(function () {
            $('#modalKonfirmasi1').modal('hide');
            $('#modalCountdown').modal('show');

            // Hitungan mundur dari 10 detik
            var countdown = 10;
            countdownInterval = setInterval(function () {
                $('#countdown').text(countdown);
                countdown--;

                if (countdown < 0) {
                    clearInterval(countdownInterval); // Hentikan interval saat countdown selesai
                    // Kirim data ke server setelah countdown selesai
                    var data = $('#formKonfirmasi1').serialize();
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
            $('#modalKonfirmasi2').modal('hide');
            $('#modalCountdown').modal('show');

            // Hitungan mundur dari 10 detik
            var countdown = 10;
            countdownInterval = setInterval(function () {
                $('#countdown').text(countdown);
                countdown--;

                if (countdown < 0) {
                    clearInterval(countdownInterval); // Hentikan interval saat countdown selesai
                    // Kirim data ke server setelah countdown selesai
                    var data = $('#formKonfirmasi2').serialize();
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

        // FS
        const fullscreenBtn = document.getElementById('fullscreenBtn');
        const logoutBtn = document.getElementById('logoutBtn');

        // Fungsi untuk masuk/keluar mode fullscreen
        function toggleFullscreen() {
            if (!document.fullscreenElement) {
                document.documentElement.requestFullscreen().catch(err => {
                    console.error(`Error trying to enable fullscreen mode: ${err.message} (${err.name})`);
                });
            } else {
                if (document.exitFullscreen) {
                    document.exitFullscreen();
                }
            }
        }

        // Event listener untuk tombol fullscreen
        fullscreenBtn.addEventListener('click', toggleFullscreen);

        // Fungsi untuk mengupdate visibilitas logout button
        function updateLogoutButtonVisibility() {
            if (document.fullscreenElement) {
                logoutBtn.style.display = 'none'; // Sembunyikan tombol logout
            } else {
                logoutBtn.style.display = 'block'; // Tampilkan tombol logout
            }
        }

        // Perubahan status fullscreen
        document.addEventListener('fullscreenchange', updateLogoutButtonVisibility);
        document.addEventListener('webkitfullscreenchange', updateLogoutButtonVisibility); // Untuk Safari
        document.addEventListener('mozfullscreenchange', updateLogoutButtonVisibility); // Untuk Firefox
        document.addEventListener('MSFullscreenChange', updateLogoutButtonVisibility); // Untuk IE/Edge

        // Tampilankan tombol logout saat halaman dimuat
        updateLogoutButtonVisibility();

    </script>
</body>

</html>