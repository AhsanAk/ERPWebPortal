<?php
session_start();


if(isset($_COOKIE)){

    $cookieKey = key($_COOKIE);

$expire = time() - 60*60*24*7;
setcookie($cookieKey, '', $expire);
}

session_destroy();



header('Location: index.php');


?>
