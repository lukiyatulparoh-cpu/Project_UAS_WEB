<?php
// ❌ JANGAN session_start()
include "koneksi2.php";

$id_user = $_SESSION['id_user'];

$qCust = mysqli_query($koneksi, "SELECT id_customer FROM tb_customer WHERE id_user='$id_user'");
$cust  = mysqli_fetch_assoc($qCust);

$id_customer = $cust['id_customer'];


$q = mysqli_query(
    $koneksi,
    "SELECT * 
     FROM tb_transaksi
     WHERE id_customer = '$id_customer'
     ORDER BY tanggal_transaksi DESC"
);

?>

<div class="container mt-4">

    <h4 class="fw-bold mb-3">📦 Pesanan Saya</h4>

    <?php if (mysqli_num_rows($q) == 0) : ?>

        <div class="alert alert-info">
            Belum ada pesanan
        </div>

    <?php else : ?>

        <table class="table table-bordered table-hover align-middle">
            <thead class="table-light text-center">
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Detail</th>
                </tr>
            </thead>

            <tbody>
                <?php $no = 1; ?>
                <?php while ($t = mysqli_fetch_assoc($q)) : ?>
                    <tr class="text-center">
                        <td><?= $no++; ?></td>
                        <td><?= $t['tanggal_transaksi']; ?></td>
                        <td>
                            Rp <?= number_format($t['total_harga'], 0, ',', '.'); ?>
                        </td>
                        <td>
                            <span class="badge bg-info">
                            <?= $t['status_transaksi']; ?>
                            </span>

                        </td>
                        <td>
                            <a href="dashboard_customer.php?menu=pesanan_detail&id=<?= $t['id_transaksi']; ?>"
                               class="btn btn-sm btn-primary">
                                Lihat
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
                
            </tbody>
        </table>

    <?php endif; ?>

</div>
