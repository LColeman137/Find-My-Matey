<?php include 'database.php';
if (!isset($_SESSION["isLoggedIn"])) {
        header("Location: login.php");
    }
//When the session starts, we create $SESSION["username"] to query the user info
?>
<!DOCTYPE html lang="en">
<html>
<?php include "header.php" ?>

<div id="container">
    <div id="navbar">
        <div class="logo2">Find My Matey</div>
        <div id="logos">
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
                echo "<img class=profileAvatar src=$user[avatar] alt=profile_pic>"; //avatar
                echo "<a class=profileUser href=profile.php?user=" . $user["username"] . ">$user[first_name] "; //first_name
                echo "$user[last_name] </a>"; //last_name
                echo "<div class=userInfo>";
                echo isset($user["posts"]) ? " Posts: $user[posts] <br>" : "Posts: 0 <br>"; //number of posts
                echo isset($userLikes["likes"]) ? " Likes:  $userLikes[likes] <br>" : " Likes: 0 <br>"; //likes
                echo isset($friendResult) ? " Friends:  ". count($friendResult) : " Likes: 0"; //friends
                echo "</div>";
                ?>
            </div>
            <div id="feed">
            <div class=newPost>
                <form action="post.php" method="post">
                    <textarea id=newPostBox placeholder="Make a post here!" name="post" required="true"></textarea>
                    <input type="submit" value="post" name="submit">
                </form>
            </div>
                <?php
                //display the posts of user and friends
                foreach ($profileResult as $profilePost) {
                    echo "<div class=post>";
                    echo "<div class=postTop ><div class=postAuthor><img class=postAvatar src=$profilePost[2]>";//avatar
                    //first_name, last_name, text, time, likes
                    echo "<a class=postUser href =profile.php?user=" . $profilePost[6] . "> $profilePost[0] $profilePost[1]</a></div>
                        <div class=postTime> " . convertTime($profilePost[5]) . "
                        </div></div>" ;
                    echo "<div class=postText>";
                    echo $profilePost[4];
                    echo "</div>";

                    //display the comments(if any)
                    if (isset($commentResult)) {
                        foreach ($commentResult as $comment) {
                            if ($profilePost[3] == $comment[0]) {
                                echo "<div class=comment><div><a href=profile.php?user=" . $comment[5] . " class=commentUser>$comment[3] $comment[4]:</a>".
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
                        foreach($postLikes as $likes){
                            if($profilePost[3] == $likes[1]){
                                $liked = true;
                                break;
                            }
                        }
                        if(!$liked){//show like button if post not liked by user
                            echo "<input class=likeButton type=submit value=Like name=likeSubmit><input type=hidden name=postId " .
                            "value=$profilePost[3]>";
                        }
                            //query the post likes
                            $likes = ($conn->query("SELECT COUNT(*) AS likes FROM `like` JOIN `user` ON like.username = user.username " .
                            "JOIN `post` ON post.post_id = like.post_id WHERE post.post_id = '$profilePost[3]'"))->fetch_row();
                        echo " Likes: $likes[0] </form>";
                        echo "</div></div>";
                    }
                    echo "</div>";
                }
                ?>
            </div>
        </div>
    </div>
</div>
</body>

</html>
