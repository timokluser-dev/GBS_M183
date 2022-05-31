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
  <title><?php echo $titel; ?></title> 
  <meta charset="UTF-8">
  <link rel="stylesheet" type="text/css" href="schutz/style.css">
</head> 
<body>

	<form method="post">
	<h1>Status: Kontoverwaltung</h1>
    Willkommen im internen Bereich beim Kontodaten lesen!<br />
    <br />

    Hier sind die Kontodaten:<br>

    <br>

    <?php foreach ($_SESSION['users'] as $user): ?>
        <div class="container__items--no-my">
            <p>***</p>
            <p>E-Mail: <?php echo $user['email']; ?></p>
            <p>Vorname: <?php echo $user['vorname']; ?></p>
            <p>Nachname: <?php echo $user['nachname']; ?></p>
            <p>Created At: <?php echo $user['created_at']; ?></p>
            <p>Updated At: <?php echo $user['updated_at']; ?></p>  
            <p>ACL - All Accounts: <?php echo $user['aclallaccounts']; ?></p>
            <p>***</p>
        </div>
    <?php endforeach; ?>

	<hr>

    Zurück zum Webshop<br />

    <input type="hidden" name="back_to_webshop">
	<input type="submit" value="OK">
	</form>

</body>
</html>

<?php
}	
?>
