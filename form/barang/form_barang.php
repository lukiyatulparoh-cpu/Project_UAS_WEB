<?php include "koneksi2.php"; ?>

<div class="row">
    <div class="col-md-6 ms-4">

        <div class="card card-primary card-outline mb-4">
            <div class="card-header">
                <div class="card-title">Form Produk</div>
            </div>

            <form action="form/barang/proses_simpan.php" method="POST" enctype="multipart/form-data">
                <div class="card-body">

                    <!-- ID PRODUK -->
                    <div class="mb-3">
                        <label class="form-label">ID Produk</label>
                        <input type="text" name="id_produk" class="form-control" placeholder="P01" required>
                    </div>

                    <!-- KATEGORI -->
                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <select name="id_kategori" class="form-control" required>
                            <option value="">-- Pilih Kategori --</option>
                            <?php
                            $kategori = mysqli_query($koneksi, "SELECT * FROM tb_kategori");
                            while ($k = mysqli_fetch_assoc($kategori)) {
                                echo "<option value='$k[id_kategori]'>$k[nama_kategori]</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <!-- NAMA PRODUK -->
                    <div class="mb-3">
                        <label class="form-label">Nama Produk</label>
                        <input type="text" name="nama_produk" class="form-control" required>
                    </div>

                    <!-- DESKRIPSI -->
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="3" required></textarea>
                    </div>

                    <!-- HARGA -->
                    <div class="mb-3">
                        <label class="form-label">Harga</label>
                        <input type="number" name="harga" class="form-control" required>
                    </div>

                    <!-- STOK -->
                    <div class="mb-3">
                        <label class="form-label">Stok</label>
                        <input type="number" name="stok" class="form-control" required>
                    </div>

                    <!-- GAMBAR -->
                    <div class="mb-3">
                        <label class="form-label">Gambar Produk</label>
                        <input type="file" name="gambar" class="form-control">
                    </div>

                </div>

                <div class="card-footer">
                    <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                    <a href="dashboard_admin.php?menu=produk" class="btn btn-secondary float-end">Kembali</a>
                </div>

            </form>
        </div>
    </div>
</div>
