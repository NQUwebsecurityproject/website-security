# 帳密竊取攻擊           
hack1.php和index1.html是一組的，而hack.php和index.html是另外一組         
            
## hack1.php和index1.html程式碼講解說明            
### index1.html         
以一個登入畫帳號密碼畫面為基底的html檔，最主要的重點是form表單，action把表單內容丟置hack1.php，method屬性是設置表單中數據傳輸給私服器端的方式，post是與action指定的私服器建立關聯，並於私服器端讀取參數，當然要先解碼，因為這裡要傳輸帳密所以盡量別用get，要不然表單的參數會直接印在程序的URL中喔,input是放入訊息的，type為屬性這用到text,password,submit，各別是字段默認20個字符，密碼字段裡面輸入的字符會掩蓋，再來是提交按鈕如字面把表單提交給私服器，而type之後的name為元素名稱，最後的placeholder是字段預設值的提示，像是要輸入帳號的地方會在填框中提示"帳號"的意思。            
                        
form標籤的各項指令參考:http://www.w3school.com.cn/tags/tag_form.asp      
input標籤的各項指令參考:http://www.w3school.com.cn/tags/tag_input.asp    
      
### hack1.php           
最主要用的PHP是sever端腳本語言，在hackproof中會有sever簡易的建構方法，$login是名為login的變數，以此類推$pass,$data也是一樣的意思，$ _ POST["acc"]意思是透過POST函數取得剛才在HTML中建的表單中'acc'欄位的值，$ _ POST["pwd"]也是一樣，只是改取表單中'pwd'欄位的值， fopen("logfile.txt","a+")就是打開logfile.txt文件，"a+"意思是讀寫檔案，寫入時寫在文件最末端，若文件沒有建立自動生成，若要參考"a+"以外的值可以找下面"PHP  fopen()函数教學"，fwrite那行是指寫入$data文件(前一行fopen打開的文件)，內容是"  "裡的東西，其實就是一開始輸入的帳號及密碼，fclose就如字面關閉開啟的檔案，其實這指令和fopen是一套的，header就是轉跳到你後面指定的網址，我們是把網址指到hackproof中建的登入成功的畫面，其實在駭客攻擊時是轉跳到你現在登入的網站啦，你可以試試修改location之後的網址，header()其實還有其他的參數下方有連結教學。
                        
PHP語法教學:http://www.w3school.com.cn/php/index.asp                        
PHP  fopen()函数教學:http://www.w3school.com.cn/php/func_filesystem_fopen.asp           
PHP  fwrite()函数教學:http://www.w3school.com.cn/php/func_filesystem_fwrite.asp         
PHP  header()函数教學:http://www.w3school.com.cn/php/func_http_header.asp           
            
## hack.php和index.html程式碼講解說明              
### index.html         
和/hackerproof/index.html一樣，用jQuery發出請求已改變狀態並觸發php檔，與index1.html具一樣效果，而與index1.html不同在於它是用button觸發狀態，index1.html是直接input表單。               
                        
### hack.php           
使用$ _ REQUEST不管是get或post都可收到，但預設順序為POST>GET，其他就和hack1.php一樣，最後轉跳到hackerproof資料夾中登入成功的畫面。                    
