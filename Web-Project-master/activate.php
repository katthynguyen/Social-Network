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
<?php if (isset($_GET['code'])): ?>
<?php
    $code = $_GET['code'];
    $success = false;

    $success = activateUser($code);
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
    header('Location: login.php');
?>
<?php else: ?>
<div class="alert alert-danger" role="alert">
    Kích hoạt tài khoản thất bại
</div>
<?php endif; ?>
<?php else: ?>
<form action="activate.php" method="GET">   
    <div class="main-core">
        <div>
            <h1>Kích hoạt tài khoản</h1>
        </div>
        <p>Mã Kích Hoạt</p>
        <div class="input-2">
            <input type="text" name="code" placeholder="Mã Kích Hoạt">
        </div>
        <div class="submit-data">
            <button type="submit">Kích hoạt</button>
        </div>
    </div>
</form>
<?php endif; ?>
<?php include 'footer.php'; ?>