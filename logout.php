<?php 
require_once 'AndLib/AndCore.php';
session_start();
session_destroy();
header('Location:' . AndPath::getHost() . AndPath::getPath() . '/index.php');
?>