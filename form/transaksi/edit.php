<?php
include "koneksi2.php";

$id = $_GET['id'];

// Ambil transaksi utama
$trans = mysqli_query($koneksi, "
    SELECT * FROM tb_transaksi 
    WHERE id_transaksi = '$id'
");
$data = mysqli_fetch_assoc($trans);

// Ambil detail transaksi
$detail = mysqli_query($koneksi, "
    SELECT * FROM tb_detail_transaksi 
    WHERE id_transaksi = '$id'
");
$d = mysqli_fetch_assoc($detail);
?>

<div class="row">
  <div class="col-md-6 ms-4">

    <div class="card card-warning card-outline mb-4">

      <div class="card-header">
        <div class="card-title">Edit Transaksi</div>
      </div>

      <form action="form/transaksi/proses_simpan.php" method="POST">

        <div class="card-body">

          <input type="hidden" name="edit_mode" value="1">

          <div class="mb-3">
            <label class="form-label">ID Transaksi</label>
            <input type="text" name="id_transaksi"
                   class="form-control"
                   value="<?= $data['id_transaksi']; ?>" readonly>
          </div>

          <div class="mb-3">
            <label class="form-label">Tanggal</label>
            <input type="date" name="tanggal"
                   class="form-control"
                   value="<?= $data['tanggal_transaksi']; ?>" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Customer</label>
            <select name="id_customer" class="form-control" required>
              <option value="">-- Pilih Customer --</option>
              <?php
              $cust = mysqli_query($koneksi, "
                  SELECT * FROM tb_customer ORDER BY nama_customer
              ");
              while ($c = mysqli_fetch_assoc($cust)) {
                  $sel = ($c['id_customer'] == $data['id_customer']) ? "selected" : "";
                  echo "<option value='{$c['id_customer']}' $sel>
                          {$c['nama_customer']}
                        </option>";
              }
              ?>
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label">Produk</label>
            <select name="id_produk" class="form-control" required>
              <option value="">-- Pilih Produk --</option>
              <?php
              $prod = mysqli_query($koneksi, "
                  SELECT * FROM tb_produk ORDER BY nama_produk
              ");
              while ($p = mysqli_fetch_assoc($prod)) {
                  $sel = ($p['id_produk'] == $d['id_produk']) ? "selected" : "";
                  echo "<option value='{$p['id_produk']}' $sel>
                          {$p['nama_produk']}
                        </option>";
              }
              ?>
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label">Jumlah</label>
            <input type="number" name="jumlah"
                   class="form-control"
                   value="<?= $d['jumlah']; ?>" min="1" required>
          </div>

        </div>

        <div class="card-footer">
          <button type="submit" name="update" class="btn btn-warning">
            Update
          </button>

          <a href="dashboard_admin.php?menu=transaksi"
             class="btn btn-secondary float-end">
             Kembali
          </a>
        </div>

      </form>

    </div>
  </div>
</div>
