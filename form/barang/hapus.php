<?php
include "../../koneksi2.php";

$id = $_GET['id'] ?? '';

if ($id == '') {
  header("Location: ../../dashboard.php?menu=produk");
  exit;
}

/* ================= CEK DI DETAIL TRANSAKSI ================= */
$cekTransaksi = mysqli_query($koneksi, "
  SELECT id_produk 
  FROM tb_detail_transaksi 
  WHERE id_produk = '$id'
");

if (mysqli_num_rows($cekTransaksi) > 0) {
  echo "<script>
          alert('Produk tidak bisa dihapus karena sudah pernah digunakan dalam transaksi.');
          window.location='../../dashboard.php?menu=produk';
        </script>";
  exit;
}

/* ================= HAPUS DATA TERKAIT ================= */
mysqli_begin_transaction($koneksi);

// hapus stok dulu (FK constraint)
mysqli_query($koneksi, "DELETE FROM tb_stok WHERE id_produk = '$id'");

// hapus produk
mysqli_query($koneksi, "DELETE FROM tb_produk WHERE id_produk = '$id'");

mysqli_commit($koneksi);

echo "<script>
        alert('Produk berhasil dihapus.');
        window.location='../../dashboard.php?menu=produk';
      </script>";
?>
