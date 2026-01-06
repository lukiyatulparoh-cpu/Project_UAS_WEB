<?php
include "../../koneksi2.php";

$id = $_GET['id'];

mysqli_begin_transaction($koneksi);

/* Ambil detail transaksi */
$q = mysqli_query($koneksi, "
    SELECT d.id_produk, d.jumlah
    FROM tb_detail_transaksi d
    WHERE d.id_transaksi = '$id'
");

if (mysqli_num_rows($q) == 0) {
    mysqli_rollback($koneksi);
    echo "<script>
        alert('Data transaksi tidak ditemukan.');
        window.location='../../dashboard_admin.php?menu=transaksi';
    </script>";
    exit;
}

$data = mysqli_fetch_assoc($q);

/* Kembalikan stok */
mysqli_query($koneksi, "
    UPDATE tb_produk
    SET stok = stok + {$data['jumlah']}
    WHERE id_produk = '{$data['id_produk']}'
");

/* Hapus detail transaksi */
mysqli_query($koneksi, "
    DELETE FROM tb_detail_transaksi 
    WHERE id_transaksi = '$id'
");

/* Hapus transaksi utama */
$hapus = mysqli_query($koneksi, "
    DELETE FROM tb_transaksi 
    WHERE id_transaksi = '$id'
");

/* Commit / Rollback */
if ($hapus) {
    mysqli_commit($koneksi);
    echo "<script>
        alert('Transaksi berhasil dihapus');
        window.location='../../dashboard_admin.php?menu=transaksi';
    </script>";
} else {
    mysqli_rollback($koneksi);
    echo "<script>
        alert('Gagal menghapus transaksi');
        window.location='../../dashboard_admin.php?menu=transaksi';
    </script>";
}
?>
