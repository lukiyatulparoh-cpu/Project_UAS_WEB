<?php
require('FPDF/fpdf.php');
// Membuat objek PDF
$pdf = new FPDF();
$pdf->AddPage();
// Header PDF
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'Laporan Penjualan', 0, 1, 'C');
// Isi PDF
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(50, 10, 'Nama Barang',1,0,'C');
$pdf->Cell(40, 10, 'Jumlah',1,0,'C');
$pdf->Cell(40, 10, 'Harga',1,0,'C');
$pdf->Cell(50, 10, 'Total',1,0,'C');
$pdf->Ln();
$harga1 = 7000000;
$total1 = 3 * $harga1;
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(50, 10, 'Laptop',1);
$pdf->Cell(40, 10, '3',1,0,'C');
$pdf->Cell(40, 10, number_format($harga1),1,0,'R');
$pdf->Cell(50, 10, number_format($total1),1,0,'R');
$pdf->Ln();
$harga2 = 50000;
$total2 = 1 * $harga2;
$pdf->Cell(50, 10, 'Printer',1);
$pdf->Cell(40, 10, '1',1,0,'C');
$pdf->Cell(40, 10, number_format($harga2),1,0,'R');
$pdf->Cell(50, 10, number_format($total2),1,0,'R');
$pdf->Ln();

$total_keseluruhan = $total1 + $total2;

$pdf->Ln(0);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(130, 10, 'TOTAL HARGA KESELURUHAN', 1, 0, 'R');
$pdf->Cell(50, 10, number_format($total_keseluruhan), 1, 1, 'R');

$pdf->Output();
?>