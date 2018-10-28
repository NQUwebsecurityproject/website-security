<?php
$link=mysqli_connect("localhost","root","guest","questionnaire_bar");
mysqli_query($link,"set names utf8");
$id = $_REQUEST["id"];
$chk = mysqli_query($link, "SELECT * FROM `quest_q` WHERE `quest_id` = '$id'");
$cnt = $chk->num_rows;
for ($i=0;$i<$cnt;$i++) {
    $rs = mysqli_fetch_row($chk);
    $qid = $rs[0];
    $quest = $rs[2];
    echo "<div class='que'><span class='q'>".($qid+1).".$quest</span><div class='option'>";
    $chk1 = mysqli_query($link, "SELECT * FROM `q_a` WHERE `Q_id` = '$qid'");
    $cnt1 = $chk1->num_rows;
    for ($j=0;$j<$cnt1;$j++) {
        $rs1 = mysqli_fetch_row($chk1);
        $aid = $rs1[2];
        $type = $rs1[3];
        $value = $rs1[4];
        $detail = $rs1[5];
        if ($type == "text") {
            echo "<input class='$type' type='$type' id='$qid' name='$qid'>";
        }
        else if ($type == "radio" || $type == "checkbox") {
            echo "<input class='$type' type='$type' id='$aid' name='$qid' value='$value'>$detail";
        }
    }
    echo "</div></div>";
}
echo "<button id='submit' onclick='ans($id,$cnt)'>提交</button>";
?>