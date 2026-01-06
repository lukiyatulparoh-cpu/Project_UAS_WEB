<?php
include "../../koneksi2.php";

$id = $_POST['id_transaksi'];

$ext = pathinfo($_FILES['bukti']['name'], PATHINFO_EXTENSION);
$file = "bukti_" . time() . "." . $ext;

move_uploaded_file($_FILES['bukti']['tmp_name'], "../../uploads/bukti/" . $file);

mysqli_query($koneksi, "
  UPDATE tb_transaksi 
  SET bukti_transfer='$file', status_transaksi='menunggu_verifikasi'
  WHERE id_transaksi='$id'
");

header("Location: ../../dashboard_customer.php?menu=checkout_sukses");
