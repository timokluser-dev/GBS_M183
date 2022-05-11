<!DOCTYPE html> 
<html lang="de">

<?php
/*  Sollte diese Datei direkt aufgerufen werden, 
	wird man auf die Startseite weitergeleitet.
	(Ansonsten würde eine unerwünschte Fehlermeldung erzeugt.)
	Weitere Verbesserungen auf Webserver:
	* alle inc-Dateien in separaten Ordner, der für die Benutzer
	  nicht zugänglich ist. 
	* für Benutzer nur 'index.php' zulassen
*/	
if (!isset($_SESSION['status'])) {
	header('Location: ../index.php');
exit;
} else {
?> 

<head>
  <title><?php echo $titel ?></title> 
  <meta charset="UTF-8">
  <link rel="stylesheet" type="text/css" href="schutz/style.css">
</head> 
<body>

	<form method="post">
	<h1>Status: Konto anlegen</h1>
	E-Mail als Benutzerkonto:<br>
	<input type="email" size="40" maxlength="250" name="email" value="<?php echo $email ?>"> <br><br>
	 
	Passwort:<br>
	<input type="password" size="40"  maxlength="250" name="passw"><br>
	 
	Passwort wiederholen:<br>
	<input type="password" size="40" maxlength="250" name="passwConfirm"><br><br>
	 
	<input type="submit" name="KontoAnlegen" value="Konto anlegen">
	
	<hr>
	Ich möchte zur&uuml;ck zur Anmeldung wechseln.<br>
	<input type="submit" name="zurAnmeldung" value="Zur Anmeldung">
	</form>
 
</body>
</html>

<?php
}	
?>