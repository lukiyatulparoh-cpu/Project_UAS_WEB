<?php
include "../../koneksi2.php";

$id_produk = $_POST['id_produk'];
$jumlah    = $_POST['jumlah'];

mysqli_begin_transaction($koneksi);

/* ================= SIMPAN RIWAYAT STOK ================= */
$sql1 = mysqli_query($koneksi, "
    INSERT INTO tb_stok 
    (id_produk, jumlah, tanggal)
    VALUES 
    ('$id_produk', '$jumlah', NOW())
");

/* ================= UPDATE STOK PRODUK ================= */
$sql2 = mysqli_query($koneksi, "
    UPDATE tb_produk
    SET stok = stok + $jumlah
    WHERE id_produk = '$id_produk'
");

/* ================= SELESAI ================= */
if ($sql1 && $sql2) {

    mysqli_commit($koneksi);
    header("Location: ../../dashboard_admin.php?menu=produk");
    exit;

} else {

    mysqli_rollback($koneksi);
    echo "❌ Gagal menyimpan stok";
}
?>
