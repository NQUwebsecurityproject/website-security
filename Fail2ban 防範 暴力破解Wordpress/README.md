# Fail2ban防範暴力破解Wordpress
## 使用環境
* 伺服器端為centos 7(wordpress需要Apache,PHP,MariaDB)
    >　Wordpress架設參考[Install WordPress 5 with Apache, MariaDB 10 and PHP 7 on CentOS 7](https://www.tecmint.com/install-wordpress-with-apache-on-centos-rhel-fedora/)。
* 駭客端為kali linux
     
駭客端暴力破解工具為hydra
伺服器端防護工具為fail2ban(需安裝python)。    
## Hydra攻擊指令介紹      
![image](c.png)      
先查看網頁的原始碼，在擷取需要的資料，詳細說明參考[Hydra操作說明](https://github.com/NQUwebsecurityproject/website-security/tree/master/Hydra%E6%93%8D%E4%BD%9C%E8%AA%AA%E6%98%8E)，攻擊指令如下：       
```
hydra -l jack -P pass.txt -V 192.168.207.8 http-form-post "/wp-login.php:log=^USER^&pwd=^PASS^&wp-submit=Log In&testcookie=1:ERROR"
```
## Fail2ban規則編寫
### 規則檔編寫  
```
gedit /etc/fail2ban/jail.conf
```
添加以下內容
```python
[apache-auth]   ##名稱
enabled = true  ##啟用
port   =http,https
filter = httpd    ##過濾檔名稱
action = iptables-multiport[name=http, port="http,https",protocol=tcp]         ##動作
logpath  = /var/log/httpd/tecminttest-acces-log      #log檔位置
maxretry = 10                       #登入失敗幾次封鎖 
findtime = 60                        
bandtime = 120                      #被ban的時間
```
> 這裡設定一分鐘之內有10次嘗試登入的動作，ip就會被ban 2分鐘的時間
### 過濾器編寫      
過濾器的作用是在log檔中比對出駭客攻擊的訊息。     
先查看log檔：
```
cat /var/log/httpd/tecminttest-acces-log
```
> 此處wordpress的log檔在tecminttest-acces-log

![image](g.png)
> 此處可以看到log檔的前端皆為連入伺服器的主機ip，而皆是192.168.207.3是因為剛有先暴力破解過所以這是駭客的ip，等下過濾檔以此為依據比對

再編寫過濾檔：       
```
gedit /etc/fail2ban/filter.d/httpd.conf
```      
```python
# Fail2Ban httpd filter
#
[INCLUDES]
# Read common prefixes. If any customizations available -- read them from
# apache-common.local
before = apache-common.conf

[Definition]

failregex =<HOST>.
ignoreregex =
```
```python       
failregex =<HOST>.      
```
這裡過濾檔的編寫很簡單，只要比對連入伺服器的主機ip就好了，因為我們是要防範暴力破解，所以要防護短時間內有大量的測試帳密封包，而那些規則檔有做好設定了，所以過濾檔只要去比對ip就好了

### 過濾器測試
測試過濾檔有沒有比對到log檔的內容：      
```
fail2ban-regex /var/log/httpd/tecminttest-acces-log /etc/fail2ban/filter.d/httpd
```      
![image](d.png)       
測試都比對到了，重啟fail2ban：      
```
systemctl restart fail2ban
```
再做一次駭客端攻擊。          
發現沒有成功，而且還被伺服器禁止做連線。

### 查看執行檔的執行狀態
```
fail2ban-client status apache-auth
```     
![image](f.png)

> 此處可以看到駭客的ip 192.168.207.3被ban掉了，代表防護成功!!!

再來觀察iptables的狀況    

```
iptables --list
```
確實iptables有把駭客的ip給ban掉了! 駭客端想要連此ip的話就會連不上，只能等bantime時間結束為止      