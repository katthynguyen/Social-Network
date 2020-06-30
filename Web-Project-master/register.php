<?php 
  require_once 'init.php';
  require_once 'function.php';
  //require_once 'function.sample.php';
  require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css?family=Permanent+Marker" rel="stylesheet">
    <style type="text/css">
        body{
            background-image: url(https://phongvu.vn/cong-nghe/wp-content/uploads/2018/07/hinh-nen-laptop.jpeg);
        }
    </style>
  </head>
  <body>
  <?php if(isset($_POST["displayName"]) && isset($_POST["email"]) && isset($_POST["password"])
          &&isset($_POST["birthday"])&& isset($_POST["phoneNumber"]))
{
    $displayName = $_POST['displayName'];
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $hassPass = password_hash($pass,PASSWORD_DEFAULT);
    $birthday=$_POST['birthday'];
    $phonenumber=$_POST['phoneNumber'];
    $succes = false;
    $user = findUserByEmail($email);
    if(!$user){
        $code = generateRandomString(16);
        $stmt = $db->prepare("INSERT INTO users (displayName,email,password,birthday,phoneNumber,avartar,code,status)VALUES(?,?,?,?,?,?,?,?)");
        $stmt->execute(array($displayName,$email,$hassPass,$birthday,$phonenumber,"",$code,0));
        $newUserId = $db->lastInsertId();
        sendEmail($email,$displayName,'Kích hoạt tài khoản',"Chào $displayName<br/>Đây là email kích hoạt tài khoản của bạn.<br/>mời bạn bấm vào link và copy code dán vào để kích hoạt tài khoản của mình.<br/>-----------------------------------<br/>UserName: $email <br/>Your code:  $code <br/><p>Đường dẫn kích hoạt: <a href=\"$BASE_URL/verify.php\">Bấm vào...</a></p>");
        $succes = true;
        $_SESSION['Id'] = $newUserId;
        header('Location: registerconfirm.php'); 
    }
    else{
      echo "
        <div class='register-fail'>
           Đăng ký thất bại
        </div>";
    }
    
}
?>
    <div class="signup-form">
      <form action="register.php" method="POST">
        <h1>Đăng ký</h1>
        <input type="text" id="displayName" placeholder="Họ và tên" name="displayName" class="txtb">
        <input type="email" id="email" placeholder="Email" name="email" class="txtb">
        <input type="password"  id="password" placeholder="Mật khẩu" name="password" class="txtb">
        <input type="date" id="birthday" placeholder="Năm sinh" name="birthday" class="txtb">
        <input type="text" id="phoneNumber" placeholder="Số điện thoại" name="phoneNumber" class="txtb">
        <input type="submit" value="Tạo tài khoản" class="signup-btn">
          <a href="Login.php">Tôi đã có tài khoản</a>
      </form>
    </div>
  </body>
</html>
