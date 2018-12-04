<?php
$link=mysqli_connect("localhost","root","guest","questionnaire_bar");
mysqli_query($link,"set names utf8");
$chk = mysqli_query($link, "SELECT MAX(`ans_id`) FROM `u_ans` WHERE `quest_id` = 0 ");
$cnt = $chk->num_rows;
if ($cnt) {
    $id = mysqli_fetch_row($chk);
    $aid = $id[0]+1;
}
else {
    $aid = 0;
}
$qnum = $_REQUEST["q"]; //有幾個問題
$quest = $_REQUEST["quest"]; //問卷編號
$ans = [];
echo "<div><span class='title'>你的答案：<span></br>";
for ($i=0;$i<$qnum;$i++) {
    $x = "ans".$i;
    $ans[$i] = $_REQUEST[$x];
    mysqli_query($link, "INSERT INTO `u_ans`(`quest_id`, `Q_id`, `ans_id`, `ans`) VALUES ($quest, $i, $aid, '$ans[$i]')");
    echo "第".($i+1)."題：".$ans[$i]."</br>";
}
echo "<div>";
?>