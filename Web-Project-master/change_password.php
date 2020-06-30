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
<h1>Đổi mật khẩu</h1>
<?php if (isset($_POST['Currentpassword']) && isset($_POST['password'])): ?>
<?php
    $password = $_POST['password'];
    $Currentpassword = $_POST['Currentpassword'];
    $hashPassword = password_hash($password, PASSWORD_DEFAULT);

    $success = false;

    if (password_verify($Currentpassword, $currentUser['password']))
    {
        updateUserPassword($currentUser['id'], $password);
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
    header('Location: index.php');
?>
<?php else: ?>
<div class="alert alert-danger" role="alert">
    Đổi mật khẩu thất bại
</div>
<?php endif; ?>
<?php else: ?>
<form action="change_password.php" method="POST">   
    <div class="main-core">
        <div>
            <h1>Đổi mật khẩu</h1>
        </div>
        <p>Mật Khẩu Hiện Tại</p>
        <div class="input-2">
            <input type="password" name="Currentpassword" placeholder="Mật Khẩu Hiện Tại">
        </div>
        <p>Mật Khẩu Mới</p>
        <div class="input-2">
            <input type="password" name="password" placeholder="Mật Khẩu Mới">
        </div>
        <div class="submit-data">
            <button type="submit">Cập nhật</button>
        </div>
    </div>
</form>
<?php endif; ?>
<?php include 'footer.php'; ?>