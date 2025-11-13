<?php 
include 'koneksi.php'; 
$data = mysqli_query($koneksi,"SELECT gambar FROM beranda ORDER BY id DESC LIMIT 1");
$d = mysqli_fetch_array($data);
$imgSrc = $d['gambar'] ? "uploads/".$d['gambar'] : "https://img.freepik.com/premium-photo/interior-school-class-room-is-empty-with-flat-modern-illustration-board-desk_1257429-43119.jpg";

?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Website Kelas XI PPLG</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  

<!-- 🔹 Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container">
      <img src="1.png" alt="Logo" width="40" height="40" class="me-2">
    <a class="navbar-brand" href="#beranda">XI PPLG B</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link" href="#beranda">Beranda</a></li>
        <li class="nav-item"><a class="nav-link" href="#jadwal">Jadwal Pelajaran</a></li>
        <li class="nav-item"><a class="nav-link" href="#piket">Jadwal Piket</a></li>
        <li class="nav-item"><a class="nav-link" href="#struktur">Struktur Kelas</a></li>
        <li class="nav-item"><a class="nav-link" href="#pengumuman">Pengumuman</a></li>
      </ul>
      <a href="admin.php" class="btn btn-success btn-sm">Login Admin</a>
    </div>
  </div>
</nav>

<!-- 🔹 Konten -->
<div class="container my-4">

  <!-- 🎉 Selamat Datang -->

  <section id="beranda" class="text-center mb-5">
   <img src="<?= $imgSrc ?>" alt="Foto Kelas" class="img-fluid rounded mb-3">

    <h2>Selamat Datang di Website Kelas XI PPLG B</h2>
    <p>Temukan semua informasi penting seputar kegiatan dan data kelas XI PPLG di sini.</p>
  </section>

  <hr class="my-4">

  <!-- 📘 Jadwal Pelajaran -->
  <section id="jadwal" class="mb-5">
    <h4 class="text-primary mb-3">📘 Jadwal Pelajaran</h4>
    <div class="table-responsive">
      <table class="table table-bordered table-striped">
        <thead class="table-primary">
          <tr><th>Hari</th><th>Jam</th><th>Mata Pelajaran</th><th>Guru</th></tr>
        </thead>
        <tbody>
          <?php
          $data = mysqli_query($koneksi,"SELECT * FROM jadwal_pelajaran");
          while($d = mysqli_fetch_array($data)){
            echo "<tr><td>$d[hari]</td><td>$d[jam]</td><td>$d[mata_pelajaran]</td><td>$d[guru]</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </section>

  <hr class="my-4">

  <!-- 🧹 Jadwal Piket -->
  <section id="piket" class="mb-5">
    <h4 class="text-success mb-3">🧹 Jadwal Piket</h4>
    <div class="table-responsive">
      <table class="table table-bordered table-striped">
        <thead class="table-success">
          <tr><th>Hari</th><th>Petugas</th></tr>
        </thead>
        <tbody>
          <?php
          $data = mysqli_query($koneksi,"SELECT * FROM jadwal_piket");
          while($d = mysqli_fetch_array($data)){
            echo "<tr><td>$d[hari]</td><td>$d[petugas]</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </section>

  <hr class="my-4">

  <!-- 👥 Struktur Kelas -->
  <section id="struktur" class="mb-5">
    <h4 class="text-info mb-3">👥 Struktur Kelas</h4>
    <ul class="list-group">
      <?php
      $data = mysqli_query($koneksi,"SELECT * FROM struktur_kelas");
      while($d = mysqli_fetch_array($data)){
        echo "<li class='list-group-item'><strong>$d[jabatan]:</strong> $d[nama]</li>";
      }
      ?>
    </ul>
  </section>

  <hr class="my-4">

  <!-- 📢 Pengumuman -->
  <section id="pengumuman" class="mb-5">
    <h4 class="text-danger mb-3">📢 Pengumuman</h4>
    <?php
    $data = mysqli_query($koneksi,"SELECT * FROM pengumuman ORDER BY tanggal DESC");
    while($d = mysqli_fetch_array($data)){
      echo "
      <div class='card mb-3'>
        <div class='card-body'>
          <h5 class='card-title'>$d[judul]</h5>
          <p class='card-text'>$d[isi]</p>
          <p class='card-text'><small class='text-muted'>$d[tanggal]</small></p>
        </div>
      </div>";
    }
    ?>
  </section>

  <hr class="my-4">

  <!-- 🔹 Footer -->
  <footer class="text-center text-muted py-3">
    © 2025 Kelas XI PPLG B | SMKN 4 Marabahan
  </footer>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
