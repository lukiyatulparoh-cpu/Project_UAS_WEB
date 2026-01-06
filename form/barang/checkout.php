<?php
include "koneksi2.php";

$keranjang = $_SESSION['keranjang'] ?? [];
$total = 0;

foreach ($keranjang as $item) {
  $total += $item['harga'] * $item['qty'];
}

if (empty($keranjang)) {
  echo "<div class='alert alert-warning'>Keranjang kosong</div>";
  return;
}

$id_user = $_SESSION['id_user'];
$q = mysqli_query($koneksi, "SELECT nama FROM tb_users WHERE id_user='$id_user'");
$user = mysqli_fetch_assoc($q);
?>

<div class="container mt-4">
<h4 class="fw-bold mb-3">🧾 Checkout</h4>

<form action="form/barang/checkout_proses.php" method="post" enctype="multipart/form-data">

  <div class="mb-3">
    <label>Nama Pemesan</label>
    <input type="text" class="form-control" value="<?= $user['nama'] ?>" readonly>
  </div>

  <div class="mb-3">
    <label>Metode Pembayaran</label>
    <select name="pembayaran" id="metode" class="form-select" required>
      <option value="">-- Pilih --</option>
      <option value="COD">COD</option>
      <option value="Transfer">Transfer</option>
    </select>
  </div>

  <!-- Upload bukti -->
  <div class="mb-3" id="buktiBox" style="display:none">
    <label>Upload Bukti Transfer</label>
    <input type="file" name="bukti" class="form-control">
  </div>

  <h5 class="fw-bold">Total: Rp <?= number_format($total); ?></h5>

  <button type="submit" class="btn btn-success mt-3">
    Proses Pesanan
  </button>
</form>
</div>

<script>
document.getElementById('metode').addEventListener('change', function(){
  document.getElementById('buktiBox').style.display =
    this.value === 'Transfer' ? 'block' : 'none';
});
</script>
