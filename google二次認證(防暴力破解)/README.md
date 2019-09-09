# CentOS 7 SSH 連線驗證(Google Authenticator)  參照:[CentOS 7 SSH 兩步驟驗證](https://kenwu0310.wordpress.com/2016/12/09/centos-7-ssh-%E9%9B%99%E5%9B%A0%E7%B4%A0%E8%AA%8D%E8%AD%89-using-google-authenticator/)
## 1.因為要用到git的套件，所以要先看看你虛擬機上的git版本是否最新，如果不是請在root模式下:
```
[root@user]# yum update nss curl\
```
>參考於:[git clone 報錯 incompatible or unsupported protocol version處理方法](https://blog.csdn.net/feinifi/article/details/79629904)。
## 2.先git clone google-authenticator-libpam到你虛擬機的桌面安裝Development Tools。
```
[root@user/Desktop]# git clone google-authenticator-libpam
[root@user/Desktop]# yum groupinstall "Development Tools"
```
## 3.再來進到google-authenticator-libpam-master資料夾，執行bootstrap.sh,configure兩個檔案，之後再下make && make install。
```
[root@user/Desktop]# cd google-authenticator-libpam-master
[root@user/Desktop/google-authenticator-libpam-master]# ./bootstrap.sh
[root@user/Desktop/google-authenticator-libpam-master]# ./configure
```
>如果出現錯誤訊息，無法找到PAM library or the PAM header檔案，就先安裝pam-devel套件後，再下./configure指令。
```
[root@user/Desktop/google-authenticator-libpam-master]# ./configure
[root@user/Desktop/google-authenticator-libpam-master]# configure: error: Unable to find the PAM library or the PAM header files
[root@user/Desktop/google-authenticator-libpam-master]# yum install pam-devel
[root@user/Desktop/google-authenticator-libpam-master]# ./configure
```
## 4.然後把pam_google_authenticator.so移動或複製到/usr/lib64/security/，通常pam_google_authenticator.so會在/usr/local/lib/security/目錄中，你也可先下指令找尋。
```
[root@user/Desktop/google-authenticator-libpam-master]# find / -name pam_google_authenticator.so -type f
[root@user/Desktop/google-authenticator-libpam-master]# /usr/lib64/security/
                                          .
                                          .
                                          .
[root@user/Desktop/google-authenticator-libpam-master]# mv /usr/local/lib/security/pam_google_authenticator.* /usr/lib64/security/
```
## 5.最後修改設定檔就可以執行google-authenticator。
```
[root@user/Desktop/google-authenticator-libpam-master]# gedit /etc/pam.d/sshd
```
>再加入最後一行。
```
auth required pam_google_authenticator.so nullok
```
>然後把sshd_config檔裡的驗證回應改成yes。
```
[root@user/Desktop/google-authenticator-libpam-master]# gedit /etc/ssh/sshd_config
```
>驗證回應改成yes。
```
ChallengeResponseAuthentication yes
```
>重啟SSH Service。
```
[root@user/Desktop/google-authenticator-libpam-master]# systemctl restart sshd
```
## 6.執行google-authenticator後會出現QRcode，然後在手機下載google-authenticator，手機開啟google-authenticator後，會請你掃碼或輸入金鑰，之後你在遠端登入用SSH協定時，必須再輸入手機二次驗證碼，還有個重點是在QRcode下方有五行數字，那五個字串是你無法正常驗證時，用來當萬能鑰匙的。
```
[root@user/Desktop/google-authenticator-libpam-master]# google-authenticator
```
> ## 影片教學與實測:[google-authenticator二次認證](https://www.youtube.com/watch?v=xyS7Ms2LalM)。
