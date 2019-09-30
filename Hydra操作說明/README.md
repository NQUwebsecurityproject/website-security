# Hydra 操作流程說明
在Linux虛擬機上，使用[AltoroMutual公開測試網站](http://www.testfire.net/)做操作示範。   
## 擷取網站資訊
在使用Hydra指令時需要：  
1.url:user pass(網址:用戶密碼格式)   
2.錯誤訊息   
3.網頁傳輸形式(基本為Post形式，Get安全性低，會讓帳戶和密碼顯示在URL欄位)    
4.Host   
以上資訊可以在網頁源代碼上查到，也可用Burp suite(封包解析)來抓取。  
## 源代碼操作
1.於瀏覽器上右鍵網頁查看源代碼，此處Login Failed訊息需要   
![image](https://github.com/LarrySu508/website-security/blob/master/Hydra%E6%93%8D%E4%BD%9C%E8%AA%AA%E6%98%8E/a.png)      
![image](https://github.com/LarrySu508/website-security/blob/master/Hydra%E6%93%8D%E4%BD%9C%E8%AA%AA%E6%98%8E/b.png)   
2.需要的重要訊息   
![image](https://github.com/LarrySu508/website-security/blob/master/Hydra%E6%93%8D%E4%BD%9C%E8%AA%AA%E6%98%8E/c.png)   
![image](https://github.com/LarrySu508/website-security/blob/master/Hydra%E6%93%8D%E4%BD%9C%E8%AA%AA%E6%98%8E/d.png)   
![image](https://github.com/LarrySu508/website-security/blob/master/Hydra%E6%93%8D%E4%BD%9C%E8%AA%AA%E6%98%8E/e.png)   
## Burp suite擷取
Burp suite是圖形化介面，會把重點封包提出。  
1.調整網頁至8080埠號。   
![image](https://github.com/LarrySu508/website-security/blob/master/Hydra%E6%93%8D%E4%BD%9C%E8%AA%AA%E6%98%8E/f.png)  
2.開啟Burp suite後，在測試網頁任意輸入帳密，再回到Burp suite查看。  
![image](https://github.com/LarrySu508/website-security/blob/master/Hydra%E6%93%8D%E4%BD%9C%E8%AA%AA%E6%98%8E/g.png)  
## Hydra指令
得到了post，/dologin，uid=^^&passw=^^&btnSubmit=Login，Login Failed等訊息後，就可以下Hydra的指令。  
```
Hydra -l admin -P password.txt -V www.testfire.net http-post-form “/dologin:uid=^USER^&passw=^PASS^&btnSubmit=Login:Login Failed:C=/login.jsp
```
![image](https://github.com/LarrySu508/website-security/blob/master/Hydra%E6%93%8D%E4%BD%9C%E8%AA%AA%E6%98%8E/h.png)   
User和passw部分具體看實際格式，內容要分別改成^USER^和^PASS^，-V是詳細過程列出，-l和-p後分別寫入帳號和密碼，如果是字典檔的話改成-L和-P後面接對應的字典檔，-v後的輸入順序為host，http-post-form，url，錯誤訊息，網頁後綴，每一段需要使用“:”隔开。  
破解成功時會是以下狀態：  
![image](https://github.com/LarrySu508/website-security/blob/master/Hydra%E6%93%8D%E4%BD%9C%E8%AA%AA%E6%98%8E/fin.png)   