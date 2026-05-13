<?php 
include 'koneksi.php';
$id = $_GET['id'];
$hapus = mysqli_query($conn, "DELETE FROM users WHERE id = '$id'");
if ($hapus) {
    echo "<script>alert('User berhasil dihapus!'); window.location='users.php';</script>";
} else {
    echo "<script>alert('Gagal menghapus user!'); window.location='users.php';</script>";
}
?>