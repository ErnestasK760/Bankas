<?php
require __DIR__.'/functions.php';
session_start();
validateSessionID();
selectingSas();
print_r($_POST);
print_r($_SESSION);
?>
