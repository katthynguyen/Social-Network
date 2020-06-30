<?php
    require_once 'init.php';
    if (!$currentUser)
    {
        header('Location: Home.php');
        exit();
    }

    if (isset($_GET['submit']) && isset($_GET['userId']))
    {
        $userId = $_GET['userId'];
        $postId = $_GET['postId'];

        $kq = sendLike($currentUser['userId'], $postId[['postId']]);
        $postId = getLiked($userId, $postId);
    }
    
    header('Location: profile.php?userId=' . $userId);
?>