<?php
include_once 'included.php';
echo "<br/>Уничтожаем: " . session_destroy() . "<p>";

var_dump($_SESSION);
echo "<p>";
var_dump($_COOKIE);
echo "<p>";

 ?>
 <br/>
<a href="test.php">test.php</a><br/>
<br/>
<a href="test3.php">test3.php</a><br/>