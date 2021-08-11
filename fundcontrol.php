<?php
require __DIR__.'/functions.php';
session_start();
print_r($_SESSION);
if ('POST' == $_SERVER['REQUEST_METHOD'] && isset($_SESSION['id'])){
    $_SESSION['IBANID']=array();
    $_SESSION['IBANID'] = $_POST['a'];
    header('Location:https://localhost/Projektas/Bankas/fundcontrol.php');
    die;
}

?>


<?php if ('GET' == $_SERVER['REQUEST_METHOD'] && isset($_SESSION['id'])) :?>
<?php 
  $vartotojai = getVartotojas(); 
  foreach($vartotojai as $arrindex => $array){
    if($array['ID'] == $_SESSION['id']){
      $thisuser = $array;
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="text/css" rel="stylesheet" href="css/bootstrap.min.css">
    <script type="text/javascript" src="js/bootstrap.min.js" defer></script>
    <title>Ernesto bankas</title>
    <style>
      .sastable {
        width:90%;
        margin:auto;
      }
      .h2-caption {
        margin-left: 10%;
        padding-top:2%;
      }
      .moneytext {
        display:inline-block;
      }
      .btndiv {
        display:flex;
        flex-direction: row;
        justify-content: center;
      }
    </style>
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
        <a class="nav-link" href="https://localhost/Projektas/Bankas/logout.php">Atsijungti</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<!-- Saskaitos table -->
<h2 class="h2-caption"><?= $thisuser['Vardas']." ".$thisuser['Pavarde'] ?></h2>
<div class="sastable">
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
            $times = 1;
            foreach($thisuser['IBAN'] as $key => $array){
                if($times == $_SESSION['IBANID']){
                    $sasnr = $key;
                    $suma = $array;
                }
                $times++;
            }
            ?>
            <tr class="text-center">
                <th scope="row"><?= $_SESSION['IBANID']?></th>
                  <td><?= $sasnr ?></td>
                  <td scope="row" class="text-center">
                  <span class="moneytext mx-5"><?= $suma ?> </span>
                  <td class="text-center">
                <div class="btndiv">
                    <form action="https://localhost/Projektas/Bankas/accountlist.php?route=prideti-lesu" method="post">
                    <button type="submit" class="btn btn-primary btn-sm mx-1">Pridėti lėšų</button>
                    </form>
                    <form action="https://localhost/Projektas/Bankas/accountlist.php?route=atimti-lesu" method="post">
                    <button type="submit" class="btn btn-secondary btn-sm mx-1">Atimti lėšas</button>
                    </form>
                </div>
                </td>
            </td>
            </tr>
          </tbody>
      </table>
</div>


</body>
</html>
<?php endif ?>