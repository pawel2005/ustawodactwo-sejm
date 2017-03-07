<?php
/**
 * Skrypt i formularz rejestracji
 * @author Sobak
 * @package User System
 */

require 'header.php'; // Dołącz początkowy kod HTML
require 'config.php'; // Dołącz plik konfiguracyjny i połączenie z bazą
require_once 'user.class.php';

/**
 * Sprawdź czy formularz został wysłany
 */
if ($_POST['send'] == 1) {
    // Zabezpiecz dane z formularza przed kodem HTML i ewentualnymi atakami SQL Injection
    $login = mysql_real_escape_string(htmlspecialchars($_POST['login']));
    $pass = mysql_real_escape_string(htmlspecialchars($_POST['pass']));
    $pass_v = mysql_real_escape_string(htmlspecialchars($_POST['pass_v']));
    $email = mysql_real_escape_string(htmlspecialchars($_POST['email']));
    $email_v = mysql_real_escape_string(htmlspecialchars($_POST['email_v']));

    /**
     * Sprawdź czy podany przez użytkownika email lub login już istnieje
     */
    $existsLogin = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM users WHERE login='$login' LIMIT 1"));
    $existsEmail = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM users WHERE email='$email' LIMIT 1"));

    $errors = ''; // Zmienna przechowująca listę błędów które wystąpiły


    // Sprawdź, czy nie wystąpiły błędy
    if (!$login || !$email || !$pass || !$pass_v || !$email_v ) $errors .= '- Musisz wypełnić wszystkie pola<br />';
    if ($existsLogin[0] >= 1) $errors .= '- Ten login jest zajęty<br />';
    if ($existsEmail[0] >= 1) $errors .= '- Ten e-mail jest już używany<br />';
    if ($email != $email_v) $errors .= '- E-maile się nie zgadzają<br />';
    if ($pass != $pass_v)  $errors .= '- Hasła się nie zgadzają<br />';

    /**
     * Jeśli wystąpiły jakieś błędy, to je pokaż
     */
    if ($errors != '') {
        echo '<p class="error">Rejestracja nie powiodła się, popraw następujące błędy:<br />'.$errors.'</p>';
    }

    /**
     * Jeśli nie ma żadnych błędów - kontynuuj rejestrację
     */
    else {

        // Posól i zasahuj hasło
        $pass = user::passSalter($pass);

        // Zapisz dane do bazy
        mysql_query("INSERT INTO users (login, email, pass) VALUES('$login','$email','$pass');") or die ('<p class="error">Wystąpił błąd w zapytaniu i nie udało się zarejestrować użytkownika.</p>');

        echo '<p class="success">'.$login.', zostałeś zarejestrowany.
        <br /><a href="login.php">Logowanie</a></p>';
    }
}
?>

<form method="post" action="">
 <label for="login">Login:</label>
 <input maxlength="32" type="text" name="login" id="login" />

 <label for="pass">Hasło:</label>
 <input maxlength="32" type="password" name="pass" id="pass" />

 <label for="pass_again">Hasło (ponownie):</label>
 <input maxlength="32" type="password" name="pass_v" id="pass_again" />

 <label for="email">Email:</label>
 <input type="text" name="email" maxlength="50" id="email" />

 <label for="email_again">Email (ponownie):</label>
 <input type="text" maxlength="255" name="email_v" id="email_again" /><br />


 <input type="hidden" name="send" value="1" />
 <input type="submit" value="Zarejestruj" />
</form>

<?php
require 'footer.php'; // Dołącz końcowy kod HTML
?>
