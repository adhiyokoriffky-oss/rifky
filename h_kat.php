<?php 
include "koneksi.php";
$id = $_GET['id'];
$hapus = mysqli_query($conn, "DELETE FROM categories WHERE id='$id'");

if ($hapus) {
    echo "<script>alert('Data Berhasil Dihapus')</script>";
    header ("refresh:0, kategori_produk.php");
} else {
    echo "<script>alert('Data Gagal Dihapus')</script>";
    header ("refresh:0, kategori_produk.php"); 
}
?>