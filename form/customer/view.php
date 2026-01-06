<?php
include "koneksi2.php";
?>

<div class="app-content">
  <div class="container-fluid">

    <div class="row">
      <div class="col-md-10">

        <div class="card mb-4 shadow-sm">

          <!-- HEADER -->
          <div class="d-flex justify-content-between align-items-center p-3 border-bottom">
            <h4 class="mb-0">Data Customer</h4>

            <?php if ($_SESSION['role'] == 'admin') { ?>
              <a href="dashboard_admin.php?menu=customer_form"
                 class="btn btn-primary btn-sm px-4">
                <i class="bi bi-plus-circle"></i> Tambah Customer
              </a>
            <?php } ?>
          </div>

          <!-- BODY -->
          <div class="card-body p-0">
            <table class="table table-bordered table-striped align-middle mb-0">

              <thead class="table-light">
                <tr>
                  <th class="text-center" style="width:50px;">No</th>
                  <th>ID Customer</th>
                  <th>Nama Customer</th>
                  <th>Email</th>
                  <th>No HP</th>
                  <th>Alamat</th>

                  <?php if ($_SESSION['role'] == 'admin') { ?>
                    <th class="text-center" style="width:160px;">Aksi</th>
                  <?php } ?>
                </tr>
              </thead>

              <tbody>
                <?php
                $no = 1;
                $sql = mysqli_query($koneksi, "
                    SELECT * FROM tb_customer
                    ORDER BY id_customer ASC
                ");

                while ($data = mysqli_fetch_assoc($sql)) {
                ?>
                  <tr>
                    <td class="text-center"><?= $no++; ?></td>
                    <td><?= $data['id_customer']; ?></td>
                    <td><?= $data['nama_customer']; ?></td>
                    <td><?= $data['email']; ?></td>
                    <td><?= $data['no_hp']; ?></td>
                    <td><?= $data['alamat']; ?></td>

                    <?php if ($_SESSION['role'] == 'admin') { ?>
                      <td class="text-center">
                        <div class="btn-group">
                          <a href="dashboard_admin.php?menu=edit_customer&id_customer=<?= $data['id_customer']; ?>"
                             class="btn btn-warning btn-sm">
                            Edit
                          </a>

                          <a href="form/customer/hapus.php?id_customer=<?= $data['id_customer']; ?>"
                             onclick="return confirm('Yakin hapus customer ini?')"
                             class="btn btn-danger btn-sm">
                            Hapus
                          </a>
                        </div>
                      </td>
                    <?php } ?>
                  </tr>
                <?php } ?>
              </tbody>

            </table>

            <!-- FOOTER -->
            <div class="p-3 text-end border-top">
              <a href="laporan/laporan_customer.php"
                 target="_blank"
                 class="btn btn-info btn-sm">
                <i class="bi bi-printer"></i> Cetak PDF
              </a>
            </div>

          </div>
        </div>

      </div>
    </div>

  </div>
</div>
