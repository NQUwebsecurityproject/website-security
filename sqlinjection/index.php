<?php 
$link=mysqli_connect("localhost","root","guest","questionnaire_bar");
mysqli_query($link,"set names utf8");
session_start(); 
if (isset($_SESSION["name"]) && isset($_SESSION["passwd"])) {
    $name = $_SESSION['name']; $pass = $_SESSION['passwd'];
}else {
    $name = ""; $pass = "";
}?>
<html>
    <head><meta charset="utf-8">
        <title>是個需要登入的網站</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <style>
            body {
                background-color: #85F7DC;
                font-family: consolas, 微軟正黑體, "microsoft jhenghei";
                overflow: hidden;
                margin: auto 0;
            }
            .content {
                background-color: #00aa99;
                border-radius: 28px;
                min-width: 440px;
                position: absolute;
                padding: 6px 8px;
                margin: 0 10px 0 10px;
                display: none;
                float: right;
                right: 0;
                top: 14px;
            }
            .content input {
                transform: translate(0, 2px);
                font-size: 14px;
            }
            .content span {
                font-size: 14px;
                padding: 5px 0 0 0;
                margin: 5px 0 0 0;
            }
            #go {
                background-color: #00aa99;
                border-radius: 20px;
                font-family: consolas;
                font-weight: 900;
                font-size: 18px;
                cursor: pointer;
                border: 0;
                height: 40px;
                width: 40px;
            }
            #go:hover {
                background-color: #F44993;
                transform: translate(0, -2.5px);
            }
            #b {
                background-color: #00aa99;
                border-radius: 20px;
                font-family: consolas;
                font-weight: 900;
                font-size: 12px;
                margin: 0 10px 0 0;
                height: 40px;
                border: 0;
                color: lightgreen;                
                float: right;
                width: 40px;
            }
            .b {
                cursor: pointer;
            }
            .b:hover {
                background-color: #F44993;
                color: lightpink;
            }
            #login, #logout {
                background-color: #005555;
                border-radius: 12px;
                border-color: #005555 #008888 #008888 #005555;
                border: 0 1px 1px 0;
                cursor: pointer;                
                height: 24px;
                color: lightgreen;
            }
            #login:hover, #logout:hover {
                background-color: #DB367E;
                border-color: #db367e #fd69af #fd69af #db367e;
                color: lightpink;
            }
            #acc, #pwd {
                background-color: lightgray;
                font-family: consolas, 微軟正黑體, 'Microsoft jhenghei';
                font-size: 14px;
                padding: 0 0 0 5px;
                height: 22px;
                border: 0;
            }
            .header {
                background-color: #116666;
                padding: 14px 0 10px 0;
                margin: auto 0;
                float: left;
                width: 100%;
            }
            #search {
                background-color: #00aa99;
                border-radius: 5px;
                font-family: consolas;
                margin-left: 5px;
                font-size: 20px;
                padding: 0 0 0 5px;
                height: 32px;
                border: 0;
                width: 240px;
                color: white;
            }
            #search::placeholder {
                color: lightgreen;
            }
            #search, #go {
                transform: translate(0, -3px);
            }
            #title {
                font-weight: 900;
                font-size: 28px;
                margin: 0 10px;
                color: lightgreen;
            }
            #title2 {
                font-weight: 900;
                font-size: 28px;
            }
            .linebreak, .lb {
                weight: auto;
                float: left;
                margin: 2px;
            }
            #subcontent {
                vertical-align: middle;
                overflow-y: auto;
                position: absolute;
                padding: 20px 10%;
                display: block;
                height: calc(100% - 90px);
                width: 80%;
                left: 0;
                top: 70px;
            }
            #subcontent .quest {
                background-color: #229999;
                min-width: 800px;
                display: block;
                height: 200px;
                margin: 20px;
                float: left;
                width: 100%;
            }
            #subcontent div .title {
                font-weight: 900;
                font-size: 48px;
                position: relative;
                padding: 10px;
                margin: 60px 0 0 0;
                float: left;
            }
             #subcontent div p {
                position: absolute;
                padding: 10px;
                margin: 110px 0 0 calc(10% + 22px);
                float: left;
                left: 0;
            }
            #subcontent div button {
                background-color: #11DBDB;
                font-family: consolas, 微軟正黑體, 'Microsoft jhenghei';
                font-weight: 900;
                font-size: 32px;
                position: relative;
                height: 100%;
                cursor: pointer;
                border: 0;
                float: right;
                width: 250px;
            }
            .que {
                margin: 20px;
            }
            .q {
                font-weight: 900;
                font-size: 24px;
            }
            .option {
                margin: 10px 20px;
            }
            .text {
                font-size: 20px;
                padding: 0 0 0 5px;
                height: 36px;
                width: 200px;
            }
            .radio {
                color: #ffffff;
                transform: translate(0, 1px);
                font-size: 20px;
                height: 15px;;
                width: 15px;
            }
            #submit {
                background-color: #229999;
                border-radius: 22px;
                font-size: 14px;
                cursor: pointer;
                height: 44px;
                border: 0;
                float: right;
                width: 44px;
            }
            .clear {
                clear: both;
            }
        </style>
    </head>
    <body>
        <div class="header">
            <span id="title">來填問卷吧</span><span id="title2">Questionnaire Bar</span>
            <input id="search" placeholder="Search">
            <button id="go" onclick="search()">Go></button>
            <button class="b" id="b" onclick="">登入</button>
            <div class="content" id="content">
                <div class="lb">
                    <span>賬號：</span><input id="acc" placeholder="賬號" value="<?php echo $name ?>">
                    <span>密碼：</span><input id="pwd" type="password" placeholder="密碼" value="<?php echo $pass ?>">
                    <div class="clear"></div>
                </div>
                <div class="linebreak">
                    <input type="checkbox" id="r" name="r" checked><span>記住登入資訊。</span>
                    <button id="login" onclick="login()">登入</button>
                    <div class="clear"></div>
                </div>
                <div class="clear"></div>
            </div>
            <div class="clear"></div>
        </div>
        <div id="subcontent">
            <?php
                $chk = mysqli_query($link, "SELECT * FROM `questionnaire` WHERE 1");
                $cnt = $chk->num_rows;
                for ($i=0;$i<$cnt;$i++) {
                    $rs=mysqli_fetch_row($chk);
                    $id = $rs[0];
                    $title = $rs[1];
                    $detail = $rs[2];
                    echo "<div class='quest'><span class='title'>".$title."</span><p>".$detail."</p><button onclick='quest(".$id.")'>開始填寫>></button><div class='clear'></div></div>";
                }
            ?>
        </div>
        <div class="clear"></div>
        <script>
            var input = document.getElementById("pwd");
            // Execute a function when the user releases a key on the keyboard
            input.addEventListener("keyup", function(event) {
            // Cancel the default action, if needed
            event.preventDefault();
            // Number 13 is the "Enter" key on the keyboard
            if (event.keyCode === 13) {
                // Trigger the button element with a click
                document.getElementById("login").click();
            }
            });
            function login() {
                var account = document.getElementById("acc").value;
                var passwd = document.getElementById("pwd").value;
                var rem = document.getElementById("r").checked;
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        $("#b").html(this.responseText); //把button
                        $("#b").removeClass("b"); //去掉有按鈕性質的css
                        $("#b").css("width", "130px"); //讓文字可以fit in區塊不跑版
                    }
                };
                xmlhttp.open("POST", "login.php", true);
                xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xmlhttp.send("account=" + account + "&passwd=" + passwd + "&rem=" + rem);
            }
            function search() { //顯示無用搜尋裏面的東西
                var search = document.getElementById("search").value;
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        $("#subcontent").html(this.responseText);
                    }
                };
                xmlhttp.open("POST", "search.php", true);
                xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xmlhttp.send("search=" + search);
            }
            function quest(a) {
                var id = a;
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        $("#subcontent").html(this.responseText);
                    }
                };
                xmlhttp.open("POST", "access.php", true);
                xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xmlhttp.send("id=" + id);
            }
            function ans(w, x) {
                var req = "q=" + x + "&quest=" + w;// post q:有幾個問題 quest:問卷編號
                for (var i=0;i<x;i++) {
                    var y = document.getElementById(i); // 針對名字弄的因爲我不會用name回傳value 慘
                    var z = document.getElementsByName(i);
                    var b = null;
                    req = req+"&qid="+i; // post qid:問題編號
                    if (y.type == "text") {
                        a = y.value;
                        req = req+"&ans"+i+"="+a; // ans:答案
                    }else if (z[0].type == "radio") { // 單選題
                        for (var j=0;j<z.length;j++) {
                            if (z[j].checked) { //如果選了就寫入;
                                b = z[j].value;
                                req = req+"&ans"+i+"="+b; // ans:答案(可多個或單個不過這是單選)
                            }
                        }if (b == null) {
                            alert('請填寫第'+(i+1)+"題");
                            return 0;
                        }
                    }
                }
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        $("#subcontent").html(this.responseText);
                    }
                };
                xmlhttp.open("POST", "request.php", true);
                xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xmlhttp.send(req);
            }
            $(document).ready(function(){
                $(".b").click(function(){
                    if ($("#b").width() == 28) {
                        $(".content").toggle("fast","swing");
                    }
                });
                $("#login").click(function(){
                    $(".content").hide();
                });
            });
        </script>
        <?php 
            if(isset($_SESSION["name"]) && isset($_SESSION["passwd"])) {
                ?><script>login();</script><?php
            }
        ?>
    </body>
</html>