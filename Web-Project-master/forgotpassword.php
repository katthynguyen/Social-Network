<?php
    require_once 'init.php';
?>
<?php include 'Header.php'; ?>
<style>
    .main-core .input-1 input
{
    width: 100%;
    border-radius: 8px;
    
    height: 25px;
}
h1{
    margin-top:26px;
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
<h1>Kích hoạt tài khoản</h1>
<?php if (isset($_POST['email'])): ?>
<?php
    $email = $_POST['email'];
    $success = false;
    $user = findUserByEmail($email);
    $success = forgotPasswordUser($user);
    // if (isset($_COOKIE[$username]))
    // {
    //     if ($password == $_COOKIE[$username])
    //     {
    //         $success = true;
    //     }
    // }
?>
<?php if ($success): ?>
    <div class="alert alert-success" role="alert">
        kiểm tra email để kích hoạt tài khoản
    </div>
<?php else: ?>
<div class="alert alert-danger" role="alert">
    Gửi mã kích hoạt thất bại
</div>
<?php endif; ?>
<?php else: ?>
<form action="forgotpassword.php" method="POST">   
    <div class="main-core">
        <div>
            <h1>Quên mật khẩu</h1>
        </div>
        <p>Email</p>
        <div class="input-2">
            <input type="text" name="email" placeholder="Email">
        </div>
        <div class="submit-data">
            <button type="submit">Xác nhận</button>
        </div>
    </div>
</form>
<?php endif; ?>
<?php include 'footer.php'; ?>