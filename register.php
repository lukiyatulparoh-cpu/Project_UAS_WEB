<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Register | Sistem Penjualan</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="dist/css/adminlte.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

<style>
/* ================= GLOBAL ================= */
* {
  font-family: "Segoe UI", sans-serif;
}

body {
  background-color: #ffe4e9; /* pink pastel */
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
}

/* ================= REGISTER BOX ================= */
.register-box {
  width: 400px;
}

/* ================= CARD ================= */
.card {
  background-color: #e6f0ff; /* biru pastel */
  border-radius: 22px;
  border: none;
  box-shadow: 0 16px 35px rgba(0,0,0,0.15);
  overflow: hidden;
}

/* ================= HEADER ================= */
.card-header {
  background-color: #f3b6c2; /* pink accent */
  color: #3b2f2f;
  text-align: center;
  padding: 1.6rem;
}

.card-header h3 {
  font-weight: 700;
  margin-bottom: 4px;
}

/* ================= BODY ================= */
.register-card-body {
  background-color: #ffffff;
  padding: 2.4rem;
}

/* ================= INPUT ================= */
.input-group-text {
  background-color: #f3b6c2;
  border: none;
  color: #3b2f2f;
  border-radius: 14px 0 0 14px;
}

.form-control {
  border: 1px solid #e6f0ff;
  border-left: none;
  border-radius: 0 14px 14px 0;
  padding: 12px;
  color: #3b2f2f;
}

.form-control:focus {
  box-shadow: none;
  border-color: #f3b6c2;
}

/* ================= BUTTON ================= */
.btn-primary {
  background-color: #f3b6c2;
  border: none;
  border-radius: 16px;
  padding: 12px;
  font-weight: 700;
  color: #3b2f2f;
  transition: 0.25s;
}

.btn-primary:hover {
  background-color: #e7a2b0;
  transform: translateY(-1px);
}

/* ================= LINK ================= */
a {
  color: #f3b6c2;
  font-weight: 600;
}

a:hover {
  color: #d98a99;
  text-decoration: none;
}

/* ================= RESPONSIVE ================= */
@media (max-width: 576px) {
  .register-box {
    width: 90%;
  }
}

</style>

</head>

<body class="register-page">

<div class="register-box">
<div class="card">
<div class="card-header text-center">
  <h3 class="fw-bold mb-0">Registrasi Akun</h3>
  <small>Daftar untuk masuk ke sistem</small>
</div>

<div class="card-body register-card-body">

<form action="proses_register.php" method="post">

<div class="input-group mb-3">
  <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
  <input type="text" name="nama" class="form-control" placeholder="Nama Lengkap" required>
</div>

<div class="input-group mb-3">
  <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
  <input type="email" name="email" class="form-control" placeholder="Email" required>
</div>

<div class="input-group mb-4">
  <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
  <input type="password" name="password" class="form-control" placeholder="Password" required>
</div>

<button type="submit" name="btnRegister" class="btn btn-primary w-100">
  Daftar
</button>


</form>

<p class="text-center mt-3">
  Sudah punya akun? <a href="login.php">Login</a>
</p>

</div>
</div>
</div>

<script src="dist/js/adminlte.js"></script>
</body>
</html>
