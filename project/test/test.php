<?php 
include_once 'included.php';
$_SESSION['x'] = 12;

echo "on test: x=" . $_SESSION['x'] . "<p>";
var_dump($_SESSION);
echo "<p>";
var_dump($_COOKIE);
echo "<p>";


?>
<br/>
<a href="test3.php">test3.php</a><br/>
<a href="kill_session.php">kill_session.php</a>