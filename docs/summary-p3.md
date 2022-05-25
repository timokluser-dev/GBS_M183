# M183 Summary P3

[TOC]

## ...

## Debugging

### Add PHP XDebug extension

1. Stop XAMPP: `apache`
2. Copy [php_xdebug.dll](./summary-p3/php_xdebug.dll) to `c:\xampp\php\ext`
3. Edit `c:\xampp\php\php.ini`:
   ```ini
   ; eof

   [xdebug]
   zend_extension = "c:\xampp\php\ext\php_xdebug.dll"
   xdebug.mode=develop,debug
   xdebug.client_host=127.0.0.1
   xdebug.client_port=9003
   xdebug.start_with_request=yes
   ```
4. Start XAMPP: `apache`

### Visual Studio Code

"Run and Debug" → "create a launch.json file" → PHP

To Debug: `Listen for Xdebug`

### PhpStorm

![](res/2022-05-25-14-16-24.png)
