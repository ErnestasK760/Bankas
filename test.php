<?php


function round($num,$a)
{
    $number = $num * pow(10,$a);
    $res = (int)$number / pow(10,$a);
    return $res;
}
?>