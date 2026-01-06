<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include "../../koneksi2.php";

/* ================= AMBIL ID PRODUK ================= */
$id = $_POST['id_produk'] ?? '';

if ($id == '') {
    header("Location: ../../dashboard_customer.php?menu=produk");
    exit;
}

/* ================= AMBIL DATA PRODUK ================= */
$q = mysqli_query($koneksi, "SELECT * FROM tb_produk WHERE id_produk='$id'");
$p = mysqli_fetch_assoc($q);

if (!$p) {
    header("Location: ../../dashboard_customer.php?menu=produk");
    exit;
}

/* ================= INIT KERANJANG ================= */
if (!isset($_SESSION['keranjang'])) {
    $_SESSION['keranjang'] = [];
}

/* ================= TAMBAH / UPDATE QTY ================= */
if (isset($_SESSION['keranjang'][$id])) {
    $_SESSION['keranjang'][$id]['qty'] += 1;
} else {
    $_SESSION['keranjang'][$id] = [
        'id_produk'   => $p['id_produk'],
        'nama_produk' => $p['nama_produk'],
        'harga'       => $p['harga'],
        'gambar'      => $p['gambar'],
        'qty'         => 1
    ];
}

/* ================= REDIRECT KE CART ================= */
header("Location: ../../dashboard_customer.php?menu=cart");
exit;
