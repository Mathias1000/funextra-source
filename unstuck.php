<?php

/*
Nothing needs to be changed, feel free to alter anything.
Please leave the 'Made by Bellatrix' line.
*/

echo "<html><body>";

include('_config.php');
global $aHost, $aDatabase, $aPort, $aUsername, $aPass, $cHost, $cDatabase, $cPort, $cUsername, $cPass;

function shitChecker($str)
{
    $var = preg_match('/[^a-zA-Z]/', $str);
    return $var;
}
function shitCheckerNum($str)
{
  $var = preg_match('/[^a-zA-Z0-9]/', $str);
  return $var;
}

//if unstuck button is pressed, verify and query db if valid
if(isset($_POST['submit']))
{
    //players account name, password and character name
    $account = $_POST['account'];
    $password = $_POST['password'];
    $character = $_POST['character'];
    
    //Connect to character database
    $con = mysql_connect($cHost.":".$cPort, $cUsername, $cPass) or die(mysql_error());
    mysql_select_db($cDatabase) or die(mysql_error());

    //Remove bullshit characters from user entered data
    $character = mysql_real_escape_string(html_entity_decode(htmlentities($character)));

    //check for non-alpha characters
    if(shitChecker($character) == 1)
    {
      die("Charaktername enthält ungültige Zeichen!");
    }

    //Get acct id
    $query = "SELECT acct FROM characters WHERE name = '".$character."'";

    $result = mysql_query($query) or die(mysql_error());
    $numrows = mysql_num_rows($result);

    echo "<tr><td align=center>";

    //if no rows exist, the character does not exist
    if($numrows == 0)
    {
        die("Dieser Charakter existiert nicht auf diesem Account!");
    }

    $row = mysql_fetch_array($result);
    $acct = $row[0];

    mysql_close();

    //Connect to accounts database
    $con = mysql_connect($aHost.":".$aPort, $aUsername, $aPass) or die(mysql_error());
    mysql_select_db($aDatabase) or die(mysql_error());

    //Remove bullshit characters from user entered data
    $account = mysql_real_escape_string(html_entity_decode(htmlentities($account)));
    $password = mysql_real_escape_string(html_entity_decode(htmlentities($password)));

    if(shitCheckerNum($account) == 1)
    {
      die("Account enthält ungültige Zeichen!");
    }
    if(shitCheckerNum($password) == 1)
    {
      die("Passwort enthält ungültige Zeichen!");
    }
	$passwort = $_POST["password"];
	$user = strtoupper($account);
	$pw = strtoupper($passwort);
	$shapw = sha1($user.":".$pw); 
    $query = "SELECT login, acct, encrypted_password FROM accounts WHERE login ='".$account."' AND encrypted_password = '".$shapw."' AND acct = '".$acct."'";

    $result = mysql_query($query) or die(mysql_error());
    $numrows = mysql_num_rows($result);

    //if no rows, user entered invalid data
    if ($numrows == 0)
    {
        die("Accountname oder Passwort sind falsch!");
    }

    //update the character table to set the character to hearth location
    $query = "update characters SET positionX = bindpositionX, positionY = bindpositionY, positionZ = bindpositionZ, mapId = bindmapId, zoneId = bindzoneId WHERE name = '".$character."'";

    mysql_query($query) or die(mysql_error());

    echo "Der Charakter '".$character."' wurde freigesetzt!";

    echo "</td></tr>";

    //close mysql connection
    mysql_close();
}
//if page is loaded, display unstuck form
else
{
}


?>


<html xmlns="http://www.w3.org/1999/xhtml" >
<head>

    <!--- easyDisclaimer Start --->
    <script type="text/javascript">
    function killDisclaimer() {
    tb_remove()
    document.cookie = "disclaimer_accept=1";
    }
    </script>
    <script type="text/javascript" src="thickbox/jquery.js"></script>
    <script type="text/javascript" src="thickbox/thickbox.js"></script>
    <link rel="stylesheet" href="thickbox/thickbox.css" type="text/css" media="screen" />
    <!--- easyDisclaimer End --->
    
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta name="robots" content="INDEX,FOLLOW">
    
    <title>Charakter Freisetzen</title>
    <meta http-equiv="Pragma" content="no-cache"/>
    <meta http-equiv="Cache-Control" content="no-cache"/>
    <style type="text/css" media="screen">@import url(server_stats.css);</style>
    <!--[if lt IE 7.]>
    <script defer type="text/javascript" src="pngfix.js"></script>
    <![endif]-->
</head>
<?php include ("easydisclaimer.php"); ?>
<body <?php checkCookie() ?> >
<?php echoDisclaimer() ?>


    <center>
    <div class="logo"></div>
    <div style="width:300px">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <table width="100%" border="0" cellspacing="1" cellpadding="3">
            <tr class="head"><th colspan="2">Charakter Freisetzen</th></tr>
            <tr>
                <th>Accountname: </th><td align="center"><input class="button" type="text" name="account" value='' size="30" maxlength="16"/></td>
            </tr>
            <tr>
                <th>Charaktername: </th><td align="center"><input class="button" type="text" name="character" value='' size="30" maxlength="16"/></td>
            </tr>
            <tr>
            	<th>Passwort: </th><td align="center"><input class="button" type="password" name="password" value='' size="30" maxlength="16"/></td>
            </tr>


				
				
        </table>
        <input type="button" class="button" value="Zurück" onClick="history.go(-1)" />
        <input type="submit" name="submit" value="Freisetzen" class="button"/>
        </form>

		<?php
        if (!empty($error)){
            echo '<table width="100%" border="0" cellspacing="1" cellpadding="3"><tr><td class="error" align="center">';
            foreach($error as $text)
                echo $text.'</br>';
            echo '</td></tr></table>';
        };
        if (!empty($msg)){
            echo '<table width="100%" border="0" cellspacing="1" cellpadding="3"><tr><td align="center">';
            foreach($msg as $text)
                echo $text.'</br>';
            echo '</td></tr></table>';
            exit();
        };
        ?>

    </div>
    </center>

</table>
</body>
</html>