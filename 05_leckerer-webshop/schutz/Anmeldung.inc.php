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
	<br><?php echo $errorMessage ?>
	<h1>Status: Anmeldung</h1>
	E-Mail als Benutzerkonto:<br>
	<input type="email" size="40" maxlength="250" name="email" value="<?php echo $email ?>"><br><br>
	 
	Passwort:<br>
	<input type="password" size="40"  maxlength="250" name="passw"><br>
	 
	<input type="submit" name="anmelden" value="Anmelden"><br><br>

	<hr>
	Ich habe noch kein Konto und m&ouml;chte eines anlegen.<br>
	<input type="submit" name="zumKontoAnlegen" value="Zum Konto Anlegen">
	</form> 
	
</body>
</html>

<?php
}	
?>