<?php
include '../dbconnect.php';

if(!isset($_POST['barang'], $_POST['qty'], $_POST['tanggal'])){
    header("location:masuk.php");
    exit;
}

$barang   = $_POST['barang'];
$qty      = (int) $_POST['qty'];
$tanggal  = $_POST['tanggal'];
$ket      = $_POST['ket'];

if($qty <= 0){
    echo "<script>alert('Jumlah harus lebih dari 0'); window.location='masuk.php';</script>";
    exit;
}

$dt = mysqli_query($conn,"SELECT stock FROM sstock_brg WHERE idx='$barang'");
if(mysqli_num_rows($dt) == 0){
    echo "<script>alert('Barang tidak ditemukan'); window.location='masuk.php';</script>";
    exit;
}
$data = mysqli_fetch_assoc($dt);

mysqli_begin_transaction($conn);

$sisa = $data['stock'] + $qty;

$q1 = mysqli_query($conn,"UPDATE sstock_brg SET stock='$sisa' WHERE idx='$barang'");
$q2 = mysqli_query($conn,"INSERT INTO sbrg_masuk (idx,tgl,jumlah,keterangan)
                          VALUES('$barang','$tanggal','$qty','$ket')");

if($q1 && $q2){
    mysqli_commit($conn);
    header("location:masuk.php?status=success");
} else {
    mysqli_rollback($conn);
    header("location:masuk.php?status=fail");
}
exit;
