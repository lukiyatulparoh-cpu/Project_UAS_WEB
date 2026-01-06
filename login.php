<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Login | Clairmont Dessert</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="dist/css/adminlte.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

<style>
* {
  font-family: "Segoe UI", sans-serif;
}

body {
  background: linear-gradient(135deg, #ffe4e9, #e6f0ff);
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
}

.login-box {
  width: 380px;
}

.card {
  background: rgba(255,255,255,0.75);
  backdrop-filter: blur(12px);
  border-radius: 24px;
  border: none;
  box-shadow: 0 18px 40px rgba(0,0,0,0.15);
  overflow: hidden;
  animation: fadeIn 0.8s ease;
}

@keyframes fadeIn {
  from { opacity: 0; transform: translateY(20px);}
  to { opacity: 1; transform: translateY(0);}
}

.card-header {
  background: linear-gradient(135deg, #f3b6c2, #f7cdd4);
  color: #3b2f2f;
  text-align: center;
  padding: 1.8rem;
}

.card-header h3 {
  font-weight: 800;
  margin-bottom: 4px;
}

.login-card-body {
  background-color: transparent;
  padding: 2.4rem;
}

.input-group-text {
  background: #f3b6c2;
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

.btn-primary {
  background: linear-gradient(135deg, #f3b6c2, #f1aebd);
  border: none;
  border-radius: 18px;
  padding: 12px;
  font-weight: 700;
  color: #3b2f2f;
  transition: 0.3s;
}

.btn-primary:hover {
  background: linear-gradient(135deg, #f1aebd, #e59aaa);
  transform: translateY(-2px);
  box-shadow: 0 10px 18px rgba(0,0,0,0.12);
}

a {
  color: #f1aebd;
  font-weight: 600;
}

a:hover {
  color: #d98a99;
  text-decoration: none;
}

@media (max-width: 576px) {
  .login-box {
    width: 92%;
  }
}
</style>



</head>

<body class="login-page">

<div class="login-box">

  <div class="card card-outline">

    <div class="card-header text-center">
      <h3 class="mb-0 fw-bold">Welcome Sweeties</h3>
      <small>Silakan login untuk melanjutkan</small>
    </div>

    <div class="card-body login-card-body">

      <form action="proses_login.php" method="post">

        <div class="input-group mb-3">
          <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
          <input type="text" name="txtUsername" class="form-control" placeholder="Username" required>
        </div>

        <div class="input-group mb-4">
          <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
          <input type="password" name="txtPassword" class="form-control" placeholder="Password" required>
        </div>

        <button type="submit" name="btnLogin" class="btn btn-primary w-100">
          Login
        </button>

      </form>

      <p class="mt-3 text-center">
        <a href="register.php">Belum punya akun?</a>
      </p>

    </div>
  </div>
</div>

<script src="dist/js/adminlte.js"></script>
</body>
</html>
