# Summary P2

[__TOC__]

## SSL/TLS

### Add Hosts

```cmd
code C:\Windows\System32\drivers\etc\hosts
```

### Generate Cert

Use the script: `c:\xampp\apache\makecert.bat`  

:arrow_right: As Administrator

```cmd
cd c:\xampp\apache\ && .\makecert.bat
```

Country Name (2 letter code) [AU]: `CH`  
State or Province Name (full name) [Some-State]: `SG`  
Locality Name (eg, city) []: `St.Gallen`  
Organization Name (eg, company) [Internet Widgits Pty Ltd]: `GBSSG`  
Organizational Unit Name (eg, section) []: `IT`  
Common Name (e.g. server FQDN or YOUR name) []: `www.web.m183`  
Email Address []: `noreply@gbssg.ch` 

:arrow_right: **PUBLIC**: `c:\xampp\apache\conf\ssl.crt\server.crt`  
:arrow_right: **PRIVATE**: `c:\xampp\apache\conf\ssl.key\server.key`

### Import Cert

Run: `certmgr.msc`

→ 'Eigene Zertifikate' - Alle Aufgaben - Importieren (c:\xampp\apache\conf\ssl.crt\server.crt)


