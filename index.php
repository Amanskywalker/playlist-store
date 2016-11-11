<?php
 ob_start();
 session_start();
 require_once 'dbconnect.php';

 // it will never let you open index(login) page if session is set
 if ( isset($_SESSION['user'])!="" ) {
  header("Location: home.php");
  exit;
 }

 $error = false;

 if( isset($_POST['btn-login']) ) {

  // prevent sql injections/ clear user invalid inputs
  $email = trim($_POST['email']);
  $email = strip_tags($email);
  $email = htmlspecialchars($email);

  $pass = trim($_POST['pass']);
  $pass = strip_tags($pass);
  $pass = htmlspecialchars($pass);
  // prevent sql injections / clear user invalid inputs

  if(empty($email)){
   $error = true;
   $emailError = "Please enter your email address.";
  } else if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
   $error = true;
   $emailError = "Please enter valid email address.";
  }

  if(empty($pass)){
   $error = true;
   $passError = "Please enter your password.";
  }

  // if there's no error, continue to login
  if (!$error) {

   $password = hash('sha256', $pass); // password hashing using SHA256

   $res=mysql_query("SELECT userId, userName, userPass FROM users WHERE userEmail='$email'");
   $row=mysql_fetch_array($res);
   $count = mysql_num_rows($res); // if uname/pass correct it returns must be 1 row

   if( $count == 1 && $row['userPass']==$password ) {
    $_SESSION['user'] = $row['userId'];
    header("Location: home.php");
   } else {
    $errMSG = "Incorrect Credentials, Try again...";
   }

  }

 }
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href = "style.css" rel="stylesheet" type="text/css" />
<link href="assets/css/bootstrap.min.css" rel ="stylesheet" type="text/css">
<title>Login Registration System</title>
</head>
<body id ="bg">
<link href = "style.css" rel="stylesheet" type="text/css" />

<div id ="input">
    <form method="post" action=" " autocomplete="off">

            <?php
   if ( isset($errMSG) ) {

    ?>

   <?php echo $errMSG; ?>

                <?php
   }
   ?>

  <div class="input-group">
  <span class="input-group-addon" id="basic-addon1"><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span></span>

             <input type="email" name="email" class="form-control" placeholder="Your Email" value="<?php echo $email; ?>"
             maxlength="40" aria-describedby="basic-addon1" />
</div>
                <span class="text-danger"><?php echo $emailError; ?></span>


    <div class="input-group">
    <span class="input-group-addon" id="basic-addon1"> <span class="glyphicon glyphicon-lock" aria-hidden="true"></span></span>

             <input type="password" name="pass" class="form-control" placeholder="Your Password" maxlength="15" />
    </div>
                <span class="text-danger"><?php echo $passError; ?></span>

             <div class="input-group">
               <button type="submit" class="btn btn-block btn-primary" name="btn-login">Sign In</button>
             </div>



             <a id="register" href="register.php">Sign Up Here...</a>

    </form>

  </div>

<!--toggle images-->
<div id="images-toggle">
<img id="myButton" src="1.png" />
        <script type="text/javascript">
            var images = ['1.png', '2.png', '3.png','4.png'],
                i = 1;

            // preload
            for (var j=images.length; j--;) {
                var img = new Image();
                img.src = images[j];
            }

            // event handler
            document.getElementById('myButton').addEventListener('click', function() {
                this.src = images[i >= images.length - 1 ? i = 0 : ++i];
            }, false);
        </script>
</div>
</body>
</html>
<?php ob_end_flush(); ?>
