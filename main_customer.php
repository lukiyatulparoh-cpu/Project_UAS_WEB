<?php
include "koneksi2.php";

/* ================= DEFAULT KATEGORI ================= */
$qFirstKat = mysqli_query($koneksi,"SELECT id_kategori FROM tb_kategori LIMIT 1");
$firstKat = mysqli_fetch_assoc($qFirstKat);

$kategoriAktif = $_GET['kategori'] ?? $firstKat['id_kategori'];

$promo = [
    "dist/assets/img/promo1.png",
    "dist/assets/img/promo2.png",
    "dist/assets/img/promo3.png",
    "dist/assets/img/promo4.png"
];
?>

<div class="container mt-4">

<!-- ================= BANNER ================= -->
<div class="mb-4">
  <img src="dist/assets/img/banner.png" class="w-100 rounded shadow" style="height:300px; object-fit:cover;">
</div>

<!-- ================= KATEGORI ATAS ================= -->
<h4 class="fw-bold mb-3 text-center">🛒 Shop By Categories</h4>

<div class="row mb-5 text-center">
<?php
$qKat = mysqli_query($koneksi,"SELECT * FROM tb_kategori");
while($k = mysqli_fetch_assoc($qKat)){
?>
  <div class="col-md-4 mb-3">
    <a href="dashboard_customer.php?menu=home&kategori=<?= $k['id_kategori']; ?>#produk"
       class="text-decoration-none text-dark">
      <div class="card shadow-sm h-100">
        <img src="uploads/kategori/<?= $k['gambar']; ?>" class="card-img-top">
        <div class="card-body">
          <h5 class="fw-bold"><?= $k['nama_kategori']; ?></h5>
        </div>
      </div>
    </a>
  </div>
<?php } ?>
</div>

<!-- ================= FILTER KATEGORI ================= -->
<h3 class="fw-bold mb-4 text-center">Featured Menu</h3>

<div class="mb-4 text-center">
<?php
$qKat = mysqli_query($koneksi,"SELECT * FROM tb_kategori");
while($k = mysqli_fetch_assoc($qKat)){
?>
  <a href="dashboard_customer.php?menu=home&kategori=<?= $k['id_kategori']; ?>#produk"
     class="btn btn-outline-primary me-2 mb-2
     <?= ($kategoriAktif == $k['id_kategori']) ? 'active' : ''; ?>">
     <?= $k['nama_kategori']; ?>
  </a>
<?php } ?>
</div>

<!-- ================= PRODUK ================= -->
<h5 class="fw-bold mb-3" id="produk">Produk</h5>

<div class="row">
<?php
$qProduk = mysqli_query($koneksi, "
    SELECT * FROM tb_produk 
    WHERE id_kategori='$kategoriAktif'
");

if(mysqli_num_rows($qProduk) == 0){
    echo "<div class='alert alert-warning'>Produk belum tersedia</div>";
}

while($p = mysqli_fetch_assoc($qProduk)){
?>
  <div class="col-md-3 mb-4">
    <div class="card shadow-sm h-100 d-flex flex-column">

      <img src="uploads/<?= $p['gambar']; ?>" class="card-img-top" style="height:180px; object-fit:cover;">

      <div class="card-body d-flex flex-column">
        <h6><?= $p['nama_produk']; ?></h6>

        <?php if($p['status']=='promo'){ ?>
          <span class="badge bg-danger mb-2">Promo</span>
        <?php } ?>

        <p class="fw-bold mt-auto">Rp <?= number_format($p['harga']); ?></p>

        <!-- FORM TAMBAH KE KERANJANG -->
        <form action="form/barang/cart_add.php" method="post" class="mt-2">
          <input type="hidden" name="id_produk" value="<?= $p['id_produk']; ?>">
          <button type="submit"
                  class="btn btn-primary w-100 d-flex align-items-center justify-content-center gap-2 rounded-pill add-cart-btn">
            🛒 <span>Tambah ke Keranjang</span>
          </button>
        </form>

      </div>
    </div>
  </div>
<?php } ?>
</div>

<!-- ================= PROMO ================= -->
<h5 class="fw-bold mb-3 mt-5">🔥 Promo Spesial</h5>

<div class="d-flex gap-3 overflow-auto pb-3">
<?php foreach($promo as $img){ ?>
  <div style="min-width:260px">
    <img src="<?= $img ?>" class="img-fluid rounded shadow-sm">
  </div>
<?php } ?>
</div>

</div>
