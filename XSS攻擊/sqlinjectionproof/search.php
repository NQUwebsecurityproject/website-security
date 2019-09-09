<?php
$link=mysqli_connect("localhost","root","guest","questionnaire_bar");
mysqli_query($link,"set names utf8");
$search = $_REQUEST["search"];
if(! get_magic_quotes_gpc() ) {
        $search = addslashes ($search);
}
$chk = mysqli_query($link, "SELECT * FROM `questionnaire` WHERE `title` LIKE '%$search%'");
$cnt = $chk->num_rows;
if ($cnt) {
    for ($i=0;$i<$cnt;$i++) {
        $rs=mysqli_fetch_row($chk);
        $id = $rs[0];
        $title = $rs[1];
        $detail = $rs[2];
        echo "<div class='quest' value='".$id."'><span class='title'>".$title."</span><p>".$detail."</p><button>開始填寫>></button><div class='clear'></div></div>";
    }
}else {
    echo "0個搜尋結果。";
}
?>