<?php
include("config.php");
echo "<h2>Users</h2>";
$sql=$dbh->prepare("SELECT CONCAT(Firstname,' ',Lastname) AS name FROM users WHERE RelatedUserTypeID = 1");
$sql->execute();
while($r=$sql->fetch()){
 echo "<div class='user'>{$r['name']}</div>";
}
?>
