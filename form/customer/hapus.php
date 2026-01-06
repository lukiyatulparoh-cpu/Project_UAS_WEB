<?php
include "../../koneksi2.php";

$id_customer = $_GET['id_customer'] ?? '';

if (empty($id_customer)) {
    echo "
        <script>
            alert('ID Customer tidak ditemukan!');
            window.location='../../dashboard_admin.php?menu=customer';
        </script>
    ";
    exit;
}

/* ===== CEK APAKAH CUSTOMER SUDAH ADA TRANSAKSI ===== */
$cek = mysqli_query($koneksi, "
    SELECT id_transaksi 
    FROM tb_transaksi 
    WHERE id_customer = '$id_customer'
");

if (mysqli_num_rows($cek) > 0) {
    echo "
        <script>
            alert('Customer tidak bisa dihapus karena sudah memiliki transaksi!');
            window.location='../../dashboard_admin.php?menu=customer';
        </script>
    ";
    exit;
}

/* ===== HAPUS CUSTOMER ===== */
$hapus = mysqli_query($koneksi, "
    DELETE FROM tb_customer 
    WHERE id_customer = '$id_customer'
");

if ($hapus) {
    echo "
        <script>
            alert('Customer berhasil dihapus');
            window.location='../../dashboard_admin.php?menu=customer';
        </script>
    ";
} else {
    echo "
        <script>
            alert('Gagal menghapus customer');
            window.location='../../dashboard_admin.php?menu=customer';
        </script>
    ";
}
?>
