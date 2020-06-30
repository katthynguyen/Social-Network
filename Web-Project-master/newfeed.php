<?php
  require_once 'init.php';
  if (!$currentUser) {
    header('Location: Home.php');
    exit();
  }
  if (isset($_GET['userId']))
  {
   $post= getNewFeeds_id($_GET['userId']);

  }
?>
<?php include 'Header.php';?>
<script src="style.js"></script>
<div class="container">
  <div class="menu">
    <br>
    <ul class="menu-ul-newfeed">
        <br><li class="menu-li-newfeed"><a class="menu-a-newfeed" href="newfeed.php?userId=<?php echo $currentUser['userId']    ?>"><i class="fa fa-home"></i> Bảng tin </a></li>
          <br> <li class="menu-li-newfeed"><a class="menu-a-newfeed" href="profile.php?userId=<?php print $currentUser['userId']?>"><i class="fas fa-users"></i> Trang cá nhân</a></li>
          <br><li class="menu-li-newfeed"><a class="menu-a-newfeed" href="chat.php?userId=<?php print $currentUser['userId'] ?>"> <i class="fab fa-facebook-messenger"></i> Tin nhắn</a></li>
          <br>
      </ul>
  </div>
  <div class="main-content">
  <?php 
    if (count($post) > 0)
    {  ?> 
      <div class="card-pro-profile">
      <?php foreach ($post as $posts): ?>
        <hr> 
        <div class="card-header-profile-stu">
          <img class="card-header-profile-stu-img"src="avatar.php?userId=<?php echo $posts['userId'];?>" class="img-circle" alt="...">
          <h1 class="card-header-profile-stu-h1"><?php echo  $posts['displayName']; ?></h1>
      
        </div>
        <div class="card-body-profile-stu">
          <p class="card-body-profile-stu-p"><?php echo "</br>".$posts['postContent']; ?></p>
          <img class="card-body-profile-stu-img" src="http://images6.fanpop.com/image/photos/39500000/Dahyun-dahyun-twice-39551471-600-960.jpg" alt="...">
          <form class="cardLikeComment" method="GET" action="like.php">
            <input type = "hidden" name="postId" value=<?php echo $posts['postId']; ?>>
            <input type = "hidden" name="userId" value=<?php echo $posts['userId']; ?>>
            <?php //if (checkLikes($posts['userId'], $posts['postId']) == true): ?>
              <!-- <span><button type="submit" name="Like" class="btn-stu-profile"><i class="far fa-thumbs-up"></i>Đã Thích</button> </span> -->
            <?php //else: ?>
              <span><button type="submit" name="Like" class="btn-stu-profile"><i class="far fa-thumbs-up"></i> Thích</button> </span>
            <?php //endif; ?>
            <span><button type="submit" class="btn-stu-profile"><i class="far fa-comment"></i> Bình luận</button> </span>
          </form>
          <?php $comment = getNewComments($posts['postId']); ?>
          <?php foreach($comment as $comments): ?>
  
          <div class="card-comment">
            <p class="card-body-profile-stu-p"><?php echo  $comments['displayName'].": ".$comments['commentContent']; ?></p>
          </div>
          <?php endforeach ?>
          
          <div class="<?php echo $posts['postId'] ?>">
            <form method="GET" action="create_comment_new_feed.php">
              <input type="hidden" name="postId" value=<?php echo $posts['postId']; ?>>
              <input type="hidden" name="userIdComment" value=<?php echo $currentUser['userId']; ?>>
              <input type="hidden" name="userIdCommented" value=<?php echo $_GET['userId']; ?>>
              <textarea class="form-control-stu-profile" rows="2" id="comment" name="comment"></textarea>
              <input class="btn-submit" type="submit" value="Đăng"> 
            </form>
          </div>
        </div>
      
      <?php endforeach ?>
      </div>
    <?php }?>
      </div>
    <div>
  </div>
</div>
<?php include 'footer.php';?>