<?php
include "koneksi2.php";

// === Generate ID Transaksi Otomatis ===
$q = mysqli_query($koneksi, "SELECT MAX(id_transaksi) AS last FROM tb_transaksi");
$data = mysqli_fetch_assoc($q);

$no = (int) substr($data['last'], 3, 4);
$no++;
$id_transaksi = "TRX" . str_pad($no, 4, "0", STR_PAD_LEFT);
?>

<div class="row">
  <div class="col-md-6 ms-4">

    <div class="card card-primary card-outline mb-4">

      <div class="card-header">
        <div class="card-title">Form Transaksi</div>
      </div>

      <form action="form/transaksi/proses_simpan.php" method="POST">

        <div class="card-body">

          <div class="mb-3">
            <label class="form-label">Tanggal</label>
            <input type="date" name="tanggal" class="form-control"
                   value="<?= date('Y-m-d'); ?>" required>
          </div>

          <div class="mb-3">
            <label class="form-label">ID Transaksi</label>
            <input type="text" name="id_transaksi"
                   class="form-control"
                   value="<?= $id_transaksi; ?>" readonly>
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
                  echo "<option value='{$c['id_customer']}'>{$c['nama_customer']}</option>";
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
                  echo "<option value='{$p['id_produk']}'>
                          {$p['nama_produk']} — Rp ".number_format($p['harga'],0,',','.')."
                        </option>";
              }
              ?>
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label">Jumlah</label>
            <input type="number" name="jumlah"
                   class="form-control" min="1" required>
          </div>

        </div>

        <div class="card-footer">
          <button type="submit" name="simpan" class="btn btn-primary">
            Simpan Transaksi
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
