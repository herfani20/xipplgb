<?php
session_start();
if(isset($_POST['login'])){
  $user = $_POST['username'];
  $pass = $_POST['password'];
  if($user=="admin" && $pass=="123"){
    $_SESSION['login']=true;
    header("Location: dashboard.php");
  } else {
    $error = "Username atau password salah!";
  }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
  <div class="col-md-4 offset-md-4">
    <div class="card">
      <div class="card-header bg-primary text-white">Login Admin</div>
      <div class="card-body">
        <?php if(isset($error)): ?><div class="alert alert-danger"><?= $error ?></div><?php endif; ?>
        <form method="POST">
          <input type="text" name="username" class="form-control mb-3" placeholder="Username">
          <input type="password" name="password" class="form-control mb-3" placeholder="Password">
          <button class="btn btn-primary w-100" name="login">Login</button>
        </form>
      </div>
    </div>
  </div>
</div>
</body>
</html>
