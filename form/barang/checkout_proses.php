<?php
session_start();
include "../../koneksi2.php";

/* ================== VALIDASI LOGIN ================== */
if (!isset($_SESSION['login'])) {
    die("Anda belum login");
}

if (empty($_SESSION['keranjang'])) {
    die("Keranjang kosong");
}

$id_user = $_SESSION['id_user'];

/* ================== PASTIKAN CUSTOMER ADA ================== */
$qCust = mysqli_query($koneksi, "SELECT * FROM tb_customer WHERE id_user='$id_user'");
$cust  = mysqli_fetch_assoc($qCust);

if (!$cust) {
    mysqli_query($koneksi, "
        INSERT INTO tb_customer (id_user, created_at)
        VALUES ('$id_user', NOW())
    ");
    $id_customer = mysqli_insert_id($koneksi);
} else {
    $id_customer = $cust['id_customer'];
}

/* ================== UPDATE DATA CUSTOMER ================== */
$no_hp  = mysqli_real_escape_string($koneksi, $_POST['no_hp']);
$alamat = mysqli_real_escape_string($koneksi, $_POST['alamat']);

mysqli_query($koneksi, "
    UPDATE tb_customer 
    SET no_hp='$no_hp', alamat='$alamat'
    WHERE id_customer='$id_customer'
");

/* ================== DATA TRANSAKSI ================== */
$pembayaran = $_POST['pembayaran'];
$tanggal    = date('Y-m-d H:i:s');
$status     = "pending";

/* ================== HANDLE BUKTI TRANSFER ================== */
$bukti = NULL;

if ($pembayaran == "Transfer") {

    if (!isset($_FILES['bukti']) || $_FILES['bukti']['name'] == '') {
        die("Bukti transfer wajib diupload!");
    }

    $ext = pathinfo($_FILES['bukti']['name'], PATHINFO_EXTENSION);
    $bukti = "bukti_" . time() . "_" . rand(100,999) . "." . $ext;

    move_uploaded_file($_FILES['bukti']['tmp_name'], "../../uploads/bukti/" . $bukti);
}

/* ================== BUAT KODE TRANSAKSI ================== */
$qKode = mysqli_query($koneksi, "SELECT MAX(id_transaksi) AS last_id FROM tb_transaksi");
$data  = mysqli_fetch_assoc($qKode);
$next  = $data['last_id'] + 1;

$kode_transaksi = "TRX-" . str_pad($next, 4, "0", STR_PAD_LEFT);

/* ================== HITUNG TOTAL ================== */
$total_harga = 0;
foreach ($_SESSION['keranjang'] as $item) {
    $total_harga += $item['harga'] * $item['qty'];
}

/* ================== TRANSAKSI DATABASE ================== */
mysqli_begin_transaction($koneksi);

/* ================== SIMPAN TRANSAKSI ================== */
mysqli_query($koneksi, "
    INSERT INTO tb_transaksi
    (kode_transaksi, id_customer, tanggal_transaksi, total_harga, status_transaksi, metode_pembayaran, bukti_transfer)
    VALUES
    ('$kode_transaksi','$id_customer','$tanggal','$total_harga','$status','$pembayaran','$bukti')
");

$id_transaksi = mysqli_insert_id($koneksi);

/* ================== DETAIL TRANSAKSI + UPDATE STOK ================== */
foreach ($_SESSION['keranjang'] as $item) {

    $id_produk = $item['id_produk'];
    $harga     = $item['harga'];
    $qty       = $item['qty'];
    $subtotal  = $harga * $qty;

    $cek = mysqli_query($koneksi, "SELECT stok FROM tb_produk WHERE id_produk='$id_produk'");
    $s   = mysqli_fetch_assoc($cek);

    if ($s['stok'] < $qty) {
        mysqli_rollback($koneksi);
        die("Stok produk tidak mencukupi!");
    }

    mysqli_query($koneksi, "
        INSERT INTO tb_detail_transaksi
        (id_transaksi, id_produk, harga, jumlah, subtotal)
        VALUES
        ('$id_transaksi','$id_produk','$harga','$qty','$subtotal')
    ");

    mysqli_query($koneksi, "
        UPDATE tb_produk 
        SET stok = stok - $qty 
        WHERE id_produk = '$id_produk'
    ");
}

/* ================== SELESAI ================== */
mysqli_commit($koneksi);
unset($_SESSION['keranjang']);

header("Location: ../../dashboard_customer.php?menu=pesanan&status=sukses");
exit;
