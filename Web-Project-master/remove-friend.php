<?php
  require_once 'init.php';
  if(!$currentUser)
  {
    header('Location: Home.php');
    exit();
  }
  $userID=$_POST['userId'];
  $profile = findUserById($userID);
  removeFriendRequest($currentUser['userId'],$profile['userId']);
  header('Location: profile.php?userId=' . $_POST["userId"]);