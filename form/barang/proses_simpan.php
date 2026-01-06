<?php
include "../../koneksi2.php";

$id_produk   = $_POST['id_produk'] ?? '';
$id_kategori = $_POST['id_kategori'];
$nama        = $_POST['nama_produk'];
$harga       = $_POST['harga'];
$stok        = $_POST['stok'];

$gambar    = $_FILES['gambar']['name'] ?? '';
$gambarTmp = $_FILES['gambar']['tmp_name'] ?? '';

// folder uploads
$targetDir  = $_SERVER['DOCUMENT_ROOT'] . "/uas/uploads/";
$targetFile = $targetDir . $gambar;

/* ================== GENERATE KODE PRODUK ================== */
$qKode = mysqli_query($koneksi, "
    SELECT MAX(kode_produk) AS kodeTerbesar 
    FROM tb_produk
");
$dataKode = mysqli_fetch_assoc($qKode);
$urutan = (int) substr($dataKode['kodeTerbesar'], 4, 3);
$urutan++;

$kode_produk = "PRD-" . str_pad($urutan, 3, "0", STR_PAD_LEFT);

/* ================== SIMPAN DATA BARU ================== */
if (isset($_POST['simpan'])) {

    if (!empty($gambar)) {
        move_uploaded_file($gambarTmp, $targetFile);
    }

    $sql = mysqli_query($koneksi, "
        INSERT INTO tb_produk 
        (kode_produk, id_kategori, nama_produk, harga, stok, gambar, status, created_at, updated_at)
        VALUES
        ('$kode_produk', '$id_kategori', '$nama', '$harga', '$stok', '$gambar', 'aktif', NOW(), NOW())
    ");

    if ($sql) {
        header("Location: ../../dashboard_admin.php?menu=produk");
        exit;
    } else {
        echo "❌ Gagal menyimpan data produk";
    }

/* ================== UPDATE DATA ================== */
} elseif (isset($_POST['update'])) {

    if (!empty($gambar)) {

        move_uploaded_file($gambarTmp, $targetFile);

        $sql = mysqli_query($koneksi, "
            UPDATE tb_produk 
            SET id_kategori='$id_kategori',
                nama_produk='$nama',
                harga='$harga',
                stok='$stok',
                gambar='$gambar',
                updated_at=NOW()
            WHERE id_produk='$id_produk'
        ");

    } else {

        $sql = mysqli_query($koneksi, "
            UPDATE tb_produk 
            SET id_kategori='$id_kategori',
                nama_produk='$nama',
                harga='$harga',
                stok='$stok',
                updated_at=NOW()
            WHERE id_produk='$id_produk'
        ");
    }

    if ($sql) {
        header("Location: ../../dashboard_admin.php?menu=produk");
        exit;
    } else {
        echo "❌ Gagal mengupdate data produk";
    }
}
?>
