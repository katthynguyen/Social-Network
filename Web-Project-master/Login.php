<?php 
  require_once 'init.php';
  require_once 'function.php';
  //require_once 'function.sample.php';
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" charset="utf-8"></script>
    <style type="text/css">
        body{
            background-image: url(https://phongvu.vn/cong-nghe/wp-content/uploads/2018/07/hinh-nen-laptop.jpeg);
        }
    </style>
  </head>
  <body>
  <?php if(isset($_POST['email']) && isset($_POST['password']))  
{
    $email = $_POST['email'];
    $password = $_POST['password'];
    $succes=false;
    $user = findUserByEmail($email);
    
    if($user && $user['status'] == 1 && password_verify($password,$user['password'])){
        $succes = true;
        $_SESSION['Id'] = $user['userId'];
        header('Location: newfeed.php?userId='.$_SESSION['Id']);  
    }else{
        echo "
        <div class='login-fail'>
           Đăng nhập thất bại
        </div>";
    }
}
?>
      <form action="Login.php" class="login-form" method="POST">
        <h1>Đăng nhập</h1>
        <div class="txtb">
          <input type="text" id="email" name="email">
          <span data-placeholder="Email"></span>
        </div>
        <div class="txtb">
          <input type="password" id="password" name="password" >
          <span data-placeholder="Password"></span>
        </div>
        <input type="submit" class="logbtn" value="Đăng nhập">
        <div class="bottom-text">
          Tạo tài khoản mới? <a href="register.php">Đăng ký</a>
          <br>
           <a href="forgotpassword.php">Quên mật khẩu</a>
        </div>
        
      </form>
      <script type="text/javascript">
      $(".txtb input").on("focus",function(){
        $(this).addClass("focus");
      });
      $(".txtb input").on("blur",function(){
        if($(this).val() == "")
        $(this).removeClass("focus");
      });
      </script>


  </body>
</html>
