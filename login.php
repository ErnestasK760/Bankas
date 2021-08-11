<?php
require __DIR__.'/functions.php';
session_start();
validateSessionID();
?>

<?php if ('GET' == $_SERVER['REQUEST_METHOD'] && !isset($_SESSION['id'])) :?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="text/css" rel="stylesheet" href="css/bootstrap.min.css">
    <script type="text/javascript" src="js/bootstrap.min.js" defer></script>
    <title>Ernesto bankas</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="https://localhost/Projektas/Bankas/index.php">Ernesto Bankas</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarText">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="https://localhost/Projektas/Bankas/newuser.php">Naujas vartotojas</a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="https://localhost/Projektas/Bankas/login.php">Prisijungimas</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<!-- Login forma -->
<form class="row g-3 mx-auto mt-3" method="POST">

  <div class="col-md-2">
    <label class="form-label">First name</label>
    <input type="text" name="Vardas" class="form-control" value="">
  </div>
  <div class="col-md-2">
    <label  class="form-label">Last name</label>
    <input type="text" name="Pavarde" class="form-control" value="">
  </div>
  <div class="col-md-3">
    <label class="form-label">Asmens Kodas</label>
    <input type="text" name="ASMK" class="form-control">
  </div>
  <div class="col-12">
    <button class="btn btn-primary" type="submit">Prisijungti</button>
  </div>
</form>
</body>
</html>
<?php endif ?>

<?php if ('GET' == $_SERVER['REQUEST_METHOD'] && isset($_SESSION['id'])) :?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="text/css" rel="stylesheet" href="css/bootstrap.min.css">
    <script type="text/javascript" src="js/bootstrap.min.js" defer></script>
    <title>Ernesto bankas</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="https://localhost/Projektas/Bankas/index.php">Ernesto Bankas</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarText">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="https://localhost/Projektas/Bankas/newuser.php">Naujas vartotojas</a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="https://localhost/Projektas/Bankas/accountlist.php">Saskaita</a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="https://localhost/Projektas/Bankas/login.php">Prisijungimas</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<!-- Login forma -->
<form class="row g-3 mx-auto mt-3" method="POST">

  <div class="col-md-2">
    <label class="form-label">First name</label>
    <input type="text" name="Vardas" class="form-control" value="">
  </div>
  <div class="col-md-2">
    <label  class="form-label">Last name</label>
    <input type="text" name="Pavarde" class="form-control" value="">
  </div>
  <div class="col-md-3">
    <label class="form-label">Asmens Kodas</label>
    <input type="text" name="ASMK" class="form-control">
  </div>
  <div class="col-12">
    <button class="btn btn-primary" type="submit">Prisijungti</button>
  </div>
</form>
</body>
</html>
<?php endif ?>