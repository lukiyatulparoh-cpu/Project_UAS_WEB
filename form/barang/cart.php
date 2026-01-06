<?php
include "koneksi2.php";

$keranjang = $_SESSION['keranjang'] ?? [];
$total = 0;
?>

<div class="container mt-4">

<h4 class="fw-bold mb-3">🛒 Keranjang Belanja</h4>

<?php if (empty($keranjang)) { ?>

  <div class="alert alert-info text-center">
    Keranjang masih kosong
  </div>

<?php } else { ?>

<div class="card shadow-sm">

<div class="card-body table-responsive">

<table class="table table-bordered align-middle text-center">

<thead class="table-light">
<tr>
  <th>Produk</th>
  <th>Nama</th>
  <th>Harga</th>
  <th width="140">Qty</th>
  <th>Subtotal</th>
  <th>Aksi</th>
</tr>
</thead>

<tbody>
<?php foreach ($keranjang as $item) {

  $subtotal = $item['harga'] * $item['qty'];
  $total += $subtotal;
?>
<tr>
  <td>
    <img src="uploads/<?= $item['gambar']; ?>" width="60">
  </td>

  <td><?= $item['nama_produk']; ?></td>

  <td>Rp <?= number_format($item['harga']); ?></td>

  <td>
    <form action="form/barang/cart_update.php" method="post" class="d-inline">
      <input type="hidden" name="id" value="<?= $item['id_produk']; ?>">
      <input type="hidden" name="aksi" value="kurang">
      <button class="btn btn-sm btn-outline-secondary">−</button>
    </form>

    <span class="mx-2"><?= $item['qty']; ?></span>

    <form action="form/barang/cart_update.php" method="post" class="d-inline">
      <input type="hidden" name="id" value="<?= $item['id_produk']; ?>">
      <input type="hidden" name="aksi" value="tambah">
      <button class="btn btn-sm btn-outline-secondary">+</button>
    </form>
  </td>

  <td>Rp <?= number_format($subtotal); ?></td>

  <td>
    <form action="form/barang/cart_update.php" method="post">
      <input type="hidden" name="id" value="<?= $item['id_produk']; ?>">
      <input type="hidden" name="aksi" value="hapus">
      <button class="btn btn-danger btn-sm"
        onclick="return confirm('Hapus produk ini?')">
        Hapus
      </button>
    </form>
  </td>
</tr>
<?php } ?>
</tbody>

</table>

</div>

<div class="card-footer d-flex justify-content-between align-items-center">
  <h5>Total: Rp <?= number_format($total); ?></h5>

  <a href="dashboard_customer.php?menu=checkout" class="btn btn-success">
    Checkout Sekarang
  </a>
</div>


</div>
<?php } ?>

</div>
