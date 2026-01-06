<?php
session_start();
include("../../koneksi2.php");

$tanggal = $_GET['tanggal'];

$sql = mysqli_query($koneksi, "
    SELECT 
        t.id_transaksi,
        t.tanggal_transaksi,
        c.id_customer,
        c.nama_customer,
        p.id_produk,
        p.nama_produk,
        p.harga,
        d.jumlah,
        d.subtotal
    FROM tb_transaksi t
    JOIN tb_customer c ON t.id_customer = c.id_customer
    JOIN tb_detail_transaksi d ON t.id_transaksi = d.id_transaksi
    JOIN tb_produk p ON d.id_produk = p.id_produk
    WHERE DATE(t.tanggal_transaksi) = '$tanggal'
    ORDER BY t.id_transaksi DESC
");

if (mysqli_num_rows($sql) == 0) {
  echo "<div class='alert alert-warning m-3'>Tidak ada transaksi pada tanggal ini</div>";
  exit;
}
?>

<table class="table table-bordered table-striped align-middle">
<thead>
<tr>
<th>No</th>
<th>ID Transaksi</th>
<th>Tanggal</th>
<th>ID Customer</th>
<th>Nama Customer</th>
<th>ID Produk</th>
<th>Nama Produk</th>
<th>Harga</th>
<th>Jumlah</th>
<th>Subtotal</th>

<?php if ($_SESSION['role'] == 'admin') { ?>
<th class="text-center">Aksi</th>
<?php } ?>
</tr>
</thead>

<tbody>
<?php $no=1; while ($data = mysqli_fetch_assoc($sql)) { ?>
<tr>
<td><?= $no++; ?></td>
<td><?= $data['id_transaksi']; ?></td>
<td><?= $data['tanggal_transaksi']; ?></td>
<td><?= $data['id_customer']; ?></td>
<td><?= $data['nama_customer']; ?></td>
<td><?= $data['id_produk']; ?></td>
<td><?= $data['nama_produk']; ?></td>
<td>Rp <?= number_format($data['harga'],0,',','.'); ?></td>
<td><?= $data['jumlah']; ?></td>
<td>Rp <?= number_format($data['subtotal'],0,',','.'); ?></td>

<?php if ($_SESSION['role'] == 'admin') { ?>
<td class="text-center">
  <div class="btn-group">
    <a href="dashboard_admin.php?menu=edit_transaksi&id=<?= $data['id_transaksi']; ?>"
       class="btn btn-info btn-sm">Edit</a>

    <a href="form/transaksi/hapus.php?id=<?= $data['id_transaksi']; ?>"
       onclick="return confirm('Yakin hapus transaksi ini?')"
       class="btn btn-danger btn-sm">Delete</a>
  </div>
</td>
<?php } ?>

</tr>
<?php } ?>
</tbody>
</table>