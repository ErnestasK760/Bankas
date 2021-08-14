<?php
require __DIR__.'/functions.php';
session_start();
auth();
selectingSas();
router();
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
        <?php if(!workerisLogged()) :?>
        <li class="nav-item">
          <a class="nav-link" href="https://localhost/Projektas/Bankas/newuser.php">Naujas vartotojas</a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="https://localhost/Projektas/Bankas/accountlist.php">Sąskaita</a>
        </li>
        <?php endif ?>
        <li class="nav-item">
        <a class="nav-link" href="https://localhost/Projektas/Bankas/logout.php">Atsijungti</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<?php showMessages() ?>;
<?php if(isLogged()): ?>
<!-- Saskaitos table -->
<h2 class="h2-caption-fundcontrol"><?= thisUserArray()['Vardas']." ".thisUserArray()['Pavarde'] ?></h2>
<div class="sastable-fundcontrol">
  <table class="table table-bordered table-hover mt-2">
      <thead>
        <tr>
          <th scope="col" class="text-center">#</th>
          <th scope="col" class="text-center">Saskaitos nr</th>
          <th scope="col" class="text-center">Lėšos</th>
          <th scope="col" class="text-center"></th>
        </tr>
      </thead>
        <tbody>
            <tr class="text-center">
                <th scope="row"><?= $_SESSION['IBANID']?></th>
                  <td><?= thisUserSasNR() ?></td>
                  <td scope="row" class="text-center">
                  <span class="moneytext-fundcontrol mx-5"><?= thisUserMoney().' EUR'?> </span>
                  <td class="">
                <div class="btndiv-fundcontrol">
                    <form action="https://localhost/Projektas/Bankas/fundcontrol.php?route=prideti-lesas" method="post">
                    <input name = "les_plus" class="moneyinput-fundcontrol">
                    <button type="submit" class="btn btn-primary btn-sm mx-1 mb-1">Pridėti lėšų</button>
                    </form>
                    <form action="https://localhost/Projektas/Bankas/fundcontrol.php?route=atimti-lesas" method="post">
                    <input name = "les_minus" class="moneyinput-fundcontrol">
                    <button type="submit" class="btn btn-secondary btn-sm mx-1 mb-1">Atimti lėšas</button>
                    </form>
                </div>
                </td>
            </td>
            </tr>
          </tbody>
      </table>
<form action="https://localhost/Projektas/Bankas/accountlist.php" method="get">
<button type="submit" class="btn btn-warning btn-sm mx-1 mb-1">Grįžti</button>
</form>
</div>
<?php endif ?>
<?php if(workerisLogged()): ?>
<!-- Saskaitos table -->
<h2 class="h2-caption-fundcontrol"><?= thisUserArray()['Vardas']." ".thisUserArray()['Pavarde'] ?></h2>
<div class="sastable-fundcontrol">
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
            <tr class="text-center">
                <th scope="row"><?= 1 ?></th>
                  <td><?= thisUserSasNR() ?></td>
                  <td scope="row" class="text-center">
                  <span class="moneytext-fundcontrol mx-5"><?= 'b'.' EUR'?> </span>
                  <td class="">
                <div class="btndiv-fundcontrol">
                    <form action="https://localhost/Projektas/Bankas/fundcontrol.php?route=prideti-lesas" method="post">
                    <input name = "les_plus" class="moneyinput-fundcontrol">
                    <button type="submit" class="btn btn-primary btn-sm mx-1 mb-1">Pridėti lėšų</button>
                    </form>
                    <form action="https://localhost/Projektas/Bankas/fundcontrol.php?route=atimti-lesas" method="post">
                    <input name = "les_minus" class="moneyinput-fundcontrol">
                    <button type="submit" class="btn btn-secondary btn-sm mx-1 mb-1">Atimti lėšas</button>
                    </form>
                </div>
                </td>
            </td>
            </tr>
          </tbody>
      </table>

<form action="https://localhost/Projektas/Bankas/accountlist.php" method="get">
<button type="submit" class="btn btn-warning btn-sm mx-1 mb-1">Grįžti</button>
</form>
</div>


</body>
</html>
<?php endif ?>