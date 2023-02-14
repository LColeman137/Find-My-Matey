<?php include 'database.php';
if (!isset($_SESSION["isLoggedIn"])) {
    header("Location: login.php");
}
$username = $_GET["user"];
?>
<!DOCTYPE html lang="en">
<html>
<?php include "header.php" ?>
<div id="container">
    <div id="navbar">
        <div class="logo2">Find My Matey</div>
        <div id="logos">
            <?php echo "You are logged in as $user[first_name]"; ?>
            <a href="index.php"><img class=navButtons src="./assets/001-home.png"></a>
            <a href=""><img class=navButtons src="./assets/002-users.png"></a>
            <a href=""><img class=navButtons src="./assets/003-message.png"></a>
            <a href=""><img class=navButtons src="./assets/006-notification.png"></a>
            <a href=""><img class=navButtons src="./assets/004-settings.png"></a>
            <a href="logOut.php"><img class=navButtons src="./assets/005-sign-out.png"></a>
        </div>
    </div>
    <div id="innercontainer">
        <div id="sidebar">
            <?php
            $user = ($conn->query("SELECT avatar, first_name, last_name, COUNT(post_id) AS posts " .
                "FROM post JOIN user ON post.username = user.username WHERE user.username = '$username'" .
                "GROUP BY user.username"))->fetch_assoc();
            if (is_null($user)) { //if user has no posts
                $user = ($conn->query("SELECT * FROM user WHERE username = '$username'"))->fetch_assoc();
            }
            //query the friends (if any)
            $friendStmt = $conn->query("SELECT DISTINCT friend FROM friend JOIN user ON friend.username = '$username'");
            $friendResult = $friendStmt->fetch_all();
            $userStmt = $conn->query("SELECT user.username, COUNT(post_id) FROM post JOIN user " .
                "ON post.username = '$username'");
            //query the user's likes
            $userLikes = ($conn->query("SELECT COUNT(*) AS likes FROM `like` JOIN `user` ON like.username = user.username " .
                "JOIN `post` ON post.post_id = like.post_id WHERE post.username = '$username'"))->fetch_assoc();
            echo "<img class=profileAvatar src=$user[avatar] alt=profile_pic>"; //avatar
            echo "<div class=profileUser>$user[first_name] "; //first_name
            echo "$user[last_name] </div>"; //last_name
            echo "<div class=userInfo>";
            echo isset($user["posts"]) ? " Posts: $user[posts] <br>" : "Posts: 0 <br>"; //number of posts
            echo isset($userLikes["likes"]) ? " Likes:  $userLikes[likes] <br>" : " Likes: 0 <br>"; //likes
            echo isset($friendResult) ? " Friends:  " . count($friendResult) : " Likes: 0"; //friends
            echo "</div>";
            ?>
        </div>
        <div id="feed">
            <?php
            $profileQuery = "SELECT first_name, last_name, avatar, post_id, text, time, post.username FROM " .
                "post JOIN user ON post.username = user.username WHERE user.username = '$username' ORDER BY post.post_id DESC";
            //first_name, last_name, avatar, post_id, text, time, likes
            $profileResult = ($conn->query($profileQuery))->fetch_all();
            foreach ($profileResult as $profilePost) {
                echo "<div class=post>";
                echo "<div class=postTop ><div class=postAuthor ><img class=postAvatar src=$profilePost[2]>"; //avatar
                //first_name, last_name, text, time, likes
                echo "<a class=postUser href =profile.php?user=" . $profilePost[6] . "> $profilePost[0] $profilePost[1] </a></div>
                    <div class=postTime>" . convertTime($profilePost[5]) . "</div></div>";
                echo "<div class=postText>";
                echo $profilePost[4];
                echo "</div>";

                //display the comments(if any)
                if (isset($commentResult)) {
                    foreach ($commentResult as $comment) {
                        if ($profilePost[3] == $comment[0]) {
                            echo "<div class=comment><div><div class=commentUser>$comment[3] $comment[4]:</div>" .
                                " $comment[1] </div><div class=commentTime>" . convertTime($comment[2]) . "</div></div>";
                        }
                    }
                    //link to show/hide comment form
                    echo "<div class=postActions><div class=commentStuff>";
                    echo "<a href=# onclick=toggleForm($profilePost[3]);return false id=$profilePost[3]Btn>Comment</a>";
                    echo "<form action=post.php method=post id=$profilePost[3] hidden=true>";
                    echo "<textarea name=comment required=true></textarea>";
                    echo "<input type=submit value=comment name=commentSubmit><input type=hidden name=postId " .
                        "value=$profilePost[3]></form><form action=post.php method=post hidden=true></div>";
                    echo "<div class=likeStuff>";
                    $liked = false;
                    foreach ($postLikes as $likes) {
                        if ($profilePost[3] == $likes[0]) {
                            $liked = true;
                            break;
                        }
                    }
                    if (!$liked) { //show like button if post not liked by user
                        echo "<input class=likeButton type=submit value=Like name=likeSubmit><input type=hidden name=postId " .
                            "value=$profilePost[3]>";
                    }
                }
                //query the post likes
                $postLikes = ($conn->query("SELECT COUNT(*) AS likes FROM `like` JOIN `user` ON like.username = user.username " .
                    "JOIN `post` ON post.post_id = like.post_id WHERE post.post_id = '$profilePost[3]'"))->fetch_row();
                echo " Likes: $postLikes[0] </form>";
                echo "</div></div>";
                echo "</div>";
            }
            ?>
        </div>
    </div>
</div>
</div>
</body>

</html>
