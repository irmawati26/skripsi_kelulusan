<?php
session_start();
if (isset($_SESSION['logged']) && !empty($_SESSION['logged'])) {
    include "../database.php";
    include '_header.php';
    if (isset($_POST['submit'])) {
        if (isset($_FILES["file"]) && $_FILES["file"]["size"] > 0) {
            // Validasi Tipe File
            $fileType = strtolower(pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION));
            if ($fileType != 'csv') {
                echo "<script type=\"text/javascript\">alert(\"Invalid File!Please Upload CSV File.\");window.location = \"data.php\"</script>";
                exit;
            }
            // Validasi Ukuran File
            $maxFileSize = 500000; // 500KB
            if ($_FILES["file"]["size"] > $maxFileSize) {
                echo "<script type=\"text/javascript\">alert(\"File size exceeds the allowed limit! Please choose a smaller file.\");window.location = \"data.php\"</script>";
                exit;
            }
            $filename = $_FILES["file"]["tmp_name"];
            $file = fopen($filename, "r");
            mysqli_query($db_conn, "TRUNCATE TABLE un_siswa");
            while (($unData = fgetcsv($file, 10000, ",")) !== FALSE) {
                // Query Insert dengan Prepared Statements
                $stmt = $db_conn->prepare("INSERT INTO un_siswa VALUES(?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("sssssssi", $unData[0], $unData[1], $unData[2], $unData[3], $unData[4]);
                $res = $stmt->execute();
                if (!$res) {
                    echo "<script type=\"text/javascript\">alert(\"Invalid File!Please Upload CSV File.\");window.location = \"data.php\"</script>";
                    exit;
                }
            }
            fclose($file);
            echo "<script type=\"text/javascript\">alert(\"CSV File has been successfully Imported.\");window.location = \"data.php\"</script>";
        } else {
            echo "<script type=\"text/javascript\">alert(\"No file selected! Please choose a CSV file.\");window.location = \"data.php\"</script>";
            exit;
        }
    }
    $qsiswa = mysqli_query($db_conn, "SELECT * FROM un_siswa");
    ?>
    <div class="container">
        <h2>Data Kelulusan</h2>
        <hr>
        <div class="row col-sm-8">
            <form class="form-horizontal well" method="post" action="data_upload.php" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="importCsv" class="col-sm-3 control-label">CSV/Excel File</label>
                    <div class="col-sm-9">
                        <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                            <div class="form-control" data-trigger="fileinput">
                                <i class="glyphicon glyphicon-file fileinput-exists"></i> <span
                                    class="fileinput-filename"></span>
                            </div>
                            <span class="input-group-addon btn btn-default btn-file">
                                <span class="fileinput-new">Pilih file</span>
                                <span class="fileinput-exists">Ganti</span>
                                <input type="file" name="file">
                            </span>
                            <a href="#" class="input-group-addon btn btn-default fileinput-exists"
                                data-dismiss="fileinput">Buang</a>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="downloadCsvTemplate" class="col-sm-3 control-label">Download Template CSV</label>
                    <div class="col-sm-9">
                        <a href="template.csv" download class="btn btn-default">Unduh</a>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-9">
                        <button type="submit" name="submit" class="btn btn-default">Upload</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="container">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No. Ujian</th>
                        <th>NISN</th>
                        <th>Nama Siswa</th>
                        <th>Jurusan</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($qsiswa) > 0) {
                        while ($data = mysqli_fetch_array($qsiswa)) {
                            echo '<tr';
                            if ($data['status'] == 0) {
                                echo ' style="background-color: red;"';
                            }
                            echo '>';
                            echo '<td>' . $data['no_ujian'] . '</td>';
                            echo '<td>' . $data['nisn'] . '</td>';
                            echo '<td>' . $data['nama'] . '</td>';
                            echo '<td>' . $data['jurusan'] . '</td>';
                            echo '<td>';
                            echo ($data['status'] == 1) ? 'Lulus' : '<em>Tidak Lulus</em>';
                            echo '</td>';
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr><td colspan="8"><em>Belum ada data! Segera lakukan upload data.</em></td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php
    include '_footer.php';
} else {
    header('Location: ./login.php');
    exit;
}
?>