<?php
  require_once 'function.php';
  //require_once 'function.sample.php';
  require_once 'init.php';
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
    <link rel="stylesheet" href="./Font-Awesomecss/css/font-awesome.min.css">

    <link  rel="stylesheet" type="text/css" href="stylelist.css">
    <title>Facebook</title>
  </head>
  <body>
   <div class="container-fluid">       
   <nav class="navbar navbar-expand-sm navbar-dark bg-primary rounded fixed-top">
    <?php if($currentUser):?>
        <a class="navbar-brand" href="newfeed.php">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT5Hq-bnGVESlv6xZRqqjmK0DarHxSNmIzlLXqdmHYxgF8_CbbW&s" style="width:50px;">
        </a>
        <ul class="navbar-nav ml-auto">
        <form action="search.php" method="GET" class="form-inline my-2 my-lg-0">
                    <div class="search-box">
                      <input type="text" name="search" class="search-txt" placeholder="Tìm kiếm"/>
                        <button class="search-btn" type="submit" name="submit">
                          <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
                </ul>
        <ul class="navbar-nav ml-auto ">
            <li class="nav-item">
               <a class="nav-link active" href="profile.php?userId=<?php print $currentUser['userId'] ?>"  ><?php echo $currentUser ?  $currentUser['displayName']  : '' ?></a>
            </li>
    
            <li class="nav-item">
               <a class="nav-link active" href="newfeed.php?userId=<?php print $currentUser['userId'] ?>">Trang chủ</a>
            </li>
            <li class="nav-item">
               <a class="nav-link active" href="logout.php">Đăng xuất</a>
            </li>
        <?php endif; ?>
        </ul>
      </nav>
   </div>
   


   