
<?php
include "koneksi2.php";

$id = $_GET['id'];
$q = mysqli_query($koneksi, "SELECT * FROM tb_transaksi WHERE id_transaksi='$id'");
$data = mysqli_fetch_assoc($q);
?>

<div class="container mt-5">

<div class="card shadow p-4">

<?php if ($data['metode_pembayaran'] == 'Transfer') { ?>

<h4>💳 Silakan Lakukan Pembayaran</h4>

<div class="alert alert-info mt-3">
  <strong>Transfer ke:</strong><br>
  BCA - 1234567890<br>
  a.n Dessert Store
</div>

<form action="form/barang/upload_bukti_transaksi.php" method="post" enctype="multipart/form-data">
  <input type="hidden" name="id_transaksi" value="<?= $id ?>">
  <input type="file" name="bukti" class="form-control mb-3" required>
  <button class="btn btn-primary">Upload Bukti Pembayaran</button>
</form>

<?php } else { ?>

<h4 class="text-success">✅ Pesanan Berhasil</h4>
<p>Pesanan kamu akan segera diproses.</p>

<a href="dashboard_customer.php" class="btn btn-success mt-3">Kembali ke Beranda</a>

<?php } ?>

</div>
</div>
