<?php
session_start();
/**
 * Profil
 * @author Sobak
 * @package User System
 */

require 'header.php'; // Dołącz początkowy kod HTML
require 'config.php'; // Dołącz plik konfiguracyjny i połączenie z bazą
require_once 'user.class.php';

/**
 * Tylko dla zalogowanych użytkowników
 */
if (!user::isLogged()) {
    echo '<p class="error">Przykro nam, ale ta strona jest dostępna tylko dla zalogowanych użytkowników.</p>';
}

else {
    $id = $_GET['id'];

    /**
     * Sprawdź czy użytkownik o podanym ID istnieje
     */
    $userExist = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM users WHERE id = '$id'"));

    // Użytkownik nie istnieje
    if ($userExist[0] == 0) {
        die ('<p>Przykro nam, ale użytkownik o podanym identyfikatorze nie istnieje.</p>');
    }

    /**
     * Użytkownik istnieje, tak więc pokaż jego profil
     */
    
    // Zapisz dane użytkownika o podanym ID, do zmiennej $profile
    $profile = user::getDataById ($id);
    
    echo '<h1>Profil użytkownika '.$profile['login'].'</h1>';

    echo '<b>Nick:</b> '.$profile['login'].'<br />';
    echo '<b>Email:</b> '.$profile['email'].'<br />';

}

require 'footer.php'; // Dołącz końcowy kod HTML

?>
