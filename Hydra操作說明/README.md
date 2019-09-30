# Hydra 操作流程說明
在Linux虛擬機上，使用[AltoroMutual公開測試網站](http://www.testfire.net/)做操作示範。   
## 擷取網站資訊
在使用Hydra指令時需要：  
1.url:user pass(網址:用戶密碼格式)   
2.錯誤訊息   
3.網頁傳輸形式(基本為Post形式，Get安全性低，會讓帳戶和密碼顯示在URL欄位)    
4.Host   
以上資訊可以在網頁源代碼上查到，也可用burp suite(封包解析)來抓取。  
## 源代碼操作
1.於瀏覽器上右鍵網頁查看源代碼，此處Login Failed訊息需要   
![image](https://github.com/LarrySu508/website-security/blob/master/Hydra%E6%93%8D%E4%BD%9C%E8%AA%AA%E6%98%8E/a.png)      
![image](https://github.com/LarrySu508/website-security/blob/master/Hydra%E6%93%8D%E4%BD%9C%E8%AA%AA%E6%98%8E/b.png)   
2.需要的重要訊息   
![image](https://github.com/LarrySu508/website-security/blob/master/Hydra%E6%93%8D%E4%BD%9C%E8%AA%AA%E6%98%8E/c.png)   
![image](https://github.com/LarrySu508/website-security/blob/master/Hydra%E6%93%8D%E4%BD%9C%E8%AA%AA%E6%98%8E/d.png)   
![image](https://github.com/LarrySu508/website-security/blob/master/Hydra%E6%93%8D%E4%BD%9C%E8%AA%AA%E6%98%8E/e.png)   
