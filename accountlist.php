<?php
require __DIR__.'/functions.php';
session_start();
auth();
selectingSas();
router();
print_r($_POST);
print_r($_SESSION);
?>
<?php if(isLogged()){
  $thisuser = thisUserArray();} 
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
        <?php if(isLogged()):?>
        <li class="nav-item">
        <a class="nav-link" href="https://localhost/Projektas/Bankas/accountlist.php">Sąskaita</a>
        </li>
        <?php endif ?>
        <?php if(isLogged() == false):?>
        <li class="nav-item">
        <a class="nav-link" href="https://localhost/Projektas/Bankas/login.php">Prisijungimas</a>
        </li>
        <?php endif ?>
        <?php if(isLogged()):?>
        <li class="nav-item">
        <a class="nav-link" href="https://localhost/Projektas/Bankas/logout.php">Atsijungti</a>
        </li>
        <?php endif ?>
      </ul>
    </div>
  </div>
</nav>
<?php showMessages() ?>;
<!-- Saskaitos table -->
<h2 class="h2-caption-accountlist"><?= $thisuser['Vardas']." ".$thisuser['Pavarde'] ?></h2>
<div class="sastable-accountlist">
  <table class="table table-bordered table-hover mt-3">
      <thead>
        <tr>
          <th scope="col" class="text-center">#</th>
          <th scope="col" class="text-center">Saskaitos nr</th>
          <th scope="col" class="text-center">Lėšos</th>
          <th scope="col" class="text-center"></th>
        </tr>
      </thead>
        <tbody>
        <?php
          printSas();
        ?>
          </tbody>
      </table>
      <form action="https://localhost/Projektas/Bankas/fundcontrol.php?route=prideti-sas" method="post">
      <button type="submit" class="btn btn-warning btn-sm mx-1 mb-1">Pridėti sąskaitą</button>
      </form>
</div>
</body>
</html>