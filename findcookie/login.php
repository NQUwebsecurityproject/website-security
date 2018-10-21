<?php
$link=mysqli_connect("localhost","root","guest","account");
mysqli_query($link,"set names utf8");
$acc = $_REQUEST["account"];
$pwd = $_REQUEST["passwd"];
$rem = $_REQUEST["rem"];
if ($acc == "" | $acc == null) {
    ?><script>alert("賬號不可爲空！！");</script><?php
    ?><script>window.location.reload();</script><?php
}else {
    $chk = mysqli_query($link, "SELECT `passwd` FROM `account` WHERE `account` = '$acc'");
    $rs=mysqli_fetch_row($chk);
    if ($rs[0] == "" | $rs[0] == null) {//比對賬號
        ?><script>alert("該賬號未注冊！！");</script><?php
    }
    else if ($pwd == $rs[0]) { //比對密碼
        echo "<span>登入成功，</span><a href='index.html' onclick='logout()'><button>登出</button></a>";
        if ($rem) {
            setcookie("name", $acc);
            setcookie("passwd", $pwd);
        }
    }
    else if ($pwd == "" | $pwd == null) {
        ?><script>alert("密碼不可爲空！！");</script><?php
    }/* else if () {
        ?><script>window.location.replace("login.html");</script><?php
    }*/
    else {
        ?><script>alert("密碼錯誤");
        window.location.replace("index.html");</script><?php
        
    }
}
?>