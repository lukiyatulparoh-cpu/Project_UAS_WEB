<?php
include "koneksi2.php";
?>

<div class="app-content">
<div class="container-fluid">
<div class="row">
<div class="col-md-12">

<div class="card mb-4 shadow-sm">

  <!-- HEADER -->
  <div class="d-flex justify-content-between align-items-center p-3 border-bottom">
      <h4 class="mb-0">Data Transaksi</h4>

      <?php if ($_SESSION['role'] == 'admin') { ?>
        <a href="dashboard_admin.php?menu=transaksi_form"
          class="btn btn-primary btn-sm px-4">
          <i class="bi bi-plus-circle"></i> Tambah Transaksi
        </a>
      <?php } ?>
  </div>

  <!-- FILTER -->
  <div class="px-3 pt-2 pb-3">
    <label class="form-label">Filter Tanggal</label>
    <input type="date" id="tanggal" class="form-control w-25">
  </div>

  <!-- BODY -->
  <div class="card-body p-0">
    <div id="tabelTransaksi"></div>
  </div>

</div>

</div>
</div>
</div>
</div>

<script>
document.getElementById('tanggal').addEventListener('change', function () {
  let tgl = this.value;

  if (tgl === "") {
    document.getElementById('tabelTransaksi').innerHTML = "";
    return;
  }

  fetch("form/transaksi/load_transaksi.php?tanggal=" + tgl)
    .then(res => res.text())
    .then(data => {
      document.getElementById('tabelTransaksi').innerHTML = data;
    });
});
</script>
