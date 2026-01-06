<?php include "koneksi2.php"; ?>

<div class="row">
    <div class="col-md-6 ms-4">
        <div class="card card-primary card-outline mb-4">
            <div class="card-header">
                <div class="card-title">Form Customer</div>
            </div>

            <form action="form/customer/proses_simpan.php" method="POST">
                <div class="card-body">

                    <div class="mb-3">
                        <label class="form-label">ID Customer</label>
                        <input type="text" name="id_customer" class="form-control" 
                               placeholder="Contoh: C01" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nama Customer</label>
                        <input type="text" name="nama_customer" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">No HP</label>
                        <input type="text" name="no_hp" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <input type="text" name="alamat" class="form-control" required>
                    </div>

                </div>

                <div class="card-footer">
                    <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                    <a href="dashboard_admin.php?menu=customer" class="btn btn-secondary float-end">
                        Kembali
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>
