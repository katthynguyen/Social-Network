<?php
require_once 'init.php';

$id = $_GET['postId'];
$id_user = $_GET['userId'];
var_dump($id_user);
var_dump($id);
$post = get_post_ID($id,$id_user);
var_dump($post);
var_dump($post['postImages']);

//header('content-type: image/jpeg');
//echo $post[0]['postImages'];