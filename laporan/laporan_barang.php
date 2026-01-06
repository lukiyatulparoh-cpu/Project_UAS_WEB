<?php
require('FPDF/fpdf.php');
include('koneksi2.php');

$pdf = new FPDF('P','mm','A4');
$pdf->AddPage();
$pdf->SetAutoPageBreak(false);

/* ================= HEADER ================= */
$pdf->SetFont('Arial','B',16);
$pdf->Cell(0,10,'LAPORAN DATA PRODUK',0,1,'C');

$pdf->SetFont('Arial','',10);
$pdf->Cell(0,8,'Sistem Informasi Penjualan - Clairmont',0,1,'C');
$pdf->Cell(0,6,'Tanggal Cetak : '.date('d-m-Y'),0,1,'C');
$pdf->Ln(5);

/* ================= HEADER TABEL ================= */
function headerTabel($pdf){
    $pdf->SetFont('Arial','B',10);
    $pdf->SetFillColor(220,220,220);

    $pdf->Cell(10,10,'No',1,0,'C',true);
    $pdf->Cell(25,10,'Kode',1,0,'C',true);
    $pdf->Cell(45,10,'Nama Produk',1,0,'C',true);
    $pdf->Cell(35,10,'Gambar',1,0,'C',true);
    $pdf->Cell(40,10,'Harga',1,0,'C',true);
    $pdf->Cell(25,10,'Stok',1,1,'C',true);

    $pdf->SetFont('Arial','',10);
}

headerTabel($pdf);

/* ================= ISI DATA ================= */
$no = 1;
$tinggi = 30;
$batasBawah = 270;

$query = mysqli_query($koneksi,"SELECT * FROM tb_produk ORDER BY nama_produk");

while($row = mysqli_fetch_assoc($query)){

    if($pdf->GetY() + $tinggi > $batasBawah){
        $pdf->AddPage();
        headerTabel($pdf);
    }

    $pdf->Cell(10,$tinggi,$no++,1,0,'C');
    $pdf->Cell(25,$tinggi,$row['kode_produk'] ?? '-',1);
    $pdf->Cell(45,$tinggi,$row['nama_produk'],1);

    // GAMBAR
    $x = $pdf->GetX();
    $y = $pdf->GetY();
    $pdf->Cell(35,$tinggi,'',1);

    if(!empty($row['gambar']) && file_exists('../uploads/'.$row['gambar'])){
        $pdf->Image(
            '../uploads/'.$row['gambar'],
            $x + 5,
            $y + 2,
            25,
            25
        );
    }

    $pdf->Cell(40,$tinggi,'Rp '.number_format($row['harga'],0,',','.'),1,0,'R');
    $pdf->Cell(25,$tinggi,$row['stok'],1,1,'C');
}

/* ================= FOOTER ================= */
$pdf->Ln(5);
$pdf->SetFont('Arial','I',9);
$pdf->Cell(0,10,'Dicetak melalui Sistem Clairmont',0,0,'R');

/* ================= OUTPUT ================= */
$pdf->Output();
?>
