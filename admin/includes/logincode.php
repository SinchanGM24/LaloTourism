<?php
session_start();

$connection = mysqli_connect("localhost", "root", "", "lalotourism2");

if (isset($_POST['login_btn'])) {


    $query = "SELECT * FROM `admin` WHERE `Username` = ? AND `Password` = ?";
    $Username = $_POST['Username'];
    $Password = $_POST['Password'];
    if ($stmt = mysqli_prepare($connection, $query)) {
        // Mengikat parameter
        mysqli_stmt_bind_param($stmt, "ss", $Username, $Password);

        // Menjalankan statement
        mysqli_stmt_execute($stmt);

        // Mendapatkan hasil
        $result = mysqli_stmt_get_result($stmt);

        // Memeriksa apakah ada baris yang cocok
        if (mysqli_num_rows($result) > 0) {
            $_SESSION['Username'] = $Username;
            $_SESSION['Password'] = $Password;
            // Mengarahkan ke halaman submit jika login berhasil
            header("Location: ../Profile.php");
            exit(); // tambahkan exit setelah header
        } else {
            // Mengatur pesan error dalam sesi jika login gagal
            $_SESSION['error'] = "Username atau password salah.";
            header("Location: ../index.php");
            exit();
        }
    }
}
if (isset($_GET['logout'])) {
    // Hancurkan sesi
    session_destroy();
    // Arahkan ke halaman login
    header("Location: ../index.php");
    exit();
}


