<?php
session_start();
include 'koneksi.php';

// Inisialisasi variabel kosong untuk menyimpan data input dari pengguna
$id_lapangan = $id_pengguna = $username = $tanggal_booking = $jam_mulai = $lama_booking = "";
$tgl_err = $jam_err = $lama_err = "";

// Periksa apakah metode POST digunakan untuk mengirimkan data form
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id_lapangan = trim($_POST["id_lapangan"]);
    $id_pengguna = trim($_POST["id_pengguna"]);
    $username = trim($_POST["username"]);

    // Validasi tanggal booking
    if (empty(trim($_POST["tanggal_booking"]))) {
        $tgl_err = "Please enter tanggal.";
    } else {
        $tanggal_booking = trim($_POST["tanggal_booking"]);
    }

    // Validasi jam mulai
    if (empty(trim($_POST["jam_mulai"]))) {
        $jam_err = "Please enter jam mulai.";
    } else {
        $jam_mulai = trim($_POST["jam_mulai"]);
    }

    // Validasi lama booking
    if (empty(trim($_POST["lama_booking"]))) {
        $lama_err = "Please enter lama booking.";
    } else {
        $lama_booking = trim($_POST["lama_booking"]);
    }

    // Periksa apakah tidak ada kesalahan validasi sebelum menambahkan booking baru ke database
    if (empty($tgl_err) && empty($jam_err) && empty($lama_err)) {
        // SQL statement untuk menambahkan booking baru ke database
        $sql = "INSERT INTO booking (id_lapangan, id_pengguna, username, tanggal_booking, jam_mulai, lama_booking) VALUES (?, ?, ?, ?, ?, ?)";
        
        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("iisssi", $param_idlapangan, $param_idpengguna, $param_username, $param_tanggalbooking, $param_jammulai, $param_lamabooking);
            
            // Atur parameter
            $param_idlapangan = $id_lapangan;
            $param_idpengguna = $id_pengguna;
            $param_username = $username;
            $param_tanggalbooking = $tanggal_booking;
            $param_jammulai = $jam_mulai;
            $param_lamabooking = $lama_booking;
            
            // Eksekusi statement
            if ($stmt->execute()) {
                // Update status lapangan
                $sql_update = "UPDATE Lapangan SET status = 'Dipesan' WHERE id_lapangan = ?";
                if ($stmt_update = $mysqli->prepare($sql_update)) {
                    $stmt_update->bind_param("i", $id_lapangan);
                    $stmt_update->execute();
                    $stmt_update->close();
                } else {
                    echo "Oops! Something went wrong with updating the status. Please try again later.";
                }

                echo "Lapangan berhasil di pesan.";
                // Redirect ke halaman setelah pendaftaran berhasil
                header("location: index.php");
                exit();
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Tutup statement
            $stmt->close();
        }
    }

    // Tutup koneksi
    $mysqli->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pemesanan Lapangan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <center>
    <h1 class="mt-3 mb-5">
     Form Booking Lapangan</h1>
    <div class="col-4">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <!-- Input Data Hilang dari tampilan user -->
        <input type="hidden" name="id_lapangan" id="id_lapangan" value="<?php echo $_GET['id_lapangan']; ?>">
        <input type="hidden" name="id_pengguna" id="id_pengguna" value="<?php echo $_SESSION['id_pengguna']; ?>">

        <label for="username">Username:</label>
        <input class="form-control" type="text" id="username" name="username" value="<?PHP echo $_SESSION['username']; ?>" required readonly><br>

        <div <?php echo (!empty($tgl_err)) ? 'has-error' : ''; ?>>
        <label for="tanggal_booking">Tanggal Booking:</label>
        <input class="form-control" type="date" id="tanggal_booking" name="tanggal_booking" value="<?php echo $tanggal_booking; ?>" required><br>
        <span class="help-block"><?php echo $tgl_err; ?></span>
        </div>

        <div <?php echo (!empty($jam_err)) ? 'has-error' : ''; ?>>
        <label for="jam_mulai">Jam Mulai:</label>
        <input class="form-control" type="time" id="jam_mulai" name="jam_mulai" value="<?php echo $jam_mulai; ?>" required><br>
        <span class="help-block"><?php echo $jam_err; ?></span>
        </div>

        <div <?php echo (!empty($lama_err)) ? 'has-error' : ''; ?>>
        <label for="lama_booking">Lama Booking (jam):</label>
        <select class="form-control" id="lama_booking" name="lama_booking" value="<?php echo $lama_booking; ?>" required>
            <option value="1">1 Jam</option>
            <option value="2">2 Jam</option>
            <option value="3">3 Jam</option>
            <option value="1">4 Jam</option>
            <option value="2">5 Jam</option>
            <option value="3">6 Jam</option>
            <!-- Tambahkan opsi lainnya sesuai kebutuhan -->
        </select><br>
        <span class="help-block"><?php echo $lama_err; ?></span>


        <button class="btn btn-primary" type="submit">PESAN </button>
        </center>
    </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
