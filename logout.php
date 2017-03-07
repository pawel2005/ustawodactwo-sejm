<?php
session_start();
/**
 * Skrypt wylogowania
 * @author Sobak
 * @package User System
 */

require 'header.php'; // Dołącz początkowy kod HTML

session_destroy();
$_SESSION = array ();
echo '<p class="success">Zostałeś wylogowany! Możesz przejść na <a href="index.php">stronę główną</a></p>';

require 'footer.php'; // Dołącz końcowy kod HTML
?>
