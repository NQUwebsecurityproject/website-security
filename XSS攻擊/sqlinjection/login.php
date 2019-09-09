<?php
$link=mysqli_connect("localhost","root","guest","questionnaire_bar");
mysqli_query($link,"set names utf8");
session_start();
$acc = $_REQUEST["account"];
$pwd = $_REQUEST["passwd"];
$rem = $_REQUEST["rem"];
if(! get_magic_quotes_gpc() ) {
        $acc = addslashes ($acc);
        $pwd = addslashes ($pwd);
}
if ($acc == "" | $acc == null) {
    ?><script>alert("賬密不可爲空！！");</script><?php
    ?><script>window.location.reload();</script><?php
}else {
    $chk = mysqli_query($link, "SELECT `passwd` FROM `account` WHERE `account` = '$acc'");
    $rs = mysqli_fetch_row($chk);
    if ($rs[0] == "" | $rs[0] == null) {//比對賬號
        ?><script>alert("該賬號未注冊！！");
        window.location.replace("index.php");</script><?php
    }
    else if ($pwd == $rs[0]) { //比對密碼
        if (isset($_SESSION["attempt"])) {
            echo var_dump($_SESSION["attempt"][0]);
            for ($i=0; $i<count($_SESSION["attempt"]);$i++) {
                if ($_SESSION["attempt"][$i]['accs'] == $acc) {
                    unset($_SESSION["attempt"][$i]);
                }
            }
        }
        if ($rem) {
            $_SESSION["name"] = $acc;
            $_SESSION["passwd"] = $pwd;
        }
        echo "<span>登入成功，</span><a href='logout.php'><button id='logout'>登出</button></a>";
    }
    else if ($pwd == "" | $pwd == null) {
        ?><script>alert("密碼不可爲空！！");
        window.location.replace("index.php");</script><?php
    }/* else if () {
        ?><script>window.location.replace("login.html");</script><?php
    }*/
    else {
        if (!isset($_SESSION["attempt"])) {
            $_SESSION["attempt"] = [
                0 => [
                    'accs' => $acc,
                    'freq' => 1,
                    'date' => date("Y-m-d"),
                    'hour' => date("H"),
                    'mins' => date("i"),
                ],
            ]
            ?><script>alert("密碼錯誤，<?php echo '還剩'.(5-$_SESSION['attempt'][0]['freq']).'次嘗試機會。'; ?>");
            window.location.replace("index.php");</script><?php
        }else {
            $ifexit=0;
            foreach ($_SESSION["attempt"] as $num => $info) {
                $i=0;
                if ($info["accs"]==$acc) {
                    $ifexit=1;
                    if ($info['freq']<4) {
                        $_SESSION['attempt'][$num]['freq'] += 1;
                        $_SESSION['attempt'][$num]['date'] = date("Y-m-d");
                        $_SESSION['attempt'][$num]['hour'] = date("H");
                        $_SESSION['attempt'][$num]['mins'] = date("i");
                        ?><script>alert("密碼錯誤，<?php echo $info['accs'].'還剩'.(5-$_SESSION['attempt'][$num]['freq']).'次嘗試機會。'; ?>");
                        window.location.replace("index.php");</script><?php
                    }
                    else if ($info['freq']==4) {
                        $_SESSION['attempt'][$num]['freq'] += 1;
                        // echo "在這".$info['freq'];
                        ?><script>alert("密碼錯誤！賬號<?php echo $info['accs']; ?>嘗試登入太多次了，請等<?php echo (2-((int)date('i')-(int)$info['mins'])); ?>分鐘再來!");
                        window.location.replace("index.php");</script><?php
                    }else {
                        if ($info['date']==date("Y-m-d") && $info['hour']==date("H")) {
                            if ( ((int)date("i")-(int)$info['mins'])<2 ) {
                                // echo "在這".$info['freq'];
                                ?><script>alert("賬號<?php echo $info['accs']; ?>嘗試登入太多次了，請等<?php echo (2-((int)date('i')-(int)$info['mins'])); ?>分鐘再來!");
                                window.location.replace("index.php");</script><?php
                            }else {
                                $_SESSION['attempt'][$num]['freq'] -= 2;
                                if ($pwd == $rs[0]) {
                                    unset($_SESSION["attempt"][$i]);
                                    if ($rem) {
                                        $_SESSION["name"] = $acc;
                                        $_SESSION["passwd"] = $pwd;
                                    }
                                    echo "<span>登入成功，</span><a href='logout.php'><button id='logout'>登出</button></a>";
                                }else {
                                    ?><script>alert("密碼錯誤，<?php echo $info['accs'].'還剩'.(5-$_SESSION['attempt'][$num]['freq']).'次嘗試機會。'; ?>");
                                    window.location.replace("index.php");</script><?php
                                }
                            }
                        }
                    }
                }
                $i++;
            }
            if (!$ifexit) {
                array_push($_SESSION["attempt"], [
                    'accs' => $acc,
                    'freq' => 1,
                    'date' => date("Y-m-d"),
                    'hour' => date("H"),
                    'mins' => date("i"),
                ])
                ?><script>alert("密碼錯誤，<?php echo '還剩'.(5-$_SESSION['attempt'][count($_SESSION['attempt'])-1]['freq']).'次嘗試機會。'; ?>");
                window.location.replace("index.php");</script><?php
            }
        }
    }
}
?>