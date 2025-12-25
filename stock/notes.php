<?php
session_start();
include_once '../dbconnect.php';

// CEGAH AKSES LANGSUNG
if (!isset($_POST['konten'])) {
    header("location:index.php");
    exit;
}

$konten = mysqli_real_escape_string($conn, $_POST['konten']);
$oleh   = $_SESSION['user'];

$query = "INSERT INTO notes (contents, admin, status) 
          VALUES ('$konten', '$oleh', 'aktif')";

$hasil = mysqli_query($conn, $query);

if ($hasil) {
    echo "
    <div style='padding:20px; background:#d4edda; color:#155724'>
        <b>Success!</b> Note berhasil ditambahkan.
    </div>
    <meta http-equiv='refresh' content='1; url=index.php'>
    ";
} else {
    echo "
    <div style='padding:20px; background:#f8d7da; color:#721c24'>
        <b>Failed!</b> Gagal menambahkan note.
    </div>
    <meta http-equiv='refresh' content='2; url=index.php'>
    ";
}
