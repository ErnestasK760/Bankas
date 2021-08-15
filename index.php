<?php
require __DIR__ . '/functions.php';
session_start();
// session_unset();
?>
<!-- !isset($_SESSION['id'])) -->

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
          <?php if (!workerisLogged()) : ?>
            <li class="nav-item">
              <a class="nav-link" href="https://localhost/Projektas/Bankas/newuser.php">Naujas vartotojas</a>
            </li>
          <?php endif ?>
          <?php if (isLogged()) : ?>
            <li class="nav-item">
              <a class="nav-link" href="https://localhost/Projektas/Bankas/accountlist.php">Sąskaita</a>
            </li>
          <?php endif ?>
          <?php if (workerisLogged()) : ?>
            <li class="nav-item">
              <a class="nav-link" href="https://localhost/Projektas/Bankas/allaccountlist.php">Sąskaitų sąrašas</a>
            </li>
          <?php endif ?>
          <?php if (!isLogged() && !workerisLogged()) : ?>
            <li class="nav-item">
              <a class="nav-link" href="https://localhost/Projektas/Bankas/login.php">Prisijungimas</a>
            </li>
          <?php endif ?>
          <?php if (workerisLogged()) : ?>
            <li class="nav-item">
              <a class="nav-link" href="https://localhost/Projektas/Bankas/logout.php">Atsijungti</a>
            </li>
          <?php endif ?>
          <?php if (isLogged()) : ?>
            <li class="nav-item">
              <a class="nav-link" href="https://localhost/Projektas/Bankas/logout.php">Atsijungti</a>
            <?php endif ?>
            </li>
        </ul>
        <?php if (isLogged()) : ?>
          <span class="navbar-text">
            <?= thisUserArray()['Vardas'] ?>
          </span>
        <?php endif ?>
        <?php if (workerisLogged()) : ?>
          <span class="navbar-text">
            <?= $_SESSION['name'] ?>
          </span>
        <?php endif ?>
      </div>
    </div>
  </nav>
</body>

</html>
<?php showMessages() ?>
<h1 class="index-login mt-3 ps-3">Sveiki atvykę į Ernesto banką!</h1>