<?php
include 'koneksi.php';
session_start();
if (!isset($_SESSION['login'])) {
  header('Location: admin.php');
  exit;
}

// ===== Tambah pengumuman =====
if (isset($_POST['tambah'])) {
    $judul = $_POST['judul'];
    $isi = $_POST['isi'];
    $tanggal = $_POST['tanggal'] ?? date('Y-m-d');

    $stmt = $koneksi->prepare("INSERT INTO pengumuman (judul, isi, tanggal) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $judul, $isi, $tanggal);
    $stmt->execute();
    header('Location: pengumuman.php');
    exit;
}

// ===== Edit pengumuman =====
if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $judul = $_POST['judul'];
    $isi = $_POST['isi'];
    $tanggal = $_POST['tanggal'];

    $stmt = $koneksi->prepare("UPDATE pengumuman SET judul=?, isi=?, tanggal=? WHERE id=?");
    $stmt->bind_param("sssi", $judul, $isi, $tanggal, $id);
    $stmt->execute();
    header('Location: pengumuman.php');
    exit;
}

// ===== Hapus pengumuman =====
if (isset($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];
    $stmt = $koneksi->prepare("DELETE FROM pengumuman WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header('Location: pengumuman.php');
    exit;
}

// ===== Ambil data pengumuman =====
$res = $koneksi->query("SELECT * FROM pengumuman ORDER BY id DESC");

// ===== Ambil data untuk edit jika ada =====
$editData = null;
if (isset($_GET['edit'])) {
    $id = (int)$_GET['edit'];
    $result = $koneksi->query("SELECT * FROM pengumuman WHERE id=$id");
    $editData = $result->fetch_assoc();
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Pengumuman</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
<div class="container">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0">Pengumuman</h3>
  </div>

  <!-- Form Tambah / Edit -->
  <form method="post" class="mb-4">
    <input type="hidden" name="id" value="<?= $editData['id'] ?? '' ?>">
    <input name="judul" class="form-control mb-2" placeholder="Judul" required value="<?= htmlspecialchars($editData['judul'] ?? '') ?>">
    <textarea name="isi" class="form-control mb-2" placeholder="Isi pengumuman" rows="4" required><?= htmlspecialchars($editData['isi'] ?? '') ?></textarea>
    <input type="date" name="tanggal" class="form-control mb-2" value="<?= $editData['tanggal'] ?? date('Y-m-d') ?>">
    <div class="d-flex gap-2">
        <?php if ($editData): ?>
            <button type="submit" name="edit" class="btn btn-warning">Simpan Perubahan</button>
            <a href="pengumuman.php" class="btn btn-secondary">Batal</a>
        <?php else: ?>
            <button type="submit" name="tambah" class="btn btn-primary">Tambah Pengumuman</button>
            <a href="dashboard.php" class="btn btn-secondary">Kembali</a>
        <?php endif; ?>
    </div>
  </form>

  <!-- Daftar pengumuman -->
  <ul class="list-group">
    <?php while($r = $res->fetch_assoc()): ?>
      <li class="list-group-item mb-2">
        <b><?=htmlspecialchars($r['judul'])?></b> 
        <small class="text-muted">(<?=htmlspecialchars($r['tanggal'])?>)</small>
        <p class="mt-2"><?=nl2br(htmlspecialchars($r['isi']))?></p>
        <a href="?edit=<?=$r['id']?>" class="btn btn-warning btn-sm">Edit</a>
        <a href="?hapus=<?=$r['id']?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus pengumuman ini?')">Hapus</a>
      </li>
    <?php endwhile; ?>
  </ul>
</div>
</body>
</html>
