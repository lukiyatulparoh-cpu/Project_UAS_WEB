<?php include "koneksi2.php"; ?>

<div class="app-content">
  <div class="container-fluid">

    <div class="row">
      <div class="col-md-8">

        <div class="card mb-4">

          <div class="d-flex justify-content-between align-items-center p-3">
            <h3 class="mb-0">Data Customer - Clairmont</h3>
          </div>

          <div class="card-body p-0">
            <table class="table table-bordered table-striped align-middle mb-0">

              <thead>
                <tr>
                  <th style="width: 10px" class="text-center">No</th>
                  <th>Kode Customer</th>
                  <th>Nama Customer</th>
                  <th class="text-center" style="width: 120px">HP</th>
                </tr>
              </thead>

              <tbody>
                <?php
                  $no = 1;
                  $sql = mysqli_query($koneksi, "SELECT * FROM tb_customer ORDER BY nama_customer");

                  while($data = mysqli_fetch_assoc($sql)){
                ?>
                <tr>
                  <td class="text-center"><?= $no++; ?></td>
                  <td><?= $data['kode_customer']; ?></td>
                  <td><?= $data['nama_customer']; ?></td>
                  <td class="text-center"><?= $data['no_hp']; ?></td>
                </tr>
                <?php } ?>
              </tbody>

            </table>
          </div>

          <div class="card-footer text-end">
            <a href="laporan/laporan_customer.php" target="_blank" class="btn btn-warning">
              <i class="bi bi-printer"></i> Cetak Laporan Data Customer
            </a>
          </div>

        </div>

      </div>
    </div>

  </div>
</div>
