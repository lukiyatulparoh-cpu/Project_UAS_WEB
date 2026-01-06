<?php include "koneksi2.php"; 

?>

<div class="container-fluid">
  <div class="card">

    <div class="d-flex justify-content-between align-items-center p-3">
            <h3 class="mb-0">Data Produk</h3>

            <?php if ($_SESSION['role'] == 'admin') { ?>  
              <div class="d-flex justify-content-end gap-2">
                <a href="dashboard_admin.php?menu=tambah_stok"
                  class="btn btn-primary px-4 py-2"
                  style="font-size:14px; font-weight:600;">
                  Tambah Stok
                </a>

                <a href="dashboard_admin.php?menu=barang_form"
                  class="btn btn-primary px-4 py-2"
                  style="font-size:14px; font-weight:600;">
                  Tambah Produk
                </a>
              </div>

            <?php } ?>

          </div>

    <div class="card-body">

      <div class="row mb-3">
        <div class="col-md-4">
          <label>Kategori</label>
          <select id="kategori" class="form-control">
            <option value="">-- Pilih Kategori --</option>
            <?php
              $kat = mysqli_query($koneksi, "SELECT * FROM tb_kategori");
              while ($k = mysqli_fetch_assoc($kat)) {
                echo "<option value='$k[id_kategori]'>$k[nama_kategori]</option>";
              }
            ?>
          </select>
        </div>
      </div>

      <div id="tabelProduk"></div>

    </div>
  </div>
</div>

<script>
document.getElementById('kategori').addEventListener('change', function() {
  let id = this.value;

  if (id === "") {
    document.getElementById('tabelProduk').innerHTML = "";
    return;
  }

  fetch("form/barang/load_produk.php?kategori=" + id)
    .then(res => res.text())
    .then(data => {
      document.getElementById('tabelProduk').innerHTML = data;
    });
});
</script>
