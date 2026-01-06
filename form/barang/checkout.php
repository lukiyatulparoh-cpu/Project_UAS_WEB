<?php
// ❌ JANGAN session_start (sudah di dashboard)
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

?>

<div class="container mt-4">
<h4 class="fw-bold mb-3">🧾 Checkout</h4>

<form action="form/barang/checkout_proses.php" method="post" enctype="multipart/form-data" >
<input type="hidden" name="id_customer" value="<?= $id_customer ?>">

  <div class="mb-3">
    <label>Nama Pemesan</label>
    <input type="text" name="nama" class="form-control" required>
  </div>

  <div class="mb-3">
    <label>No HP</label>
    <input type="text" name="no_hp" class="form-control" required>
  </div>

  <div class="mb-3">
    <label>Alamat</label>
    <textarea name="alamat" class="form-control" required></textarea>
  </div>

  <div class="mb-3">
    <label>Metode Pembayaran</label>
    <select name="pembayaran" class="form-select" required>
      <option value="">-- Pilih --</option>
      <option value="COD">COD</option>
      <option value="Transfer">Transfer</option>
    </select>
  </div>

  <h5 class="fw-bold">Total: Rp <?= number_format($total); ?></h5>

  <button type="submit" class="btn btn-success mt-3">
    Proses Pesanan
  </button>

</form>
</div>
