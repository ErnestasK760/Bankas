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
}

function pridetiLesas()
{
    $vartotojai = getVartotojas();
    foreach($vartotojai as $array){
        if($array['ID'] == $_SESSION['id']){
          $thisuser = $array;
        }
    }
    $times = 1;
    foreach($thisuser['IBAN'] as $key => $array){
        if($times == $_SESSION['IBANID']){
            $sasnrarray = $key;
            $moneyarray = $array;
        }
        $times++;
    }


}

function atimtiLesas() 
{

}

function pasalintiSas()
{

}