帳密竊取攻擊
===============================================================
hack1.php和index1.html是一組的，而hack.php和index.html是另外一組

hack1.php和index1.html程式碼講解說明
-----------------------------------
index1.html是以一個登入畫帳號密碼畫面為基底的html檔，最主要的重點是form表單，action把表單內容丟置hack1.php，method屬性是設置表單中數據傳輸給私服器端的方式，post是與action指定的私服器建立關聯，並於私服器端讀取參數，當然要先解碼，因為這裡要傳輸帳密所以盡量別用get，要不然表單的參數會直接印在程序的URL中喔,input是放入訊息的，type為屬性這用到text,password,submit，各別是字段默認20個字符，密碼字段裡面輸入的字符會掩蓋，再來是提交按鈕如字面把表單提交給私服器，而type之後的name為元素名稱，最後的placeholder是字段預設值的提示，像是要輸入帳號的地方會在填框中提示"帳號"的意思。

form標籤的各項指令參考:http://www.w3school.com.cn/tags/tag_form.asp      
input標籤的各項指令參考:http://www.w3school.com.cn/tags/tag_input.asp

hack.php和index.html程式碼講解說明
---------------------------------
