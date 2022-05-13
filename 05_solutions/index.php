<?php
session_start();
include 'schutz' . DIRECTORY_SEPARATOR . 'modeldb.inc.php';
include 'schutz' . DIRECTORY_SEPARATOR . 'modelkunde.inc.php';

$errorMessage = '';
$showFormular = TRUE;
$error = FALSE;

// In der Datei modeldb.inc.php wird die Klasse 'Database' deklariert.
// Sie verf�gt �ber eine Methode 'getConnection', die den Verweis auf den Datenbankzugriff enth�lt.
$database = new Database(); 
$dbConnection = $database->getConnection();

// In der Datei 'modelkunde.inc.php' wird die Klasse 'Kunde' deklariert.
// Als Input wird der Verweis auf den Datenbankzugriff mitgegeben.
// Die Klasse enth�lt Lese- und Schreibfunktionen auf die Datenbank.
$kunde = new kunde($dbConnection); 
$kundetmp = $kunde;

// Solange die Sessionvariable nicht definiert ist, 
// ist man nicht angemeldet und man bleibt im Status 'Anmeldung': 
if (!isset($_SESSION['status'])) {
	$_SESSION['status'] = "Anmeldung";
	$_SESSION['angemeldet'] = FALSE; 
}

/*
echo "*** SESSION['status'] vor Automat: ".$_SESSION['status']." *** <br>";
$out = ($_SESSION['angemeldet']) ? "angemeldet" : "nicht angemeldet";
echo "*** SESSION['angemeldet'] vor Automat: ".$out." ***<br>";
*/

// Im Status 'Anmeldung' wechselt man durch...
// ...Eingabe der richtigen Credentials in den Status 'Webshop' 
//    (Beim Wechsel wird der Statuswechsel gezeigt.) oder
// ...Klick auf den Button 'zumKontoAnlegen' in den Status 'KontoAnlegen'. 
// Im Status 'Anmeldung' verbleibt man durch...
// ...Eingabe von falschen Credentials oder 
// ...Klick auf den Browserbutton 'Aktuelle Seite neu laden'.
if ($_SESSION['status'] == "Anmeldung") {
	$_SESSION['angemeldet'] = FALSE; 
	if (isset($_POST['zumKontoAnlegen'])) {
		$_SESSION['status'] = "KontoAnlegen";
	} 
}

// Im Status 'KontoAnlegen' wechselt man durch...
// ...richtige Eingabe von Mailadresse und des Passwortes (2x) in den Status 'Anmeldung' 
//    (Beim Wechsel wird der Statuswechsel gezeigt.) oder
// ...Klick auf den Button 'zur Anmeldung' in den Status 'Anmeldung'. 
// Im Status 'KontoAnlegen' verbleibt man durch...
// ...Fehler bei der Eingabe von Mailadresse und des Passwortes (2x) oder 
// ...Klick auf den Browserbutton 'Aktuelle Seite neu laden'.
if ($_SESSION['status'] == "KontoAnlegen") {
	$_SESSION['angemeldet'] = FALSE; 
	if (isset($_POST['zurAnmeldung'])) {
		$_SESSION['status'] = "Anmeldung";
	} 
}

// Im Status 'Webshop' wechselt man durch... 
// ...Klick auf den Button 'abmelden' in den Status 'Anmeldung'. 
// Im Status 'Webshop' verbleibt man durch...
// ...Klick auf den Browserbutton 'Aktuelle Seite neu laden'.
if ($_SESSION['angemeldet'] == TRUE && $_SESSION['status'] == "Webshop") {
	if (isset($_POST['abmelden'])) {
		session_regenerate_id();
		$_SESSION['status'] = "Anmeldung";
	}  
}

