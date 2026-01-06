<?php
include "koneksi2.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../../login.php");
    exit;
}

$q = mysqli_query($koneksi, "
    SELECT t.*, c.nama_customer
    FROM tb_transaksi t
    JOIN tb_customer c ON t.id_customer = c.id_customer
    ORDER BY t.tanggal_transaksi DESC
");
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Kelola Transaksi</title>

<style>
/* ===============================
   BACKGROUND HALAMAN (SOFT)
================================ */
body {
    background-color: #f5f5dc;
    font-family: 'Segoe UI', sans-serif;
}

/* ===============================
   CONTAINER
================================ */
.container {
    background-color: transparent;
}

/* ===============================
   TABLE SOFT ELEGANT
================================ */
.table-clairmont {
    color: #2e2a44;
}

.table-clairmont thead {
    background-color: #b6a6d6;
}

.table-clairmont th,
.table-clairmont td {
    border-color: #c4b5fd;
}

.table-clairmont tbody tr:hover {
    background-color: #ddd6fe;
}

/* ===============================
   BADGE STATUS
================================ */
.badge-selesai {
    background-color: #7cb69d;
    color: #064e3b;
}

.badge-proses {
    background-color: #fddd5c;
    color: #713f12;
}

.badge-batal {
    background-color: #ff6961;
    color: #7f1d1d;
}

/* ===============================
   BUTTON
================================ */
.btn-update {
    background-color: #fbcfe8;
    color: #831843;
    border: none;
}

.btn-update:hover {
    background-color: #f9a8d4;
}

.btn-lihat {
    background-color: #bae6fd;
    color: #075985;
    border: none;
}

.btn-lihat:hover {
    background-color: #7dd3fc;
}

/* ===============================
   DROPDOWN STATUS (PASTEL)
================================ */
.form-select {
    background-color: #ede9fe;      /* ungu pastel muda */
    color: #3b2f5c;                 /* ungu teks */
    border: 1px solid #c4b5fd;
    border-radius: 8px;
}

.form-select:focus {
    background-color: #f5f3ff;
    border-color: #a78bfa;
    box-shadow: 0 0 0 0.2rem rgba(167, 139, 250, 0.25);
    color: #2e1065;
}

/* option dropdown */
.form-select option {
    background-color: #f5f3ff;
    color: #2e1065;
}

</style>
</head>

<body>

<div class="container mt-4">
    <h3 class="mb-4 fw-bold text-secondary">💸 Kelola Transaksi</h3>

    <div class="table-responsive">
        <table class="table table-clairmont table-bordered table-hover align-middle">
            <thead class="text-center">
                <tr>
                    <th>Kode</th>
                    <th>Customer</th>
                    <th>Tanggal</th>
                    <th>Total</th>
                    <th>Metode</th>
                    <th>Status</th>
                    <th>Bukti</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>

            <?php if (mysqli_num_rows($q) == 0) { ?>
                <tr>
                    <td colspan="8" class="text-center text-muted">
                        Belum ada transaksi
                    </td>
                </tr>
            <?php } ?>

            <?php while ($t = mysqli_fetch_assoc($q)) {
                $status = $t['status_transaksi'];
                $badge = match ($status) {
                    'selesai' => 'badge-selesai',
                    'proses'  => 'badge-proses',
                    'batal'   => 'badge-batal',
                    default   => 'bg-secondary'
                };
            ?>
                <tr>
                    <td><?= htmlspecialchars($t['kode_transaksi']); ?></td>
                    <td><?= htmlspecialchars($t['nama_customer']); ?></td>

                    <td class="text-center">
                        <?= date('d M Y H:i', strtotime($t['tanggal_transaksi'])); ?>
                    </td>

                    <td class="text-end">
                        Rp <?= number_format($t['total_harga'], 0, ',', '.'); ?>
                    </td>

                    <td class="text-center">
                        <?= htmlspecialchars($t['metode_pembayaran']); ?>
                    </td>

                    <td class="text-center">
                        <span class="badge <?= $badge; ?>">
                            <?= ucfirst($status); ?>
                        </span>
                    </td>

                    <td class="text-center">
                        <?php if (!empty($t['bukti_transfer'])) { ?>
                            <a href="../uas/uploads/bukti/<?= $t['bukti_transfer']; ?>"
                               target="_blank"
                               class="btn btn-lihat btn-sm">
                                Lihat
                            </a>
                        <?php } else { ?>
                            <span class="text-muted">-</span>
                        <?php } ?>
                    </td>

                    <td class="text-center">
                        <form action="form/transaksi/update_status.php"
                              method="POST"
                              class="d-flex gap-2 justify-content-center">

                            <input type="hidden" name="id_transaksi"
                                   value="<?= $t['id_transaksi']; ?>">

                            <select name="status"
                                    class="form-select form-select-sm"
                                    <?= $status=='selesai'?'disabled':''; ?>>
                                <option value="pending" <?= $status=='pending'?'selected':''; ?>>Pending</option>
                                <option value="proses"  <?= $status=='proses'?'selected':''; ?>>Proses</option>
                                <option value="selesai" <?= $status=='selesai'?'selected':''; ?>>Selesai</option>
                                <option value="batal"   <?= $status=='batal'?'selected':''; ?>>Batal</option>
                            </select>

                            <button type="submit"
                                    class="btn btn-update btn-sm"
                                    <?= $status=='selesai'?'disabled':''; ?>>
                                Update
                            </button>
                        </form>
                    </td>
                </tr>
            <?php } ?>

            </tbody>
        </table>
    </div>
</div>

</body>
</html>