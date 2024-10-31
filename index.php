<?php
session_start();
include 'koneksi.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Ketersediaan Lapangan</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Status Ketersediaan Lapangan</h1>
        <table class="table table-bordered table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>Nama Lapangan</th>
                    <th>Jenis Lapangan</th>
                    <th>Status</th>
                    <?php 
                    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
                        echo "<th>Aksi</th>";
                    }
                    ?>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT id_lapangan, nama_lapangan, jenis_lapangan, status FROM lapangan";
                $result = $mysqli->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["nama_lapangan"] . "</td>";
                        echo "<td>" . $row["jenis_lapangan"] . "</td>";
                        echo "<td>" . $row["status"] . "</td>";
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
                    echo "<tr><td colspan='4' class='text-center'>0 results</td></tr>";
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
    <!-- Bootstrap JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
