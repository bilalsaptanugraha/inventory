<!doctype html>
<html class="no-js" lang="en">

<?php 
include '../dbconnect.php';
include 'cek.php';

/* ================= UPDATE BARANG ================= */
if(isset($_POST['update'])){
    $idx = $_POST['idbrg'];
    $nama = $_POST['nama'];
    $jenis = $_POST['jenis'];
    $merk = $_POST['merk'];
    $ukuran = $_POST['ukuran'];
    $satuan = $_POST['satuan'];
    $lokasi = $_POST['lokasi'];

    $updatedata = mysqli_query($conn,"
        UPDATE sstock_brg 
        SET nama='$nama', jenis='$jenis', merk='$merk', ukuran='$ukuran', satuan='$satuan', lokasi='$lokasi'
        WHERE idx='$idx'
    ");

    if ($updatedata){
        echo "<meta http-equiv='refresh' content='1; url= stock.php'/>";
    }
}

/* ================= HAPUS BARANG ================= */
if(isset($_POST['hapus'])){
    $idx = $_POST['idbrg'];

    mysqli_query($conn,"DELETE FROM sstock_brg WHERE idx='$idx'");
    mysqli_query($conn,"DELETE FROM sbrg_keluar WHERE id='$idx'");
    mysqli_query($conn,"DELETE FROM sbrg_masuk WHERE id='$idx'");

    echo "<meta http-equiv='refresh' content='1; url= stock.php'/>";
}
?>

<head>
<meta charset="utf-8">
<title>Logistics</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="assets/css/bootstrap.min.css">
<link rel="stylesheet" href="assets/css/font-awesome.min.css">
<link rel="stylesheet" href="assets/css/themify-icons.css">
<link rel="stylesheet" href="assets/css/metisMenu.css">
<link rel="stylesheet" href="assets/css/slicknav.min.css">
<link rel="stylesheet" href="assets/css/styles.css">
<link rel="stylesheet" href="assets/css/responsive.css">

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
</head>

<body>

<div class="page-container">

<!-- ================= SIDEBAR ================= -->
<div class="sidebar-menu">
    <div class="sidebar-header"></div>
    <div class="main-menu">
        <div class="menu-inner">
            <ul class="metismenu">
                <li><a href="index.php">Notes</a></li>
                <li class="active"><a href="stock.php">Stock Barang</a></li>
                <li>
                    <a href="javascript:void(0)">Transaksi Data</a>
                    <ul class="collapse">
                        <li><a href="masuk.php">Barang Masuk</a></li>
                        <li><a href="keluar.php">Barang Keluar</a></li>
                    </ul>
                </li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
</div>

<!-- ================= MAIN CONTENT ================= -->
<div class="main-content">

<div class="header-area">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h3>Hi, <?=$_SESSION['user'];?>!</h3>
        </div>
        <div class="col-md-6 text-right">
            <strong>
            <script>
                var d = new Date();
                var days = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
                var months = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
                document.write(days[d.getDay()] + ', ' + d.getDate() + ' ' + months[d.getMonth()] + ' ' + d.getFullYear());
            </script>
            </strong>
        </div>
    </div>
</div>

<div class="page-title-area">
    <h4>Daftar Barang</h4>
</div>

<div class="main-content-inner">
<div class="card">
<div class="card-body">

<button data-toggle="modal" data-target="#myModal" class="btn btn-info mb-3">
Tambah Barang
</button>

<table id="dataTable3" class="display" style="width:100%">
<thead>
<tr>
<th>No</th>
<th>Nama</th>
<th>Jenis</th>
<th>Merk</th>
<th>Ukuran</th>
<th>Stock</th>
<th>Satuan</th>
<th>Lokasi</th>
<th>Aksi</th>
</tr>
</thead>
<tbody>

<?php
$no=1;
$data=mysqli_query($conn,"SELECT * FROM sstock_brg ORDER BY nama ASC");
while($p=mysqli_fetch_array($data)){
?>
<tr>
<td><?=$no++?></td>
<td><?=$p['nama']?></td>
<td><?=$p['jenis']?></td>
<td><?=$p['merk']?></td>
<td><?=$p['ukuran']?></td>
<td><?=$p['stock']?></td>
<td><?=$p['satuan']?></td>
<td><?=$p['lokasi']?></td>
<td>
<button class="btn btn-warning" data-toggle="modal" data-target="#edit<?=$p['idx']?>">Edit</button>
<button class="btn btn-danger" data-toggle="modal" data-target="#del<?=$p['idx']?>">Hapus</button>
</td>
</tr>

<!-- MODAL EDIT -->
<div class="modal fade" id="edit<?=$p['idx']?>">
<div class="modal-dialog">
<div class="modal-content">
<form method="post">
<div class="modal-body">
<input type="hidden" name="idbrg" value="<?=$p['idx']?>">
<input class="form-control mb-2" name="nama" value="<?=$p['nama']?>" required>
<input class="form-control mb-2" name="jenis" value="<?=$p['jenis']?>">
<input class="form-control mb-2" name="merk" value="<?=$p['merk']?>">
<input class="form-control mb-2" name="ukuran" value="<?=$p['ukuran']?>">
<input class="form-control mb-2" name="satuan" value="<?=$p['satuan']?>">
<input class="form-control mb-2" name="lokasi" value="<?=$p['lokasi']?>">
</div>
<div class="modal-footer">
<button class="btn btn-success" name="update">Simpan</button>
</div>
</form>
</div>
</div>
</div>

<!-- MODAL DELETE -->
<div class="modal fade" id="del<?=$p['idx']?>">
<div class="modal-dialog">
<div class="modal-content">
<form method="post">
<div class="modal-body">
<input type="hidden" name="idbrg" value="<?=$p['idx']?>">
Yakin hapus barang ini?
</div>
<div class="modal-footer">
<button class="btn btn-danger" name="hapus">Hapus</button>
</div>
</form>
</div>
</div>
</div>

<?php } ?>

</tbody>
</table>

</div>
</div>
</div>

<footer class="text-center mt-4">
© Logistics System
</footer>

</div>
</div>

<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/metisMenu.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

<script>
$(document).ready(function(){
    $('#dataTable3').DataTable();
});
</script>

</body>
</html>
