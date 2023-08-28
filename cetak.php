<?php
include "database.php";
require('fpdf/fpdf.php');
if (isset($_POST['submit'])) {
    $no_ujian = $_POST['no_ujian'];
    $hasil = mysqli_query($db_conn, "SELECT * FROM un_siswa WHERE no_ujian='$no_ujian'");
    if (mysqli_num_rows($hasil) > 0) {
        $data = mysqli_fetch_array($hasil);
        class PDF extends FPDF
        {
            function Header()
            {
                $this->SetFont('Arial', 'B', 14);
                $logoWidth = 30; // Lebar logo.png
                $titleWidth = $this->GetPageWidth() - ($logoWidth + 30); // Lebar judul
                // Posisi X awal
                $initialX = $this->GetX();
                // Tabel Logo, Judul, dan Alamat Sekolah
                $this->Cell($logoWidth, 5, $this->Image('logo.png', $initialX + 5, $this->GetY() + 1, $logoWidth), 0, 0, 'L'); // Menampilkan logo dan mengatur lebar cell
                $this->SetFont('Arial', 'B', 12);
                $this->Cell($this->GetPageWidth(), 7, '', 0, 1, 'C'); // Menampilkan alamat sekolah di bawah judul
                $this->SetFont('Arial', 'B', 12);
                $this->Cell($this->GetPageWidth(), 7, 'PENGUMUMAN KELULUSAN', 0, 1, 'C'); // Menampilkan alamat sekolah di bawah judul
                $this->SetFont('Arial', 'B', 12);
                $this->Cell($this->GetPageWidth(), 7, 'MA NURUL IKHLAS AMBON', 0, 1, 'C'); // Menampilkan alamat sekolah di bawah judul
                $this->SetFont('Arial', '', 10);
                $this->Cell($this->GetPageWidth(), 7, 'Jln. H.Abdullah Air Besar, Batu Merah, Kec. Sirimau, Kota Ambon, Maluku', 0, 1, 'C'); // Menampilkan alamat sekolah di bawah judul
                $this->Ln(5); // Jarak antara logo dan judul
                $this->Line($this->GetX(), $this->GetY(), $this->GetPageWidth() - $this->GetX(), $this->GetY());
                $this->Ln(5);
            }
            function Content($data)
            {
                $this->SetFont('Arial', '', 12);
                // Posisi Tabel Informasi Siswa di Tengah Kertas
                $this->SetXY(($this->GetPageWidth() - 160) / 2.5, $this->GetY());
                // Tabel Informasi Siswa
                $this->Cell(40, 10, 'Nomor Ujian', 1, 0, 'L');
                $this->Cell(120, 10, $data['no_ujian'], 1, 1, 'L');
                $this->Cell(40, 10, 'NISN', 1, 0, 'L');
                $this->Cell(120, 10, $data['nisn'], 1, 1, 'L');
                $this->Cell(40, 10, 'Nama Siswa', 1, 0, 'L');
                $this->Cell(120, 10, $data['nama'], 1, 1, 'L');
                $this->Cell(40, 10, 'Jurusan', 1, 0, 'L');
                $this->Cell(120, 10, $data['jurusan'], 1, 1, 'L');
                $this->Ln(5);
                // Posisi Status Kelulusan di Tengah Kertas
                $this->SetXY(($this->GetPageWidth() - 120) / 2, $this->GetY() + 5);
                // Status Kelulusan
                $this->SetFont('Arial', 'B', 12);
                $this->Cell(0, 10, '', 0, 1, 'C');
                $this->Ln(5);
                // Status Kelulusan
                $this->SetFont('Arial', 'B', 12);
                $this->Cell(0, 10, 'Status Kelulusan', 0, 1, 'C');
                $this->Ln(5);
                if ($data['status'] == 1) {
                    $status = 'SELAMAT! Anda dinyatakan LULUS.';
                    $textColor = array(0, 0, 255); // Warna teks biru (RGB)
                    $fontStyle = 'B'; // Teks bold
                    $this->SetTextColor($textColor[0], $textColor[1], $textColor[2]);
                    $this->SetFont('Arial', $fontStyle, 12);
                    $this->Cell(0, 10, $status, 0, 1, 'C');
                } else {
                    $status = 'MAAF! Anda dinyatakan TIDAK LULUS.';
                    $textColor = array(255, 0, 0); // Warna teks merah (RGB)
                    $fontStyle = 'B'; // Teks bold
                    $this->SetTextColor($textColor[0], $textColor[1], $textColor[2]);
                    $this->SetFont('Arial', $fontStyle, 12);
                    $this->Cell(0, 10, $status, 0, 1, 'C');
                }
                // Posisi Tanda Tangan di Tengah Kertas
                $this->SetXY(($this->GetPageWidth() - 150) / 2, $this->GetY());
                // Tanda Tangan
                $this->SetFont('Arial', 'B', 12);
                $this->SetTextColor(0, 0, 0); // Set warna teks menjadi hitam
                $this->Cell(150, 10, 'Tanda Tangan', 0, 1, 'C');
                $this->Cell(0, 10, 'Ambon, ' . date('d/m/Y'), 0, 0, 'C');
                $this->Ln(10);
                // Posisi Tanda Tangan di Tengah Kertas
                $this->SetXY(($this->GetPageWidth() - 30) / 2, $this->GetY());
                // Gambar Tanda Tangan
                $this->Image('ttd.png', $this->GetX(), $this->GetY(), 30);
                $this->Ln(30);
                // Text Tanda Tangan
                $this->SetFont('Arial', '', 12);
                $this->Cell(0, 10, 'HAYATI, S.Pd', 0, 1, 'C');
                // Posisi Alamat di Tengah Kertas
                $this->SetXY(($this->GetPageWidth() - 150) / 2, $this->GetY() + 20);
            }
            function Footer()
            {
                $this->SetY(-15);
                $this->SetFont('Arial', 'I', 8);
                $this->Cell(0, 10, 'Dokumen ini dicetak pada ' . date('d/m/Y H:i:s'), 0, 0, 'R');
            }
        }
        $pdf = new PDF('P', 'mm', 'A4'); // Mengatur orientasi halaman menjadi potret dan ukuran kertas A4 (210mm x 297mm)
        $pdf->SetAutoPageBreak(true, 20); // Mengatur batas akhir halaman dengan margin bawah 20mm
        $pdf->SetMargins(20, 20, 20); // Mengatur batas tepi kertas kiri, atas, kanan, dan bawah
        $pdf->AddPage();
        $pdf->Content($data);
        ob_end_clean();
        $pdf->Output('I', 'Pengumuman Kelulusan.pdf');
        exit();
    } else {
        echo 'Nomor ujian yang Anda inputkan tidak ditemukan! Periksa kembali nomor ujian Anda.';
    }
} else {
    echo 'Akses langsung ke halaman ini tidak diizinkan.';
}
?>