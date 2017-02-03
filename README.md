# php_example

# TODO 
 1. SQL injection prevention(Mysqli param binding)(DONE)
 2. XSS prevention(input tester)(DONE)
 3. CSRF prevention(session tokens generated with bin2hex)(DONE)
 4. Add captcha https://www.google.com/recaptcha (DONE)
 5. Argon2i hash http://www.hackinsight.org/news,567.html  &&   https://wiki.php.net/rfc/argon2_password_hash
 6. SSL http://www.uniformserver.com/ZeroXI_documentation/apache.html
 Checklist: http://stackoverflow.com/questions/28695117/what-should-a-secure-login-script-consist-of/28710255#28710255

# For reCaptcha
 1. Go to php.ini
 2. Find extension=ext/php_openssl.dll 
 3. Delete the semicolon(;) in front of it and save
