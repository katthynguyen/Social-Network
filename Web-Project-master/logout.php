<?php
require_once 'init.php';

unset($_SESSION['Id']);
header('Location: Home.php');