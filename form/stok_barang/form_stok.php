<?php include "koneksi2.php"; ?>

<div class="row">
  <div class="col-md-6 ms-4">
    <div class="card card-primary card-outline mb-4">

      <div class="card-header">
        <div class="card-title">Form Tambah Stok Produk</div>
      </div>

      <form action="form/stok_barang/proses_simpan.php" method="POST">
        <div class="card-body">

          <!-- PRODUK -->
          <div class="mb-3">
            <label class="form-label">Produk</label>
            <select name="id_produk" id="id_produk" class="form-control" required>
              <option value="">-- Pilih Produk --</option>
              <?php
              $produk = mysqli_query($koneksi, "
                SELECT id_produk, nama_produk, harga 
                FROM tb_produk 
                ORDER BY nama_produk
              ");
              while ($p = mysqli_fetch_assoc($produk)) {
                echo "<option value='{$p['id_produk']}' data-harga='{$p['harga']}'>
                        {$p['id_produk']} - {$p['nama_produk']}
                      </option>";
              }
              ?>
            </select>
          </div>

          <!-- HARGA OTOMATIS -->
          <div class="mb-3">
            <label class="form-label">Harga</label>
            <input type="number" id="harga" class="form-control" readonly>
          </div>

          <!-- JUMLAH TAMBAH STOK -->
          <div class="mb-3">
            <label class="form-label">Jumlah Tambah Stok</label>
            <input type="number" name="jumlah" class="form-control" min="1" required>
          </div>

        </div>

        <div class="card-footer">
          <button type="submit" class="btn btn-primary">Simpan</button>
          <a href="dashboard_admin.php?menu=produk" class="btn btn-secondary float-end">Kembali</a>
        </div>

      </form>

    </div>
  </div>
</div>

<script>
document.getElementById('id_produk').addEventListener('change', function () {
  const harga = this.options[this.selectedIndex].getAttribute('data-harga');
  document.getElementById('harga').value = harga ?? '';
});
</script>
