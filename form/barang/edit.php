<?php
include "koneksi2.php";

$id = $_GET['id'] ?? '';

if ($id == '') {
  header("Location: ../../dashboard_admin.php?menu=produk");
  exit;
}

/* ================= AMBIL DATA PRODUK ================= */
$qProduk = mysqli_query($koneksi, "
  SELECT p.*, k.nama_kategori
  FROM tb_produk p
  JOIN tb_kategori k ON p.id_kategori = k.id_kategori
  WHERE p.id_produk = '$id'
");

$produk = mysqli_fetch_assoc($qProduk);

if (!$produk) {
  echo "<div class='alert alert-danger'>Produk tidak ditemukan.</div>";
  exit;
}

/* ================= AMBIL KATEGORI ================= */
$qKategori = mysqli_query($koneksi, "SELECT * FROM tb_kategori ORDER BY nama_kategori");
?>

<div class="container mt-4">

<h4 class="fw-bold mb-3">Edit Produk</h4>

<div class="card shadow-sm">
  <div class="card-body">

<form action="form/barang/proses_simpan.php" method="POST" enctype="multipart/form-data">

  <input type="hidden" name="id_produk" value="<?= $produk['id_produk']; ?>">

  <div class="mb-3">
    <label class="form-label">Nama Produk</label>
    <input type="text" name="nama_produk" class="form-control"
           value="<?= $produk['nama_produk']; ?>" required>
  </div>

  <div class="mb-3">
    <label class="form-label">Kategori</label>
    <select name="id_kategori" class="form-select" required>
      <?php while($k=mysqli_fetch_assoc($qKategori)){ ?>
        <option value="<?= $k['id_kategori']; ?>"
          <?= $k['id_kategori']==$produk['id_kategori']?'selected':'' ?>>
          <?= $k['nama_kategori']; ?>
        </option>
      <?php } ?>
    </select>
  </div>

  <div class="mb-3">
    <label class="form-label">Harga</label>
    <input type="number" name="harga" class="form-control"
           value="<?= $produk['harga']; ?>" required>
  </div>

  <div class="mb-3">
    <label class="form-label">Stok</label>
    <input type="number" name="stok" class="form-control"
           value="<?= $produk['stok']; ?>" required>
  </div>

  <div class="mb-3">
    <label class="form-label">Gambar</label>
    <input type="file" name="gambar" class="form-control">
    <small class="text-muted">Kosongkan jika tidak ingin mengganti gambar</small>
  </div>

  <div class="mb-3">
    <img src="../../uploads/<?= $produk['gambar']; ?>" width="120" class="rounded shadow-sm">
  </div>

  <div class="d-flex justify-content-between">
    <a href="dashboard_admin.php?menu=produk" class="btn btn-secondary">Kembali</a>
    <button type="submit" name="update" class="btn btn-primary">Simpan Perubahan</button>
  </div>

</form>

  </div>
</div>

</div>
