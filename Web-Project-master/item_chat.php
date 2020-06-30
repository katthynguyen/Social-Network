
<?php 
  require_once 'init.php';
  require_once 'function.php';
  //require_once 'function.sample.php';
    if(isset($_GET['userId']))
    {
        
      $userID = $_GET['userId'];
      $userSend = findUserById($userID);

      $id_gui  = (int)$userID;
    }
    $id_nhan =null;
    //$userReceive = findUserById($userID2);

    $id_BanBe = Load_ID_Chat($id_gui);

    $list_user = array();
?>