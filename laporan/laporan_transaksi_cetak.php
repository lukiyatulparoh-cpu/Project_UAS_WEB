<?php
include "koneksi2.php";
require "FPDF/fpdf.php";

$pdf = new FPDF('L','mm','A4');
$pdf->AddPage();

/* ================= HEADER ================= */
$pdf->SetFont('Arial','B',16);
$pdf->Cell(0,10,'LAPORAN TRANSAKSI PENJUALAN',0,1,'C');

$pdf->SetFont('Arial','',11);
$pdf->Cell(0,8,'Sistem Penjualan Clairmont',0,1,'C');
$pdf->Cell(0,8,'Periode: '.$_POST['tgl_awal'].' s/d '.$_POST['tgl_akhir'],0,1,'C');
$pdf->Ln(5);

/* ================= HEADER TABEL ================= */
$pdf->SetFont('Arial','B',10);
$pdf->SetFillColor(220,220,220);

$pdf->Cell(28,10,'Tanggal',1,0,'C',true);
$pdf->Cell(45,10,'Customer',1,0,'C',true);
$pdf->Cell(28,10,'Kode Produk',1,0,'C',true);
$pdf->Cell(55,10,'Nama Produk',1,0,'C',true);
$pdf->Cell(18,10,'Qty',1,0,'C',true);
$pdf->Cell(28,10,'Harga',1,0,'C',true);
$pdf->Cell(28,10,'Total',1,0,'C',true);
$pdf->Cell(30,10,'Total Bayar',1,1,'C',true);

/* ================= DATA ================= */
$pdf->SetFont('Arial','',10);
$total_keseluruhan = 0;

$query = mysqli_query($koneksi,"
    SELECT * FROM v_laporan_transaksi_clairmont
    WHERE tanggal BETWEEN '$_POST[tgl_awal]' AND '$_POST[tgl_akhir]'
    ORDER BY tanggal, id_transaksi
");

while($row = mysqli_fetch_assoc($query)){
    $total_keseluruhan += $row['total'];

    $pdf->Cell(28,10,date('d-m-Y',strtotime($row['tanggal'])),1,0,'C');
    $pdf->Cell(45,10,$row['nama_customer'],1,0);
    $pdf->Cell(28,10,$row['id_produk'],1,0,'C');
    $pdf->Cell(55,10,$row['nama_produk'],1,0);
    $pdf->Cell(18,10,$row['jumlah'],1,0,'C');
    $pdf->Cell(28,10,'Rp '.number_format($row['harga'],0,',','.'),1,0,'R');
    $pdf->Cell(28,10,'Rp '.number_format($row['total'],0,',','.'),1,0,'R');
    $pdf->Cell(30,10,'Rp '.number_format($row['total'],0,',','.'),1,1,'R');
}

/* ================= TOTAL ================= */
$pdf->SetFont('Arial','B',11);
$pdf->Cell(202,10,'TOTAL KESELURUHAN',1,0,'C');
$pdf->Cell(58,10,'Rp '.number_format($total_keseluruhan,0,',','.'),1,1,'R');

/* ================= FOOTER ================= */
$pdf->Ln(5);
$pdf->SetFont('Arial','I',9);
$pdf->Cell(0,10,'Dicetak oleh Sistem Clairmont',0,0,'R');

$pdf->Output();
?>
