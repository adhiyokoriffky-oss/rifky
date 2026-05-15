<?php

session_start();
include 'koneksi.php';

// cek apakah sudah login
if (!isset($_SESSION['login'])) {
    header('Location: login.php');
    exit;
}

if (isset($_POST['submit'])) {

  $product_id = $_POST['product_id'];
  $change_type = $_POST['change_type'];
  $qty = intval($_POST['qty']);
  $note = $_POST['note'];
  $user_id = $_SESSION['user_id'];

  // Ambil stok sekarang
  $q = mysqli_query($conn, "SELECT stock FROM products WHERE id = '$product_id'");
  $data = mysqli_fetch_assoc($q);

  $stock_before = $data['stock'];

  // Hitung stok baru
  if ($change_type == 'ADD') {
    $stock_after = $stock_before + $qty;
  } else {
    $stock_after = $stock_before - $qty;
    if ($stock_after < 0) {
      echo "<script>alert('Stok tidak cukup');</script>";
      exit;
    }
  }

  // Update stok
  mysqli_query($conn, "UPDATE products SET stock = '$stock_after' WHERE id = '$product_id'");

  // insert log
  mysqli_query($conn, "INSERT INTO stock_logs (product_id, change_type, qty, stock_before, stock_after, note, created_by) 
                      VALUES ('$product_id', '$change_type', '$qty', '$stock_before', '$stock_after', '$note', '$user_id')");

                      header("Location: stok.php?success=1");
                      exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Stock - InvAdmin</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>
<?php if (isset($_GET['success'])): ?>
  <script>
    alert('Stok berhasil diperbarui!');
  </script>
<?php endif; ?>
  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="index.php" class="logo d-flex align-items-center">
        <img src="assets/img/logo.png" alt="">
        <span class="d-none d-lg-block">InvAdmin</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->


    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">
        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="assets/img/profile-img.jpg" alt="Profile" class="rounded-circle">
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6><?php echo isset($_SESSION['name']) ? $_SESSION['name'] : 'User'; ?></h6>
              <span><?php echo isset($_SESSION['role']) ? $_SESSION['role'] : 'Role'; ?></span>
            </li>
            <li>
              <hr class="dropdown-divider" />
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="logout.php">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
              </a>
            </li>
          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->
      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
   <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link collapsed" href="index.php">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="kategori_produk.php">
          <i class="bi bi-tags"></i>
          <span>Kategori Produk</span>
        </a>
      </li><!-- End Profile Page Nav -->

      <li class="nav-item">
        <a class="nav-link " href="produk.php">
          <i class="bi bi-box-seam"></i>
          <span>Data Produk</span>
        </a>
      </li><!-- End Data Produk Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="laporan.php">
          <i class="bi bi-bar-chart-line"></i>
          <span>Laporan</span>
        </a>
      </li><!-- End Laporan Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="users.php">
          <i class="bi bi-people"></i>
          <span>Manajemen User</span>
        </a>
      </li><!-- End Register Page Nav -->
    </ul>

  </aside><!-- End Sidebar-->

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Manajemen Stok</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="produk.php">Data Produk</a></li>
          <li class="breadcrumb-item active">Manajemen Stok</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <!-- FORM MANAJEMEN STOK -->
        <div class="col-lg-6">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Manajemen Stok</h5>
              <form method="post">
              <div class="mb-3">
                <label class="form-label">Pilih Produk</label>
                <select name="product_id" class="form-select" required>
                  <option value="">-- Pilih Produk --</option>
                  <?php
                  include 'koneksi.php';
                  $produk = mysqli_query($conn, "SELECT * FROM products");
                  while ($p = mysqli_fetch_assoc($produk)) {
                    echo "<option value='{$p['id']}'>{$p['product_name']}</option>";
                  }
                  ?>
                </select>
              </div>
              <div class="mb-3">
                <label class="form-label">Jenis Aksi</label>
                <select name="change_type" class="form-select">
                  <option value="ADD">Tambah Stok</option>
                  <option value="REDUCE">Kurangi Stok</option>
                </select>
              </div>
              <div class="mb-3">
                <label class="form-label">Jumlah</label>
                <input type="number" name="qty" class="form-control" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Catatan</label>
                <textarea name="note" class="form-control" rows="2"></textarea>
              </div>
              <button type="submit" name="submit" class="btn btn-primary">Simpan Perubahan</button>
              </form>
            </div>
          </div>
        </div>

        <!-- RIWAYAT STOK -->
        <div class="col-lg-6">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Riwayat Stok</h5>

              <table class="table table-striped">
                <thead>
                  <tr>
                    <th scope="col">Tanggal</th>
                    <th scope="col">Produk</th>
                    <th scope="col">Aksi</th>
                    <th scope="col">Qty</th>
                    <th scope="col">User</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $query = mysqli_query($conn, "SELECT sl.*, p.product_name, u.name FROM stock_logs sl 
                            JOIN products p ON sl.product_id = p.id 
                            JOIN users u ON sl.created_by = u.id 
                            ORDER BY sl.created_at DESC");
                  while ($row = mysqli_fetch_assoc($query)) {
                    $badge = $row['change_type'] == 'ADD'
                    ? "<span class='badge bg-success'>+ (ADD)</span>"
                    : "<span class='badge bg-danger'>- (REDUCE)</span>";
                    echo "<tr>
                            <td>" . date('d M Y H:i', strtotime($row['created_at'])) . "</td>
                            <td>{$row['product_name']}</td>
                            <td>{$badge}</td>
                            <td>{$row['qty']}</td>
                            <td>{$row['name']}</td>
                          </tr>";
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </section>

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="copyright">
      &copy; Copyright <strong><span>InvAdmin</span></strong>. All Rights Reserved
    </div>
    <div class="credits">
      Designed by <a href="https://www.instagram.com/mchrifkyadhiyoko/">RifkyAdhiyoko</a>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.min.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>