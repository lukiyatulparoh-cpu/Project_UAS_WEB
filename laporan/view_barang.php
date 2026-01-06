<?php include "koneksi2.php"; ?>

<div class="app-content">
<div class="container-fluid">

<div class="row">
<div class="col-md-9">

<div class="card mb-4">

<div class="d-flex justify-content-between align-items-center p-3">
    <h3 class="mb-0">Data Produk - Clairmont</h3>

    <a href="laporan/laporan_barang.php" target="_blank" class="btn btn-warning">
        <i class="bi bi-printer"></i> Cetak Laporan Produk
    </a>
</div>

<div class="card-body p-0">

<table class="table table-bordered table-striped align-middle">
<thead class="table-light">
<tr class="text-center">
    <th width="50">No</th>
    <th>Kode</th>
    <th>Produk</th>
    <th width="90">Gambar</th>
    <th width="130">Harga</th>
    <th width="80">Stok</th>
</tr>
</thead>

<tbody>
<?php
$no = 1;
$sql = mysqli_query($koneksi, "SELECT * FROM tb_produk ORDER BY nama_produk");

while($data = mysqli_fetch_assoc($sql)){
?>
<tr>
    <td class="text-center"><?= $no++ ?></td>
    <td><?= $data['kode_produk'] ?></td>
    <td><?= $data['nama_produk'] ?></td>

    <td class="text-center">
        <?php if(!empty($data['gambar'])){ ?>
            <img src="uploads/<?= $data['gambar'] ?>" width="60" class="rounded">
        <?php } else { ?>
            <small class="text-muted">No Image</small>
        <?php } ?>
    </td>

    <td class="text-end">Rp <?= number_format($data['harga'],0,',','.') ?></td>
    <td class="text-center"><?= $data['stok'] ?></td>
</tr>
<?php } ?>
</tbody>
</table>

</div>

</div>
</div>
</div>

</div>
</div>
