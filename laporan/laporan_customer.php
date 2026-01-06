<?php
require "FPDF/fpdf.php";
include "koneksi2.php";

$pdf = new FPDF('P','mm','A4');
$pdf->AddPage();
$pdf->SetAutoPageBreak(false);

/* ================= HEADER ================= */
$pdf->SetFont('Arial','B',14);
$pdf->Cell(0,10,'LAPORAN DATA CUSTOMER',0,1,'C');

$pdf->SetFont('Arial','',10);
$pdf->Cell(0,8,'Sistem Informasi Penjualan - Clairmont',0,1,'C');
$pdf->Cell(0,6,'Tanggal Cetak : '.date('d-m-Y'),0,1,'C');
$pdf->Ln(5);

/* ================= HEADER TABEL ================= */
function headerCustomer($pdf){
    $pdf->SetFont('Arial','B',10);
    $pdf->SetFillColor(220,220,220);

    $pdf->Cell(10,8,'No',1,0,'C',true);
    $pdf->Cell(25,8,'Kode',1,0,'C',true);
    $pdf->Cell(55,8,'Nama Customer',1,0,'C',true);
    $pdf->Cell(35,8,'No HP',1,0,'C',true);
    $pdf->Cell(65,8,'Alamat',1,1,'C',true);

    $pdf->SetFont('Arial','',10);
}

headerCustomer($pdf);

/* ================= ISI DATA ================= */
$no = 1;
$tinggi = 8;
$batasBawah = 270;

$sql = mysqli_query($koneksi, "SELECT * FROM tb_customer ORDER BY nama_customer");

while($row = mysqli_fetch_assoc($sql)){

    // Page break manual
    if($pdf->GetY() + $tinggi > $batasBawah){
        $pdf->AddPage();
        headerCustomer($pdf);
    }

    $pdf->Cell(10,$tinggi,$no++,1,0,'C');
    $pdf->Cell(25,$tinggi,$row['kode_customer'],1,0);
    $pdf->Cell(55,$tinggi,$row['nama_customer'],1,0);
    $pdf->Cell(35,$tinggi,$row['no_hp'],1,0);
    $pdf->Cell(65,$tinggi,$row['alamat'],1,1);
}

/* ================= FOOTER ================= */
$pdf->Ln(5);
$pdf->SetFont('Arial','I',9);
$pdf->Cell(0,10,'Dicetak melalui Sistem Clairmont',0,0,'R');

/* ================= OUTPUT ================= */
$pdf->Output();
?>
