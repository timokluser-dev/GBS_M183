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
	<h1>Statuswechsel von Konto anlegen zu Anmeldung</h1>
	Sie haben das Konto erfolgreich angelegt: <?php echo $email ?><br>
	<hr/>
	Mit OK k&ouml;nnen sich anmelden. <br>
	<input type="submit" value="OK">
	</form>

</body>
</html>

<?php
}	
?>