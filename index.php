<?php
include "service/connection.php";
session_start();

$message_login = "";

if (isset($_POST['masuk'])) {
    $username = htmlspecialchars($_POST["username"]);
    $password = htmlspecialchars($_POST["password"]);

    $sql_login = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result_user = $connected->query($sql_login);
    if ($result_user->num_rows > 0) {
        $data_user = $result_user->fetch_assoc();
        $_SESSION["user_id"] = $data_user["user_id"];
        $_SESSION["computer_name"] = $data_user["computer_name"];
        $_SESSION["role"] = $data_user["role"];
        $_SESSION["is_login"] = true;
        if ($_SESSION["role"] === "admin") {
            header("location: pemilihan/admin.php");
        } else {
            header("location: pemilihan/index.php");
        }
    } else {
        $message_login = "Pastikan anda memasukkan username dan password yang benar!";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Pemilihan Ketua Osis SMK TJP 2024</title>
    <!-- bootstrap -->
    <link rel="stylesheet" href="assets/bootstrap-5.3.3-dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <div class="row justify-content-center" style="padding-top: 50px;">
            <div class="col-xl-4 col-lg-5 col-sm-6 col-12">
                <!-- form start -->
                <form action="" method="POST" class="my-5">
                    <div class="border rounded-2 p-4 mt-5 bg-light">
                        <div class="login-form">
                            <h5 class="fw-bold mb-3">Login</h5>
                            <p class="text-danger">
                                <?= $message_login ?>
                            </p>
                            <div class="mb-3">
                                <label class="form-label" for="username">Username</label>
                                <input type="text" name="username" id="username" class="form-control"
                                    placeholder="Masukkan username" required />
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="password">Password</label>
                                <input type="password" name="password" id="password" class="form-control"
                                    placeholder="Masukkan password" required />
                            </div>
                            <div class="d-grid py-3 mt-3">
                                <button type="submit" name="masuk" class="btn btn-lg btn-primary">
                                    Masuk
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- /form end -->

            </div>
        </div>
    </div>

    <!-- bootstrap js -->
    <script src="assets/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>