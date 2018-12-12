<?php
$link=mysqli_connect("localhost","root","guest","questionnaire_bar");
mysqli_query($link,"set names utf8");
session_start();

// mail
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Load composer's autoloader
require 'vendor/autoload.php';

$mail = new PHPMailer(true);// Passing `true` enables exceptions

//Server settings
$mail->SMTPDebug = 2;                                 // Enable verbose debug output
$mail->isSMTP();       // Set mailer to use SMTP
$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true; // Enable SMTP authentication
$mail->Username = '01lu301998@gmail.com';    // SMTP username
$mail->Password = '';    // SMTP password
$mail->SMTPSecure = 'ssl';   // Enable TLS encryption, `ssl` also accepted
$mail->Port = 465;  // TCP port to connect to
// mail

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
    else if ($pwd == "" | $pwd == null) {
        ?><script>alert("密碼不可爲空！！");
        window.location.replace("index.php");</script><?php
    }/* else if () {
        ?><script>window.location.replace("login.html");</script><?php
    }*/
    else if ($pwd != $rs[0]) {
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
                        ?><script>alert("密碼錯誤！賬號<?php echo $info['accs']; ?>嘗試登入太多次了，請等<?php echo (2-((int)date('i')-(int)$info['mins'])); ?>分鐘再來!");</script><?php
                        try {
                            //Recipients
                            $mail->setFrom('01lu301998@gmail.com', 'questionnaire');
                            $mail->addAddress('s110510501@student.nqu.edu.tw', 'blablabla');     // Add a recipient

                            //Content
                            $mail->isHTML(true);                                  // Set email format to HTML
                            $mail->Subject = 'Someone try to login your Questionnaire account for SEVERAL TIMES.';
                            $mail->Body    = 'Hello, ---   your Questionnaire account has been login for <b>SEVERAL TIMES</b>.';

                            $mail->SMTPOptions = array(
                                'ssl' => array(
                                    'verify_peer' => false,
                                    'verify_peer_name' => false,
                                    'allow_self_signed' => true
                                )
                            );
                            $mail->send();
                            echo 'Message has been sent';
                        } catch (Exception $e) {
                            echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
                        }
                        ?><script>window.location.replace("index.php");</script><?php
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
                        }else {
                            $_SESSION['attempt'][$num]['freq'] = 1;
                            $_SESSION['attempt'][$num]['date'] = date("Y-m-d");
                            $_SESSION['attempt'][$num]['hour'] = date("H");
                            $_SESSION['attempt'][$num]['mins'] = date("i");
                            ?><script>alert("密碼錯誤，<?php echo $info['accs'].'還剩'.(5-$_SESSION['attempt'][$num]['freq']).'次嘗試機會。'; ?>");
                            window.location.replace("index.php");</script><?php
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
    }else { //比對密碼
        // echo var_dump($_SESSION["attempt"]);
        if (isset($_SESSION["attempt"])) {
            for ($i=0; $i<count($_SESSION["attempt"]);$i++) {
                if ($_SESSION["attempt"][$i]['accs'] == $acc) {
                    if ($_SESSION["attempt"][$i]["freq"] <=4) {
                        unset($_SESSION["attempt"][$i]);
                        for ($j=$i+1;$j<count($_SESSION["attempt"]);$j++) {
                            $_SESSION["attempt"][$j-1]=$_SESSION["attempt"][$j];
                            unset($_SESSION["attempt"][$j]);
                        }
                    }else {
                        ?><script>alert("賬號<?php echo $_SESSION['attempt'][$i]['accs']; ?>嘗試登入太多次了，請等<?php echo (2-((int)date('i')-(int)$_SESSION['attempt'][$i]['mins'])); ?>分鐘再來!");
                        window.location.replace("index.php");</script><?php
                    }
                }
            }
        }else {
            if ($rem) {
                $_SESSION["name"] = $acc;
                $_SESSION["passwd"] = $pwd;
            }
            echo "<span>登入成功，</span><a href='logout.php'><button id='logout'>登出</button></a>";
        }
    }
}
?>