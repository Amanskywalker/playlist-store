<?php
  require_once 'dbconnect.php';
  require_once 'home.php';
  $dbcon=mysql_select_db($userRow[userName]);

$error=false;
if(isset($_POST['create']))
{
  $pname = $_POST['pname'];
  $pname= stripslashes($pname);
  $pname= mysql_real_escape_string($pname);

  if(empty($pname))
  {
    $error=true;
    $playerror="please enter some name for the playlist";
  }

  echo "new page";
  mysql_select_db('chandresh');
  $query ="create table $pname (N0. int not null auto_increment primary key,music_name varchar(40),artist varchar(20),length varchar(20),genres varchar(20),youtube_link varchar(200))";
  $res=mysql_query($query);
}
//header("Location: choose.php");


?>

<!DOCTYPE html>
<html>
<head>
  <title>playlist
  </title>
</head>
<body>
      <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <input method="text" placeholder="playlist_name" name="pname">
        <button type="submit" name="create">create_playlist</button>
      </form>
</body>
</html>
