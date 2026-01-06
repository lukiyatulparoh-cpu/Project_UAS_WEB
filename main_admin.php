<?php
include "koneksi2.php";

// total customer
$qCustomer = mysqli_query($koneksi,
  "SELECT COUNT(*) AS total FROM tb_customer"
);
$customer = mysqli_fetch_assoc($qCustomer);

// total produk
$qBarang = mysqli_query($koneksi,
  "SELECT COUNT(*) AS total FROM tb_produk"
);
$barang = mysqli_fetch_assoc($qBarang);

// total transaksi
$qTransaksi = mysqli_query($koneksi,
  "SELECT COUNT(*) AS total FROM tb_transaksi"
);
$transaksi = mysqli_fetch_assoc($qTransaksi);

// total pendapatan
$qPendapatan = mysqli_query($koneksi,
  "SELECT SUM(total_harga) AS total FROM tb_transaksi"
);
$pendapatan = mysqli_fetch_assoc($qPendapatan);


$qTotalStok = mysqli_query($koneksi,
  "SELECT SUM(stok) AS total FROM tb_produk"
);
$totalStok = mysqli_fetch_assoc($qTotalStok)['total'] ?? 0;

$qMenipis = mysqli_query($koneksi,
  "SELECT COUNT(*) AS total
   FROM tb_produk
   WHERE stok BETWEEN 1 AND 5"
);
$stokMenipis = mysqli_fetch_assoc($qMenipis)['total'];

$qHabis = mysqli_query($koneksi,
  "SELECT COUNT(*) AS total
   FROM tb_produk
   WHERE stok = 0"
);
$stokHabis = mysqli_fetch_assoc($qHabis)['total'];


// total barang
$qBarang = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM tb_produk");
$barang  = mysqli_fetch_assoc($qBarang);

// total customer
$qCust = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM tb_customer");
$cust  = mysqli_fetch_assoc($qCust);

// total transaksi
$qTrans = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM tb_transaksi");
$trans  = mysqli_fetch_assoc($qTrans);

// total qty
$qQty = mysqli_query($koneksi, "SELECT SUM(jumlah) AS total FROM tb_detail_transaksi");
$qty  = mysqli_fetch_assoc($qQty);


