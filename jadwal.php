<?php
session_start();
if(!isset($_SESSION['login'])) header("Location: admin.php");
include 'koneksi.php';

if(isset($_POST['simpan'])){
  mysqli_query($koneksi,"INSERT INTO jadwal_pelajaran VALUES(NULL,'$_POST[hari]','$_POST[jam]','$_POST[mapel]','$_POST[guru]')");
}
if(isset($_GET['hapus'])){
  mysqli_query($koneksi,"DELETE FROM jadwal_pelajaran WHERE id='$_GET[hapus]'");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Kelola Jadwal</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container my-4">
  <h3>Kelola Jadwal Pelajaran</h3>
  <form method="POST" class="row g-2 mb-3">
    <div class="col-md-2"><input type="text" name="hari" class="form-control" placeholder="Hari"></div>
    <div class="col-md-2"><input type="text" name="jam" class="form-control" placeholder="Jam"></div>
    <div class="col-md-3"><input type="text" name="mapel" class="form-control" placeholder="Mata Pelajaran"></div>
    <div class="col-md-3"><input type="text" name="guru" class="form-control" placeholder="Guru"></div>
    <div class="col-md-2"><button class="btn btn-primary w-100" name="simpan">Simpan</button></div>
  </form>

  <table class="table table-bordered">
    <thead><tr><th>Hari</th><th>Jam</th><th>Mata Pelajaran</th><th>Guru</th><th>Aksi</th></tr></thead>
    <tbody>
      <?php
      $data = mysqli_query($koneksi,"SELECT * FROM jadwal_pelajaran");
      while($d=mysqli_fetch_array($data)){
        echo "<tr>
          <td>$d[hari]</td><td>$d[jam]</td><td>$d[mata_pelajaran]</td><td>$d[guru]</td>
          <td><a href='?hapus=$d[id]' class='btn btn-danger btn-sm'>Hapus</a></td>
        </tr>";
      }
      ?>
    </tbody>
  </table>
  <a href='dashboard.php' class='btn btn-secondary mt-2'>Kembali</a>
</div>
</body>
</html>
