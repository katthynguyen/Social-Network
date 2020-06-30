<?php 
    require_once 'init.php';
    require_once 'function.php';
    //require_once 'function.sample.php';
?>
<?php include 'Header.php';?>
<!-- content -->

<h1>Kích hoạt tài khoản</h1>


<?php if(isset($_GET['code']))  
{
    $code = $_GET['code'];
    $good=activeteUser($code);
    if($good){
        $_SESSION['userId'] = $user['id'];
        header('Location: Login.php');  
    }else{
        echo "
        <div class='alert alert-danger' role='alert'>
    Kích hoạt tài khoản thất bại
    </div>";
    }
}
?>
<div class="login-card">
    <form action="verify.php" method="GET">
            <div class="form-group">
                <label for="code">Mã kích hoạt:</label>
                <input type="text" class="form-control" id="code" placeholder="Code..." name="code">
                <button type="submit" name="login" class="btn mt-3" style="background-image: radial-gradient(circle at 10% 20%, rgba(230, 115, 1, 0.68) 21.4%, rgb(255, 78, 78) 80.3%);width:100%;color:#fff;font-weight:bold;">Kích hoạt tài khoản</button>
            </div>
        </form>
</div>