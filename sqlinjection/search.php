<?php
$link=mysqli_connect("localhost","root","guest","questionnaire_bar");
mysqli_query($link,"set names utf8");
$search = $_REQUEST["search"];
$chksum = $_REQUEST["chksum"];
if ($chksum) {
    $chk = mysqli_query($link, "SELECT * FROM `questionnaire` WHERE `u_id` = '$search'");
}else {
    $chk = mysqli_query($link, "SELECT * FROM `questionnaire` WHERE `title` LIKE '%$search%'");
}
$cnt = $chk->num_rows;
echo $cnt."個搜尋結果。";
if ($cnt) {
    for ($i=0;$i<$cnt;$i++) {
        $rs=mysqli_fetch_row($chk);
        $id = $rs[0];
        $title = $rs[2];
        $detail = $rs[3];
        echo "<div class='quest' value='".$id."'><span class='title'>".$title."</span><p>".$detail."</p><button onclick='quest(".$id.")'>開始填寫>></button><div class='clear'></div></div>";
    }
}
?>