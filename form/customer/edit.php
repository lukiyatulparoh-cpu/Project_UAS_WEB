<?php
include "koneksi2.php";

$id_customer = $_GET['id_customer'] ?? '';

if (empty($id_customer)) {
    echo "<script>
            alert('ID Customer tidak ditemukan');
            window.location='dashboard_admin.php?menu=customer';
          </script>";
    exit;
}

$sql = mysqli_query($koneksi, "
    SELECT * FROM tb_customer 
    WHERE id_customer = '$id_customer'
");

$data = mysqli_fetch_assoc($sql);

if (!$data) {
    echo "<script>
            alert('Data customer tidak ditemukan');
            window.location='dashboard_admin.php?menu=customer';
          </script>";
    exit;
}
?>

<div class="row">
    <div class="col-md-6 ms-4">
        <div class="card card-primary card-outline mb-4">

            <div class="card-header">
                <div class="card-title">Edit Customer</div>
            </div>

            <form action="form/customer/proses_simpan.php" method="POST">

                <div class="card-body">

                    <div class="mb-3">
                        <label class="form-label">ID Customer</label>
                        <input type="text" name="id_customer"
                               class="form-control"
                               value="<?= $data['id_customer']; ?>" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nama Customer</label>
                        <input type="text" name="nama_customer"
                               class="form-control"
                               value="<?= $data['nama_customer']; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email"
                               class="form-control"
                               value="<?= $data['email']; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">No HP</label>
                        <input type="text" name="no_hp"
                               class="form-control"
                               value="<?= $data['no_hp']; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <input type="text" name="alamat"
                               class="form-control"
                               value="<?= $data['alamat']; ?>" required>
                    </div>

                </div>

                <div class="card-footer">
                    <button type="submit" name="update" class="btn btn-warning">
                        Update
                    </button>

                    <a href="dashboard_admin.php?menu=customer"
                       class="btn btn-secondary float-end">
                        Kembali
                    </a>
                </div>

            </form>

        </div>
    </div>
</div>
