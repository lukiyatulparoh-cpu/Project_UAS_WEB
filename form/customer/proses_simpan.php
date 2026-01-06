<?php
include "../../koneksi2.php";

$id_customer   = $_POST['id_customer'] ?? '';
$nama_customer = $_POST['nama_customer'];
$email         = $_POST['email'];
$no_hp         = $_POST['no_hp'];
$alamat        = $_POST['alamat'];

/* ==========================================
   GENERATE KODE CUSTOMER OTOMATIS (CST-001)
========================================== */
$cek = mysqli_query($koneksi, "SELECT kode_customer FROM tb_customer ORDER BY id_customer DESC LIMIT 1");
$data = mysqli_fetch_assoc($cek);

if ($data) {
    $no = (int) substr($data['kode_customer'], 4, 3);
    $no++;
    $kode_customer = "CST-" . str_pad($no, 3, "0", STR_PAD_LEFT);
} else {
    $kode_customer = "CST-001";
}

/* ================= SIMPAN DATA BARU ================= */
if (isset($_POST['simpan'])) {

    $sql = mysqli_query($koneksi, "
        INSERT INTO tb_customer 
        (kode_customer, nama_customer, email, no_hp, alamat)
        VALUES
        ('$kode_customer', '$nama_customer', '$email', '$no_hp', '$alamat')
    ");
}

/* ================= UPDATE DATA ================= */
elseif (isset($_POST['update'])) {

    $sql = mysqli_query($koneksi, "
        UPDATE tb_customer SET
            nama_customer = '$nama_customer',
            email         = '$email',
            no_hp         = '$no_hp',
            alamat        = '$alamat'
        WHERE id_customer = '$id_customer'
    ");
}

/* ================= EKSEKUSI ================= */
if ($sql) {
    header("Location: ../../dashboard_admin.php?menu=customer");
    exit;
} else {
    echo "❌ Gagal menyimpan data customer!";
}
?>
