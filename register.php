<?php
  include "database.php"; 
  $error = "";
  if (isset($_POST['registerBtn'])) {
    unset($_POST["registerBtn"]);

    $username = trim($_POST['username']);
    $fname = trim($_POST['fname']);
    $lname = trim($_POST['lname']);
    $email = trim($_POST['email']);
    $emailRetype = trim($_POST['email-retype']);
    $password = trim($_POST['password']);
    $passwordRetype = trim($_POST['password-retype']);
    $avatar = $_POST['avatar'];

    if (strlen($username) >= 2 && strlen($username) <= 50 && strlen($fname) >= 2 && strlen($fname) <= 50 && strlen($lname) >= 2 && strlen($lname) <= 50) {
      $checkUsername = mysqli_query($conn, "SELECT `username` FROM user WHERE `username`='$username'");

      if (!mysqli_num_rows($checkUsername) > 0 || $checkUsername == NULL) {
        if ($email == $emailRetype) {
          if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $checkEmail = mysqli_query($conn, "SELECT `email` FROM user WHERE `email`='$email'");

            if (!mysqli_num_rows($checkEmail) > 0 || $checkEmail == NULL) {
              if ($password == $passwordRetype) {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $sql = "INSERT INTO user (username, first_name, last_name, email, password, avatar) VALUES ('$username', '$fname', '$lname', '$email', '$hashedPassword', '$avatar')";
                $result = mysqli_query($conn, $sql);
                header("Location: index.php");
                exit();
              } else {
                $error = "Passwords do not match.";
              }
            } else {
              $error = "An account already exists for this email. Please use a different email address to create a new account.";
            }
          } else {
            $error = "Invalid email format.";
          }
        } else {
          $error = "Emails do not match.";
        }
      } else {
        $error = "Username is already taken.";
      }
    } else {
      $error = "First Name, Last Name, and Username each must be at least 2 characters, but no more than 50 characters long.";
    }
  }
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" />
  <title>Register For Find My Matey</title>
  <link rel="stylesheet" href="style.css" type="text/css" />
  <script src="scripts.js"></script>
</head>

<body>
  <!-- css wave background -->
  <div class="ocean">
    <div class="wave"></div>
    <div class="wave"></div>
  </div>
  <div class=container1>
    <div class=logo>Join The Crew</div>
    <div class=justBG2>
        <form class=registerBox method="post">
          <div class=registerLine>
            <label for="username"><b>Username</b></label>
            <input class="loginField" type="text" name="username" required>
          </div>
          
          <div class=registerLine>
            <label for="fname"><b>First Name</b></label>
            <input class="loginField" type="text" name="fname" required>
          </div>
          
          <div class=registerLine>
            <label for="lname"><b>Last Name</b></label>
            <input class="loginField" type="text" name="lname" required>
          </div>
          
          <div class=registerLine>
            <label for="email"><b>Email</b></label>
            <input class="loginField" type="text" name="email" required>
          </div>
          
          <div class=registerLine>
            <label for="emailRetype"><b>Re-Type Email</b></label>
            <input class="loginField" type="text" name="email-retype" required>
          </div>
          
          <div class=registerLine>
            <label for="password"><b>Password</b></label>
            <input class="loginField" type="password" name="password" required>
          </div>
          
          <div class=registerLine>
            <label for="passwordRetype"><b>Re-Type Password</b></label>
            <input class="loginField" type="password" name="password-retype" required>
          </div>
          
          <div class=registerLine>
            <label for="avatar"><b>Choose Avatar</b></label>
            <input class="loginField" type="radio" name="avatar" value="assets/icon1.jpg" required><img src="assets/icon1.jpg" alt="icon 1" class="postAvatar">
            <input class="loginField" type="radio" name="avatar" value="assets/icon2.jpg" required><img src="assets/icon2.jpg" alt="icon 2" class="postAvatar">
            <input class="loginField" type="radio" name="avatar" value="assets/icon3.jpg" required><img src="assets/icon3.jpg" alt="icon 3" class="postAvatar">
            <input class="loginField" type="radio" name="avatar" value="assets/icon4.jpg" required><img src="assets/icon4.jpg" alt="icon 4" class="postAvatar">
          </div>
          
          <div class=loginButtonLine>
            <a id="registerButton" href="./login.php">Back</a>
            <button id="loginButton" type="submit" name="registerBtn">Come aboard</button>
          </div>
        </form>
    </div>
    <div class="error">
    <?php
    if (isset($error)) {
      echo $error;
    }
    ?>
  </div>    
  </div>
</body>
</html>
