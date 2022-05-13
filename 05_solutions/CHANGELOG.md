# CHANGELOG

- `index.php`: PHP include` von `\` auf `DIRECTORY_SEPARATOR` geändert, sodass auch Linux & macOS die Pfade richtig auflöst.
- `index.php`: "Aktuelle Session:" ans Ende der Webpage verschoben, sodass keine Konflikte mit dem `set-cookie` header der PHP Session besteht.
- `index.php`: session_regenerate_id() vor das import Anmeldung2Webshop.inc.php geschoben
- `index.php`: Vor session_regenerate_id() die alte Session ID in eine Session Variable gespeichert
- `schutz/Anmeldung2Webshop.inc.php`: die Session ID wird neu aus der Session Variable gelesen
- `index.php`: Bei der Abmeldung (`isset($_POST['abmelden'])` noch `session_regenerate_id()` hinzugefügt 
