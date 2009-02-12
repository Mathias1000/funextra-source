<?php
/*---------------------------------------------------+
| Account-Create-Page  (for ascent)
+----------------------------------------------------+
| Copyright  2008 by www.shadow-war.de
| http://www.shadow-war.de/
+----------------------------------------------------+
| Dieser Copyrighthiweis darf nicht entfernt werden!
| - - - - - - - - - - - - - - - - - - - - - - - - -
|  - - - - - - - - - - - - - - - - - - - - - - - - -
+----------------------------------------------------*/
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Account create page</title>
<style type="text/css">
<!--
body {
	background-color: #060a15;
}
body,td,th {
	color: #de771c;
}
a {
	color:#de771c;
	text-decoration:underline;
}
a:hover {
	color:#e9ae7a;
	text-decoration:none;
}
-->
</style></head>

<body>
<center><table width="724" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><table width="724" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><img src="Bilder/Acc.-Page-by-www.shadow-war.de_03.jpg" width="724" height="218" /></td>
      </tr>
      <tr>
        <td><table width="724" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top" width="137"><img src="Bilder/Acc.-Page-by-www.shadow-war.de_05.jpg" width="137" height="379" /></td>
            <td align="center" valign="top" width="415" background="Bilder/Acc.-Page-by-www.shadow-war.de_06.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">

<?php
include 'config.php';
$verbindung = mysql_connect("$host", "$dbuser", "$dbpasswort")
or die("Verbindung zur Datenbank konnte nicht hergestellt werden");

mysql_select_db("$datenbank") or die ("Datenbank konnte nicht ausgewhlt werden");

$username = $_POST["username"];
$passwort = $_POST["passwort"];
$passwort2 = $_POST["passwort2"];
$email = $_POST["email"];
$tbc = $_POST["tbc"];

if($passwort != $passwort2 OR $username == "" OR $passwort == "" OR $email == "")
    {
    echo "Eingabefehler. Bitte alle Felder korekt ausfllen. <a href=\"index.php\">Zurck</a><br>";
    exit;
    }
$passwort = $_POST["passwort"];
$user = strtoupper($username);
$pw = strtoupper($passwort);
$shapw = sha1($user.":".$pw);


$result = mysql_query("SELECT acct FROM accounts WHERE login LIKE '$username'");
$menge = mysql_num_rows($result);

if($menge == 0)
    {
    $eintrag = "INSERT INTO accounts (login, encrypted_password, email, flags) VALUES ('$username', '$shapw', '$email', '$tbc')";
    $eintragen = mysql_query($eintrag);
	
    if($eintragen == true)
        {
        echo "Der Account <b>$username</b> wurde erstellt.<br><br>
		  Realmlist:<br>set realmlist $realmlist
		 ";
        }
    else
        {
        echo "Fehler beim Speichern des Benutzernames.<br> <a href=\"index.php\">Zurck</a><br>";
        }


    }

else
    {
    echo "Benutzername schon vorhanden. <a href=\"index.php\">Zurck</a><br>";
    }
?>

  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</td>
            <td valign="top" width="172"><img src="Bilder/Acc.-Page-by-www.shadow-war.de_07.jpg" width="172" height="379" /></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><img src="Bilder/Acc.-Page-by-www.shadow-war.de_08.jpg" width="724" height="306" border="0" usemap="#Map" /></td>
      </tr>
    </table></td>
  </tr>
</table>
</center>

<map name="Map" id="Map"><area shape="rect" coords="19,52,696,77" href="http://www.shadow-war.de" /></map></body>
</html>