switch ($_SESSION['status']) {
	
    case "Anmeldung":
    	// Je nach Benutzereingaben erfolgt ein Zustandswechsel oder nicht
		$titel = 'Anmeldung';
		$email = (isset($_POST["email"]) && is_string($_POST["email"])) ? htmlspecialchars($_POST["email"]) : "";
		$passw = (isset($_POST["passw"]) && is_string($_POST["passw"])) ? htmlspecialchars($_POST["passw"]) : "";
		
		if (isset($_POST['anmelden']))  {
			// Formular wurde bereits einmal ausgef�llt 
			if(strlen($email) == 0) {
				$errorMessage = 'Bitte geben Sie ein Konto an. <br>';
				$error = true;
			} else {
				// Zugriff auf Datenbank: 
				$kundetmp = $kunde->getLoginInfoByEmail($email);
				//�berpr�fung des Passworts: 
				if ($kundetmp == TRUE && password_verify($passw, $kundetmp['passw'])) {
					// Anmeldung war erfolgreich, da Mailadresse vorhanden und Passwort stimmt 
					$_SESSION['kundeid'] = htmlspecialchars($kundetmp['id']);
					$_SESSION['angemeldet'] = TRUE; 
					$_SESSION['status'] = "Webshop";
					$_SESSION['email'] = $email;
					$_SESSION['sessionid'] = session_id();
					// Beim n�chsten Durchgang ist eine neue Session gefordert: 
					session_regenerate_id();
/*					Alternative: Geltungsdauer des Cookies im Browser auf 0 setzen
					if (ini_get("session.use_cookies")) {
					    $params = session_get_cookie_params();
					    // folgender Befehl ist n�tig, sonst wird 
					    // beim n�chsten Durchgang keine neue Session erzeugt:
					    setcookie(session_name(), '', 0, $params["path"],
				        	$params["domain"], $params["secure"], $params["httponly"]
					    );
					} else {
						echo "<br>Kein Cookie vorhanden.<br>";	
					}
*/		
					// In produktiven Systemen wird eine Kunden-Id aus der DB nie ausgegeben!
					include 'schutz' . DIRECTORY_SEPARATOR . 'Anmeldung2Webshop.inc.php';
					// nach der Anzeige des Statuswechsel soll das Formular nicht angezeigt werden:
					$showFormular = false;
				} else {
					// Anmeldung war nicht erfolgreich, da Mailadresse/Passwort falsch
			 		$errorMessage = "Eine Anmeldung war nicht m&ouml;glich. Haben Sie ein Konto? <br>";
			 	}
			}
		} 
		if($showFormular) {
			// wird nur gezeigt, wenn Mailadresse/Passwort nochmals eingegeben werden sollen
			include 'schutz' . DIRECTORY_SEPARATOR . 'Anmeldung.inc.php';
		}	
        break;
        
    case "KontoAnlegen":
    	// Je nach Benutzereingaben erfolgt ein Zustandswechsel oder nicht
		$titel = 'Konto anlegen';
		$email = (isset($_POST["email"]) && is_string($_POST["email"])) ? htmlspecialchars($_POST["email"]) : "";
		$passw = (isset($_POST["passw"]) && is_string($_POST["passw"])) ? htmlspecialchars($_POST["passw"]) : "";
		$passwConfirm = (isset($_POST["passwConfirm"]) && is_string($_POST["passwConfirm"])) ? htmlspecialchars($_POST["passwConfirm"]) : "";

		if (isset($_POST['KontoAnlegen'])) {
			// Formular wurde bereits einmal ausgef�llt 
			  
			if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				echo 'Bitte eine g&uuml;ltige E-Mail-Adresse eingeben<br>';
				$error = true;
			} 
			if(strlen($passw) == 0) {
				echo 'Bitte ein Passwort angeben. <br>';
				$error = true;
			}
			if($passw != $passwConfirm) {
				echo 'Die Passw&ouml;rter m&uuml;ssen &uuml;bereinstimmen<br>';
				$error = true;
			}
			 
			if(!$error) { 
			// Die Eingabedaten wurden validiert und sind i.O.
				if($kunde->getkundeByEmail($email) == true) {					
					echo 'Diese E-Mail-Adresse ist bereits vergeben.<br>';
					$error = true;
				} 
				 
				if(!$error) { 
					// Die Mailadresse ist noch frei und kann in die DB eingetrgen werden
					if($kunde->changekundePasswordByEmail($email, $passw)) { 
						include 'schutz' . DIRECTORY_SEPARATOR . 'KontoAnlegen2Anmeldung.inc.php';
						$_SESSION['status'] = "Anmeldung";
						// nach der Anzeige des Statuswechsel soll das Formular nicht angezeigt werden:
						$showFormular = false;
					} else {
						echo 'Beim Abspeichern ist ein Fehler aufgetreten.<br>';
					}
				} 
			}
		}
		if($showFormular) {
			// wird nur gezeigt, wenn Mailadresse/Passwort nochmals eingegeben werden sollen
			include 'schutz' . DIRECTORY_SEPARATOR . 'KontoAnlegen.inc.php';
		} 
        break;
        
    case "Webshop":
		$titel = 'WebShop';
		if ($_SESSION['angemeldet'] == TRUE) {
			include 'schutz' . DIRECTORY_SEPARATOR . 'Webshop.inc.php';
		} else echo "Sie sind nicht angemeldet."."<br>";
        break;
        		   
}

// In produktiven Systemen darf die Session-ID nie ausgegeben werden!
echo "<br><br>Aktuelle Session: ".session_id()."<br>"; 

?>
