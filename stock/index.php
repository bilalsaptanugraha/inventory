<!doctype html>
<html class="no-js" lang="en">

<?php 
include '../dbconnect.php';
include 'cek.php';
?>

<head>
    <meta charset="utf-8">
    <link rel="icon" type="image/png" href="../favicon.png">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Logistics</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/themify-icons.css">
    <link rel="stylesheet" href="assets/css/metisMenu.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/css/slicknav.min.css">

    <link rel="stylesheet" href="assets/css/typography.css">
    <link rel="stylesheet" href="assets/css/default-css.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/responsive.css">

    <script src="assets/js/vendor/modernizr-2.8.3.min.js"></script>
</head>

<body>

<div id="preloader">
    <div class="loader"></div>
</div>

<div class="page-container">

    <!-- SIDEBAR -->
    <div class="sidebar-menu">
        <div class="sidebar-header">
            <!-- LOGO DIHAPUS -->
        </div>
        <div class="main-menu">
            <div class="menu-inner">
                <nav>
                    <ul class="metismenu" id="menu">
                        <li class="active"><a href="index.php"><span>Notes</span></a></li>
                        <li><a href="stock.php"><span>Stock Barang</span></a></li>
                        <li>
                            <a href="javascript:void(0)" aria-expanded="true">
                                <span>Transaksi Data</span>
                            </a>
                            <ul class="collapse">
                                <li><a href="masuk.php">Barang Masuk / Kembali</a></li>
                                <li><a href="keluar.php">Barang Keluar</a></li>
                            </ul>
                        </li>
                        <li><a href="logout.php"><span>Logout</span></a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <!-- MAIN CONTENT -->
    <div class="main-content">

        <!-- HEADER -->
        <div class="header-area">
            <div class="row align-items-center">
                <div class="col-md-6 col-sm-8 clearfix">
                    <div class="nav-btn pull-left">
                        <span></span><span></span><span></span>
                    </div>
                    <div class="search-box pull-left">
                        <h2>Hi, <?=$_SESSION['user'];?>!</h2>
                    </div>
                </div>
                <div class="col-md-6 col-sm-4 clearfix">
                    <ul class="notification-area pull-right">
                        <li>
                            <h3>
                                <div class="date">
                                    <script>
                                        var months = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
                                        var myDays = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
                                        var date = new Date();
                                        document.write(
                                            myDays[date.getDay()] + ', ' +
                                            date.getDate() + ' ' +
                                            months[date.getMonth()] + ' ' +
                                            date.getFullYear()
                                        );
                                    </script>
                                </div>
                            </h3>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- CEK STOK HABIS -->
        <?php 
        $cek = mysqli_query($conn,"SELECT * FROM sstock_brg WHERE stock < 1");
        while($s = mysqli_fetch_array($cek)){
            echo "<div class='alert alert-danger alert-dismissible fade show'>
                <button type='button' class='close' data-dismiss='alert'>&times;</button>
                Stok <strong>{$s['nama']} {$s['merk']} {$s['ukuran']}</strong> sudah habis
            </div>";
        }
        ?>

        <!-- PAGE TITLE -->
        <div class="page-title-area">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <div class="breadcrumbs-area clearfix">
                        <h4 class="page-title pull-left">Dashboard</h4>
                        <ul class="breadcrumbs pull-left">
                            <li><a href="index.php">Home</a></li>
                            <li><span>Dashboard</span></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-6 clearfix">
                    <div class="user-profile pull-right">
                        <!-- FOTO DIHAPUS -->
                    </div>
                </div>
            </div>
        </div>

        <!-- CONTENT -->
        <div class="main-content-inner">
            <div class="row mt-5 mb-5">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h2>Notes</h2>

                            <div class="table-responsive mt-4">
                                <table class="table table-bordered table-hover">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>No</th>
                                            <th>Catatan</th>
                                            <th>Ditulis oleh</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <form method="POST" action="notes.php">
                                        <tr>
                                            <td></td>
                                            <td><input type="text" class="form-control" name="konten" required></td>
                                            <td>Saya, <b><?=$_SESSION['user'];?></b></td>
                                            <td><button class="btn btn-primary btn-sm">Add</button></td>
                                        </tr>
                                    </form>

                                    <?php
                                    $q = mysqli_query($conn,"SELECT * FROM notes WHERE status='aktif' ORDER BY id DESC");
                                    $no=1;
                                    while($d=mysqli_fetch_array($q)){
                                        echo "<tr>
                                            <td>$no</td>
                                            <td><b>{$d['contents']}</b></td>
                                            <td>{$d['admin']}</td>
                                            <td>
                                                <form method='POST' action='del.php'>
                                                    <input type='hidden' name='id' value='{$d['id']}'>
                                                    <button class='btn btn-danger btn-sm'>Delete</button>
                                                </form>
                                            </td>
                                        </tr>";
                                        $no++;
                                    }
                                    ?>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- FOOTER -->
    <footer>
        <div class="footer-area">
            <p>&copy; Logistics System</p>
        </div>
    </footer>

</div>

<script src="assets/js/vendor/jquery-2.2.4.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/metisMenu.min.js"></script>
<script src="assets/js/jquery.slimscroll.min.js"></script>
<script src="assets/js/scripts.js"></script>

</body>
</html>
