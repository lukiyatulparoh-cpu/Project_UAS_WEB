<?php
// ❌ jangan session_start kalau sudah di dashboard
include "koneksi2.php";

$id_transaksi = $_GET['id'] ?? '';

if ($id_transaksi == '') {
    echo "<div class='alert alert-danger'>ID Transaksi tidak ditemukan</div>";
    return;
}

/* ================= AMBIL DATA TRANSAKSI ================= */
$qTransaksi = mysqli_query($koneksi, "
    SELECT *
    FROM tb_transaksi
    WHERE id_transaksi = '$id_transaksi'
");

$transaksi = mysqli_fetch_assoc($qTransaksi);

if (!$transaksi) {
    echo "<div class='alert alert-danger'>Data transaksi tidak ditemukan</div>";
    return;
}

/* ================= AMBIL DETAIL PRODUK ================= */
$qDetail = mysqli_query($koneksi, "
    SELECT 
        d.jumlah,
        d.harga,
        p.nama_produk,
        p.gambar
    FROM tb_detail_transaksi d
    JOIN tb_produk p ON d.id_produk = p.id_produk
    WHERE d.id_transaksi = '$id_transaksi'
");
?>

<div class="container mt-4">

  <h4 class="fw-bold mb-3">📄 Detail Pesanan</h4>

  <!-- INFO TRANSAKSI -->
  <div class="card mb-4">
    <div class="card-body">
      <table class="table table-borderless mb-0">
        <tr>
          <td width="200">ID Transaksi</td>
          <td>: <strong><?= $transaksi['id_transaksi']; ?></strong></td>
        </tr>
        <tr>
          <td>Tanggal</td>
          <td>: <?= date('d M Y', strtotime($transaksi['tanggal_transaksi'])); ?></td>
        </tr>
        <tr>
          <td>Status</td>
          <td>:
            <span class="badge bg-warning">
              <?= $transaksi['status_transaksi']; ?>
            </span>
          </td>
        </tr>
        <tr>
          <td>Total Bayar</td>
          <td>: <strong>Rp <?= number_format($transaksi['total_harga']); ?></strong></td>
        </tr>
      </table>
    </div>
  </div>

  <!-- DETAIL PRODUK -->
  <div class="card">
    <div class="card-header fw-bold">
      🛒 Detail Produk
    </div>

    <div class="card-body p-0">
      <table class="table table-bordered mb-0 align-middle">
        <thead class="text-center">
          <tr>
            <th>No</th>
            <th>Produk</th>
            <th>Nama</th>
            <th>Harga</th>
            <th>Qty</th>
            <th>Subtotal</th>
          </tr>
        </thead>

        <tbody>
        <?php
        $no = 1;
        $grandTotal = 0;

        while ($d = mysqli_fetch_assoc($qDetail)) {
            $subtotal = $d['harga'] * $d['jumlah'];
            $grandTotal += $subtotal;
        ?>
          <tr>
            <td class="text-center"><?= $no++; ?></td>

            <td class="text-center">
              <img src="uploads/<?= $d['gambar']; ?>" width="60">
            </td>

            <td><?= $d['nama_produk']; ?></td>

            <td class="text-end">
              Rp <?= number_format($d['harga']); ?>
            </td>

            <td class="text-center">
              <?= $d['jumlah']; ?>
            </td>

            <td class="text-end">
              <strong>Rp <?= number_format($subtotal); ?></strong>
            </td>
          </tr>
        <?php } ?>
        </tbody>

        <tfoot>
          <tr>
            <th colspan="5" class="text-end">TOTAL</th>
            <th class="text-end text-success">
              Rp <?= number_format($grandTotal); ?>
            </th>
          </tr>
        </tfoot>

      </table>
    </div>
  </div>

  <!-- TOMBOL KEMBALI -->
   <div class="mt-4 d-flex gap-2">

  <a href="form/barang/invoice_pdf.php?id=<?= $transaksi['id_transaksi'] ?>" 
     target="_blank"
     class="btn btn-primary">
     🧾 Cetak Invoice
  </a>

</div>

  <div class="mt-3">
    <a href="dashboard_customer.php?menu=pesanan"
       class="btn btn-secondary btn-sm">
       ← Kembali ke Pesanan Saya
    </a>
  </div>

</div>
