<?php
  require_once 'init.php';
  if  (!$currentUser)
  {
    header('Location: Home.php');
    exit();
  }
  if (isset($_POST['userId']))
  {
    $userID = $_POST['userId'];
    $profile = findUserById($userID);
    sendFriendRequest($currentUser['userId'],$profile['userId']);
    sendEmail($profile['email'], $profile['displayName'],  'Thông báo kết bạn ', $currentUser['displayName'] . " Kết Bạn" );
    header('Location: profile.php?userId=' . $_POST['userId']);
  }
