<?php
    require_once 'init.php';
    if (!$currentUser)
    {
        header('Location: Home.php');
        exit();
    }

    $content = $_GET['postContent'];
    $avatar = $_GET['postImages'];

    $success = true;

    if (isset($_FILES['postImages']) && $_FILES['postImages']['name'])
    {
        $success = false;
        $file = $_FILES['postImages'];
        $fileName = $file['name'];
        $fileSize = $file['size'];
        $fileTemp = $file['tmp_name'];
        $newImage = resizeImage($fileTemp, 500, 300);
        ob_start();
        imagejpeg($newImage);
        $avatar = ob_get_contents();
        var_dump($avatar);
        ob_end_clean();
        $success = true;
    }

    createPost($currentUser['userId'], $content, $avatar);

    header('Location: profile.php?userId=' . $currentUser['userId']);
?>