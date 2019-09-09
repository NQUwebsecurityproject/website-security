<?php
$link=mysqli_connect("localhost","root","guest","database");
mysqli_query($link,"set names utf8");
$acc = $_REQUEST["account"];
$pwd = $_REQUEST["passwd"];
if ($acc == "" | $acc == null) {
    ?><script>alert("賬號不可爲空！！");</script><?php
    ?><script>window.location.replace("index.html");</script><?php
}
$chk = mysqli_query($link, "SELECT `passwd` FROM `user` WHERE `account` = '$acc'");
$rs=mysqli_fetch_row($chk);
if ($pwd == $rs[0]) {
    echo "登入成功";
}else if ($pwd == "" | $pwd == null) {
    ?><script>alert("密碼不可爲空！！");</script><?php
}/* else if () {
    ?><script>window.location.replace("login.html");</script><?php
}*/
else {
    ?><script>alert("密碼錯誤");
    window.location.replace("index.html");</script><?php
    
}

?>