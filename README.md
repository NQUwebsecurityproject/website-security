# 網站資安防護website-security
為金門大學 資訊工程學系 第五組  
指導教授：柯志亨   
組員：劉鳳安、陸佑函、蘇川民、王文濤、許哲瑋

## 目錄
* [動機](https://github.com/NQUwebsecurityproject/website-security#%E5%8B%95%E6%A9%9F) 
* [簡介](https://github.com/NQUwebsecurityproject/website-security#%E7%B0%A1%E4%BB%8B)  
* 專題研究內容  
  1. [釣魚網站](https://github.com/NQUwebsecurityproject/website-security#%E9%87%A3%E9%AD%9A%E7%B6%B2%E7%AB%99)    
  2. [暴力破解](https://github.com/NQUwebsecurityproject/website-security#%E6%9A%B4%E5%8A%9B%E7%A0%B4%E8%A7%A3)   
  3. [網頁認證碼](https://github.com/NQUwebsecurityproject/website-security#%E7%B6%B2%E9%A0%81%E8%AA%8D%E8%AD%89%E7%A2%BC)
  4. [Fail2ban防範暴力破解](https://github.com/NQUwebsecurityproject/website-security#fail2ban-%E9%98%B2%E7%AF%84%E6%9A%B4%E5%8A%9B%E7%A0%B4%E8%A7%A3)
  5. [bash檔編寫防範暴力破解](https://github.com/NQUwebsecurityproject/website-security#bash%E6%AA%94%E7%B7%A8%E5%AF%AB%E9%98%B2%E7%AF%84%E6%9A%B4%E5%8A%9B%E7%A0%B4%E8%A7%A3)
  6. [二次認證](https://github.com/NQUwebsecurityproject/website-security#%E4%BA%8C%E6%AC%A1%E8%AA%8D%E8%AD%89)

* 防護介紹補充
  1. [DoS,DDoS](https://github.com/NQUwebsecurityproject/website-security#dosddos) 
  2. [iptable](https://github.com/NQUwebsecurityproject/website-security#iptables)
## 動機

現在大家上網、使用網頁都是每天都一定會做的事，但當使用的帳號密碼因為要容易記憶所以設得很簡單，而這時你的帳密就很容易被駭客盜取、破解，針對以上的事情，有這個動機要來研究如何防護帳號密碼不被輕易破解，而藉此機會也讓其他人了解如何防護自己的帳密，所以以此教程來呈現

## 簡介
我們專題研究的項目主要是防護帳號密碼，以免被駭客盜取、破解，一開始建置釣魚網站，再來研究暴力破解，要做防護網頁的話，我們組有研究兩方面，其一網頁程式碼編寫來做防護，其二在伺服器建置防火牆規則進行防護，我們組大部分時間研究後項，查資料有找到結合防火牆功能的工具，名為fail2ban，確實能很有效地防護暴力破解，但fail2ban畢竟是已經做好的工具，所以我們了解它的功能，去自己編寫程式建置一套防護工具，這樣未來針對駭客多樣化的攻擊，我們也能去進行防護。

## 專題研究內容

### 釣魚網站
 「網路釣魚」 （Phishing）即為透過"不明網站"來騙取個人資料的方式，最主要是騙取帳號與密碼用，可能以以下兩種方式做為網站的背景  
 1. 使用與官網相似的網址與頁面（假網頁）  
 2. 網路抽獎廣告連結  
 
 這裡有幾種建立釣魚網站的方式：
 1. 利用網頁程式語言來編寫簡單的釣魚網站: [FB釣魚網站(php)](https://github.com/NQUwebsecurityproject/website-security/tree/master/FB%E9%87%A3%E9%AD%9A%E7%B6%B2%E7%AB%99(php))  
 2. [beef建置釣魚網站](https://www.youtube.com/watch?v=3mcEpn0_sJM)    
 3. [setoolkit建置釣魚網站](https://www.youtube.com/watch?v=9n5BQiGtxDk) 

### 暴力破解
用Hydra套件來做暴力破解或字典攻擊，最主要是猜測帳號與密碼，把可能的選項一個個去試出來，只要駭客機器效能夠好，就能在短時間內測試上萬筆的帳密，所以只要密碼太簡單就會很容易被破解

以下範例:
 1. [Hydra操作說明](https://github.com/NQUwebsecurityproject/website-security/tree/master/Hydra%E6%9A%B4%E5%8A%9B%E7%A0%B4%E8%A7%A3/Hydra%E6%93%8D%E4%BD%9C%E8%AA%AA%E6%98%8E) 
 2. [暴力破解wordpress](https://github.com/NQUwebsecurityproject/website-security/tree/master/Hydra%E6%9A%B4%E5%8A%9B%E7%A0%B4%E8%A7%A3/%E6%9A%B4%E5%8A%9B%E7%A0%B4%E8%A7%A3Wordpress)
 3. [暴力破解Webcam](https://github.com/NQUwebsecurityproject/website-security/tree/master/Hydra%E6%9A%B4%E5%8A%9B%E7%A0%B4%E8%A7%A3/%E6%9A%B4%E5%8A%9B%E7%A0%B4%E8%A7%A3Webcam)
    
### 網頁認證碼
大家有時可能會看到，當帳號密碼失敗太多次時，網頁會跳出驗證碼，要你輸入它圖形的英文數字，要測試你是不是機器人，而現在recaptcha能從網頁的使用訊息來判斷你不是機器人，這樣能免去打驗證碼，且能防範暴力破解的攻擊。

[Recaptcha網頁認證教學](https://github.com/NQUwebsecurityproject/website-security/tree/master/Recaptcha%E7%B6%B2%E9%A0%81%E8%AA%8D%E8%AD%89%E6%95%99%E5%AD%B8)

### Fail2ban 防範暴力破解
Fail2ban是運用iptables防火牆的機制，當偵查到不明有危害的ip就能進行封鎖，而偵查方式是運用連入伺服器留下的log檔的資訊，當某一ip的封包在短時間內大量傳送到伺服器時能進行防護，比如暴力破解網頁密碼，短時間內傳大量帳密的測試封包要破解使用者的帳密，fail2ban能對其ip進行封鎖，然而能封鎖多久，相關設定可以從以下教程來學習。

1. [Fail2Ban 防範暴力破解(ssh、vsftp)](https://github.com/NQUwebsecurityproject/website-security/tree/master/Fail2ban%E6%95%99%E5%AD%B8/Fail2Ban%20%E9%98%B2%E7%AF%84%E6%9A%B4%E5%8A%9B%E7%A0%B4%E8%A7%A3(ssh%E3%80%81vsftp))
2. [Fail2ban防範暴力破解Wordpress](https://github.com/NQUwebsecurityproject/website-security/tree/master/Fail2ban%E6%95%99%E5%AD%B8/Fail2ban%20%E9%98%B2%E7%AF%84%20%E6%9A%B4%E5%8A%9B%E7%A0%B4%E8%A7%A3Wordpress)

 > Fail2ban vs 網頁認證碼   
fail2ban 的好處是在任何網站都能快速建置防護，不用去查看網頁程式碼，且不只針對網頁，針對多樣應用程式皆能同時進行防護。

### bash檔編寫防範暴力破解
編寫linux bash檔 ，對log檔進行監控，只要有失敗登入達一定數量以上，就把對方的ip加到iptables的黑名單裡面，只要在黑名單裡面就會把對方傳來的封包丟掉

[bash檔編寫防範暴力破解](https://github.com/NQUwebsecurityproject/website-security/tree/master/bash%E6%AA%94%E7%B7%A8%E5%AF%AB%E9%98%B2%E7%AF%84%E6%9A%B4%E5%8A%9B%E7%A0%B4%E8%A7%A3)

### 二次認證
二次認證顧名思義就是輸入完密碼後，還要再進行第二次認證，這跟網頁的圖形或Recaptcha驗證很像，但這是可以連結手機或其他硬體來做認證，當輸入進行登入動作成功時，就會傳一次性驗證碼或是傳訊息到手機通知是否是當事人使用來驗證，這樣能做到第二層的防護，就算帳號密碼被竊取到，也能防止非當事人登入。

現在各家公司登入都有二次認證的功能例如:google、facebook，對於大家常用且重要的帳號可以去啟用二次認證的功能。

以下是ssh 二次認證的防護教學:
[CentOS 7 SSH 連線驗證(Google Authenticator)](https://github.com/NQUwebsecurityproject/website-security/tree/master/google%E4%BA%8C%E6%AC%A1%E8%AA%8D%E8%AD%89(%E9%98%B2%E6%9A%B4%E5%8A%9B%E7%A0%B4%E8%A7%A3))

## 防護介紹補充
### DoS,DDoS
DoS攻擊：為阻斷服務攻擊，顧名思義就是想把伺服器的連線給阻斷掉，駭客通常會對伺服器一直做請求或偽造的回應封包，導致伺服器壅塞，這樣伺服器品質下滑。 
HPING3做資源消耗型攻擊，主要是TCP洪水攻擊，一直傳送大量帶有特定旗標的TCP(通常都是SYN)封包，導致受害者不斷回送ACK封包，使資料無法傳送。  
DDoS攻擊：為分散式阻斷服務攻擊，意思就是強化版的DoS攻擊，通常會運用兩個或以上的電腦去做攻擊，重點是又增加伺服器資源耗盡的問題，嚴重點還可能會讓伺服器當機。

### iptables
Iptable是個控制Linux核心netfilter的模組，管理封包的處理與轉傳，所以其實是一個防火牆過濾的模組。  
可做上述的DoS、DDoS和暴力破解的防護。
  1. [iptables設定教學](https://github.com/NQUwebsecurityproject/website-security/tree/master/Linux%E9%98%B2%E7%81%AB%E7%89%86iptable%E8%A8%AD%E5%AE%9A)   
2. [DoS防護](https://github.com/LarrySu508/website-security/blob/master/DoS%E9%98%B2%E8%AD%B7/README.md)

