<?php
include "koneksi.php";

$auto = mysqli_query($conn, "select max(product_code) as max_code from products");
$hasil = mysqli_fetch_array($auto);
$code = $hasil['max_code'];
if ($code == NULL) {
    $urutan = 0;
} else {
    $urutan = (int) substr($code, 1, 3);
}
$urutan++;
$huruf = "P";
$kd_produk = $huruf . sprintf("%03s", $urutan);
if (isset($_POST['simpan'])) {
    $nm_produk = $_POST['nm_produk'];
    $stok = $_POST['stok'];
    $min_stok = $_POST['min_stok'];
    $harga = $_POST['harga'];
    $id_kategori = $_POST['id_kategori'];

    // Upload Gambar
    $imgfile = $_FILES['gambar']['name'];
    $tmp_file = $_FILES['gambar']['tmp_name'];
    $extension = strtolower(pathinfo($imgfile, PATHINFO_EXTENSION));

    $dir = "produk_img/";
    $allowed_extensions = array("jpg", "jpeg", "png", "webp");

    if (!in_array($extension, $allowed_extensions)) {
        echo "<script>alert('Format tidak valid. Hanya jpg, jpeg, png, dan webp yang diperbolehkan.');</script>";
    } else {
        $imgnewfile = md5(time() . $imgfile) . "." . $extension;
        move_uploaded_file($tmp_file, $dir . $imgnewfile);

        $query = mysqli_query($conn, "INSERT INTO products(category_id, product_code), product_name, stock, min_stock, price, gambar) VALUES ('$id_kategori', '$kd_produk', '$nm_produk', '$stok', '$min_stok', '$harga', '$$imgnewfile')");
        if ($query) {
            echo "<script>alert('Produk berhasil ditambahkan!')</script>";
            header("refresh:0, produk.php");
        } else {
            echo "<script>alert('Produk gagal ditambahkan!')</script>";
            header("refresh:0, produk.php");
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Kategori Produk - InvAdmin</title>
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
        <li class="nav-item dropdown">
        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="assets/img/profile-img.jpg" alt="Profile" class="rounded-circle">
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6>Kevin Anderson</h6>
              <span>Web Designer</span>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                <i class="bi bi-person"></i>
                <span>My Profile</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                <i class="bi bi-gear"></i>
                <span>Account Settings</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="pages-faq.html">
                <i class="bi bi-question-circle"></i>
                <span>Need Help?</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="login.php">
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
            </li><!-- End F.A.Q Page Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" href="laporan.php">
                    <i class="bi bi-bar-chart-line"></i>
                    <span>Laporan</span>
                </a>
            </li><!-- End Contact Page Nav -->

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
            <h1>Data Produk</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="produk.php">Data Produk</a></li>
                    <li class="breadcrumb-item active">Tambah</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->
        <section class="section">
            <div class="row">
                <div class="col-lg-6">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Tambah Produk</h5>

                            <!-- Vertical Form -->
                            <form class="row g-3" method="post" enctype="multipart/form-data">
                                <div class="col-12">
                                    <label for="kd_produk" class="form-label">Kode Produk</label>
                                    <input type="text" class="form-control" id="kd_produk" name="kd_produk" value="<?php echo $kd_produk?>" readonly>
                                </div>
                                <div class="col-12">
                                    <label for="nm_produk" class="form-label">Nama produk</label>
                                    <input type="text" class="form-control" id="nm_produk" name="nm_produk" required>
                                </div>
                                <div class="col-12">
                                    <label for="stok" class="form-label">Stok</label>
                                    <input type="number" class="form-control" id="stok" name="stok" required>
                                </div>
                                <div class="col-12">
                                    <label for="min_stok" class="form-label">Minimal Stok</label>
                                    <input type="number" class="form-control" id="min_stok" name="min_stok" required>
                                </div>
                                <div class="col-12">
                                    <label for="harga" class="form-label">Harga</label>
                                    <input type="number" class="form-control" id="harga" name="harga" required>
                                </div>
                                <div class="col-12">
                                    <label for="id_kategori" class="form-label">Kategori</label>
                                    <select class="form-control" id="id_kategori" name="id_kategori" required>
                                        <option value="">-- Pilih Kategori --</option>
                                        <?php
                                        include "koneksi.php";
                                        $query = mysqli_query($conn, "SELECT * FROM categories");
                                        while ($kategori = mysqli_fetch_array($query)) {
                                            echo "<option value='{$kategori['id']}'>{$kategori['category_name']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label for="gambar" class="form-label">Gambar Produk</label>
                                    <input type="file" class="form-control" id="gambar" name="gambar" required>
                                </div>
                                <div class="text-center">
                                <button type="button" class="btn btn-warning"><a href="kategori_produk.php" style="color: black; text-decoration:none;">Kembali</a></button>
                                <button type="reset" class="btn btn-secondary">Reset</button>
                                <button type="submit" class="btn btn-success" name="simpan">Simpan</button>
                                </div>
                            </form><!-- Vertical Form -->

                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">
        <div class="copyright">
            &copy; Copyright <strong><span>Nama Sistem</span></strong>. All Rights Reserved
        </div>
        <div class="credits">
            Designed by <a href="">Nama Kalian</a>
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