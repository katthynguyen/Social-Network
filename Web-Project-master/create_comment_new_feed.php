<?php
    require_once 'init.php';
    if (!$currentUser)
    {
        header('Location: Home.php');
        exit();
    }

    $content = $_GET['comment'];
    $postId = $_GET['postId'];
    $userIdComment = $_GET['userIdComment'];
    $userIdCommented = $_GET['userIdCommented'];
    
    createComment($postId, $userIdComment, $content);
    header('Location: newfeed.php?userId=' . $userIdCommented);
?>