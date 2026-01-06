<?php
include 'koneksi2.php';

$passwordBaru = password_hash('admin123', PASSWORD_DEFAULT);

mysqli_query($koneksi, "
    UPDATE tb_users 
    SET password = '$passwordBaru'
    WHERE email = 'admin@gmail.com'
");

echo "Password admin berhasil di-hash";
