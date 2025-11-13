<?php
include 'koneksi.php';

if(isset($_POST['upload'])){
    if(isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0){
        $filename = time() . "_" . $_FILES['gambar']['name'];
        $target = "uploads/" . $filename;

        if(move_uploaded_file($_FILES['gambar']['tmp_name'], $target)){
            // Hapus gambar lama jika ada
            $old = mysqli_query($koneksi,"SELECT gambar FROM beranda ORDER BY id DESC LIMIT 1");
            if($row = mysqli_fetch_array($old)){
                if(file_exists("uploads/".$row['gambar'])){
                    unlink("uploads/".$row['gambar']);
                }
            }

            // Simpan gambar baru
            mysqli_query($koneksi,"INSERT INTO beranda (gambar) VALUES ('$filename')");
            echo "<script>alert('Gambar berhasil diupload');window.location='beranda.php';</script>";
        } else {
            echo "<script>alert('Gagal upload gambar');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title></title>
</head>
<body>
<div class="container mt-5">
  <div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
      <h5 class="mb-0">Upload Gambar Beranda</h5>
    </div>
    <div class="card-body">
      <form action="" method="post" enctype="multipart/form-data">
        <div class="mb-4">
          <label for="gambar" class="form-label">Pilih Gambar Beranda</label>
          <input class="form-control form-control-lg" type="file" id="gambar" name="gambar" required>
        </div>
        <a type="submit" name="upload" class="btn btn-success">
          Upload
        </a>
          <a href="dashboard.php" class="btn btn-secondary">Kembali</a>
      </form>
    </div>
  </div>
</div>

</body>
</html>