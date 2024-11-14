<?php
session_start();
include 'koneksi.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Billiard Billing - Status Ketersediaan Lapangan</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="img/bill.png"/>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles -->
    <link href="css/yozz.min.css" rel="stylesheet">

    <style>
        body {

            background: url('img/nack.avif');
            background-size: 30%;
            color: #fff;
        }
        .container {
            background-color: rgba(0, 0, 0, 0.7);
            border-radius: 10px;
            padding: 30px;
        }
        .table {
            background-color: rgba(255, 255, 255, 0.8);
            color: #000;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .btn-secondary:disabled {
            background-color: #343a40;
        }
    </style>
</head>
<body id="page-top">

<!-- Tambahkan kelas fixed-top pada navbar -->
<<nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
  <div class="container-fluid"> <!-- Ubah dari 'container' ke 'container-fluid' -->
    <a class="navbar-brand js-scroll-trigger" href="#page-top">eightspacebilliard</a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      Menu
      <i class="fa fa-bars"></i>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav text-uppercase ml-auto">
        <li class="nav-item">
          <a class="nav-link js-scroll-trigger" href="#pesan">pesan</a>
        </li>
        <li class="nav-item">
          <a class="nav-link js-scroll-trigger" href="#portfolio">Profil</a>
        </li>
        <li class="nav-item">
          <a class="nav-link js-scroll-trigger" href="#contact">Kontak Kami</a>
        </li>
      </ul>
    </div>
  </div>
</nav>


<!-- Tambahkan CSS agar konten tidak tertutup navbar -->
<style>
  body {
    padding-top: 56px; /* Tambahkan padding agar konten tidak tertutup navbar */
  }
</style>


<!-- Header -->
<header class="masthead">
    <div class="container">
        <div class="intro-text">
            <div class="intro-lead-in">Welcome To</div>
            <div class="intro-heading text-uppercase">eightspacebilliard</div>
            <a class="btn btn-primary btn-xl text-uppercase js-scroll-trigger" href="#pesan">Selengkapnya</a>
        </div>
    </div>
</header>

<!-- Status Ketersediaan Lapangan Section -->
<section id="pesan" class="mt-5">
    <div class="container">
        <h1 class="text-center mb-4">Status Ketersediaan Table</h1>
        <table class="table table-bordered table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>Nama Table</th>
                    <th>Jenis Table</th>
                    <th>Status</th>
                    <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) { echo "<th>Aksi</th>"; } ?>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT id_lapangan, nama_lapangan, jenis_lapangan, status FROM lapangan";
                $result = $mysqli->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row["nama_lapangan"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["jenis_lapangan"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["status"]) . "</td>";
                        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
                            if ($row["status"] == "Tersedia") {
                                echo "<td><a class='btn btn-primary' href='booking.php?id_lapangan=" . $row["id_lapangan"] . "'>Pesan</a></td>";
                            } else {
                                echo "<td><button class='btn btn-secondary' disabled>Tidak Tersedia</button></td>";
                            }
                        }
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4' class='text-center'>Tidak ada data</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <div class="text-center">
            <?php 
            if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
                echo '<p><a class="btn btn-danger" href="logout.php">Logout</a></p>'; 
            } else {
                echo '<p><a class="btn btn-success" href="login_pengguna.php">Login Pengguna</a></p>';
                echo '<p><a class="btn btn-info" href="register.php">Sign Up Pengguna</a></p>';
            }
            ?>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section id="contact">
    <div class="container">
        <h2 class="text-center text-uppercase">Kontak Kami</h2>
        <h3 class="section-subheading text-muted text-center">Silakan menghubungi kami melalui form di bawah ini:</h3>
        <form id="contactForm" name="sentMessage" novalidate="novalidate">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <input class="form-control" id="name" type="text" placeholder="Nama *" required data-validation-required-message="Silahkan masukkan nama Anda terlebih dahulu.">
                    </div>
                    <div class="form-group">
                        <input class="form-control" id="email" type="email" placeholder="Email *" required data-validation-required-message="Silahkan masukkan email Anda terlebih dahulu.">
                    </div>
                    <div class="form-group">
                        <input class="form-control" id="subject" type="text" placeholder="Perihal *" required data-validation-required-message="Silahkan masukkan perihal terlebih dahulu.">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <textarea class="form-control" id="message" placeholder="Isi Pesan *" required data-validation-required-message="Silahkan isi pesan terlebih dahulu."></textarea>
                    </div>
                </div>
                <div class="col-lg-12 text-center">
                    <button id="sendMessageButton" class="btn btn-primary btn-xl text-uppercase" type="submit">Kirim Pesan</button>
                </div>
            </div>
        </form>
    </div>
</section>

<!-- Footer -->
<footer class="footer">
    <div class="container text-center">
        <span class="copyright">Copyright 2024 &copy; All Rights Reserved</span>
        <ul class="list-inline quicklinks mt-3">
            <li class="list-inline-item">
                <a href="https://www.youtube.com/@yustikaslamet9432/videos">Tugas RPL Informatika UNSIL 2024</a>
            </li>
        </ul>
    </div>
</footer>

<!-- Bootstrap JS, Popper.js, and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
