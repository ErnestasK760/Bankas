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
    elseif ('POST' == $_SERVER['REQUEST_METHOD'] && 'prideti-sas' == $route) {
        pridetiSas();
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
    if(mb_strlen($_POST['Vardas'],"UTF-8") < 3 || mb_strlen($_POST['Pavarde'],"UTF-8") < 3 ||  (mb_strlen($_POST['ASMK'],"UTF-8") < 11 || mb_strlen($_POST['ASMK'],"UTF-8") > 11)){
        addMessage('danger','Blogai įvesta informacija');
        header('Location:https://localhost/Projektas/Bankas/newuser.php');
        die;
    }   else    {
    $vartotojai[]= ['Vardas' => $_POST['Vardas'],'Pavarde' => $_POST['Pavarde'],'IBAN' => [$_POST['SasNR'] => 0],'ASMK' => $_POST['ASMK'],'ID' => createID()];
    setVartotojas($vartotojai);
    addMessage('success','Vartotojas sėkmingai sukurtas');
    header('Location:https://localhost/Projektas/Bankas/index.php');
    die;
        }
    }
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
            <button type="submit" name="b" value='.$for.' class="btn btn-danger btn-sm mx-4">Pašalinti sąskaitą</button>
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
        if(!empty($_POST['a'])){
        $_SESSION['IBANID'] =  array();
        $_SESSION['IBANID'] = $_POST['a'];
        header('Location:https://localhost/Projektas/Bankas/fundcontrol.php');
        die;
        return $_SESSION['IBANID'] = $_SESSION['IBANID'];
        }else if (!empty($_POST['b'])){
            $_SESSION['IBANID'] =  array();
            $_SESSION['IBANID'] = $_POST['b'];
            return $_SESSION['IBANID'] = $_SESSION['IBANID'];
        }
    }
}

function auth()
{
    if(!isset($_SESSION['id'])){
        header('Location:https://localhost/Projektas/Bankas/index.php');
        die;
    }
}

function validateSessionID()
{
if ('POST' == $_SERVER['REQUEST_METHOD']) {
    $vartotojai = getVartotojas();
    foreach($vartotojai as $masindex => $array) {
        if($_POST['ASMK'] == $array['ASMK']){
            $_SESSION['id'] = $array['ID'];
            addMessage('success','Sėkmingai prisijungta');
        }
        // elseif($_POST['ASMK'] != $array['ASMK']){
        //     addMessage('danger','Blogai suvesta informacija');
        //     header('Location:https://localhost/Projektas/Bankas/newuser.php');
        //     die;
        // }
    }
    // header('Location:https://localhost/Projektas/Bankas/index.php');
    // die;
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
    $times = 1;
    $vartotojai = getVartotojas();
    foreach($vartotojai as &$array){
        if($array['ID'] == $_SESSION['id']){
            foreach($array['IBAN'] as &$value){
                if($_SESSION['IBANID'] == $times){
                    $value += $_POST['les_plus'];
                    print_r($value);
                    }
                $times++;
                }
        }
    }
    setVartotojas($vartotojai);
    addMessage('success','Lėšos sėkmingai pridėtos');
    header('Location:https://localhost/Projektas/Bankas/fundcontrol.php');
    die;
}

function atimtiLesas() 
{
    
        $times = 1;
        $vartotojai = getVartotojas();
        foreach($vartotojai as &$array){
            if($array['ID'] == $_SESSION['id']){
                foreach($array['IBAN'] as &$value){
                    if($_SESSION['IBANID'] == $times){
                        if($_POST['les_minus'] > $value){
                            addMessage('danger','Neužtenka lėšų');
                        }else if ($_POST['les_minus'] <= $value){
                            $value -= $_POST['les_minus'];
                            addMessage('success','Lėšos sėkmingai atimtos');
                        }
                    $times++;
                    }
                }
            }
        }
        setVartotojas($vartotojai);
        header('Location:https://localhost/Projektas/Bankas/fundcontrol.php');
        die;


}

function pridetiSas()
{
    $vartotojai = getVartotojas();
    foreach($vartotojai as &$array){
        if($array['ID'] == $_SESSION['id']){
           $array['IBAN'] += [createIBAN() => 0];
        }
    }
    setVartotojas($vartotojai);
    addMessage('success','Nauja sąskaita sėkmingai sukurta');
    header('Location:https://localhost/Projektas/Bankas/accountlist.php');
    die;
}

function pasalintiSas()
{
        $times = 1;
        $vartotojai = getVartotojas();
        foreach($vartotojai as &$array){
            if($array['ID'] == $_SESSION['id']){
                foreach($array['IBAN'] as $key => &$value){
                    if ($_SESSION['IBANID'] == $times && $value == 0){
                        unset($array['IBAN'][$key]);
                        addMessage('success','Sėkmingai pašalinta sąskaita');
                    }else if ($_SESSION['IBANID'] == $times && $value > 0){
                        addMessage('danger','Sąskaitoje yra lėšų');
                    }
                    $times++;
                }
            }
        }
        setVartotojas($vartotojai);
        header('Location:https://localhost/Projektas/Bankas/accountlist.php');
        die;

}

// type succes|danger|info
function addMessage(string $type, string $msg) : void
{
    $_SESSION['msg'][] = ['type' => $type, 'msg' => $msg];
}
function clearMessages() : void
{
    $_SESSION['msg']= [];
}
function showMessages() : void
{
    $messages = $_SESSION['msg'];
    clearMessages();
    require __DIR__.'/msg.php';
}
function logout()
{
    session_start();
    unset($_SESSION['id']);
    unset($_SESSION['IBANID']);
    addMessage('success','Sėkmingai atsijungta');
    header('Location:https://localhost/Projektas/Bankas/index.php');
    die;
}
function isLogged()
{
    if(isset($_SESSION['id'])){
        return true;
    }
}