<?php
  require_once 'init.php';
  if(isset($_GET['userId']))
  {
    $userID = $_GET['userId'];
    $profile = findUserById($userID);
    $isFollowing = getFriendship($currentUser['userId'],$userID);
    $isFollower = getFriendship($userID,$currentUser['userId']);
    $post = getNewFeeds_User($userID);
    
  }
  
  
?>
<?php include 'Header.php';?>
<div class="mainprofile" enctype="multipart/form-data">
  <div class="top-profile">
     <div class="card-top-profile">
         <img class="img-top-profile" src="https://i.pinimg.com/originals/9f/ab/17/9fab17ac364fe92f798c81d3d73c9135.jpg" alt="Card image cap">
    </div>
    <div class="container-profile">
      <nav style="border: 1px solid black;" >
        <div class="card-avatar" style="width: 14rem;" enctype="multipart/form-data">
          <img class="card-avatar-img" src="avatar.php?userId= <?php echo $currentUser['userId']?>" alt="Card image cap">
        </div>
          <div class="nav-info">
            <ul class="nav-info-ul" class="navbar-nav ">
              <li class="nav-item-li ">
                <a class="nav-link-a" href="#">Dòng thời gian</a>
              </li>
              <li class="nav-item-li">
                <a class="nav-link-a" href="update-profile.php">Cập nhật</a>
              </li>
            </ul>
        </div>
      </nav>
    </div>
    <div class="button-friend">
      <?php if (isset($_GET['userId'])): ?>
          <?php if ($currentUser['userId'] != $_GET['userId']): ?>
            <?php if ($isFollowing && $isFollower): ?>
              <form method="POST" action="remove-friend.php">
                  <input type="hidden" name="userId" value="<?php echo $_GET['userId'];?>">
                  <button class="btn-friend" type="submit" ><i class="fas fa-align-justify"></i>
                    Hủy kết bạn
                  </button>
              </form>
              <form method="POST" action="chat.php?userId=<?php echo $currentUser['userId']  ?>&id=<?php  echo $_GET['userId'];?>">
                  <input type="hidden" name="userId" value="<?php echo $_GET['userId'];?>">
                  <button class="btn-friend" type="submit" ><i class="fas fa-align-justify"></i>
                    Nhắn tin
                  </button>
              </form>
            <?php else: ?>
              <?php if ($isFollowing && !$isFollower): ?>
                <form method="POST" action="remove-friend.php">
                    <input type="hidden" name="userId" value="<?php echo $_GET['userId'];?>">
                    <button class="btn-friend" type="submit" ><i class="fas fa-align-justify"></i>
                      Xóa yêu cầu kết bạn
                    </button>
                </form>
              <?php endif; ?>

              <?php if (!$isFollowing && $isFollower): ?>
                <form method="POST" action="add-friend.php">
                    <input type="hidden" name="userId" value="<?php echo $_GET['userId'];?>">
                    <button class="btn-friend" type="submit" ><i class="fas fa-align-justify"></i>
                      Đồng ý yêu cầu kết bạn
                    </button>
                </form>
                <form method="POST" action="remove-friend.php">
                    <input type="hidden" name="userId" value="<?php echo $_GET['userId'];?>">
                    <button class="btn-friend" type="submit" ><i class="fas fa-align-justify"></i>
                      Hủy yêu cầu kết bạn
                    </button>
                </form>
              <?php endif; ?>

              <? if (!$isFollowing && !$isFollower): ?>
                <form method="POST" action="add-friend.php">
                    <input type="hidden" name="userId" value="<?php echo $_GET['userId'];?>">
                    <button class="btn-friend" type="submit" ><i class="fas fa-align-justify"></i>
                      Gửi yêu cầu kết bạn
                    </button>
                </form>
              <?php endif; ?>
            <?php endif; ?>
          <?php else: ?>
          <form action="update-profile.php">
              <button class="btn-friend" type="submit" ><i class="fas fa-align-justify"></i>
                Cập nhật thông tin
              </button>
          </form>
        <?php endif;?>
      <? endif; ?>
    </div>
    <div class="user-name">
        <p1><?php echo  $profile['displayName']; ?></p1>
    </div>
  </div>
  <div class="left-profile">
    <div class="card bg-light mb-3" style="max-width: 18rem;">
  <div class="card-header-profile">Giới thiệu</div>
  <div class="card-body-profile">
    <p class="card-text"><i class="fas fa-birthday-cake"></i> Năm sinh <?php echo  $profile['birthday']; ?></p>
    <p class="card-text"><i class="fas fa-mobile-alt"></i> Số điện thoại <?php echo  $profile['phoneNumber']; ?></p>
    <p class="card-text"><i class="fas fa-envelope"></i> Email <?php echo  $profile['email']; ?></p>
  </div>
</div>
  </div>
  <div class="main-content-profile">
    <form action="create-post.php" method="GET" enctype="multipart/form-data" >
      <div class="form-group-profile">
        <label class="label-profile" for="postContent">Tạo bài viết</label>
        <textarea class="form-control-profile" id="postContent" name="postContent" rows="3"></textarea>
        <input type="file" class="form-control-file" id="postImages" name="postImages"/>

        <img class="img-up" id="blah" src="http://placehold.it/180" alt="your image"/>
        <input class="btn-submit" type="submit" value="Đăng">
    </form>
 
  
    <div class="card-pro-profile">
    <?php foreach ($post as $posts): ?>
      
      <div class="card-header-profile-stu">
        <img class="card-header-profile-stu-img"src="avatar.php?userId=<?php echo $profile['userId'];?>" class="img-circle" alt="...">
        <h1 class="card-header-profile-stu-h1"><?php echo  $profile['displayName']; ?></h1>
    
      </div>
      <div class="card-body-profile-stu"> 
        <p class="card-body-profile-stu-p"><?php echo $posts['postContent']; ?></p>
        <?php  //var_dump($posts['postId']) ?>
        <img class="card-body-profile-stu-img" src="Post_image.php?postId=<?php echo $posts['postId'];?>" alt="...">
        <form class="cardLikeComment" method="GET" action="like.php">
          <input type = "hidden" name="postId" value=<?php echo $posts['postId']; ?>>
          <input type = "hidden" name="userId" value=<?php echo $userID; ?>>
          <?php //if (checkLikes($userID, $posts['postId']) == true): ?>
            <!-- <span><button type="submit" name="Like" class="btn-stu-profile"><i class="far fa-thumbs-up"></i>Đã Thích</button> </span> -->
          <?php //else: ?>
            <span><button type="submit" name="Like" class="btn-stu-profile"><i class="far fa-thumbs-up"></i> Thích</button> </span>
          <?php //endif; ?>
          <span><button type="submit" class="btn-stu-profile"><i class="far fa-comment"></i> Bình luận</button> </span>
        </form>
        <?php $comment = getNewComments($posts['postId']); ?>
        <?php foreach($comment as $comments): ?>

        <div class="card-comment">
          <p class="card-body-profile-stu-p"><?php  echo  $comments['displayName'].": ".$comments['commentContent']; ?></p>
        </div>
        <?php endforeach ?>
        
        <div class="<?php echo $posts['postId'] ?>">
          <form method="GET" action="create-comment.php">
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
</div>

    <?php include 'footer.php';?>