<?php
session_start();
include 'koneksi2.php';

if (isset($_POST['btnRegister'])) {

    $nama     = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $email    = mysqli_real_escape_string($koneksi, $_POST['email']);
    $password = $_POST['password'];

    // 🔎 Cek email
    $cek = mysqli_query($koneksi, "SELECT * FROM tb_users WHERE email='$email'");
    if (mysqli_num_rows($cek) > 0) {
        echo "<script>alert('Email sudah terdaftar'); window.location='register.php';</script>";
        exit;
    }

    // 🔐 Hash password
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    // 🧮 Generate kode user
    $qUser = mysqli_query($koneksi, "SELECT MAX(id_user) AS last FROM tb_users");
    $dUser = mysqli_fetch_assoc($qUser);
    $nextUser = $dUser['last'] + 1;
    $kode_user = 'USR-' . str_pad($nextUser, 3, '0', STR_PAD_LEFT);

    mysqli_begin_transaction($koneksi);

    // 💾 Simpan ke tb_users
    mysqli_query($koneksi, "
        INSERT INTO tb_users (kode_user, nama, email, password, role, status, created_at)
        VALUES ('$kode_user','$nama','$email','$passwordHash','customer','aktif',NOW())
    ");

    $id_user = mysqli_insert_id($koneksi);

    // 🧮 Generate kode customer
    $qCus = mysqli_query($koneksi, "SELECT MAX(id_customer) AS last FROM tb_customer");
    $dCus = mysqli_fetch_assoc($qCus);
    $nextCus = $dCus['last'] + 1;
    $kode_customer = 'CST-' . str_pad($nextCus, 3, '0', STR_PAD_LEFT);

    // 💾 Simpan ke tb_customer (data minimal dulu)
    mysqli_query($koneksi, "
        INSERT INTO tb_customer
        (kode_customer, id_user, nama_customer, email, status, created_at)
        VALUES
        ('$kode_customer','$id_user','$nama','$email','aktif',NOW())
    ");

    mysqli_commit($koneksi);

    echo "<script>alert('Registrasi berhasil, silakan login'); window.location='login.php';</script>";
}
?>
