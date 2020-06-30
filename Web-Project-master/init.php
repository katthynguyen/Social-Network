<?php
require_once('./vendor/autoload.php');
require_once('function.php');
//require_once('function.sample.php');
require_once('config.php');
session_start();
$page = detect();
$currentUser =  null; 
$db = new PDO("mysql:host=$DB_HOST;dbname=$DB_NAME;charset=utf8", "$DB_USER", "");

if(isset($_SESSION['Id']))
{
    $currentUser = findUserById($_SESSION['Id']);
}