<?php
include "koneksi2.php";
$id = $_GET['id'];
?>

<div class="container mt-4">

<a href="dashboard_customer.php?menu=home"
   class="btn btn-outline-secondary mb-3">
← Kembali
</a>

<h4 class="fw-bold mb-4">Produk</h4>

<div class="row">
<?php
$q = mysqli_query($koneksi,"
  SELECT * FROM tb_produk
  WHERE id_kategori='$id'
");

if(mysqli_num_rows($q)==0){
  echo "<div class='alert alert-warning'>Produk belum tersedia</div>";
}

while($p=mysqli_fetch_assoc($q)){
?>
  <div class="col-md-3 mb-4">
    <div class="card shadow-sm h-100">
      <img src="uploads/<?= $p['gambar']; ?>" class="card-img-top">
      <div class="card-body">
        <h6><?= $p['nama_produk']; ?></h6>
        <p class="fw-bold">
          Rp <?= number_format($p['harga']); ?>
        </p>

        <a href="dashboard_customer.php?menu=cart_add&id=<?= $p['id_produk']; ?>"
           class="btn btn-success btn-sm w-100">
          Tambah ke Keranjang
        </a>
      </div>
    </div>
  </div>
<?php } ?>
</div>

</div>
