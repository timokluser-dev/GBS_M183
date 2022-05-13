<!DOCTYPE html> 
<html lang="de">

<?php
/*  Sollte diese Datei direkt aufgerufen werden, 
	wird man auf die Startseite weitergeleitet.
	(Ansonsten würde der Webshop ohne Anmeldung angezeigt.)
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
	<h1>Status: Webshop</h1>

	<?php echo "Willkommen zum internen Bereich auf unserem Webshop!"."<br>"."<br>"; ?>
		
		<img src="schutz/Webshop.jpg" width="200" height="200"></img>
		
	<?php echo "<br>"."<br>"."Bildquelle: https://insight.nhtv.nl/tag/webshop/" ?>

	<hr>
	Sobald Sie den Webshop verlassen, erhalten Sie eine neue Session.
	Hier k&ouml;nnen Sie sich abmelden:<br>
	<input type="submit" name="abmelden" value="Abmelden"><br>
	</form> 
	
</body>

</html>

<?php
}	
?>
