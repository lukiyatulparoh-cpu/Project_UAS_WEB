<?php
include "koneksi2.php";

$id_user = $_SESSION['id_user'];

/* Ambil data akun + customer */
$q = mysqli_query($koneksi, "
  SELECT 
    u.nama,
    u.email,
    c.no_hp,
    c.alamat
  FROM tb_users u
  LEFT JOIN tb_customer c ON u.id_user = c.id_user
  WHERE u.id_user = '$id_user'
");

$user = mysqli_fetch_assoc($q);

/* Ambil ringkasan transaksi */
$riwayat = mysqli_query($koneksi, "
  SELECT 
    COUNT(t.id_transaksi) AS total,
    COALESCE(SUM(t.total_harga),0) AS belanja
  FROM tb_transaksi t
  JOIN tb_customer c ON t.id_customer = c.id_customer
  WHERE c.id_user = '$id_user'
    AND t.status_transaksi = 'selesai'
");


$r = mysqli_fetch_assoc($riwayat);
?>

<div class="container mt-4">

<div class="card shadow-sm">
<div class="card-body">

<h4 class="fw-bold mb-3">👤 Profil Saya</h4>

<table class="table table-borderless">
<tr><td width="150">Nama</td><td>: <?= $user['nama']; ?></td></tr>
<tr><td>Email</td><td>: <?= $user['email']; ?></td></tr>
<tr><td>No HP</td><td>: <?= $user['no_hp'] ?? '-'; ?></td></tr>
<tr><td>Alamat</td><td>: <?= $user['alamat'] ?? '-'; ?></td></tr>
<tr><td>Status</td><td>: <span class="badge bg-success">Aktif</span></td></tr>
</table>

<hr>

<div class="row text-center">
<div class="col">
  <div class="card bg-light">
    <div class="card-body">
      <h5><?= $r['total'] ?? 0 ?></h5>
      <small>Total Pesanan</small>
    </div>
  </div>
</div>

<div class="col">
  <div class="card bg-light">
    <div class="card-body">
      <h5>Rp <?= number_format($r['belanja'] ?? 0) ?></h5>
      <small>Total Belanja</small>
    </div>
  </div>
</div>
</div>

<div class="mt-3 text-end">
  <a href="dashboard_customer.php?menu=edit_profil" class="btn btn-primary btn-sm">✏️ Edit Profil</a>
  <a href="dashboard_customer.php?menu=ubah_password" class="btn btn-warning btn-sm">🔐 Ubah Password</a>
</div>

</div>
</div>
</div>
