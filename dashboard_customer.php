<?php
session_start();
include "koneksi2.php";




// Redirect kalau belum login
if ($_SESSION['role'] != 'customer') {
    header("Location: ../login.php");
    exit;
}


// Anti cache paling keras
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");
?>

<!doctype html>
<html lang="en">
  <!--begin::Head-->
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Clairmont - Dashboard Customer</title>

    <!--begin::Accessibility Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
    <meta name="color-scheme" content="light dark" />
    <meta name="theme-color" content="#007bff" media="(prefers-color-scheme: light)" />
    <meta name="theme-color" content="#8d1010ff" media="(prefers-color-scheme: dark)" />
    <!--end::Accessibility Meta Tags-->

    <!--begin::Primary Meta Tags-->
    <meta name="title" content="AdminLTE | Dashboard v2" />
    <meta name="author" content="ColorlibHQ" />
    <meta
      name="description"
      content="AdminLTE is a Free Bootstrap 5 Admin Dashboard, 30 example pages using Vanilla JS. Fully accessible with WCAG 2.1 AA compliance."
    />
    <meta
      name="keywords"
      content="bootstrap 5, bootstrap, bootstrap 5 admin dashboard, bootstrap 5 dashboard, bootstrap 5 charts, bootstrap 5 calendar, bootstrap 5 datepicker, bootstrap 5 tables, bootstrap 5 datatable, vanilla js datatable, colorlibhq, colorlibhq dashboard, colorlibhq admin dashboard, accessible admin panel, WCAG compliant"
    />
    <!--end::Primary Meta Tags-->

    <!--begin::Accessibility Features-->
    <!-- Skip links will be dynamically added by accessibility.js -->
    <meta name="supported-color-schemes" content="light dark" />
    <link rel="preload" href="dist/css/adminlte.css" as="style" />
    <!--end::Accessibility Features-->

    <!--begin::Fonts-->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
      integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q="
      crossorigin="anonymous"
      media="print"
      onload="this.media='all'"
    />
    <!--end::Fonts-->

    <!--begin::Third Party Plugin(OverlayScrollbars)-->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css"
      crossorigin="anonymous"
    />
    <!--end::Third Party Plugin(OverlayScrollbars)-->

    <!--begin::Third Party Plugin(Bootstrap Icons)-->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
      crossorigin="anonymous"
    />
    <!--end::Third Party Plugin(Bootstrap Icons)-->

    <!--begin::Required Plugin(AdminLTE)-->
    <link rel="stylesheet" href="dist/css/adminlte.css" />
    <!--end::Required Plugin(AdminLTE)-->

    <!-- apexcharts -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.css"
      integrity="sha256-4MX+61mt9NVvvuPjUWdUdyfZfxSB1/Rf9WtqRHgG5S0="
      crossorigin="anonymous"
    />
  </head>

  <body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <!--begin::App Wrapper-->
    <div class="app-wrapper">
      <!--begin::Header-->
     <nav class="app-header navbar navbar-expand bg-primary-subtle" data-bs-theme="">
        <!--begin::Container-->
        <div class="container-fluid">
          <!--begin::Start Navbar Links-->
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                <i class="bi bi-list"></i>
              </a>
            </li>
          </ul>
          <!--end::Start Navbar Links-->

          <!--begin::End Navbar Links-->
          <ul class="navbar-nav ms-auto">
            <!--begin::Navbar Search-->
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button"
                data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-search"></i>
              </a>

              <ul class="dropdown-menu dropdown-menu-end shadow-sm">

                <li>
                  <a class="dropdown-item d-flex align-items-center gap-2"
                    href="dashboard_customer.php?menu=produk">
                    🧁 <span>Cari Produk</span>
                  </a>
                </li>

                <li>
                  <a class="dropdown-item d-flex align-items-center gap-2"
                    href="dashboard_customer.php?menu=pesanan">
                    🧾 <span>Pesanan Saya</span>
                  </a>
                </li>

                <li>
                  <a class="dropdown-item d-flex align-items-center gap-2"
                    href="dashboard_customer.php?menu=cart">
                    🛒 <span>Keranjang</span>
                  </a>
                </li>

              </ul>
            </li>
            <!--end::Navbar Search-->

            <!--begin::Fullscreen Toggle-->
            <li class="nav-item">
              <a class="nav-link" href="#" data-lte-toggle="fullscreen">
                <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i>
                <i data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display: none"></i>
              </a>
            </li>
            <!--end::Fullscreen Toggle-->

            <!--begin::User Menu Dropdown-->
            <li class="nav-item dropdown user-menu">

            <a href="#" class="nav-link dropdown-toggle d-flex align-items-center gap-2"
              data-bs-toggle="dropdown">

              <div class="rounded-circle d-flex justify-content-center align-items-center shadow"
                  style="width:36px;height:36px;background:#7c3aed;color:white;">
                <i class="bi bi-person-fill fs-5"></i>
              </div>

              <span class="d-none d-md-inline fw-semibold text-dark">
                <?= ucwords(str_replace('@',' ', explode('@', $_SESSION['email'])[0])); ?>
              </span>
            </a>

            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end shadow"
                style="min-width: 240px;">

              <li class="user-header text-center"
                  style="background:linear-gradient(135deg,#7c3aed,#a78bfa); color:white;">

                <div class="mx-auto mb-2 rounded-circle d-flex justify-content-center align-items-center"
                    style="width:64px;height:64px;background:white;color:#7c3aed;">
                  <i class="bi bi-person-fill fs-1"></i>
                </div>

                <p class="mb-0 fw-semibold">
                  <?= ucwords(str_replace('@',' ', explode('@', $_SESSION['email'])[0])); ?>
                </p>

                <small><?= $_SESSION['email']; ?></small>
              </li>

                <!--end::User Image-->
                <!--begin::Menu Body-->
                <li class="user-body">
                  <!--begin::Row-->
                  <div class="row">
                    <div class="col-4 text-center">
                      <a href="#">Followers</a>
                    </div>
                    <div class="col-4 text-center">
                      <a href="#">Sales</a>
                    </div>
                    <div class="col-4 text-center">
                      <a href="#">Friends</a>
                    </div>
                  </div>
                  <!--end::Row-->
                </li>
                <!--end::Menu Body-->
                <!--begin::Menu Footer-->
                <li class="user-footer">
                  <a href="#" class="btn btn-default btn-flat">Profile</a>
                  <a href="logout.php" class="btn btn-default btn-flat float-end">Sign out</a>
                </li>
                <!--end::Menu Footer-->
              </ul>
            </li>
            <!--end::User Menu Dropdown-->
          </ul>
          <!--end::End Navbar Links-->
        </div>
        <!--end::Container-->
      </nav>
      <!--end::Header-->
      
      <!--begin::Sidebar-->
      <aside class="app-sidebar bg-danger-subtle" data-bs-theme="">
        <!--begin::Sidebar Brand-->
        <div class="sidebar-brand">
          <!--begin::Brand Link-->
          <a href="./index.html" class="brand-link">
            <!--begin::Brand Image-->
            <img
              src="./dist/assets/img/logo.jpeg"
              alt="AdminLTE Logo"
              class="brand-image opacity-75 shadow"
            />
            <!--end::Brand Image-->
            <!--begin::Brand Text-->
            <span class="brand-text fw-light">Clairmont Dessert</span>
            <!--end::Brand Text-->
          </a>
          <!--end::Brand Link-->
        </div>
        <!--end::Sidebar Brand-->
        <!--begin::Sidebar Wrapper-->
        <div class="sidebar-wrapper">
          <nav class="mt-2">
          <?php
            include "menu_customer.php";
          ?>        
          </nav>
        </div>
        <!--end::Sidebar Wrapper-->
      </aside>
      <!--end::Sidebar-->
      <!--begin::App Main-->
