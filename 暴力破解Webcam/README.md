# 使用hydra對Webcam進行暴力破解 

<font  size=2 >本教學者使用hydra套件  

請問你可曾想過當家裡的雲端監控攝影機哪天被有心人士使用，而你的隱私權被這個有心人知道呢?有在家裡裝攝影機可能知道要在他處像是手機監控，要登入Webcam的雲端伺服器，當被其他人知道帳密時，這個人也可登進去看，接下來演示破解Webcam。
## 1.安裝hydra
```
# yum install hydra
```
## 2.查出Webcam server的IP與Url等資料
首先如果你要看的Webcam是在你所連的分享器上，你可以用IP Scanner找到IP，如果只是隨機找練習用，網路上有一些網站有Webcam的IP。  
再來在瀏覽器上輸入所查IP，並把程式開發人員選項打開，調到Network，把Url,Host,User Password形式及錯誤訊息記下，但本次演練的Webcam沒這些設定，如果有就要加在hydra指令裡。  
指令如下：  
```
hydra -l admin -P xxx.txt -V 192.168.0.242 http-get url  
```
到xxx.txt前是用戶以及暴力破解使用的password檔，-V是指會詳細的展現破解的流程，之後host即192.168.0.242，傳輸形式為get，所以輸入http-get，接著Url用剛剛在瀏覽器查到的即可。  
> ### 展示攻擊Webcam影片:[駭入webcam](https://www.youtube.com/watch?v=KZ3TBHk6IYc)。
