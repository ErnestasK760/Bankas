<?php
require __DIR__.'/functions.php';
session_start();
validateSessionID();
print_r($_POST);
print_r($_SESSION);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="text/css" rel="stylesheet" href="css/bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="style.css">
    <script type="text/javascript" src="js/bootstrap.min.js" defer></script>
    <title>Bankas</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="https://localhost/Projektas/Bankas/index.php">Bankas</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarText">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <?php if(workerisLogged() == false) : ?>
        <li class="nav-item">
          <a class="nav-link" href="https://localhost/Projektas/Bankas/newuser.php">Naujas vartotojas</a>
        </li>
        <?php endif ?>
        <?php if(workerisLogged()) : ?>
        <li class="nav-item">
        <a class="nav-link" href="https://localhost/Projektas/Bankas/allaccountlist.php">Sąskaitų sąrašas</a>
        </li>
        <?php endif ?>
        <?php if(workerisLogged() == false) : ?>
        <li class="nav-item">
        <a class="nav-link" href="https://localhost/Projektas/Bankas/login.php">Prisijungimas</a>
        </li>
        <?php endif ?>
        <?php if(workerisLogged()) : ?>
        <li class="nav-item">
        <a class="nav-link" href="https://localhost/Projektas/Bankas/logout.php">Atsijungti</a>
        <?php endif ?>
        </li>
      </ul>
    </div>
  </div>
</nav>
<?php showMessages() ?>;
<!-- Login forma -->
<form class="row g-3 mx-auto mt-3 border border-3 rounded-5 p-3 login-login" method="POST">

  <div class="col-md-2">
    <label class="form-label">Vardas</label>
    <input type="text" name="Vardas" class="form-control" value="">
  </div>
  <div class="col-md-2">
    <label  class="form-label">Slaptažodis</label>
    <input type="text" name="pass" class="form-control" value="">
  </div>
  <div class="col-md-3">
    <label class="form-label">El.Paštas</label>
    <input type="text" name="Epastas" class="form-control">
  </div>
  <div class="col-12 login-btndiv">
    <button class="btn btn-primary" type="submit">Prisijungti</button>
</form>
    <form action='login.php' method="GET">
    <button class="btn btn-outline-primary btn-sm btn-login" type="submit">Prisijungti kaip vartotojui</button>
    </form>
    </div>
</body>
</html>