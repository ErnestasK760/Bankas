<?php
function getVartotojas() : array
{
    if (!file_exists(__DIR__.'/vartotojai.json')) {
        $vartotojai[] = ["Vardas" => "Vardenis","Pavarde" => "Pavardenis","SasNR" => ["LT0100000000000000000"],"ASMK" => 396090841912,"ID" => "0","Money" => 0];
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
    
}