<?php
session_start();
$HOST = "localhost";
$USERNAME = "INFX371";
$PASSWORD = "P*ssword";
$DB_NAME = "find_my_matey";
$conn = new mysqli($HOST, $USERNAME, $PASSWORD, $DB_NAME);

//query once session starts
if (isset($_SESSION["username"])) {
    $username = $_SESSION["username"];
    //query the user's info
    $user = ($conn->query("SELECT avatar, first_name, last_name, COUNT(post_id) AS posts, user.username ".
    "FROM post JOIN user ON post.username = user.username WHERE user.username = '$username'".
    "GROUP BY user.username"))->fetch_assoc();
    if(is_null($user)){//if user has no posts
        $user = ($conn->query("SELECT * FROM user WHERE username = '$username'"))->fetch_assoc();
    }
    //query the friends (if any)
    $friendStmt = $conn->query("SELECT DISTINCT friend FROM friend JOIN user ON friend.username = '$username'");
    $friendResult = $friendStmt->fetch_all();
    $userStmt = $conn->query("SELECT user.username, COUNT(post_id) FROM post JOIN user ".
    "ON post.username = '$username'");
    //query the user's posts
    $profileQuery = "SELECT first_name, last_name, avatar, post_id, text, time, post.username FROM " .
    "post JOIN user ON post.username = user.username WHERE user.username = '$username'";
    //if user has friends, query them
    if ($friendResult != NULL) {
        foreach ($friendResult as $friend) {
            $profileQuery .= " OR user.username = '$friend[0]'";
        }
    }
    //first_name, last_name, avatar, post_id, text, time, likes
    $profileResult = ($conn->query($profileQuery . "ORDER BY post.post_id DESC"))->fetch_all();
    //query the user's likes
    $userLikes = ($conn->query("SELECT COUNT(*) AS likes FROM `like` JOIN `user` ON like.username = user.username ".
    "JOIN `post` ON post.post_id = like.post_id WHERE post.username = '$username'"))->fetch_assoc();
    //query the post likes
    $postLikes = ($conn->query("SELECT like.username, post_id FROM `like` JOIN `user` ON like.username = user.username ".
        "WHERE user.username = '$username'"))->fetch_all();
}
//query the comments
$commentResult = ($conn->query("SELECT post_id, text, time, first_name, last_name, comment.username FROM `comment` JOIN `user` " .
"ON user.username = comment.username;"))->fetch_all();

/**
 * Summary of convertTime
 * @param mixed $dateTime
 * @return string the number of days or hours since a comment was posted 
 * 
 */
function convertTime($dateTime)
{
    $now = strtotime(date('Y-m-d H:i:s'));
    $dateTime = strtotime($dateTime);   
    $postTime = "Just Now ";
    if($now - $dateTime > 3600){
        $postTime = floor(($now - $dateTime) / 3600) . " hours since post";
    }
    if($now - $dateTime > 86400){
        $postTime = floor(($now - $dateTime) / 86400) . " days since post";
    }

    return "$postTime";
}
?>