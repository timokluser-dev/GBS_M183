# M183 Summary P3

[TOC]

## ...

## API

```mermaid
classDiagram
    Database .. Kunde
    Kunde .. db_kunde

    class Database {
        -string $host
        -string $db_name
        -string $db_kundename
        -string $db_passw
        -PDO $connection

        +__construct()
        +getConnection() PDO
    }

    class Kunde {
        -string $table_name

        +__construct(PDO $db)
        +getKundeByEmail(string $emailLoc) array~db_kunde~
        +getEmailAndRightsByEmail(string $emailLoc) array~db_kunde~
        +getLoginInfoByEmail(string $emailLoc) array~db_kunde~
        +getKundeInfoByEmail(string $emailLoc) array~db_kunde~
        +getAllKunde() db_kunde[]
        +setKundePasswordByEmail(string $emailLoc, string $newPasswordLoc) bool
    }

    class db_kunde {
        INT id
        VARCHAR email
        VARCHAR passw
        VARCHAR vorname?
        VARCHAR nachname?
        TIMESTAMP created_at
        TIMESTAMP updated_at?
        VARCHAR aclallaccounts?
        VARCHAR passwortcode?
        TIMESTAMP passwortcode_time?
    }
```

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
