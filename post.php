<?php
/**
 * Uses the pirate.monkeyness API to translate  English into pirate speak.
 * @param mixed $words the string to be translated
 * @return mixed the parameter translated into pirate speak
 */
function pirateSpeak($words){
    //curl used with the pirate.monkeyness API to translate each post
    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => "https://pirate.monkeyness.com/api/translate?english=" . $words,
        CURLOPT_RETURNTRANSFER => true,//returns the transfer as a string of return value curl_exec()
        CURLOPT_FOLLOWLOCATION => true,//follow location header
        CURLOPT_ENCODING => "",
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);
    //if no error, assign translated string to return value
    if (!$err) {
        $words = $response;
    }

    return $words;
}
include "database.php";
if (isset($_POST["submit"])) {
    unset($_POST["submit"]);
    $username = $_SESSION["username"];
    $date = date('Y-m-d H:i:s');
    $post = urlencode($_POST["post"]);//encode the post for html
    $post = pirateSpeak($post);
    $post = mysqli_real_escape_string($conn, $post);
    $conn->query("INSERT INTO `post` VALUES " . "(NULL, '$username', '$post', '$date')");
    header("Location: index.php");
}
if(isset($_POST["commentSubmit"])){
    unset($_POST["commentSubmit"]);
    $username = $_SESSION["username"];
    $date = date('Y-m-d H:i:s');
    $postId = $_POST["postId"];
    $text = urlencode($_POST["comment"]);//encode the post for html
    $text = pirateSpeak($text);
    $text = mysqli_real_escape_string($conn, $text);

    echo $postId;
    $conn->query("INSERT INTO `comment` VALUES " . "(NULL, '$postId', '$text', '$username', '$date')");
    header("Location: index.php");
}   
if(isset($_POST["likeSubmit"])){
    $username = $_SESSION["username"];
    $postId = $_POST["postId"];
    $conn->query("INSERT INTO `like` VALUES " . "('$postId', '$username')");
    header("Location: index.php");
}  
?>
