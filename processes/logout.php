<?php

 session_start();
 $_SESSION['userID'];
 session_unset();
 session_destroy();

 header("location:../index.php");
?>