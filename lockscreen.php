<?php
session_start();
include "koneksi2.php";

if (!isset($_SESSION['user'])) {
  header("Location: login.php");
  exit;
}

$user  = $_SESSION['user'];
$role  = $_SESSION['role'];
$nama  = $_SESSION['nama'];
$foto  = $_SESSION['foto'] ?? 'user1-128x128.jpg';
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>Clairmont Lockscreen</title>

<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="preload" href="/uas/css/adminlte.css" as="style" />
<link rel="stylesheet" href="/uas/css/adminlte.css" />

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>

<body class="lockscreen bg-body-secondary">

<div class="lockscreen-wrapper">

  <div class="lockscreen-logo">
    <a href="#"><b>Clairmont</b> System</a>
  </div>

  <div class="lockscreen-name"><?= $nama ?></div>

  <div class="lockscreen-item">

    <div class="lockscreen-image">
      <img src="/uas/assets/img/<?= $foto ?>" alt="User Image">
    </div>

    <form class="lockscreen-credentials" method="post" action="unlock.php">
      <div class="input-group">
        <input type="password" name="password" class="form-control shadow-none" placeholder="password" required>
        <div class="input-group-text border-0 bg-transparent px-1">
          <button type="submit" class="btn shadow-none">
            <i class="bi bi-box-arrow-right text-body-secondary"></i>
          </button>
        </div>
      </div>
    </form>

  </div>

  <div class="help-block text-center">Enter your password to retrieve your session</div>

  <div class="text-center">
    <a href="logout.php" class="text-decoration-none">Or sign in as a different user</a>
  </div>

  <div class="lockscreen-footer text-center">
    © 2026 <b>Clairmont System</b><br>All rights reserved
  </div>

</div>

<script src="/uas/js/adminlte.js"></script>

</body>
</html>
