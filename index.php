<?php
include "database.php";
$que = mysqli_query($db_conn, "SELECT * FROM un_konfigurasi");
$hsl = mysqli_fetch_array($que);
$timestamp = strtotime($hsl['tgl_pengumuman']);
// menghapus tags html (mencegah serangan jso pada halaman index)
$sekolah = strip_tags($hsl['sekolah']);
$tahun = strip_tags($hsl['tahun']);
$tgl_pengumuman = strip_tags($hsl['tgl_pengumuman']);
//echo $timestamp;
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Pengumuman Kelulusan</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/jasny-bootstrap.min.css" rel="stylesheet">
    <link href="css/kelulusan.css" rel="stylesheet">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <style>
        body {
            font-family: "Times New Roman", Georgia, Serif;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: "Playfair Display";
            letter-spacing: 5px;
        }

        .w3-bar-item:focus {
            outline: none;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="w3-top">
        <div class="w3-bar w3-green w3-padding w3-card" style="letter-spacing:4px;">
            <a href="index.php" class="w3-bar-item w3-button">INFORMASI KELULUSAN
                <?php echo $sekolah; ?>
            </a>
            <!-- Right-sided navbar links. Hide them on small screens -->
            <div class="w3-right w3-hide-small">
                <a href="index.php" class="w3-bar-item w3-button">Home</a>
                <a href="about.php" class="w3-bar-item w3-button">About</a>
            </div>
        </div>
    </div>
    <br>
    <br>

    <div class="container d-flex justify-content-center align-items-center">
        <!-- Use the "d-flex justify-content-center align-items-center" classes to center the image -->
        <img src="logo.png" alt="Logo" style="height: 150px;">
    </div>
    <div class="container">
        <h2>Pengumuman Kelulusan
            <?= $tahun; ?>
        </h2>
        <!-- countdown -->
        <div id="clock" class="lead"></div>
        <div id="xpengumuman">
            <?php
            if (isset($_POST['submit'])) {
                //tampilkan hasil queri jika ada
                $no_ujian = stripslashes($_POST['nomor']);
                $hasil = mysqli_query($db_conn, "SELECT * FROM un_siswa WHERE no_ujian='$no_ujian'");
                if (mysqli_num_rows($hasil) > 0) {
                    $data = mysqli_fetch_array($hasil);
            ?>
                    <table class="table table-bordered">
                        <tr>
                            <td>Nomor Ujian</td>
                            <td>
                                <?= htmlspecialchars($data['no_ujian']); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>NISN</td>
                            <td>
                                <?= htmlspecialchars($data['nisn']); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Nama Siswa</td>
                            <td>
                                <?= htmlspecialchars($data['nama']); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Kompetensi Keahlian</td>
                            <td>
                                <?= htmlspecialchars($data['jurusan']); ?>
                            </td>
                        </tr>
                    </table>
                    <?php
                    if ($data['status'] == 1) {
                        echo '<div class="alert alert-success" role="alert"><strong>SELAMAT !</strong> Anda dinyatakan LULUS.</div>';
                    } else {
                        echo '<div class="alert alert-danger" role="alert"><strong>MAAF !</strong> Anda dinyatakan TIDAK LULUS.</div>';
                    }
                    ?>
                    <?php
                    // Tambahkan tombol cetak
                    ?>
                    <form action="cetak.php" method="post">
                        <input type="hidden" name="no_ujian" value="<?= $data['no_ujian']; ?>">
                        <button class="btn btn-primary" type="submit" name="submit">Cetak</button>
                    </form>
                <?php
                } else {
                    echo 'nomor ujian yang anda inputkan tidak ditemukan! periksa kembali nomor ujian anda.';
                    //tampilkan pop-up dan kembali tampilkan form
                }
            } else {
                //tampilkan form input nomor ujian
                ?>
                <p>Masukkan nomor ujianmu pada form yang disediakan.</p>
                <form method="post">
                    <div class="input-group">
                        <input type="text" name="nomor" class="form-control" data-mask="23-101-999-9" placeholder="Nomor Ujian" required>
                        <span class="input-group-btn">
                            <button class="btn btn-primary" type="submit" name="submit">Periksa!</button>
                        </span>
                    </div>
                </form>
            <?php
            }
            ?>
        </div>
    </div><!-- /.container -->
    <footer class="footer">
        <div class="container">
            <p class="text-muted">&copy;
                <?= $tahun; ?> &middot; Tim IT
                <?= $sekolah; ?>
            </p>
        </div>
    </footer>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery.countdown.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jasny-bootstrap.min.js"></script>
    <script type="text/javascript">
        var skrg = Date.now();
        $('#clock').countdown("<?= $tgl_pengumuman; ?>", {
                elapse: true
            })
            .on('update.countdown', function(event) {
                var $this = $(this);
                if (event.elapsed) {
                    $("#xpengumuman").show();
                    $("#clock").hide();
                } else {
                    $this.html(event.strftime('Pengumuman dapat dilihat: <span>%H Jam %M Menit %S Detik</span> lagi'));
                    $("#xpengumuman").hide();
                }
            });
    </script>
</body>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</html>