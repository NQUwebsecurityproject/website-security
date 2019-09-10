# 使用Fail2Ban 防範暴力破解(ssh、vsftp) 參照:[用 Fail2Ban 防範暴力破解 (SSH、vsftp、dovecot、sendmail)](http://www.vixual.net/blog/archives/252)
## 1.
```
[root@user]# yum update nss curl\
```
![image](https://github.com/LarrySu508/cisco-note/blob/master/week1/p1.png)
>
## 2.
```
[root@user/Desktop]# git clone google-authenticator-libpam
[root@user/Desktop]# yum groupinstall "Development Tools"
```
## 3.
```
[root@user/Desktop]# cd google-authenticator-libpam-master
[root@user/Desktop/google-authenticator-libpam-master]# ./bootstrap.sh
[root@user/Desktop/google-authenticator-libpam-master]# ./configure
[root@user/Desktop/google-authenticator-libpam-master]# make && make install
```
>
```
[root@user/Desktop/google-authenticator-libpam-master]# ./configure
[root@user/Desktop/google-authenticator-libpam-master]# configure: error: Unable to find the PAM library or the PAM header files
[root@user/Desktop/google-authenticator-libpam-master]# yum install pam-devel
[root@user/Desktop/google-authenticator-libpam-master]# ./configure
```
## 4.
```
[root@user/Desktop/google-authenticator-libpam-master]# find / -name pam_google_authenticator.so -type f
[root@user/Desktop/google-authenticator-libpam-master]# /usr/lib64/security/
                                          .
                                          .
                                          .
[root@user/Desktop/google-authenticator-libpam-master]# mv /usr/local/lib/security/pam_google_authenticator.* /usr/lib64/security/
```
## 5.
```
[root@user/Desktop/google-authenticator-libpam-master]# gedit /etc/pam.d/sshd
```
>
```
auth required pam_google_authenticator.so nullok
```
>
```
[root@user/Desktop/google-authenticator-libpam-master]# gedit /etc/ssh/sshd_config
```
>
```
ChallengeResponseAuthentication yes
```
>
```
[root@user/Desktop/google-authenticator-libpam-master]# systemctl restart sshd
```
## 6.
```
[root@user/Desktop/google-authenticator-libpam-master]# google-authenticator
```
> ## 影片教學與實測:[google-authenticator二次認證](https://www.youtube.com/watch?v=xyS7Ms2LalM)。
