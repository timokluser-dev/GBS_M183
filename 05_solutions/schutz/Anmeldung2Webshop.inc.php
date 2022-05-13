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
	<h1>Statuswechsel von Anmeldung zu Webshop</h1>
	Sie wurden als Benutzer mit der Nummer <?php echo $_SESSION['kundeid'] ?> erfolgreich angemeldet. <br>
	Ihre jetzige Session <?php echo $_SESSION['sessionid'] ?> wird beendet.<br>
	Sie erhalten in unserem Webshop eine neue Session.<br> 
	<input type="submit" value="OK">
	</form>
	
</body>
</html>

<?php
}	
?>
