<?php
include 'koneksi.php';
session_start();
if (!isset($_SESSION['login'])) {
    header('Location: admin.php');
    exit;
}

// Tambah piket
if (isset($_POST['tambah'])) {
    $hari = $_POST['hari'];
    $petugas = $_POST['petugas'];

    $stmt = $koneksi->prepare("INSERT INTO jadwal_piket (hari, petugas) VALUES (?, ?)");
    if (!$stmt) die("Query error: " . $koneksi->error);

    $stmt->bind_param("ss", $hari, $petugas);
    $stmt->execute();

    $_SESSION['msg'] = "Piket berhasil ditambah!";
    header('Location: piket.php');
    exit;
}

// Hapus piket
if (isset($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];
    $stmt = $koneksi->prepare("DELETE FROM jadwal_piket WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $_SESSION['msg'] = "Piket berhasil dihapus!";
    header('Location: piket.php');
    exit;
}

// Ambil data piket
$res = $koneksi->query("SELECT * FROM jadwal_piket ORDER BY id ASC");
if (!$res) die("Query gagal: " . $koneksi->error);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Piket</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
<div class="container">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0">Daftar Piket</h3>
 
  </div>

  <?php if(isset($_SESSION['msg'])): ?>
    <div class="alert alert-success"><?= $_SESSION['msg']; unset($_SESSION['msg']); ?></div>
  <?php endif; ?>

  <form method="post" class="mb-4">
    <input name="hari" class="form-control mb-2" placeholder="Hari (Senin, Selasa...)" required>
    <input name="petugas" class="form-control mb-2" placeholder="Nama Petugas" required>
    <button name="tambah" class="btn btn-primary">Tambah Piket</button>
       <a href="dashboard.php" class="btn btn-secondary">Kembali</a>
  </form>

  <table class="table table-bordered">
    <thead>
      <tr>
        <th>ID</th>
        <th>Hari</th>
        <th>Petugas</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php while($r = $res->fetch_assoc()): ?>
        <tr>
          <td><?=$r['id']?></td>
          <td><?=htmlspecialchars($r['hari'])?></td>
          <td><?=htmlspecialchars($r['petugas'])?></td>
          <td>
            <a href="?hapus=<?=$r['id']?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus data piket ini?')">Hapus</a>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>
</body>
</html>
