<?php 
    require_once 'item_chat.php';
?>

<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<!DOCTYPE html>
<html>
	<head>
        <title>Chat</title>
        <link rel="stylesheet" type="text/css" href="chat.css">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.js"></script>
	</head>
	<!--Coded With Love By Mutiullah Samim-->
	<?php include 'Header.php';?>
		<div class="container-fluid h-100">
			<div class="row justify-content-center h-100">
				<div class="col-md-4 col-xl-3 chat"><div class="card mb-sm-3 mb-md-0 contacts_card">
                    <!-- search -->
                    <div class="card-header">
                        <form action="chat.php" method="GET">
                            <div class="input-group">
                                <input type="text" placeholder="Search..." name="search" class="form-control search">
                                <div class="input-group-prepend">
                                    <button  class="input-group-text search_btn" type="submit" name="submit"  ><i class="fas fa-search" ></i> </button>
                                </div>
                            </div>    
                        </form>
                    </div>
                    <?php 
                            if(isset($_GET['delete']))
                            {
                                Xoa_Chat($_GET['delete']);
                            }
                            if(isset($_GET['submit'])&& $_GET['search'])
                            {
                                
                                $search=$_GET['search'];
                                foreach($id_BanBe as $value)
                                {
                                    if(strpos($value['displayName'], $search ) !== false)
                                    {
                                        array_push($list_user, $value);
                                    }
                                }
                            }
                                if (count($list_user) ==0 )
                                {
                                    $list_user = $id_BanBe;
                                }
                    ?>
					<div class="card-body contacts_body">
						<ui class="contacts">
                        <?php for($i = 0; $i < count($list_user);$i ++) { ?>
                            <li class="active">
                                <div class="d-flex bd-highlight">
                                    <div class="img_cont">
                                        <img src= "avatar.php?userId= <?php echo $list_user[$i]['toMessage']?>" class="rounded-circle user_img">
                                    </div>
                                    <div class="user_info">
                                    <a type="button" href = "chat.php?userId=<?php echo $id_gui ?>&id=<?php echo $list_user[$i]['toMessage']?>" class="btn btn-link" ><?php echo $list_user[$i]['displayName'] ?></a>
                                        
                                    </div>
                                </div>
                            </li>
                        <?php } ?>
						</ui>
					</div>
					<div class="card-footer"></div>
                </div>
            </div>

            <?php
            if(isset($_GET['id']) && isset($_GET['mess']))
            {
                // echo
                 $id_gui ;
                // echo "<br>";
                // echo 
                $id_nhan = (int)$_GET['id'] ;
                // echo "<br>";
                // echo 
                $noi_dung= $_GET['mess'];                
                them_Chat($id_gui,$id_nhan,$noi_dung);
                $user_nhan = findUserById($id_nhan);
                $user_gui = findUserById($id_gui);
                sendEmail($user_nhan['email'], $user_nhan['displayName'], 'Thông báo tin nhắn  ', "Bạn có tin nhắn " . $user_gui['displayName']);
            }
            ?> 
                
                <?php 
                    $id=-1;
                    if ( isset($_GET['id']) )
                    {
                        $id = $id_nhan = (int)$_GET['id'];
                    }
                    $user = findUserById($id);
                ?>

				<div class="col-md-8 col-xl-6 chat">
					<div class="card">
						<div class="card-header msg_head">
							<div class="d-flex bd-highlight">
								<div class="img_cont">
									<img src="avatar.php?userId= <?php echo $id?>" class="rounded-circle user_img">
								</div>
								<div class="user_info">
									<span> <?php echo  $user['displayName']  ?></span>
								</div>
								<div class="video_cam">
									<span><i class="fas fa-video"></i></span>
									<span><i class="fas fa-phone"></i></span>
								</div>
							</div>
                        </div>
                        
				        <div class="card-body msg_card_body">
                        <?php
                            $chat = Chat($id_gui,$id);
                            foreach($chat as $chat1)
                            {
                        ?>
                        <?php if($chat1['messageFrom'] == $id){ ?>
							<div class="d-flex justify-content-start mb-4">
								<div class="img_cont_msg">
									<img src="avatar.php?userId=<?php echo $id?>" class="rounded-circle user_img_msg">
								</div>
								<div class="msg_cotainer_send">
                                    <?php echo$chat1['messageContent'];?>
                                    <span class="msg_time"><?php echo  $chat1['createAt']  ?></span>
                                    								
                                </div>
                            </div>
                            <?php } ?>

                        <?php if($chat1['messageFrom'] == $id_gui){ ?>
							<div class="d-flex justify-content-end mb-4">
								<div class="msg_cotainer">
                                <form action="chat.php" method = "GET"  >
                                    <?php echo $chat1['messageContent'];?>
                                    <span class="msg_time"><?php echo  $chat1['createAt']  ?></span>
                                    <input type ="hidden" name = "userId" value="<?php echo $id_gui?>"> 
                                    <input type ="hidden" name = "id" value="<?php echo $id_nhan?>"> 
                                    <input type ="hidden" name = "id" value="<?php echo $id_nhan?>">
                                    <button type = "submit" name="delete" value ="<?php echo $chat1['messageId'] ?>" > delete </button>
								</form>
                                </div>
                                
								<div class="img_cont_msg">
							<img src="avatar.php?userId=<?php echo $id_gui?>" class="rounded-circle user_img_msg">
								</div>
							</div>

                        <?php } ?>
     
                    <?php }?>
                </div>
						<div class="card-footer">
                            <form  method = "GET" id="form_input">  
							<div class="input-group">
								<div class="input-group-append">
									<span class="input-group-text attach_btn"><i class="fas fa-paperclip"></i></span>
								</div>
                                <textarea name="mess" class="form-control type_msg" placeholder="Type your message..."></textarea>
                                
								<div class="input-group-append">
                                   <input type ="hidden" name = "userId" value="<?php echo $id_gui?>"> 
									<button type="submit" name = "id" value="<?php echo $id_nhan?>" class="input-group-text send_btn" > <i class="fas fa-location-arrow"></i></button>
								</div>
                            </div>
                            </form>
                        </div>
                    </div>
				</div>
            </div>
          
        </div>      
        
        <?php
            // if(isset($_GET['id']) && isset($_GET['mess']))
            // {
            //     echo $id_gui ;
            //     echo "<br>";
            //     echo $id_nhan = (int)$_GET['id'] ;
            //     echo "<br>";
            //     echo $noi_dung= $_GET['mess'];
            //     them_Chat($id_gui,$id_nhan,$noi_dung);
            // }
        ?>          

 <?php include 'footer.php';?>
