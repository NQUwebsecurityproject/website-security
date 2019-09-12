# 使用Fail2Ban防範暴力破解(ssh、vsftp) 

<font  size=2 >本教學者使用fail2ban安裝0.9.7版
參照:[用 Fail2Ban 防範暴力破解 (SSH、vsftp、dovecot、sendmail)](http://www.vixual.net/blog/archives/252)</font>

Fail2ban 可以藉由掃描 log檔 (例如:/var/log/secure) 找出有惡意的IP進而去禁止其IP一段時間無法連入該伺服器或是永遠禁止，而暴力破解會造成一連串的登入失敗Fail2ban即可偵查出並加以防範。
## 1.安裝Fail2Ban
```
# yum install fail2ban
# systemctl enable fail2ban
# systemctl start fail2ban
```
## 2.更改設定檔
```
# cd /etc/fail2ban
# cp fail2ban.conf fail2ban.local
# gedit fail2ban.local
```
fail2ban.local預設內容
```python
[DEFAULT]
 Ignoreip  = 127.0.0.1/8  # 忽略 IP 的清單，以空白區隔不同 IP
 bantime  = 600 # 封鎖的時間，單位:秒，600=10分鐘，改為 -1 表示「永久」封鎖
 findtime  = 600 # 在多久的時間內，單位:秒，600=10分鐘
 maxretry  = 5 # 登入失敗幾次封鎖
```
添加以下內容
```python
[ssh-iptables]  
enabled  = true # 啟用 SSH
filter    = sshd
action   = iptables[name=SSH, port=ssh, protocol=tcp]
sendmail-whois[name=VSFTPD, dest=收件者 EMail, sender=顯示的寄件者 EMail]
logpath  = /var/log/secure  # Log 檔的位置
findtime  = 600 # 在多久的時間內，單位:秒，600=10分鐘
maxretry = 10  # 登入失敗幾次封鎖
```
```python
[vsftpd-iptables]
 enabled  = true # 改為 true 以啟用 vsftpd
 filter   = vsftpd
 action   = iptables[name=VSFTPD, port=ftp, protocol=tcp]
     sendmail-whois[name=VSFTPD, dest=收件者 EMail, sender=顯示的寄件者 EMail]
 logpath  = /var/log/secure # Log 檔的位置 (log 檔的位置與 ssh 相同)
 maxretry = 10 # 登入失敗幾次封鎖
 bantime  = 3600 # 封鎖的時間，單位:秒，3600=1小時
```
![image](/p3.png)

最後記得做
```
systemctl restart fail2ban
```
## 3.展示攻擊與防護(影片)
[NQU資工第五組專題:fail2ban防護篇](https://www.youtube.com/watch?v=wEuQW9laTg4&t=1s)。
