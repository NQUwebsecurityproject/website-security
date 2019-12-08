# Recaptcha網頁認證教學

## 第一步：註冊
先到[recaptcha官網](https://www.google.com/recaptcha/admin)註冊一個recaptcha管理帳號，並把想要認證的測試網頁網址加入recaptcha網頁認證管理。

![](image/a.PNG)

然後就會產生金鑰

![](image/b.PNG)
## 第二步 建置網頁
官方範例網頁
https://developers.google.com/recaptcha/docs/display

```html
<html>
  <head>
    <title>reCAPTCHA demo: Simple page</title>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
  </head>
  <body>
    <form action="?" method="POST">
      <div class="g-recaptcha" data-sitekey="your_site_key"></div>
      <br/>
      <input type="submit" value="Submit">
    </form>
  </body>
</html>
```
把網站金鑰貼在data-sitekey後
```html
<div class="g-recaptcha" data-sitekey="your_site_key"></div>
```
測試網頁就會看到
![](image/c.PNG)
![](image/d.PNG)

## 登入網頁實作

## 補充
（因每個人需求不同這邊僅供參考）
在recaptcha checkbox 認證行加入data-callback、data-expired-callback，你可以自行取一個好記的function名稱。
```html
<div class="g-recaptcha" data-sitekey="your_site_key" data-callback="verify" data-expired-callback="expired"></div>
```
或是其他想用的功能:[(更多詳細)](https://developers.google.com/recaptcha/docs/display#g-recaptcha_tag_attributes_and_grecaptcharender_parameters）)

參數|說明
--- | ---
data-sitekey | 放網頁金鑰
data-theme | 定義recaptcha的風格，有dark和light兩種。
data-size |定義recaptcha的大小，有compact和normal兩種。
data-callback | 放認證成功後回傳的function。
data-expired-callback | 放認證過期後回傳的function。
data-error-callback |　放認證錯誤發生時回傳的function。

