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
    <br>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Identitas Satuan Pendidikan</h5>
            <table class="table table-bordered table-sm">
                <tr>
                    <th>Nama</th>
                    <td>MAS NURUL IKHLAS</td>
                </tr>
                <tr>
                    <th>NPSN</th>
                    <td>60105602</td>
                </tr>
                <tr>
                    <th>Alamat</th>
                    <td>JL. H.ABDULLAH SIYAUTA AIR BESAR AHURU AMBON</td>
                </tr>
                <tr>
                    <th>Kode Pos</th>
                    <td><!-- Insert Kode Pos here --></td>
                </tr>
                <tr>
                    <th>Desa / Kelurahan</th>
                    <td>Batu Merah</td>
                </tr>
                <tr>
                    <th>Kecamatan / Kota (LN)</th>
                    <td>Kec. Sirimau</td>
                </tr>
                <tr>
                    <th>Kab. / Kota / Negara (LN)</th>
                    <td>Kota Ambon</td>
                </tr>
                <tr>
                    <th>Provinsi / Luar Negeri</th>
                    <td>Maluku</td>
                </tr>
                <tr>
                    <th>Status Sekolah</th>
                    <td>swasta</td>
                </tr>
                <tr>
                    <th>Waktu Penyelenggaraan</th>
                    <td>- / - hari</td>
                </tr>
                <tr>
                    <th>Jenjang Pendidikan</th>
                    <td>MA</td>
                </tr>
            </table>
        </div>
    </div>

    <br>
    <br>
    <br>
    <div class="w3-padding w3-card">
        <h5 class="card-title">Lokasi Sekolah</h5>
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3981.54474540928!2d128.21712457483747!3d-3.6904790962835046!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2d6ce99b0fdd975f%3A0x6b16c550f8e2b444!2sMIS%20Nurul%20Ikhlas%20Ambon!5e0!3m2!1sid!2sid!4v1689992067962!5m2!1sid!2sid"
            width="1675" height="500" style="border:0;" allowfullscreen="" loading="lazy"
            referrerpolicy="no-referrer-when-downgrade" class="mx-auto"></iframe>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</html>