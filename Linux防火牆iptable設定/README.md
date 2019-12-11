# Linux防火牆iptable設定      
## 防火牆策略
 * 防火牆策略一般分為兩種，一種叫通策略，一種叫堵策略       
    1. 通策略，默認門是關著的，必須要定義誰能進。     
    2. 堵策略則是，大門是洞開的，但是你必須有身份認證，否則不能進。      

所以我們要定義，讓進來的進來，讓出去的出去，所以通，是要全通，而堵，则是要选择。當我們定義的策略的時候，要分別定義多條功能，其中：定義數據包中允許或者不允許的策略，filter過濾的功能，而定義地址轉換的功能的則是nat選項。為了讓這些功能交替工作，我們制定出了“表”這個定義，來定義、區分各種不同的工作功能和處理方式。
檢查規則的時候，是按照從上往下的方式進行檢查的。    
## 功能分類
 * 我們現在用的比較多個功能有3個：     
    1. filter 定義允許或者不允許的，只能做在3個鏈上：INPUT ，FORWARD ，OUTPUT
    2. nat 定義地址轉換的，也只能做在3個鏈上：PREROUTING ，OUTPUT ，POSTROUTING
    3. mangle功能:修改報文原數據，是5個鏈都可以做：PREROUTING，INPUT，FORWARD，OUTPUT，POSTROUTING   

我們修改報文原數據就是來修改TTL的。能夠實現將數據包的元數據拆開，在裡面做標記/修改內容的。而防火牆標記，其實就是靠mangle來實現的。        
## 基本參數
參數|作用
-------|-------
-P|設置默認策略:iptables -P INPUT (DROP)
-F|清空規則鏈
-L|查看規則鏈
-A|在規則鏈的末尾加入新規則
-I|num 在規則鏈的頭部加入新規則
-D|num 刪除某一條規則
-s|匹配來源地址IP/MASK，加嘆號"!"表示除這個IP外。
-d|匹配目標地址
-i|網卡名稱匹配從這塊網卡流入的數據
-o|網卡名稱匹配從這塊網卡流出的數據
-p|匹配協議,如tcp,udp,icmp
--dport num|匹配目標端口號
--sport num|匹配來源端口號
## 命令選項輸入順序
1. iptables -t 表名 <-A/I/D/R> 
2. 規則鍊名 [規則] <-i/o 網卡名> 
3. -p 協議名 <-s 源IP/網路> 
4. --sport 來源端口 <-d 目標IP/目標子網>
5. --dport 目標端口 
6. -j 動作
> ### <-i/o 網卡名>:通常在LINUX中擁有網路連線的網卡做選擇。如: eth0、enp0s3。   

> ### -p 協議名：1. Icmp、2. Tcp、3. Udp、4. All

> ### -s 源IP/網路：封包來源的IP位置或網路區段，網路區段通常設定在區域網路

## 工作機制
* INPUT鏈：處理輸入數據包。
* OUTPUT鏈：處理輸出數據包。
* FORWARD鏈：處理轉發數據包。
* PREROUTING鏈：用於目標地址轉換（DNAT）。
* POSTOUTING鏈：用於源地址轉換（SNAT）。
## 僅在TCP封包篩選(-f)
* ACK-表示此封包的 Acknowledge Number 是有效的﹐也就是用來回應上一個封包
* FIN-表示傳送結束﹐然後雙方發出結束回應﹐進而正式進入 TCP 傳送的終止流程
* URG-表示這是一個攜有緊急資料的封包，接收端需優先處理
* SYN-表示要求雙方進行同步處理﹐也就是要求建立連線
* PSH-該封包連同傳送緩衝區的其它封包應立即進行傳送，而無需等待緩衝區滿了才送。接收端必須儘快將此資料交給程式處理。
* RST-連線會被馬上結束，而無需等待終止確認手續
## 常用端口
埠(PORT)|名稱
----|----
80Port|HTTP
443Port|HTTPS
25Port|SMTP
53Port|DNS
21Port|FTP
23Port|Telnet
## 應用實例
### 封鎖你討厭的人的IP，讓他永遠無法跟你連線，假設是140.113.235.151
```
iptables -A INPUT -s 140.113.235.151 -d [你自己的IP] -j REJECTED
```
### 開放內部主機可以 ssh 至外部的主機
```
iptables -A OUTPUT -o eth0 -p tcp -s [$FW_IP] --sport 1024:65535 -d any/0 --dport 22 -j ACCEPT
iptables -A INPUT -i eth0 -p tcp ! --syn -s any/0 --sport 22 -d [$FW_IP] --dport 1024:65535 -j ACCEPT
```
### 開放內部主機可以 telnet 至外部的主機
```
iptables -A OUTPUT -o eth0 -p tcp -s [$FW_IP] --sport 1024:65535 -d any/0 --dport 23 -j ACCEPT
iptables -A INPUT -i eth0 -p tcp ! --syn -s any/0 --sport 23 -d [$FW_IP] --dport 1024:65535 -j ACCEPT
```
### 限制每個 ip 的連線數量
```
iptables -I INPUT -p tcp --syn --dport 25 -m connlimit --connlimit-above 4 -j REJECT --reject-with tcp-reset
iptables -I INPUT -p tcp --syn --dport 80 -m connlimit --connlimit-above 20 -j REJECT --reject-with tcp-reset
```