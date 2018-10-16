# 簡易式登入網頁創建          
我們用XAMPP創建一個簡易的server，還有資料庫表單儲存帳號密碼，某些地方有做修改，像是MySQL密碼修改之類的，以下連結是修改方法(https://www.mauchiuan.com/2015/12/xampp-5615-mysql-phpmyadmin.html)                
                
## index.html           
這html檔就是登入帳號密碼的頁面，其中有些js的語法。
> <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
此行是使用者沒下載host jQuery情況下，在google要使用jQuery可以加入google CDN也就是這行指令。          
>var account = document.getElementById("acc").value;            
var passwd = document.getElementById("pwd").value;             
        
這兩行是設定把找尋的元素"acc","pwd"的值，分別設為"account","passwd"變數。              
          
後面的指令為http的請求，當請求發生時存储後方的函数，當readyState的屬性變動時，就會換成變動後的函數，函數為當狀態是已完成請求並響應和OK時，此時的html響回反應。最後的open()和send()是將請求發送到server，並用get的方式請求，true的意思是規定響應處在onreadystatechange事件中的就绪狀態執行的函數。    
                                
## login.php           
其實這php檔就是在連結mysql裡的帳號密碼欄位，向mysql請求欄位並對照帳密是否正確，或者是否填入。            
