<?php
$link=mysqli_connect("localhost","root","guest","questionnaire_bar");
mysqli_query($link,"set names utf8");
$qnum = $_REQUEST["q"]; //有幾個問題
$quest = $_REQUEST["quest"]; //問卷編號
$ans = [];
echo "<div><span class='title'>你的答案：<span></br>";
for ($i=0;$i<$qnum;$i++) {
    $x = "ans".$i;
    $ans[$i] = $_REQUEST[$x];
    mysqli_query($link, "INSERT INTO `u_ans`(`quest_id`, `Q_id`, `ans`) VALUES ($quest, $i, '$ans[$i]')");
    echo "第".($i+1)."題：".$ans[$i]."</br>";
}
echo "<div>";
?>