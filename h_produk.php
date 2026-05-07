<?php 
include "koneksi.php";

$id = $_GET['id'];

// ambil nama file gambar
$get = mysqli_query($conn, "SELECT gambar FROM products WHERE id='$id'");
$data = mysqli_fetch_array($get);
$gambar = $data['gambar'];

// hapus file gambar jika ada
if ($gambar != "" && file_exists("produk_img/" . $gambar)) {
    unlink("produk_img/" . $gambar);
}

//hapus data dari database
$hapus = mysqli_query($conn, "DELETE FROM products WHERE id='$id'");

if ($hapus) {
    echo "<script>alert('Data Berhasil Dihapus')</script>";
    header ("refresh:0, produk.php");
} else {
    echo "<script>alert('Data Gagal Dihapus')</script>";
    header ("refresh:0, produk.php"); 
}
?>