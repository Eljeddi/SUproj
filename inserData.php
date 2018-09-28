<?php
conn=mysqli_connect("localhost","root","","test")
             or exit("cant connect");
mysqli_query("INSERT INTO users (diary) VALUES'".$_POST['val']."'");
?>