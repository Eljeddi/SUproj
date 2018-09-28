<?php

session_start();

if(array_key_exists("id",$_COOKIE)){
    
    $_SESSION["id"]=$_COOKIE["id"];
}

if(array_key_exists("id",$_SESSION)){
    echo  "<p>logged in! <a href='loginsys.php?logout=1'>logout</a></p>";
}
else
    header("Location:loginsys.php");
 
?>
