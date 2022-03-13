<?php

/**
 * Listing 6.1 [PHP] Eine für Cross-Site-Scripting anfällige Seite - index.php
 *
 * @package Webhacking
 * @subpackage Kap06
 * @author Manuel Ziegler <contact@manuelziegler.de>
 * @version 1.00.00
 */
session_start();
?>
<!DOCTYPE html>
<html>

<head>
  <title>XSS-Demo</title>

  <head>

  <body>
    <form method="get">
      <h1>Demonstration XSS...</h1>
      <h1>...auf Web-Server mit Schwachstellen</h1>
      <h4>Lieber Kunde</h4>

      <?php
      if (isset($_GET['xss']))
        echo "Ihre Eingabe war:<br>", htmlspecialchars($_GET['xss']);
      ?>

      <p>Machen Sie eine Eingabe, wir schicken Ihnen diese wieder zurück.</p>

      <label for="xss">Eingabe:</label>
      <input type="text" name="xss" id="xss" placeholder="XSS">

      <button type="submit">an den Server schicken</button>
    </form>
  </body>

</html>
