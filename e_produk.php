<?php
session_start();
include 'koneksi.php';

// cek apakah sudah login
if (!isset($_SESSION['login'])) {
    header('Location: login.php');
    exit;
}

$id = $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM products WHERE id = '$id'");
$hasil = mysqli_fetch_array($query);
if (isset($_POST['update'])) {
    $nm_produk = $_POST['nm_produk'];
    $stok = $_POST['stok'];
    $min_stok = $_POST['min_stok'];
    $harga = $_POST['harga'];
    $id_kategori = $_POST['id_kategori'];

    $imgfile = $_FILES['gambar']['name'];

    //upload gambar baru
    if ($imgfile != "") {
        $tmp = $_FILES['gambar']['tmp_name'];
        $ext = strtolower(pathinfo($imgfile, PATHINFO_EXTENSION));
        $allowed = ["jpg", "jpeg", "png", "webp"];

        if (in_array($ext, $allowed)) {
            $imgnew= md5(time() . $imgfile) . "." . $ext;
            move_uploaded_file($tmp, "produk_img/" . $imgnew);
        
            $update = mysqli_query($conn, "UPDATE products SET 
            category_id = '$id_kategori',
            product_name = '$nm_produk',
            stock = '$stok',
            min_stock = '$min_stok',
            price = '$harga',
            gambar = '$imgnew'
            WHERE id = '$id'
            ");
        } else {
        echo "<script>alert('Format gambar tidak valid');</script>";
        return;
        }
    } else {
        //Tanpa ganti gambar 
        $update = mysqli_query($conn, "UPDATE products SET 
            category_id = '$id_kategori',
            product_name = '$nm_produk',
            stock = '$stok',
            min_stock = '$min_stok',
            price = '$harga'
            WHERE id = '$id'
            ");
    }
    if ($update) {
        echo "<script>alert('Data berhasil diubah!')</script>";
        header("refresh:0, produk.php");
    } else {
        echo "<script>alert('Data gagal diubah!')</script>";
        header("refresh:0, produk.php");
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Produk - InvAdmin</title>
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
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->
        <section class="section">
            <div class="row">
                <div class="col-lg-6">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Edit Produk</h5>

                            <!-- Vertical Form -->
                            <form class="row g-3" method="post" enctype="multipart/form-data">
                                <div class="col-12">
                                    <label for="kd_produk" class="form-label">Kode Produk</label>
                                    <input type="text" class="form-control" id="kd_produk" name="kd_produk" value="<?php echo $hasil['product_code']; ?>" readonly>
                                </div>
                                <div class="col-12">
                                    <label for="nm_produk" class="form-label">Nama produk</label>
                                    <input type="text" class="form-control" id="nm_produk" name="nm_produk" value="<?php echo $hasil['product_name']; ?>" required>
                                </div>
                                <div class="col-12">
                                    <label for="stok" class="form-label">Stok</label>
                                    <input type="number" class="form-control" id="stok" name="stok" value="<?php echo $hasil['stock']; ?>" required>
                                </div>
                                <div class="col-12">
                                    <label for="min_stok" class="form-label">Minimal Stok</label>
                                    <input type="number" class="form-control" id="min_stok" name="min_stok" value="<?php echo $hasil['min_stock']; ?>" required>
                                </div>
                                <div class="col-12">
                                    <label for="harga" class="form-label">Harga</label>
                                    <input type="number" class="form-control" id="harga" name="harga" value="<?php echo $hasil['price']; ?>" required>
                                </div>
                                <div class="col-12">
                                    <label for="id_kategori" class="form-label">Kategori</label>
                                    <select class="form-control" id="id_kategori" name="id_kategori" required>
                                        <?php
                                        $kategori = mysqli_query($conn, "SELECT * FROM categories");
                                        while ($k = mysqli_fetch_array($kategori)) {
                                            $selected = ($k['id'] == $hasil['category_id']) ? "selected" : "";
                                            echo "<option value='{$k['id']}' $selected>{$k['category_name']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Gambar Lama</label>
                                    <img src="produk_img/<?php echo $hasil['gambar']; ?>" width="80">
                                </div>
                                <div class="col-12">
                                    <label for="gambar" class="form-label">Ganti Gambar</label>
                                    <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*">
                                </div>
                                <div class="text-center">
                                <button type="button" class="btn btn-warning"><a href="kategori_produk.php" style="color: black; text-decoration:none;">Kembali</a></button>
                                <button type="reset" class="btn btn-secondary">Reset</button>
                                <button type="submit" class="btn btn-success" name="update">Update</button>
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