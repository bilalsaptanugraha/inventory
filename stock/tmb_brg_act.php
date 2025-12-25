<?php 
include '../dbconnect.php';

$nama   = $_POST['nama'];
$jenis  = $_POST['jenis'];
$merk   = $_POST['merk'];
$ukuran = $_POST['ukuran'];
$stock  = $_POST['stock'];
$satuan = $_POST['satuan'];
$lokasi = $_POST['lokasi'];

$query = mysqli_query($conn, "
    INSERT INTO sstock_brg 
    (nama, jenis, merk, ukuran, stock, satuan, lokasi) 
    VALUES 
    ('$nama', '$jenis', '$merk', '$ukuran', '$stock', '$satuan', '$lokasi')
");

if ($query){
    echo "
    <div class='alert alert-success'>
        <strong>Success!</strong> Redirecting you back in 1 seconds.
    </div>
    <meta http-equiv='refresh' content='1; url=stock.php'/>
    ";
} else {
    echo mysqli_error($conn); // 🔥 PENTING buat debug
}
?>
