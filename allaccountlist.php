<?php
require __DIR__ . '/functions.php';
session_start();
auth();
router();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link type="text/css" rel="stylesheet" href="css/bootstrap.min.css">
  <link type="text/css" rel="stylesheet" href="style.css">
  <link rel="stylesheet" type="text/css" href="datatables.min.css" />
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
          <?php if (workerisLogged()) : ?>
            <li class="nav-item">
              <a class="nav-link" href="https://localhost/Projektas/Bankas/allaccountlist.php">Sąskaitų sąrašas</a>
            </li>
          <?php endif ?>
          <?php if (!workerisLogged()) : ?>
            <li class="nav-item">
              <a class="nav-link" href="https://localhost/Projektas/Bankas/login.php">Prisijungimas</a>
            </li>
          <?php endif ?>
          <?php if (workerisLogged()) : ?>
            <li class="nav-item">
              <a class="nav-link" href="https://localhost/Projektas/Bankas/logout.php">Atsijungti</a>
            </li>
          <?php endif ?>
        </ul>
        <?php if (workerisLogged()) : ?>
          <span class="navbar-text">
            <?= $_SESSION['name'] ?>
          </span>
        <?php endif ?>
      </div>
    </div>
  </nav>
  <?php showMessages() ?>
  <h2 class="h2-caption-accountlist"><?= 'Visi vartotojai' ?></h2>
  <div class="sastable-allaccountlist">
    <table class="table table-bordered table-hover mt-2" id='mydatatable'>
      <thead>
        <tr>
          <th scope="col" class="text-center">#</th>
          <th scope="col" class="text-center">Saskaitos nr</th>
          <th scope="col" class="text-center">Vardas</th>
          <th scope="col" class="text-center">Pavarde</th>
          <th scope="col" class="text-center">Lėšos</th>
          <th scope="col" class="text-center">Funkcijos</th>
        </tr>
      </thead>
      <tbody>
        <?php showingallSas(); ?>
      </tbody>
    </table>
  </div>
  <script src="jQuery-3.3.1/jquery-3.3.1.min.js"></script>
  <script type="text/javascript" src="datatables.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#mydatatable').DataTable();
    });
  </script>
</body>

</html>