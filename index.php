<?php
session_start();
include 'dbconnect.php';

if(isset($_SESSION['role'])){
    header("location:stock");
    exit;
}

if(isset($_GET['pesan'])){
    if($_GET['pesan'] == "gagal"){
        echo "<script>alert('Username atau Password salah!');</script>";
    }else if($_GET['pesan'] == "logout"){
        echo "<script>alert('Anda berhasil keluar dari sistem');</script>";
    }else if($_GET['pesan'] == "belum_login"){
        echo "<script>alert('Anda harus login terlebih dahulu');</script>";
    }else if($_GET['pesan'] == "noaccess"){
        echo "<script>alert('Akses ditutup');</script>";
    }
}

if(isset($_POST['btn-login'])){
    $uname = mysqli_real_escape_string($conn, $_POST['username']);
    $upass = mysqli_real_escape_string($conn, md5($_POST['password']));

    $login = mysqli_query($conn,"SELECT * FROM slogin WHERE username='$uname' AND password='$upass'");
    $cek = mysqli_num_rows($login);

    if($cek > 0){
        $data = mysqli_fetch_assoc($login);

        if($data['role'] == "stock"){
            $_SESSION['user'] = $data['nickname'];
            $_SESSION['user_login'] = $data['username'];
            $_SESSION['id'] = $data['id'];
            $_SESSION['role'] = "stock";
            header("location:stock");
            exit;
        }
    }

    header("location:index.php?pesan=gagal");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>System Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">

    <style>
        body{
            background-image: url("bg.jpg");
            background-size: cover;
            background-position: center;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-box{
            width: 100%;
            max-width: 400px;
        }
    </style>

    <link rel="icon" type="image/png" href="favicon.png">
</head>

<body>

<div class="login-box">

    <form method="post">
        <div class="form-group">
            <input type="text" name="username" class="form-control text-center" placeholder="Username" required autofocus>
        </div>

        <div class="form-group">
            <input type="password" name="password" class="form-control text-center" placeholder="Password" required>
        </div>

        <button type="submit" name="btn-login" class="btn btn-primary btn-block">
            Masuk
        </button>
    </form>

</div>

</body>
</html>
