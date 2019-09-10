# 使用Fail2Ban(0.9.7版)防範暴力破解(ssh、vsftp) 參照:[用 Fail2Ban 防範暴力破解 (SSH、vsftp、dovecot、sendmail)](http://www.vixual.net/blog/archives/252)
## 1.Fail2ban 可以藉由掃描 log檔 (例如:/var/log/secure) 找出有惡意的IP進而去禁止其IP一段時間無法連入該伺服器或是永遠禁止，而暴力破解會造成一連串的登入失敗Fail2ban即可偵查出並加以防範。
## 2.安裝Fail2Ban
```
[root@localhost user/Desktop]# yum install fail2ban
[root@localhost user/Desktop]# systemctl enable fail2ban
[root@localhost user/Desktop]# systemctl start fail2ban
```
![image](https://github.com/LarrySu508/cisco-note/blob/master/week1/p1.png)
## 3.更改設定檔
```
[root@localhost user/Desktop]# cd /etc/fail2ban
[root@localhost etc/fail2ban]# cp fail2ban.conf fail2ban.local
[root@localhost etc/fail2ban]# gedit fail2ban.local
```
![image](https://github.com/LarrySu508/cisco-note/blob/master/week1/p1.png)
![image](https://github.com/LarrySu508/cisco-note/blob/master/week1/p1.png)
## 4.最後記得做systemctl restart fail2ban
> ## 實測影片:[NQU資工第五組專題:fail2ban防護篇](https://www.youtube.com/watch?v=wEuQW9laTg4&t=1s)。
