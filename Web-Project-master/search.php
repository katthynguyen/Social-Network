<?php
  require_once 'init.php';
  require_once 'function.php';
  //require_once 'function.sample.php';
?>
<?php include 'Header.php';?>

<?php 
    if (isset($_GET['submit'])&& $_GET['search']){
        $search=$_GET['search'];
        $result = searchName($search);
        $num=count($result);
}
    else
    {
        echo "ban chua nhap";
    }
?>
<div class='search-name'>
    <h1> Kết qua tìm kiếm</h1>
    <?php for ($i=0;$i<$num;$i++): {?>
        <a href="profile.php?userId=<?php echo $result[$i]['userId'] ?>"><i class="fas fa-user"></i> <?php echo $result[$i]['displayName']?></a><br>
    <?php } endfor;?>
    <div>
<?php include 'footer.php';?>
