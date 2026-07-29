<?php

session_start();
if(isset($_SESSION['ecohunt_userid'])){

    $_SESSION['ecohunt_userid'] = NULL;
    unset($_SESSION['ecohunt_userid']);
}
header ("Location: login.php");
die;