<?php
session_start();
session_destroy();
header('Location:https://localhost/Projektas/Bankas/index.php');
die;
?>