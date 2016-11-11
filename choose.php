<?php
require_once 'dbconnect.php';
require_once 'create_playlist.php';
echo "new page";
mysql_select_db('chandresh');
$query ="create table $pname (N0. int not null auto_increment primary key,music_name varchar(40),artist varchar(20),.
length varchar(20),genres varchar(20),youtube_link varchar(200))";
$res=mysql_query($query);
 ?>
