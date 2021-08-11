<?php
function getVartotojas() : array
{
    if (!file_exists(__DIR__.'/vartotojai.json')) {
        $vartotojai[] = ["Vardas" => "Vardenis","Pavarde" => "Pavardenis","SasNR" => ["LT0100000000000000000" => 0],"ASMK" => 396090841912,"ID" => "0"];
        $vartotojai = json_encode($vartotojai);
        file_put_contents(__DIR__.'/vartotojai.json', $vartotojai);
    }
    return json_decode(file_get_contents(__DIR__.'/vartotojai.json'), 1);
}

function setVartotojas(array $vartotojai) : void
{
    $vartotojai = json_encode($vartotojai);
    file_put_contents(__DIR__.'/vartotojai.json', $vartotojai);
}

function createIBAN()
{
    $IBAN = "LT01".rand(0,99).rand(1000,9999).rand(1000,9999).rand(1000,9999).rand(1000,9999);
    return $IBAN;
}

function createID()
{
    $ID = rand(1000000000,9999999999);
    return $ID;
}


function router()
{
    $route = $_GET['route'] ?? '';

    if ('POST' == $_SERVER['REQUEST_METHOD'] && 'prideti-lesas' == $route) {
        pridetiLesas();
    }
    elseif ('POST' == $_SERVER['REQUEST_METHOD'] && 'atimti-lesas' == $route) {
        atimtiLesas();
    }
    elseif ('POST' == $_SERVER['REQUEST_METHOD'] && 'pasalinti-sas' == $route) {
        pasalintiSas();
    }
//     else{
//         echo 'Page not found 404';
//         die;
//     }
}
function validateASMK()
{
    if ('POST' == $_SERVER['REQUEST_METHOD']) {
        $vartotojai = getVartotojas();
        if($_POST['Vardas'] != ''){
          foreach($vartotojai as $masindex =>$masyvas){
            if($masyvas['ASMK'] == $_POST['ASMK']){
              header('Location: https://localhost/Projektas/Bankas/newuser.php');
              die;
                }
            }
        }
    }
}
function createNewUser()
{   
    if ('POST' == $_SERVER['REQUEST_METHOD']) {
    $vartotojai = getVartotojas();
    foreach($vartotojai as $masindex =>$masyvas){
    $vartotojai[]= ['Vardas' => $_POST['Vardas'],'Pavarde' => $_POST['Pavarde'],'IBAN' => [$_POST['SasNR'] => 0],'ASMK' => $_POST['ASMK'],'ID' => createID()];
    }
    setVartotojas($vartotojai);
    header('Location:https://localhost/Projektas/Bankas/index.php');
    die;
    }
}

function index()
{
    require __DIR__.'/view/index.php';
}
function printSas()
{
    $for = 1;
    foreach(thisUserArray()['IBAN'] as $key => $array){
        echo
      '<tr class="text-center">
        <th scope="row">'.$for.'</th>
          <td>'.$key.'</td>
          <td scope="row" class="text-center">
          <span class="moneytext-accountlist mx-5">'.$array.' EUR'.'</span>
          <td class="text-center">
        <div class="btndiv-accountlist">
            <form action="https://localhost/Projektas/Bankas/fundcontrol.php" method="post">
            <button type="submit" name="a" value='.$for.' class="btn btn-secondary btn-sm mx-1">Tvarkyti sąskaitą</button>
            </form>
            <form action="https://localhost/Projektas/Bankas/accountlist.php?route=pasalinti-sas" method="post">
            <button type="submit" class="btn btn-danger btn-sm mx-4">Pašalinti sąskaitą</button>
            </form>
        </div>
        </td>
    </td>
    </tr>';
    $for++;
    }
}

function selectingSas()
{
    if ('POST' == $_SERVER['REQUEST_METHOD'] && isset($_SESSION['id'])){
        $_SESSION['IBANID'] =  array();
        $_SESSION['IBANID'] = $_POST['a'];
        header('Location:https://localhost/Projektas/Bankas/fundcontrol.php');
        die;
        return $_SESSION['IBANID'] = $_SESSION['IBANID'];
    }
}


function validateSessionID()
{
if ('POST' == $_SERVER['REQUEST_METHOD']) {
    session_start();
    $vartotojai = getVartotojas();
    foreach($vartotojai as $masindex => $array) {
        if($_POST['ASMK'] == $array['ASMK']){
            $_SESSION['id'] = $array['ID'];
        }
    }
    header('Location:https://localhost/Projektas/Bankas/index.php');
    die;
    return $_SESSION['id'] = $_SESSION['id'];
    }
}

function thisUserArray()
{
    $vartotojai = getVartotojas();
    foreach($vartotojai as $array){
        if($array['ID'] == $_SESSION['id']){
          $thisuser = $array;
        }
    }
    return $thisuser;
}
function thisUserSasNR()
{
    $times = 1;
    foreach(thisUserArray()['IBAN'] as $key => $array){
        if($times == $_SESSION['IBANID']){
            $sasnrarray = $key;
        }
        $times++;
    }
    return $sasnrarray;
}
function thisUserMoney()
{
    $times = 1;
    foreach(thisUserArray()['IBAN'] as $array){
        if($times == $_SESSION['IBANID']){
            $moneyarr = $array;
        }
        $times++;
    }
    return $moneyarr;
}

function pridetiLesas()
{

    header('Location:https://localhost/Projektas/Bankas/fundcontrol.php');
}

function atimtiLesas() 
{

}

function pasalintiSas()
{

}