# M183 Summary P2

[TOC]


## SSL/TLS

### 1. Add Hosts

```cmd
code C:\Windows\System32\drivers\etc\hosts
```

### 2. Generate Cert

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

### 3. Import Cert

Run: `certmgr.msc`

→ 'Eigene Zertifikate' - Alle Aufgaben - Importieren (c:\xampp\apache\conf\ssl.crt\server.crt)

### Possibility to Crack Private Key

![](res/2022-03-30-14-24-07.png)

![](res/2022-03-30-14-22-58.png)

### Symmetric vs Asymmetric Keys

![](res/2022-04-03-14-06-44.png)

**Symmetric**

Bei der **symmetrischen Verschlüsselung**, auch **Secret-Key Verschlüsselung** genannt, verwendet man – im Gegensatz zur asymmetrischen Verschlüsselung – **nur einen Schlüssel zum Verschlüsseln** und **Entschlüsseln**. Man unterscheidet die **symmetrischen Verschlüsselungsverfahren** nach **Blockchiffre-basierten Verfahren** und **Stromchiffren**.

Source: [studyflix.de](https://studyflix.de/)

**Asymmetric**

Die **Asymmetrische Kryptographie**, auch **Public-Key Verschlüsselung** genannt, ist durch ein **Schlüsselpaar** charakterisiert, das aus einem **nicht-geheimen öffentlichen Schlüssel (public key)** und einem **geheimen privaten Schlüssel (private key)** besteht. Der **private Schlüssel** darf dabei **nicht** in absehbarer Zeit (Jahre) **aus** dem **öffentlichen Schlüssel berechnet** werden können.

Der **öffentliche Schlüssel** ermöglicht es, Daten für den Besitzer des **privaten Schlüssels** zu verschlüsseln, dessen **digitale Signatur** zu prüfen oder ihn zu authentisieren. Dagegen kann der Besitzer des **privaten Schlüssels** die zuvor mit dem **öffentlichen Schlüssel** verschlüsselten Daten **entschlüsseln** oder **digitale Signaturen** erzeugen.

→ Digitale Signatur valide = Integrität gegeben

Source: [studyflix.de](https://studyflix.de/)

### Special Case: SSL/TLS

![](res/2022-04-03-14-17-25.png)

→ Client has a temporary session key (public & private key)

## Secure Web Forms

### Template / HTML Elements

> :exclamation: Don't use `required` for easier testing of the form. :exclamation:

```html
<form method="post">
  <!-- INPUT FIELD -->
  <!-- set value: value="" -->
  <div>
    <label for="vorname">Vorname</label>
    <input type="text" name="vorname" id="vorname" value="John Doe" />
  </div>

  <!-- RADIO -->
  <!-- set value: checked -->
  <div>
    <input type="radio" name="anrede" id="herr" value="mr" checked>
    <label for="herr">Herr</label>

    <input type="radio" name="anrede" id="frau" value="ms">
    <label for="frau">Frau</label>
  </div>

  <!-- SINGLE SELECT -->
  <!-- set value: selected -->
  <div>
    <label for="anzahl">Anzahl Karten</label>
    <select name="anzahl" id="anzahl">
      <option value="" selected disabled>Bitte wählen</option>
      <option value="1">1</option>
      <option value="2" selected>2</option>
      <option value="3">3</option>
      <option value="4">4</option>
    </select>
  </div>

  <!-- MULTI SELECT -->
  <!-- set value: selected -->
  <div>
    <label for="sektion">Gewünschte Sektion im Stadion</label>
    <select name="sektion[]" size="4" multiple="multiple" id="sektion">
      <option value="nord">Nordkurve</option>
      <option value="sued" selected>Südkurve</option>
      <option value="haupt">Haupttribüne</option>
      <option value="gegen" selected>Gegentribüne</option>
    </select>
  </div>

  <!-- TEXTAREA -->
  <!-- set value: >...< -->
  <div>
    <label for="kommentare">Kommentare/Anmerkungen</label>
    <textarea cols="70" rows="10" name="kommentare" id="kommentare">Lorem ipsum ...</textarea>
  </div>

  <!-- CHECKBOX -->
  <!-- set value: checked -->
  <div>
    <label for="agb">Ich akzeptiere die AGB.</label>
    <input type="checkbox" name="agb" id="agb" value="true" checked />
  </div>

  <!-- SUMBIT -->
  <div>
    <button type="submit">Send</button>
  </div>
</form>
```

### Validation

Checklist:

1. Get Form Field
   ```php
   $field = Helpers::getFormField('field');
   $fieldInt = Helpers::getFormField('num', FieldTypes::int);

   $fieldLongText = Helpers::getFormFieldLongText('field');
   ```
2. Check type & (Check if has content [if required])
   ```php
   // type check is already done by Helpers::getFormField
   if (!$field) {
     array_push($errors, 'Field was not supplied');
   }
   ```
   _Manual Type Check_:
   1. `is_string()`
   2. `is_bool()`
   3. `is_float()`
   4. `is_numeric()`
   5. `is_int()`
   6. `is_array()`
   7. `is_object()`
3. Further validation (e.g. array includes)
   ```php
   $salutation = Helpers::getFormField('salutation');
   $salutations = ['mr','ms'];
   // $salutations = Helpers::getJson('data.json')->salutations;
   if (!Helpers::array_includes($salutation, $salutations)) {
     array_push($errors, 'Invalid Salutation supplied');
   }
   ```

### Example Form

```php
// TODO
```

### Helper

```php
// TODO
```

#### Regex

| Pattern                    | Regex                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 | Example                                 |
| -------------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- | --------------------------------------- |
| email simple               | `^[^@ \t\r\n]+@[^@ \t\r\n]+\.[^@ \t\r\n]+$`                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           | me@domain.ch                            |
| international phone number | `^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$`                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           | +41797364812 \| 0791234567              |
| swiss phone number         | `^(0|\(0\))?([1-9]\d{1})(\d{3})(\d{2})(\d{2})$`                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       | 0791234567                              |
| credit card number         | `(^4[0-9]{12}(?:[0-9]{3})?$)|(^(?:5[1-5][0-9]{2}|222[1-9]|22[3-9][0-9]|2[3-6][0-9]{2}|27[01][0-9]|2720)[0-9]{12}$)|(3[47][0-9]{13})|(^3(?:0[0-5]|[68][0-9])[0-9]{11}$)|(^6(?:011|5[0-9]{2})[0-9]{12}$)|(^(?:2131|1800|35\d{3})\d{11}$)`                                                                                                                                                                                                                                                                                                                                                                                                                                               | 4569403961014710                        |
| IPv4                       | `(\b25[0-5]|\b2[0-4][0-9]|\b[01]?[0-9][0-9]?)(\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)){3}`                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           | 192.168.1.1 \| 127.0.0.1                |
| IPv6                       | `(([0-9a-fA-F]{1,4}:){7,7}[0-9a-fA-F]{1,4}|([0-9a-fA-F]{1,4}:){1,7}:|([0-9a-fA-F]{1,4}:){1,6}:[0-9a-fA-F]{1,4}|([0-9a-fA-F]{1,4}:){1,5}(:[0-9a-fA-F]{1,4}){1,2}|([0-9a-fA-F]{1,4}:){1,4}(:[0-9a-fA-F]{1,4}){1,3}|([0-9a-fA-F]{1,4}:){1,3}(:[0-9a-fA-F]{1,4}){1,4}|([0-9a-fA-F]{1,4}:){1,2}(:[0-9a-fA-F]{1,4}){1,5}|[0-9a-fA-F]{1,4}:((:[0-9a-fA-F]{1,4}){1,6})|:((:[0-9a-fA-F]{1,4}){1,7}|:)|fe80:(:[0-9a-fA-F]{0,4}){0,4}%[0-9a-zA-Z]{1,}|::(ffff(:0{1,4}){0,1}:){0,1}((25[0-5]|(2[0-4]|1{0,1}[0-9]){0,1}[0-9])\.){3,3}(25[0-5]|(2[0-4]|1{0,1}[0-9]){0,1}[0-9])|([0-9a-fA-F]{1,4}:){1,4}:((25[0-5]|(2[0-4]|1{0,1}[0-9]){0,1}[0-9])\.){3,3}(25[0-5]|(2[0-4]|1{0,1}[0-9]){0,1}[0-9]))` | 2001:0db8:85a3:0000:0000:8a2e:0370:7334 |

Source: [ihateregex.io](https://ihateregex.io/)

---

![](res/2022-04-03-14-01-42.png)

## 
