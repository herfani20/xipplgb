<?php
include 'koneksi.php';
session_start();
if (!isset($_SESSION['login'])) {
  header('Location: admin.php');
  exit;
}

$pesan = '';
$editMode = false;
$editData = ['id' => '', 'jabatan' => '', 'nama' => ''];

// ====== TAMBAH DATA ======
if (isset($_POST['tambah'])) {
  $jabatan = mysqli_real_escape_string($koneksi, $_POST['jabatan']);
  $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);

  if (!empty($jabatan) && !empty($nama)) {
    $stmt = $koneksi->prepare("INSERT INTO struktur_kelas (jabatan, nama) VALUES (?, ?)");
    $stmt->bind_param("ss", $jabatan, $nama);
    $stmt->execute();
    $pesan = "<div class='alert alert-success'>✅ Data berhasil ditambahkan!</div>";
  } else {
    $pesan = "<div class='alert alert-warning'>⚠️ Harap isi semua kolom!</div>";
  }
}

// ====== HAPUS DATA ======
if (isset($_GET['hapus'])) {
  $id = intval($_GET['hapus']);
  $koneksi->query("DELETE FROM struktur_kelas WHERE id=$id");
  $pesan = "<div class='alert alert-danger'>🗑️ Data berhasil dihapus!</div>";
}

// ====== MASUK MODE EDIT ======
if (isset($_GET['edit'])) {
  $id = intval($_GET['edit']);
  $result = $koneksi->query("SELECT * FROM struktur_kelas WHERE id=$id");
  if ($result && $result->num_rows > 0) {
    $editData = $result->fetch_assoc();
    $editMode = true;
  }
}

// ====== SIMPAN PERUBAHAN ======
if (isset($_POST['update'])) {
  $id = intval($_POST['id']);
  $jabatan = mysqli_real_escape_string($koneksi, $_POST['jabatan']);
  $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);

  $stmt = $koneksi->prepare("UPDATE struktur_kelas SET jabatan=?, nama=? WHERE id=?");
  $stmt->bind_param("ssi", $jabatan, $nama, $id);
  $stmt->execute();
  $pesan = "<div class='alert alert-info'>✏️ Data berhasil diperbarui!</div>";
  $editMode = false;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Kelola Struktur Kelas</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script>
    function konfirmasiHapus(jabatan) {
      return confirm('Yakin ingin menghapus data ' + jabatan + '?');
    }
  </script>
</head>
<body class="p-4 bg-light">

<div class="container">
  <h3 class="mb-4">👥 Kelola Struktur Kelas</h3>
  <?= $pesan ?>

  <form method="POST" class="card p-3 mb-3 shadow-sm">
    <input type="hidden" name="id" value="<?= $editData['id'] ?>">
    <input type="text" name="jabatan" placeholder="Jabatan" class="form-control mb-2" 
           value="<?= htmlspecialchars($editData['jabatan']) ?>" required>
    <input type="text" name="nama" placeholder="Nama" class="form-control mb-2" 
           value="<?= htmlspecialchars($editData['nama']) ?>" required>

          <?php if ($editMode): ?>
      <button name="update" class="btn btn-success">💾 Simpan Perubahan</button>
      <a href="kelola_struktur_kelas.php" class="btn btn-secondary">Batal</a>
    <?php else: ?>
      <div class="d-flex gap-2">
      <button name="tambah" class="btn btn-primary">➕Tambah</button><a href="dashboard.php" class="btn btn-secondary">Kembali</a>
    <?php endif; ?>
    </div>

  </form>


  <table class="table table-bordered table-striped shadow-sm bg-white">
    <thead class="table-dark">
      <tr><th>No</th><th>Jabatan</th><th>Nama</th><th>Aksi</th></tr>
    </thead>
    <tbody>
      <?php
      $q = $koneksi->query("SELECT * FROM struktur_kelas ORDER BY id ASC");
      $no = 1;
      while ($d = $q->fetch_assoc()) {
        echo "<tr>
          <td>$no</td>
          <td>{$d['jabatan']}</td>
          <td>{$d['nama']}</td>
          <td>
            <a href='?edit={$d['id']}' class='btn btn-warning btn-sm'>Edit</a>
            <a href='?hapus={$d['id']}' class='btn btn-danger btn-sm' onclick=\"return konfirmasiHapus('{$d['jabatan']}')\">Hapus</a>
          </td>
        </tr>";
        $no++;
      }
      ?>
    </tbody>
  </table>
</div>

</body>
</html>