<?php
$menu = isset($_GET['menu']) ? $_GET['menu'] : '';
switch ($menu) {
  // data barang
    case 'produk':
        include "form/barang/view.php";
        break;
    case 'barang_form':
        include "form/barang/form_barang.php";
        break;
     case 'load_produk':
        include "form/barang/load_produk.php";
        break;
    case 'cart_add':
        include "form/barang/cart_add.php";
        break;
    case 'cart':
        include "form/barang/cart.php";
        break;
    case 'cart_update':
        include "form/barang/cart_update.php";
        break;
    case 'checkout':
        include "form/barang/checkout.php";
        break;
    case 'checkout_proses':
        include "form/barang/checkout_proses.php";
        break;
    case 'checkout_sukses':
        include "form/barang/checkout_sukses.php";
        break;
    case 'checkout_info':
        include "form/barang/checkout_info.php";
        break;
    case 'pesanan':
        include "form/barang/pesanan.php";
        break;
    case 'pesanan_detail':
        include "form/barang/pesanan_detail.php";
        break;
    case 'invoice_pdf' :
      include "form/barang/invoice_pdf.php";
        break;
    case 'profil' :
      include "form/barang/profil.php";
        break;
    case 'logout' :
      include "logout.php";
        break;



  // data customer
    case 'customer':
        include "form/customer/view.php";
        break;
    case 'customer_form':
        include "form/customer/form_customer.php";
        break;

  // data transaksi
    case 'transaksi':
        include "form/transaksi/view.php";
        break;
    case 'transaksi_form':
        include "form/transaksi/form_transaksi.php";
        break;
    case 'load_transaksi':
        include "form/transaksi/load_transaksi.php";
        break;
  // laporan 
    case 'view_barang':
        include "laporan/view_barang.php";
        break;
    case 'view_customer':
        include "laporan/view_customer.php";
        break;
    case 'lap_transaksi':
        include "laporan/lap_transaksi.php";
        break;
    
  // edit
    case 'edit_barang':
        include "form/barang/edit.php";
        break;
    case 'edit_customer':
        include "form/customer/edit.php";
        break;
    case 'edit_transaksi':
        include "form/transaksi/edit.php";
        break;
  
  // hapus
    case 'hapus_barang':
        include "form/barang/hapus.php";
        break;
    case 'hapus_customer':
        include "form/customer/hapus.php";
        break;
    case 'hapus_transaksi':
        include "form/transaksi/edit.php";
        break;

  // tambah stok
    case 'tambah_stok':
        include "form/stok_barang/form_stok.php";
        break;

    default:
        include "main_customer.php";
        break;
}
?>

      <!--end::App Main-->
      <!--begin::Footer-->
      <footer class="app-footer bg-primary-subtle" data-bs-theme="">
        <!--begin::To the end-->
        <div class="float-end d-none d-sm-inline">Anything you want</div>
        <!--end::To the end-->
        <!--begin::Copyright-->
        <strong>
          Copyright &copy; 2025-2026&nbsp;
          <a href="https://adminlte.io" class="text-decoration-none">Clairmont Dessert</a>.
        </strong>
        All rights reserved.
        <!--end::Copyright-->
      </footer>
      <!--end::Footer-->
    </div>
    <!--end::App Wrapper-->
    <!--begin::Script-->
    <!--begin::Third Party Plugin(OverlayScrollbars)-->
    <script
      src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js"
      crossorigin="anonymous"
    ></script>
    <!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Required Plugin(popperjs for Bootstrap 5)-->
    <script
      src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
      crossorigin="anonymous"
    ></script>
    <!--end::Required Plugin(popperjs for Bootstrap 5)--><!--begin::Required Plugin(Bootstrap 5)-->
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js"
      crossorigin="anonymous"
    ></script>
    <!--end::Required Plugin(Bootstrap 5)--><!--begin::Required Plugin(AdminLTE)-->
    <script src="dist/js/adminlte.js"></script>
    <!--end::Required Plugin(AdminLTE)--><!--begin::OverlayScrollbars Configure-->
    <script>
      const SELECTOR_SIDEBAR_WRAPPER = '.sidebar-wrapper';
      const Default = {
        scrollbarTheme: 'os-theme-light',
        scrollbarAutoHide: 'leave',
        scrollbarClickScroll: true,
      };
      document.addEventListener('DOMContentLoaded', function () {
        const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);

        // Disable OverlayScrollbars on mobile devices to prevent touch interference
        const isMobile = window.innerWidth <= 992;

        if (
          sidebarWrapper &&
          OverlayScrollbarsGlobal?.OverlayScrollbars !== undefined &&
          !isMobile
        ) {
          OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
            scrollbars: {
              theme: Default.scrollbarTheme,
              autoHide: Default.scrollbarAutoHide,
              clickScroll: Default.scrollbarClickScroll,
            },
          });
        }
      });
    </script>
    <!--end::OverlayScrollbars Configure-->

    <!-- OPTIONAL SCRIPTS -->

    <!-- apexcharts -->
    <script
      src="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.min.js"
      integrity="sha256-+vh8GkaU7C9/wbSLIcwq82tQ2wTf44aOHA8HlBMwRI8="
      crossorigin="anonymous"
    ></script>

    <script>
      // NOTICE!! DO NOT USE ANY OF THIS JAVASCRIPT
      // IT'S ALL JUST JUNK FOR DEMO
      // ++++++++++++++++++++++++++++++++++++++++++

      /* apexcharts
       * -------
       * Here we will create a few charts using apexcharts
       */

    
  //-----------------------
  // - MONTHLY SALES CHART -
  //-----------------------

  const sales_chart_options = {
    series: [{
      name: 'Total Penjualan',
      data: <?= json_encode($total ?: [0]); ?>
    }],
    chart: {
      height: 180,
      type: 'area',
      toolbar: { show: false }
    },
    dataLabels: { enabled: false },
    stroke: { curve: 'smooth' },
    colors: ['#0d6efd'],
    xaxis: {
      type: 'datetime',
      categories: <?= json_encode($bulan ?: [date('Y-m-01')]); ?>
    },
    tooltip: {
      x: { format: 'MMMM yyyy' },
      y: {
        formatter: function (val) {
          return 'Rp ' + val.toLocaleString();
        }
      }
    }
  };

  const sales_chart = new ApexCharts(
    document.querySelector('#sales-chart'),
    sales_chart_options
  );
  sales_chart.render();

  //---------------------------
  // - END MONTHLY SALES CHART -
  //---------------------------

      function createSparklineChart(selector, data) {
        const options = {
          series: [{ data }],
          chart: {
            type: 'line',
            width: 150,
            height: 30,
            sparkline: {
              enabled: true,
            },
          },
          colors: ['var(--bs-primary)'],
          stroke: {
            width: 2,
          },
          tooltip: {
            fixed: {
              enabled: false,
            },
            x: {
              show: false,
            },
            y: {
              title: {
                formatter() {
                  return '';
                },
              },
            },
            marker: {
              show: false,
            },
          },
        };

        const chart = new ApexCharts(document.querySelector(selector), options);
        chart.render();
      }

      const table_sparkline_1_data = [25, 66, 41, 89, 63, 25, 44, 12, 36, 9, 54];
      const table_sparkline_2_data = [12, 56, 21, 39, 73, 45, 64, 52, 36, 59, 44];
      const table_sparkline_3_data = [15, 46, 21, 59, 33, 15, 34, 42, 56, 19, 64];
      const table_sparkline_4_data = [30, 56, 31, 69, 43, 35, 24, 32, 46, 29, 64];
      const table_sparkline_5_data = [20, 76, 51, 79, 53, 35, 54, 22, 36, 49, 64];
      const table_sparkline_6_data = [5, 36, 11, 69, 23, 15, 14, 42, 26, 19, 44];
      const table_sparkline_7_data = [12, 56, 21, 39, 73, 45, 64, 52, 36, 59, 74];

      createSparklineChart('#table-sparkline-1', table_sparkline_1_data);
      createSparklineChart('#table-sparkline-2', table_sparkline_2_data);
      createSparklineChart('#table-sparkline-3', table_sparkline_3_data);
      createSparklineChart('#table-sparkline-4', table_sparkline_4_data);
      createSparklineChart('#table-sparkline-5', table_sparkline_5_data);
      createSparklineChart('#table-sparkline-6', table_sparkline_6_data);
      createSparklineChart('#table-sparkline-7', table_sparkline_7_data);

      //-------------
      // - PIE CHART -
      //-------------

      const pie_chart_options = {
        series: [700, 500, 400, 600, 300, 100],
        chart: {
          type: 'donut',
        },
        labels: ['Chrome', 'Edge', 'FireFox', 'Safari', 'Opera', 'IE'],
        dataLabels: {
          enabled: false,
        },
        colors: ['#0d6efd', '#20c997', '#ffc107', '#d63384', '#6f42c1', '#adb5bd'],
      };

      const pie_chart = new ApexCharts(document.querySelector('#pie-chart'), pie_chart_options);
      pie_chart.render();

      //-----------------
      // - END PIE CHART -
      //-----------------
    </script>
    <!--end::Script-->
  </body>
  <!--end::Body-->
</html>
