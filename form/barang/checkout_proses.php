<?php
session_start();
include "../../koneksi2.php";

if (!isset($_SESSION['login'])) {
    die("Anda belum login");
}

if (empty($_SESSION['keranjang'])) {
    die("Keranjang kosong");
}

$id_user = $_SESSION['id_user'];

// 🧩 PASTIKAN CUSTOMER ADA
$qCust = mysqli_query($koneksi, "SELECT id_customer FROM tb_customer WHERE id_user='$id_user'");
$cust  = mysqli_fetch_assoc($qCust);

if (!$cust) {
    // Buat data customer baru
    mysqli_query($koneksi, "
        INSERT INTO tb_customer (id_user, created_at)
        VALUES ('$id_user', NOW())
    ");

    $id_customer = mysqli_insert_id($koneksi);
} else {
    $id_customer = $cust['id_customer'];
}

$pembayaran  = $_POST['pembayaran'];
$tanggal = date('Y-m-d H:i:s');


/* ================= BUAT KODE TRANSAKSI ================= */
$qKode = mysqli_query($koneksi, "SELECT MAX(id_transaksi) AS last_id FROM tb_transaksi");
$data  = mysqli_fetch_assoc($qKode);
$next  = $data['last_id'] + 1;

$kode_transaksi = "TRX-" . str_pad($next, 3, "0", STR_PAD_LEFT);

/* ================= HITUNG TOTAL ================= */
$total_harga = 0;
foreach ($_SESSION['keranjang'] as $item) {
    $total_harga += $item['harga'] * $item['qty'];
}

mysqli_begin_transaction($koneksi);

/* ================= SIMPAN TRANSAKSI ================= */
mysqli_query($koneksi, "
    INSERT INTO tb_transaksi
    (kode_transaksi, id_customer, tanggal_transaksi, total_harga, status_transaksi, metode_pembayaran)
    VALUES
    ('$kode_transaksi','$id_customer','$tanggal','$total_harga','Menunggu Pembayaran','$pembayaran')
");

$id_transaksi = mysqli_insert_id($koneksi);

/* ================= SIMPAN DETAIL + POTONG STOK ================= */
foreach ($_SESSION['keranjang'] as $item) {

    $id_produk = $item['id_produk'];
    $harga     = $item['harga'];
    $qty       = $item['qty'];
    $subtotal  = $harga * $qty;

    // 🔍 CEK STOK
    $cek = mysqli_query($koneksi, "SELECT stok FROM tb_produk WHERE id_produk='$id_produk'");
    $s   = mysqli_fetch_assoc($cek);

    if ($s['stok'] < $qty) {
        mysqli_rollback($koneksi);
        die("Stok produk tidak mencukupi!");
    }

    // 💾 SIMPAN DETAIL TRANSAKSI
    mysqli_query($koneksi, "
        INSERT INTO tb_detail_transaksi
        (id_transaksi, id_produk, harga, jumlah, subtotal)
        VALUES
        ('$id_transaksi','$id_produk','$harga','$qty','$subtotal')
    ");

    // 📉 POTONG STOK PRODUK
    mysqli_query($koneksi, "
        UPDATE tb_produk 
        SET stok = stok - $qty 
        WHERE id_produk = '$id_produk'
    ");
}
