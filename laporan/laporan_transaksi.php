<?php
require "FPDF/fpdf.php";
include "koneksi2.php";

$pdf = new FPDF('P','mm','A4');
$pdf->AddPage();
$pdf->SetAutoPageBreak(false);

/* ================= HEADER ================= */
$pdf->SetFont('Arial','B',16);
$pdf->Cell(0,10,'LAPORAN DATA TRANSAKSI',0,1,'C');

$pdf->SetFont('Arial','',10);
$pdf->Cell(0,8,'Sistem Informasi Penjualan - Clairmont',0,1,'C');
$pdf->Cell(0,6,'Tanggal Cetak : '.date('d-m-Y'),0,1,'C');
$pdf->Ln(5);

/* ================= HEADER TABEL ================= */
function headerTabel($pdf){
    $pdf->SetFont('Arial','B',10);
    $pdf->SetFillColor(220,220,220);

    $pdf->Cell(20,10,'ID',1,0,'C',true);
    $pdf->Cell(26,10,'Tanggal',1,0,'C',true);
    $pdf->Cell(38,10,'Customer',1,0,'C',true);
    $pdf->Cell(38,10,'Produk',1,0,'C',true);
    $pdf->Cell(24,10,'Harga',1,0,'C',true);
    $pdf->Cell(16,10,'Qty',1,0,'C',true);
    $pdf->Cell(28,10,'Total',1,1,'C',true);

    $pdf->SetFont('Arial','',10);
}

headerTabel($pdf);

/* ================= ISI DATA ================= */
$batasBawah = 270;
$tinggi = 10;

$sql = mysqli_query($koneksi, "
    SELECT t.id_transaksi,
           t.tanggal,
           c.nama_customer,
           b.nama AS nama_barang,
           b.harga,
           t.jumlah,
           (b.harga * t.jumlah) AS total
    FROM tbl_transaksi t
    JOIN tbl_customer c ON t.kode_customer = c.kode_customer
    JOIN tbl_barang b ON t.kode_barang = b.kode
    ORDER BY t.tanggal DESC
");

while ($row = mysqli_fetch_assoc($sql)) {

    if($pdf->GetY() + $tinggi > $batasBawah){
        $pdf->AddPage();
        headerTabel($pdf);
    }

    $pdf->Cell(20,$tinggi,$row['id_transaksi'],1,0,'C');
    $pdf->Cell(26,$tinggi,date('d-m-Y', strtotime($row['tanggal'])),1,0,'C');
    $pdf->Cell(38,$tinggi,$row['nama_customer'],1,0);
    $pdf->Cell(38,$tinggi,$row['nama_barang'],1,0);
    $pdf->Cell(24,$tinggi,'Rp '.number_format($row['harga'],0,',','.'),1,0,'R');
    $pdf->Cell(16,$tinggi,$row['jumlah'],1,0,'C');
    $pdf->Cell(28,$tinggi,'Rp '.number_format($row['total'],0,',','.'),1,1,'R');
}

/* ================= FOOTER ================= */
$pdf->Ln(5);
$pdf->SetFont('Arial','I',9);
$pdf->Cell(0,10,'Dicetak melalui Sistem Clairmont',0,0,'R');

/* ================= OUTPUT ================= */
$pdf->Output();
?>
