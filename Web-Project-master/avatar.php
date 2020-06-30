<?php
require_once 'init.php';
$id = $_GET['userId'];

$user = findUserById($id);

header('content-type: image/jpeg');
echo $user['avartar'];