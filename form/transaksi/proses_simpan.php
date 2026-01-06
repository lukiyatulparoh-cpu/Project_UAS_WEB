<?php
include "../../koneksi2.php";

$id_transaksi = $_POST['id_transaksi'];
$tanggal      = $_POST['tanggal'];
$id_customer  = $_POST['id_customer'];
$id_produk    = $_POST['id_produk'];
$jumlah       = $_POST['jumlah'];

mysqli_begin_transaction($koneksi);

/* ================= CEK STOK ================= */
$q = mysqli_query($koneksi, "
    SELECT stok, harga FROM tb_produk 
    WHERE id_produk = '$id_produk'
");
$produk = mysqli_fetch_assoc($q);

if ($produk['stok'] < $jumlah) {
    mysqli_rollback($koneksi);
    echo "<script>
            alert('Stok tidak mencukupi');
            window.history.back();
          </script>";
    exit;
}

$subtotal = $jumlah * $produk['harga'];

/* ================= EDIT MODE ================= */
if (isset($_POST['edit_mode'])) {

    // Ambil jumlah lama
    $qOld = mysqli_query($koneksi, "
        SELECT id_produk, jumlah 
        FROM tb_detail_transaksi
        WHERE id_transaksi = '$id_transaksi'
    ");
    $old = mysqli_fetch_assoc($qOld);

    // Kembalikan stok lama
    mysqli_query($koneksi, "
        UPDATE tb_produk 
        SET stok = stok + {$old['jumlah']}
        WHERE id_produk = '{$old['id_produk']}'
    ");

    // Update transaksi utama
    $sql1 = mysqli_query($koneksi, "
        UPDATE tb_transaksi SET
            tanggal_transaksi = '$tanggal',
            id_customer       = '$id_customer'
        WHERE id_transaksi = '$id_transaksi'
    ");

    // Update detail transaksi
    $sql2 = mysqli_query($koneksi, "
        UPDATE tb_detail_transaksi SET
            id_produk = '$id_produk',
            jumlah    = '$jumlah',
            subtotal  = '$subtotal'
        WHERE id_transaksi = '$id_transaksi'
    ");

    // Kurangi stok baru
    $sql3 = mysqli_query($koneksi, "
        UPDATE tb_produk
        SET stok = stok - $jumlah
        WHERE id_produk = '$id_produk'
    ");

/* ================= TRANSAKSI BARU ================= */
} else {

    // Insert transaksi utama
    $sql1 = mysqli_query($koneksi, "
        INSERT INTO tb_transaksi 
        (id_transaksi, tanggal_transaksi, id_customer)
        VALUES
        ('$id_transaksi', '$tanggal', '$id_customer')
    ");

    // Insert detail transaksi
    $sql2 = mysqli_query($koneksi, "
        INSERT INTO tb_detail_transaksi
        (id_transaksi, id_produk, jumlah, subtotal)
        VALUES
        ('$id_transaksi', '$id_produk', '$jumlah', '$subtotal')
    ");

    // Kurangi stok
    $sql3 = mysqli_query($koneksi, "
        UPDATE tb_produk
        SET stok = stok - $jumlah
        WHERE id_produk = '$id_produk'
    ");
}

/* ================= COMMIT / ROLLBACK ================= */
if ($sql1 && $sql2 && $sql3) {
    mysqli_commit($koneksi);
    header("Location: ../../dashboard_admin.php?menu=transaksi");
    exit;
} else {
    mysqli_rollback($koneksi);
    echo "❌ Gagal menyimpan transaksi";
}
?>
