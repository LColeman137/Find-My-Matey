<?php
include "database.php";
$error;
if (isset($_POST['email']) && isset($_POST['password'])) {
  $email = $_POST['email'];
  $password = $_POST['password'];

  $checkEmail = mysqli_query($conn, "SELECT email, username from user WHERE email = '$email'");
  $array = mysqli_fetch_assoc($checkEmail);
  $username = $array["username"];
  $hash = mysqli_fetch_assoc(mysqli_query($conn, "SELECT password FROM `user` WHERE email = '$email'"));

  if ($checkEmail) {
    if (password_verify($password, $hash['password'])) {
      $_SESSION["isLoggedIn"] = true;
      $_SESSION["username"] = $username;
      header("Location: index.php");
      exit();
    } else {
      $error = "Incorrect Password.";
    }
  } else {
    $error = "Username does not exist.";
  }
}
?>
<!DOCTYPE html>
<html>
<?php include 'header.php'; ?>
<div class=container1>
  <div class=logo>Find My Matey</div>
  <p id=tagline>The real booty was the love we found along the way</p>
  <div class=justBG>
    
      <form class=loginBox method="post">
        <div class=loginLine>
          <label for="email"><b>Email</b></label>
          <input class="loginField" type="text" placeholder="Enter Email" name="email" required>
        </div>
        <div class=loginLine>
          <label for="password"><b>Password</b></label>
          <input class="loginField" type="password" placeholder="Enter Password" name="password" required>
        </div>
        <div class=loginButtonLine>
          <a id="registerButton" href="./register.php">Join the crew</a>
          <button id="loginButton" type="submit">Come aboard</button>
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
  </body>

</html>