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
	<h1>Status: Webshop</h1>
    Wilkommen zum internen Bereich auf unserem Webshop!<br />
    <br />

    <img src="schutz/Webshop.jpg" alt="Webshop"><br />

    <hr>

    Sobald Sie den Webshop verlassen, erhalten Sie eine neue Session.<br />
    Hier können Sie sich abmelden:<br />

    <input type="hidden" name="abmelden">
	<input type="submit" value="OK">
	</form>

</body>
</html>

<?php
}	
?>
