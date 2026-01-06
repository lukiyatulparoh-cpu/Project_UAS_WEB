<?php
session_start();

$id   = $_POST['id'] ?? null;
$aksi = $_POST['aksi'] ?? null;

if (!$id || !$aksi || !isset($_SESSION['keranjang'])) {
    header("Location: ../../dashboard_customer.php?menu=cart");
    exit;
}

foreach ($_SESSION['keranjang'] as $index => $item) {

    if ($item['id_produk'] == $id) {

        if ($aksi == 'tambah') {
            $_SESSION['keranjang'][$index]['qty']++;

        } elseif ($aksi == 'kurang') {

            $_SESSION['keranjang'][$index]['qty']--;

            if ($_SESSION['keranjang'][$index]['qty'] <= 0) {
                unset($_SESSION['keranjang'][$index]);
                $_SESSION['keranjang'] = array_values($_SESSION['keranjang']); // rapikan index
            }

        } elseif ($aksi == 'hapus') {

            unset($_SESSION['keranjang'][$index]);
            $_SESSION['keranjang'] = array_values($_SESSION['keranjang']);
        }

        break;
    }
}

header("Location: ../../dashboard_customer.php?menu=cart");
exit;