$topBarang = mysqli_query($koneksi, "
  SELECT 
    p.nama_produk,
    SUM(d.jumlah) AS total_terjual
  FROM tb_detail_transaksi d
  JOIN tb_produk p ON d.id_produk = p.id_produk
  GROUP BY p.id_produk, p.nama_produk
  ORDER BY total_terjual DESC
  LIMIT 5
");


$barangSemua = mysqli_query($koneksi, "
  SELECT 
    id_produk,
    nama_produk,
    harga,
    stok,
    kode_produk,
    gambar
  FROM tb_produk
  ORDER BY nama_produk
");



$qlatest = mysqli_query($koneksi, "
  SELECT 
    t.id_transaksi,
    t.tanggal_transaksi,
    t.total_harga,
    t.status_transaksi,
    GROUP_CONCAT(p.nama_produk SEPARATOR ', ') AS produk
  FROM tb_transaksi t
  JOIN tb_detail_transaksi d ON t.id_transaksi = d.id_transaksi
  JOIN tb_produk p ON d.id_produk = p.id_produk
  GROUP BY t.id_transaksi
  ORDER BY t.tanggal_transaksi DESC
  LIMIT 5
");




$customers = mysqli_query($koneksi, "
  SELECT 
    id_customer,
    nama_customer,
    alamat,
    no_hp,
    created_at
  FROM tb_customer
  ORDER BY created_at DESC
");



?>

<main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
              <div class="col-sm-6">
                <h3 class="mb-0">Clairmont Dessert</h3>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                  <li class="breadcrumb-item"><a href="#">Beranda</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Clairmont</li>
                </ol>
              </div>
            </div>
            <!--end::Row-->
          </div>
          <!--end::Container-->
        </div>
        <div class="app-content">
          <!--begin::Container-->
          <div class="container-fluid">
           <div class="row">

        <!-- TOTAL CUSTOMER -->
        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box">
            <span class="info-box-icon text-bg-primary shadow-sm">
              <i class="bi bi-people-fill"></i>
            </span>
            <div class="info-box-content">
              <span class="info-box-text">Total Customer</span>
              <span class="info-box-number">
                <?= $customer['total']; ?>
              </span>
            </div>
          </div>
        </div>

        <!-- TOTAL BARANG -->
        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box">
            <span class="info-box-icon text-bg-success shadow-sm">
              <i class="bi bi-box-seam"></i>
            </span>
            <div class="info-box-content">
              <span class="info-box-text">Total Produk</span>
              <span class="info-box-number">
                <?= $barang['total']; ?>
              </span>
            </div>
          </div>
        </div>

        <!-- TOTAL TRANSAKSI -->
        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box">
            <span class="info-box-icon text-bg-warning shadow-sm">
              <i class="bi bi-receipt"></i>
            </span>
            <div class="info-box-content">
              <span class="info-box-text">Total Transaksi</span>
              <span class="info-box-number">
                <?= $transaksi['total']; ?>
              </span>
            </div>
          </div>
        </div>

        <!-- TOTAL PENDAPATAN -->
        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box">
            <span class="info-box-icon text-bg-danger shadow-sm">
              <i class="bi bi-cash-stack"></i>
            </span>
            <div class="info-box-content">
              <span class="info-box-text">Total Pendapatan</span>
              <span class="info-box-number">
                Rp <?= number_format($pendapatan['total'] ?? 0); ?>
              </span>
            </div>
          </div>
        </div>

      </div>

            <!-- /.row -->

            <!--begin::Row-->
            <div class="row">
              <div class="col-md-12">
                <div class="card mb-4">
                  <div class="card-header">
                    <h5 class="card-title">GRAFIK PENJUALAN</h5>

                    <div class="card-tools">
                      <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
                        <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                        <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                      </button>
                      <div class="btn-group">
                        <button
                          type="button"
                          class="btn btn-tool dropdown-toggle"
                          data-bs-toggle="dropdown"
                        >
                          <i class="bi bi-wrench"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" role="menu">
                          <a href="#" class="dropdown-item">Action</a>
                          <a href="#" class="dropdown-item">Another action</a>
                          <a href="#" class="dropdown-item"> Something else here </a>
                          <a class="dropdown-divider"></a>
                          <a href="#" class="dropdown-item">Separated link</a>
                        </div>
                      </div>
                      <button type="button" class="btn btn-tool" data-lte-toggle="card-remove">
                        <i class="bi bi-x-lg"></i>
                      </button>
                    </div>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <!--begin::Row-->
                    <div class="row">
                      <div class="col-md-8">
                        <p class="text-center">
                          <strong>Sales: 1 Jan, 2023 - 30 Jul, 2023</strong>
                        </p>

                        <div id="sales-chart"></div>

                      </div>
                    <div class="col-md-4">
                      <p class="text-center">
                        <strong>Status Stok Produk</strong>
                      </p>

                      <div class="progress-group">
                      Stok Tersedia
                      <span class="float-end">
                        <b><?= $totalStok ?></b>
                      </span>
                      <div class="progress progress-sm">
                        <div class="progress-bar text-bg-success" style="width:100%"></div>
                      </div>
                    </div>

                    <div class="progress-group">
                      Produk Stok Menipis
                      <span class="float-end">
                        <b><?= $stokMenipis ?></b>
                      </span>
                      <div class="progress progress-sm">
                        <div class="progress-bar text-bg-warning" style="width:100%"></div>
                      </div>
                    </div>

                    <div class="progress-group">
                      Produk Habis
                      <span class="float-end">
                        <b><?= $stokHabis ?></b>
                      </span>
                      <div class="progress progress-sm">
                        <div class="progress-bar text-bg-danger" style="width:100%"></div>
                      </div>
                    </div>


                    <!--end::Row-->
                  </div>
                  <!-- ./card-body -->
                  <div class="card-footer">
                    <!--begin::Row-->
                    <div class="row">
                      <div class="col-md-3 col-6">
                        <div class="text-center border-end">
                          <span class="text-success">
                            <i class="bi bi-caret-up-fill"></i> 17%
                          </span>
                          <h5 class="fw-bold mb-0">
                            <?= $customer['total']; ?>
                          </h5>
                          <span class="text-uppercase">TOTAL CUSTOMER</span>
                        </div>
                      </div>

                      <!-- /.col -->
                      <div class="col-md-3 col-6">
                        <div class="text-center border-end">
                          <span class="text-info"> <i class="bi bi-caret-left-fill"></i> 20% </span>
                          <h5 class="fw-bold mb-0"><?= $barang['total']; ?></h5>
                          <span class="text-uppercase">TOTAL PRODUK</span>
                        </div>
                      </div>
                      <!-- /.col -->
                      <div class="col-md-3 col-6">
                        <div class="text-center border-end">
                          <span class="text-success">
                            <i class="bi bi-caret-up-fill"></i> 20%
                          </span>
                          <h5 class="fw-bold mb-0"><?= $transaksi['total']; ?></h5>
                          <span class="text-uppercase">TOTAL TRANSAKSI</span>
                        </div>
                      </div>
                      <!-- /.col -->
                      <div class="col-md-3 col-6">
                        <div class="text-center">
                          <span class="text-danger">
                            <i class="bi bi-caret-down-fill"></i> 18%
                          </span>
                          <h5 class="fw-bold mb-0">
                            Rp <?= number_format($pendapatan['total'] ?? 0); ?>
                          </h5>
                          <span class="text-uppercase">TOTAL PENDAPATAN</span>
                        </div>
                      </div>
                    </div>
                    <!--end::Row-->
                  </div>
                  <!-- /.card-footer -->
                </div>
                <!-- /.card -->
              </div>
              <!-- /.col -->
            </div>
            <!--end::Row-->

                  <div class="col-md-12">
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Daftar Customer</h3>

      <div class="card-tools">
        <span class="badge text-bg-info">
          <?= mysqli_num_rows($customers); ?> Customer
        </span>

        <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
          <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
          <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
        </button>
        <button type="button" class="btn btn-tool" data-lte-toggle="card-remove">
          <i class="bi bi-x-lg"></i>
        </button>
      </div>
    </div>

    <!-- CARD BODY -->
    <div class="card-body p-0">
      <div class="row text-center m-1"
           style="max-height:400px; overflow-y:auto;">

        <?php while ($c = mysqli_fetch_assoc($customers)) { ?>
          <div class="col-3 p-2">
            <div class="border rounded p-2 h-100">

              <!-- ICON -->
              <i class="bi bi-person-circle fs-1 text-primary"></i>

              <!-- NAMA -->
              <div class="fw-bold fs-7 text-truncate">
                <?= $c['nama_customer']; ?>
              </div>

              <!-- KODE CUSTOMER -->
              <div class="fs-8 text-muted">
                ID: <?= $c['id_customer']; ?>
              </div>

              <!-- NO HP -->
              <div class="fs-8 text-muted text-truncate">
                <?= $c['no_hp']; ?>
              </div>

              <!-- ALAMAT -->
              <div class="fs-8 text-muted text-truncate">
                <?= $c['alamat']; ?>
              </div>

              <!-- TANGGAL DAFTAR -->
              <div class="fs-8 text-secondary">
                <?= date('d M Y', strtotime($c['created_at'])); ?>
              </div>

            </div>
          </div>
        <?php } ?>

      </div>
    </div>
  </div>
</div>

                <!--end::Row-->

                <div class="card">
  <div class="card-header">
    <h3 class="card-title">Latest Transactions</h3>

    <div class="card-tools">
      <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
        <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
        <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
      </button>
      <button type="button" class="btn btn-tool" data-lte-toggle="card-remove">
        <i class="bi bi-x-lg"></i>
      </button>
    </div>
  </div>

  <!-- CARD BODY -->
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-bordered">
    <tr class="text-center">
      <th>No</th>
      <th>Tanggal</th>
      <th>Produk</th>
      <th>Total</th>
      <th>Status</th>
    </tr>

    <?php $no=1; while($l=mysqli_fetch_assoc($qlatest)){ ?>
    <tr>
      <td><?= $no++; ?></td>
      <td><?= $l['tanggal_transaksi']; ?></td>
      <td><?= $l['produk']; ?></td>
      <td>Rp <?= number_format($l['total_harga']); ?></td>
      <td>
        <span class="badge bg-warning">
          <?= $l['status_transaksi']; ?>
        </span>
      </td>
    </tr>
    <?php } ?>
    </table>

    </div>
  </div>

  <!-- CARD FOOTER -->
  <div class="card-footer clearfix">
    <a href="dashboard_admin.php?menu=transaksi_form" 
       class="btn btn-sm btn-primary float-start">
      Tambah Transaksi
    </a>

    <a href="dashboard_admin.php?menu=transaksi" 
       class="btn btn-sm btn-secondary float-end">
      Lihat Semua Transaksi
    </a>
  </div>
</div>

                <!-- /.card -->
              </div>
              <!-- /.col -->
<div class="container-fluid mt-4">
  <div class="row">

    <!-- KOLOM KIRI (4) -->
    <div class="col-md-4">

      <div class="info-box mb-3 text-bg-warning">
        <span class="info-box-icon">
          <i class="bi bi-box-seam"></i>
        </span>
        <div class="info-box-content">
          <span class="info-box-text">Total Produk</span>
          <span class="info-box-number"><?= $barang['total']; ?></span>
        </div>
      </div>

      <div class="info-box mb-3 text-bg-success">
        <span class="info-box-icon">
          <i class="bi bi-people-fill"></i>
        </span>
        <div class="info-box-content">
          <span class="info-box-text">Total Customer</span>
          <span class="info-box-number"><?= $cust['total']; ?></span>
        </div>
      </div>

      <div class="info-box mb-3 text-bg-danger">
        <span class="info-box-icon">
          <i class="bi bi-receipt"></i>
        </span>
        <div class="info-box-content">
          <span class="info-box-text">Total Transaksi</span>
          <span class="info-box-number"><?= $trans['total']; ?></span>
        </div>
      </div>

      <div class="info-box mb-3 text-bg-info">
        <span class="info-box-icon">
          <i class="bi bi-cart-check-fill"></i>
        </span>
        <div class="info-box-content">
          <span class="info-box-text">Total Produk Terjual</span>
          <span class="info-box-number"><?= $qty['total'] ?? 0; ?></span>
        </div>
      </div>

    </div>

    <!-- KOLOM KANAN (8) -->
    <div class="col-md-8">

      <div class="card mb-4">
        <div class="card-header">
          <h3 class="card-title">5 Produk Paling Laku</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
              <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
              <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
            </button>
            <button type="button" class="btn btn-tool" data-lte-toggle="card-remove">
              <i class="bi bi-x-lg"></i>
            </button>
          </div>
        </div>

        <div class="card-body p-0">
          <table class="table table-striped mb-0">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th class="text-end">Total Terjual</th>
              </tr>
            </thead>
            <tbody>
              <?php $no=1; while ($b = mysqli_fetch_assoc($topBarang)) { ?>
              <tr>
                <td><?= $no++; ?></td>
                <td><?= $b['nama_produk']; ?></td>
                <td class="text-end">
                  <span class="badge bg-success">
                    <?= $b['total_terjual']; ?> unit
                  </span>
                </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>

        <div class="card-footer text-muted">
          Menampilkan 5 barang dengan penjualan terbanyak
        </div>
      </div>

    </div>

  </div>
</div>


                <!-- /.card -->

                <!-- PRODUCT LIST -->
               <div class="card">
  <div class="card-header">
    <h3 class="card-title">Daftar Semua Produk</h3>

    <div class="card-tools">
      <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
        <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
        <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
      </button>
      <button type="button" class="btn btn-tool" data-lte-toggle="card-remove">
        <i class="bi bi-x-lg"></i>
      </button>
    </div>
  </div>

  <div class="card-body p-0">
    <!-- AREA SCROLL -->
    <div class="px-2" style="max-height:400px; overflow-y:auto;">

      <?php if (mysqli_num_rows($barangSemua) > 0) { ?>
        <?php while ($b = mysqli_fetch_assoc($barangSemua)) { ?>

          <?php
          $imgPath = "uploads/" . $b['gambar'];
          $img = (!empty($b['gambar']) && file_exists($imgPath))
                ? $imgPath
                : "uploads/default.png";
          ?>

          <div class="d-flex border-top py-2 px-1 align-items-center">
            <div class="col-2 text-center">
              <img src="<?= $img; ?>" class="img-size-50 rounded" />
            </div>

            <div class="col-10">
              <a href="#" class="fw-bold">
                <?= $b['nama_produk']; ?>
                <span class="badge text-bg-primary float-end">
                  Rp <?= number_format($b['harga'], 0, ',', '.'); ?>
                </span>
              </a>

              <div class="text-truncate text-muted">
                Stok: <?= $b['stok']; ?> | Kode: <?= $b['kode_produk']; ?>
              </div>
            </div>
          </div>

        <?php } ?>
      <?php } else { ?>

        <div class="text-center py-4 text-muted">
          Data barang belum tersedia
        </div>

      <?php } ?>

    </div>
  </div>
</div>


                      <!-- /.item -->
                    </div>
                  </div>
                  <!-- /.card-body -->
                  <div class="card-footer text-center">
                    <a href="dashboard_admin.php?menu=produk" class="uppercase"> View All Products </a>
                  </div>
                  <!-- /.card-footer -->
                </div>
                <!-- /.card -->
              </div>
              <!-- /.col -->
            </div>
            <!--end::Row-->
          </div>
          <!--end::Container-->
        </div>
        <!--end::App Content-->
      </main>