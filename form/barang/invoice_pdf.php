<?php
ob_start();
include "koneksi2.php";
require "FPDF/fpdf.php";

$id = $_GET['id'] ?? '';

$q = mysqli_query($koneksi, "
    SELECT * FROM tb_transaksi 
    WHERE id_transaksi='$id'
");
$data = mysqli_fetch_assoc($q);

if (!$data) {
    die("Transaksi tidak ditemukan");
}

$kodeInvoice = 'INV-' . str_pad($data['id_transaksi'], 5, '0', STR_PAD_LEFT);

$pdf = new FPDF('P','mm','A4');
$pdf->AddPage();

/* ================= HEADER ================= */
$pdf->Image('../../dist/assets/img/logo.jpeg',10,8,25);
$pdf->SetFont('Arial','B',18);
$pdf->Cell(0,10,'CLAIRMONT DESSERT',0,1,'C');

$pdf->SetFont('Arial','',11);
$pdf->Cell(0,6,'Premium Cakes & Desserts',0,1,'C');
$pdf->Cell(0,6,'Jl. Sweet Avenue No. 88 | 0812-3456-7890',0,1,'C');

$pdf->Ln(5);
$pdf->Line(10,35,200,35);
$pdf->Ln(10);

/* ================= INFO TRANSAKSI ================= */
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,8,'INVOICE',0,1);

$pdf->SetFont('Arial','',11);
$pdf->Cell(50,7,'Kode Invoice');
$pdf->Cell(5,7,':');
$pdf->Cell(60,7,$kodeInvoice);
$pdf->Ln();

$pdf->Cell(50,7,'Tanggal');
$pdf->Cell(5,7,':');
$pdf->Cell(60,7,date('d M Y', strtotime($data['tanggal_transaksi'])));
$pdf->Ln();

$pdf->Cell(50,7,'Status');
$pdf->Cell(5,7,':');
$pdf->Cell(60,7,strtoupper($data['status_transaksi']));
$pdf->Ln();

$pdf->Cell(50,7,'Total Bayar');
$pdf->Cell(5,7,':');
$pdf->Cell(60,7,'Rp '.number_format($data['total_harga']));
$pdf->Ln(10);

/* ================= TABEL PRODUK ================= */
$pdf->SetFont('Arial','B',11);
$pdf->SetFillColor(240,240,240);
$pdf->Cell(10,8,'No',1,0,'C',true);
$pdf->Cell(70,8,'Produk',1,0,'C',true);
$pdf->Cell(30,8,'Harga',1,0,'C',true);
$pdf->Cell(20,8,'Qty',1,0,'C',true);
$pdf->Cell(35,8,'Subtotal',1,1,'C',true);

$pdf->SetFont('Arial','',11);

$detail = mysqli_query($koneksi, "
    SELECT d.*, p.nama_produk
    FROM tb_detail_transaksi d
    JOIN tb_produk p ON d.id_produk = p.id_produk
    WHERE d.id_transaksi='$id'
");

$no = 1;
while ($row = mysqli_fetch_assoc($detail)) {
    $pdf->Cell(10,8,$no++,1,0,'C');
    $pdf->Cell(70,8,$row['nama_produk'],1);
    $pdf->Cell(30,8,'Rp '.number_format($row['harga']),1,0,'R');
    $pdf->Cell(20,8,$row['jumlah'],1,0,'C');
    $pdf->Cell(35,8,'Rp '.number_format($row['subtotal']),1,1,'R');
}

/* ================= TOTAL ================= */
$pdf->SetFont('Arial','B',11);
$pdf->Cell(130,10,'TOTAL',1,0,'R');
$pdf->Cell(35,10,'Rp '.number_format($data['total_harga']),1,1,'R');

$pdf->Ln(15);

/* ================= FOOTER ================= */
$pdf->SetFont('Arial','I',10);
$pdf->Cell(0,8,'Terima kasih telah berbelanja di Clairmont Dessert',0,1,'C');
$pdf->Cell(0,8,'Sweet moments, delivered with love.',0,1,'C');

ob_end_clean();
$pdf->Output();
