<?php session_start(); 
if(!isset($_SESSION['login'])) 
header("Location: admin.php"); 
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-dark bg-primary">
  <div class="container-fluid">
    <a class="navbar-brand">Dashboard Admin</a>
    <a href="index.php" class="btn btn-light btn-sm">Logout</a>
  </div>
</nav>

<div class="container my-4">
  <h4>Selamat Datang, Admin</h4>
  <div class="list-group">
     <a href="beranda.php" class="list-group-item">halaman gambar</a>
    <a href="jadwal.php" class="list-group-item">Kelola Jadwal Pelajaran</a>
    <a href="piket.php" class="list-group-item">Kelola Jadwal Piket</a>
    <a href="struktur.php" class="list-group-item">Kelola Struktur Kelas</a>
    <a href="pengumuman.php" class="list-group-item">Kelola Pengumuman</a>
  </div>
</div>
</body>
</html>
