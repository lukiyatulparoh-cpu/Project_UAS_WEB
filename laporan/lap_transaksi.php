<main class="app-main">
  <div class="app-content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6"></div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
            <li class="breadcrumb-item active">Laporan Transaksi</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <div class="app-content">
    <div class="container-fluid">
      <div class="row g-4">
        <div class="col-md-6">

          <div class="card card-warning card-outline mb-4">
            <div class="card-header">
              <div class="card-title">Filter Laporan Transaksi</div>
            </div>

            <form method="post" action="./laporan/laporan_transaksi_cetak.php" target="_blank">
              <div class="card-body">

                <div class="row mb-3">
                  <label class="col-sm-4 col-form-label">Tanggal Awal</label>
                  <div class="col-sm-8">
                    <input type="date" name="tgl_awal" class="form-control" required>
                  </div>
                </div>

                <div class="row mb-3">
                  <label class="col-sm-4 col-form-label">Tanggal Akhir</label>
                  <div class="col-sm-8">
                    <input type="date" name="tgl_akhir" class="form-control" required>
                  </div>
                </div>

              </div>

              <div class="card-footer">
                <button type="submit" class="btn btn-warning">
                  <i class="bi bi-printer" ></i> Cetak Laporan
                </button>
                <button type="reset" class="btn btn-secondary float-end">
                  Reset
                </button>
              </div>
            </form>

          </div>

        </div>
      </div>
    </div>
  </div>
</main>
