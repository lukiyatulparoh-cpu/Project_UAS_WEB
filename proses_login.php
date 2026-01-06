<?php
session_start();
include 'koneksi2.php';

if (isset($_POST['btnLogin'])) {

    $email    = mysqli_real_escape_string($koneksi, $_POST['txtUsername']);
    $password = $_POST['txtPassword'];

    $query = mysqli_query($koneksi, "
        SELECT * FROM tb_users 
        WHERE email = '$email'
    ");

    if (mysqli_num_rows($query) > 0) {

        $data = mysqli_fetch_assoc($query);

        $dbPassword = $data['password'];
        $loginValid = false;

        // 🔐 Cek apakah password di database sudah di-hash
        if (password_verify($password, $dbPassword)) {
            $loginValid = true;
        }
        // 🧾 Untuk akun lama (password belum di-hash)
        else if ($password === $dbPassword) {
            $loginValid = true;

            // 🛡 Upgrade otomatis: hash password lama
            $newHash = password_hash($password, PASSWORD_DEFAULT);
            mysqli_query($koneksi, "
                UPDATE tb_users 
                SET password='$newHash'
                WHERE id_user='{$data['id_user']}'
            ");
        }

        if ($loginValid) {

            $_SESSION['login']   = true;
            $_SESSION['id_user'] = $data['id_user'];
            $_SESSION['email']   = $data['email'];
            $_SESSION['nama']    = $data['nama'];
            $_SESSION['role']    = $data['role'];

            if ($data['role'] == 'admin') {
                header("Location: dashboard_admin.php");
            } elseif ($data['role'] == 'owner') {
                header("Location: dashboard_owner.php");
            } else {
                header("Location: dashboard_customer.php");
            }
            exit;
        }

        echo "<script>
            alert('Password salah!');
            window.location='login.php';
        </script>";

    } else {
        echo "<script>
            alert('Email tidak ditemukan!');
            window.location='login.php';
        </script>";
    }
}
?>
