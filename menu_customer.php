<style>
.sidebar-menu {
  padding: 15px;
}

.sidebar-menu .nav-item {
  margin-bottom: 6px;
}

.sidebar-menu .nav-link {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 12px 14px;
  border-radius: 14px;
  color: #3b2f2f;
  font-weight: 600;
  transition: 0.3s;
}

.sidebar-menu .nav-link:hover {
  background: rgba(243,182,194,0.25);
  transform: translateX(4px);
}

.sidebar-menu .nav-link.active {
  background: linear-gradient(135deg, #f3b6c2, #f1aebd);
  color: #3b2f2f;
  box-shadow: 0 6px 12px rgba(0,0,0,0.12);
}

.sidebar-menu .icon {
  font-size: 18px;
}

.sidebar-menu .logout .nav-link {
  margin-top: 18px;
  background: rgba(255,255,255,0.5);
}
</style>

<ul class="nav sidebar-menu flex-column">

  <li class="nav-item">
    <a href="dashboard_customer.php" class="nav-link <?= (!isset($_GET['menu'])) ? 'active' : '' ?>">
      <span class="icon">🏠</span> Home
    </a>
  </li>

  <li class="nav-item">
    <a href="dashboard_customer.php?menu=produk" class="nav-link <?= ($_GET['menu'] ?? '')=='produk' ? 'active' : '' ?>">
      <span class="icon">🛍️</span> Produk
    </a>
  </li>

  <li class="nav-item">
    <a href="dashboard_customer.php?menu=cart" class="nav-link <?= ($_GET['menu'] ?? '')=='cart' ? 'active' : '' ?>">
      <span class="icon">🛒</span> Keranjang
    </a>
  </li>

  <li class="nav-item">
    <a href="dashboard_customer.php?menu=pesanan" class="nav-link <?= ($_GET['menu'] ?? '')=='pesanan' ? 'active' : '' ?>">
      <span class="icon">📦</span> Pesanan Saya
    </a>
  </li>

  <li class="nav-item">
    <a href="dashboard_customer.php?menu=profil" class="nav-link <?= ($_GET['menu'] ?? '')=='profil' ? 'active' : '' ?>">
      <span class="icon">👤</span> Profil
    </a>
  </li>

  <li class="nav-item logout">
    <a href="logout.php" class="nav-link">
      <span class="icon">🚪</span> Logout
    </a>
  </li>

</ul>
