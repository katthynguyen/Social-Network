<?php  
require_once './vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function them_Chat($id_gui,$id_nhan,$noi_dung){
    global $db;
    $stmt=$db->prepare("INSERT INTO usermessages( messageFrom, toMessage, messageContent, createAt) VALUES (?,?,?,CURRENT_TIMESTAMP())");
    $stmt->execute(array($id_gui,$id_nhan,$noi_dung));
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function Xoa_Chat($idMess)
{
    global $db;
    $stmt=$db->prepare("DELETE FROM usermessages where messageId = ?");
    $stmt->execute(array($idMess));
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function Load_ID_Chat($idFrom){
    global $db;
    $stmt=$db->prepare("SELECT DISTINCT um.toMessage ,um.messageFrom ,u.displayName FROM  usermessages um JOIN users u on u.userId = um.toMessage where um.messageFrom = ? ");
    $stmt->execute(array($idFrom));
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function Chat($idto , $idfrom)
{
    global $db;
    $stmt=$db->prepare("SELECT * FROM usermessages WHERE messageFrom = ? AND toMessage = ? or messageFrom = ? AND toMessage = ?  ORDER BY createAt ASC");
    $stmt->execute(array($idfrom,$idto,$idto,$idfrom));
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function detect()
{
    $uri = $_SERVER['REQUEST_URI'];
    $part = explode('/',$uri);
    $fileName = $part[2];
    $part = explode('.',$fileName);
    $page = $part[0];
    return $page;
}

function findUserByEmail($email)
{
    global $db;
    $stmt = $db->prepare("SELECT * FROM users WHERE email=?");
    $stmt->execute(array($email));
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
function findUserById($id)
{
    global $db;
    $stmt = $db->prepare("SELECT * FROM users WHERE userId=?");
    $stmt->execute(array($id));
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
function updateUserProfile($userId, $displayName,$password, $phoneNumber, $avatar){
    global $db;
    $stmt = $db->prepare("UPDATE users SET displayName = ?,password=?, phoneNumber = ?, avartar = ? WHERE userId = ?");
    return $stmt->execute(array($displayName,$password, $phoneNumber, $avatar, $userId));
}
function updateImage($id,$image){
    global $db;
    $stmt = $db->prepare("UPDATE users SET image =? WHERE id = ?");
    return $stmt->execute(array($image,$id));   
}
function updateImageNewFeed($id,$image){
    global $db;
    $stmt = $db->prepare("UPDATE newfeeds SET image =? WHERE id = ?");
    return $stmt->execute(array($image,$id));   
}
function createPost($userId, $postcontent, $postimages) {
    global $db;
    $stmt = $db->prepare("INSERT INTO post (userId, postContent, postImages) VALUE (?, ?, ?)");
    $stmt->execute(array($userId, $postcontent, $postimages));
    return $db->lastInsertId();
}

function getNameImage($id){
    global $db;
    $stmt = $db->prepare("SELECT image from users where id=?");
    $stmt->execute(array($id));
    $posts = $stmt->fetch(PDO::FETCH_ASSOC);
    return $posts;
}
function getNameImageNF($id){
    global $db;
    $stmt = $db->prepare("SELECT image from newfeeds where id=?");
    $stmt->execute(array($id));
    $posts = $stmt->fetch(PDO::FETCH_ASSOC);
    return $posts;
}
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
function sendEmail($to,$name,$subject,$content)
{
    global $EMAIL_FROM,$EMAIL_NAME,$EMAIL_PASSWORD;
    $mail = new PHPMailer(true);

    try {
        //Server settings
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
        $mail->isSMTP();         
        $mail->ContentType = 'text/html';            
        $mail->CharSet ='UTF-8';                       // Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = $EMAIL_FROM;                     // SMTP username
        $mail->Password   = $EMAIL_PASSWORD;                               // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
        $mail->Port       = 587;                                    // TCP port to connect to

        $mail->setFrom($EMAIL_FROM, $EMAIL_NAME);
        $mail->addAddress($to, $name);     // Add a recipient

        $mail->Subject = $subject;
        $mail->Body    = $content;
        // $mail->AltBody = $content;
        $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
        );
        $mail->send();
        return true;
    }
    catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
function activeteUser($code)
{
    global $db;
    $stmt = $db->prepare("SELECT * FROM users WHERE code=? and status=?");
    $stmt->execute(array($code,0));
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if($user && $user['code']==$code)
    {
        $stmt=$db->prepare("UPDATE users SET code=?,status=? where userId=?");
        $stmt->execute(array('',1,$user['userId']));
        return true;
    }
    return false;
}


function sendFriendRequest($userId1, $userId2)
{
    global $db;
    $stmt = $db->prepare("INSERT INTO friendships (userId1, userId2) VALUES (?, ?)");
    $stmt->execute(array($userId1, $userId2));
}
function getFriendship($userId1, $userId2)
{
    global $db;
    $stmt = $db->prepare("SELECT * FROM friendships WHERE userId1 = ? AND userId2 = ?");
    $stmt->execute(array($userId1, $userId2));
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
function removeFriendRequest($userId1, $userId2)
{
    global $db;
    $stmt = $db->prepare("DELETE FROM friendships WHERE (userId1 = ? AND userId2 = ?) OR (userId2 = ? AND userId1 = ?)");
    $stmt->execute(array($userId1, $userId2, $userId1, $userId2));
}

function searchName($displayName){
    global $db;
    $stmt=$db->prepare("SELECT userId, displayName from users where displayName like '%$displayName'");
    $stmt->execute(array($displayName));
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function resizeImage($fileName, $maxWidth, $maxHeight)
    {
        list($originWidth, $originHeight) = getimagesize($fileName);

        $Width = $originWidth;
        $Height = $originHeight;

        if ($Height > $maxHeight)
        {
            $Width = ($maxHeight / $Height) * $Width;
            $Heght = $maxHeight;
        }
        if ($Width > $maxWidth)
        {
            $Height = ($maxWidth / $Width) * $Height;
            $Width = $maxWidth;
        }

        $image_p = imagecreatetruecolor($Width, $Height);
        $image = imagecreatefromjpeg($fileName);
        imagecopyresampled($image_p, $image, 0, 0, 0 , 0, $Width, $Height, $originWidth, $originHeight);

        return $image_p;
    }
	function forgotPasswordUser($user)
    {
        global $db, $BASE_URL;
        $code = generateRandomString(16);
        $stmt = $db->prepare("UPDATE users SET code = ? WHERE userId = ?");
        $stmt->execute(array($code, $user['userId']));
        sendEmail($user['email'], $user['displayName'], 'Thay đổi mật khẩu cho tài khoản', "Mã kích hoạt tài khoản của bạn là $code <a href=\"$BASE_URL/activatepassword.php\">$BASE_URL/activatepassword.php</a>");
        return true;
    }
    function forgotUser($code)
    {
        global $db;
        $stmt = $db->prepare("SELECT * FROM users WHERE code = ? AND status = ?");
        $stmt->execute(array($code, 1));
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user && $user['code'] = $code && $user['status'] == 1)
        {
            $hashPassword = password_hash($user['email'], PASSWORD_DEFAULT);
            $stmt = $db->prepare("UPDATE users SET code = ?, password = ? WHERE userId = ?");
            $stmt->execute(array('', $hashPassword, $user['userId']));
            return true;
        }
        return false;
    }
    function activateUser($code)
    {
        global $db;
        $stmt = $db->prepare("SELECT * FROM users WHERE code = ? AND status = ?");
        $stmt->execute(array($code, 0));
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user && $user['code'] = $code)
        {
            $stmt = $db->prepare("UPDATE users SET code = ?, status = ? WHERE id = ?");
            $stmt->execute(array('', 1, $user['id']));
            return true;
        }
        return false;
    }

    function getNewComments($post_id)
    {
        global $db;
        $stmt = $db->prepare("SELECT c.*, u.displayName FROM comments c JOIN users u on c.commentAuthorId = u.userId where postId = ?");
        $stmt->execute(array($post_id));
        $comments= $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $comments;
    }

    function getNewFeeds_id($user_ID) {
    
        global $db;
        $stmt = $db->prepare("SELECT p.*, u.displayName  FROM post p JOIN friendships s ON p.userId = s.userId2 Join users u on u.userId = s.userId2  WHERE s.userId1 = ? ");
        $stmt->execute(array($user_ID));
        $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $posts;
    }
    
    function getNewFeeds() {
    
        global $db;
        $stmt = $db->prepare("SELECT p.*, u.displayName FROM post p JOIN users u ON u.userId = p.userId ORDER BY p.createAt DESC");
        $stmt->execute();
        $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $posts;
    }
    
    function getNewFeeds_User($user_id)
    {
        global $db;
        $stmt = $db->prepare("SELECT * FROM post where userId = ?");
        $stmt->execute(array($user_id));
        $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $posts;
    }

    function get_post_ID($id,$user_ID)
    {
        global $db;
        $stmt = $db->prepare("SELECT * FROM post where postId = ? and userId = ?");
        $stmt->execute(array($id,$user_ID));
        $posts = $stmt->fetch(PDO::FETCH_ASSOC);
        return $posts;
    }

    function createComment($postId, $userId, $content)
{
    global $db;
    $stmt = $db->prepare("INSERT INTO comments (postId, commentAuthorId, commentContent) VALUES (?, ?, ?)");
    $stmt->execute(array($postId, $userId, $content));
    return $db->lastInsertId();
}

function sendLike($userId1, $postId)
    {
    global $db;
    $stmt = $db->prepare("INSERT INTO liked (userId1, postId) VALUES (?, ?)");
    $stmt->execute(array($userId1, $postId));
    }
function getLiked($userId1, $postId)
    {
        global $db;
        $stmt = $db->prepare("SELECT * FROM liked ");
        $stmt->execute(array($userId1, $postssssId));
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
// function checkLikes($userId,$postId)
// {
//     global $db;
//     $stmt = $db->prepare("SELECT * FROM liked WHERE ? = userId AND ? = postId ");
//     $stmt->execute($userId,$postId);
//     return $stmt->fetch(PDO::FETCH_ASSOC);
// }
