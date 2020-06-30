<?php
    require_once 'init.php';
    if (!$currentUser)
    {
        header('Location: Home.php');
        exit();
    }
?>
<?php include 'Header.php'; ?>
<style>
    .main-core .input-1 input
{
    width: 100%;
    border-radius: 8px;
    
    height: 25px;
}

.main-core .input-2 input
{
    width: 100%;
    border-radius: 8px;
    height: 25px;
}

.main-core
{
    margin: 0 200px;
    margin-top:32px;
}

.main-core .submit-data button
{
    background: #0984e3;
    margin-top: 15px;
    width: 100px;
    height: 35px;
    border-radius: 8px;
    border: none;
    outline: none;
}
</style>
<h1>Cập nhật</h1>
<?php if (isset($_POST['displayName']) && isset($_POST['phoneNumber']) && isset($_POST['Currentpassword']) && isset($_POST['password'])): ?>
<?php
    $displayName = $_POST['displayName'];
    $phoneNumber = $_POST['phoneNumber'];
    $password = $_POST['password'];
    $Currentpassword = $_POST['Currentpassword'];
    $hashPassword = password_hash($password, PASSWORD_DEFAULT);
    $avatar = $currentUser['avartar'];
    
    $success = true;
    var_dump($displayName);
    if (isset($_FILES['avartar']) && $_FILES['avartar']['name'])
    {
        $success = false;
        $file = $_FILES['avartar'];
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
    if (password_verify($Currentpassword, $currentUser['password']))
    {
        updateUserProfile($currentUser['userId'], $displayName,$hashPassword, $phoneNumber, $avatar);
        $success = true;
    }
    
    // if (isset($_COOKIE[$username]))
    // {
    //     if ($password == $_COOKIE[$username])
    //     {
    //         $success = true;
    //     }
    // }
?>
<?php if ($success): ?>
<?php 
    header('Location: profile.php?userId='.$currentUser['userId']) ;
?>
<?php else: ?>
<div class="alert alert-danger" role="alert">
    Cập nhật thông tin thất bại
</div>
<?php endif; ?>
<?php else: ?>
<form action="update-profile.php" method="POST" enctype="multipart/form-data">   
    <div class="main-core">
        <div>
            <h1>Cập nhật</h1>
        </div>
        <p>Họ tên</p>
        <div class="input-2">
            <input type="text" id="displayName" name="displayName" placeholder="Họ tên" value = "<?php echo $currentUser['displayName']; ?>">
        </div>
        <p>Số Điện Thoại</p>
        <div class="input-2">
            <input type="text" id="displayName" name="phoneNumber" placeholder="Số Điện Thoại" value = "<?php echo $currentUser['phoneNumber']; ?>">
        </div>
        <p>Mật Khẩu Hiện Tại</p>
        <div class="input-2">
            <input type="password" name="Currentpassword" placeholder="Mật Khẩu Hiện Tại">
        </div>
        <p>Mật Khẩu Mới</p>
        <div class="input-2">
            <input type="password" name="password" placeholder="Mật Khẩu Mới">
        </div>
        <div class="form-group">
            <label for="avartar">Ảnh đại diện</label>
            <input type="file" class="form-control-file" id="avartar" name="avartar">
        </div>
        <div class="submit-data">
            <button type="submit">Cập nhật</button>
        </div>
    </div>
</form>
<?php endif; ?>
<?php include 'footer.php'; ?>