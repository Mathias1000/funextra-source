<?php

/*
Feel free to alter or change the layout in any manner you see fit.
I'd appreciate it if you left the 'Made by Bellatrix' line though.
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

if(isset($_POST['submit']))
{
    //Get all the user inputs
    $account = $_POST['account'];
    $passwordOld = $_POST['passwordOld'];
    $passwordNew = $_POST['passwordNew'];
    $passwordNew1 = $_POST['passwordNew1'];

    //Connect to accounts database
    $con = mysql_connect($aHost.":".$aPort, $aUsername, $aPass) or die(mysql_error());
    mysql_select_db($aDatabase) or die(mysql_error());

    //Remove bullshit from the user inputs(Sorta pointless as i use regex in a second...
    $account = mysql_real_escape_string(html_entity_decode(htmlentities($account)));
    $passwordOld = mysql_real_escape_string(html_entity_decode(htmlentities($passwordOld)));
    $passwordNew = mysql_real_escape_string(html_entity_decode(htmlentities($passwordNew)));
    $passwordNew1 = mysql_real_escape_string(html_entity_decode(htmlentities($passwordNew1)));

    //Die if account contains non-alphanumeric characters
    if(shitCheckerNum($account) == 1)
    {
      die("Accountname enthält ungültige Buchstaben!");
    }
    //Die if old password contains non-alphanumeric characters
    elseif(shitCheckerNum($passwordOld) == 1)
    {
      die("Passwort enthält ungültige Buchstaben!");
    }
    //Die if new password contains non-alphanumeric characters
    elseif(shitCheckerNum($passwordNew) == 1)
    {
      die("Neues Passwort enthält ungültige Buchstaben!");
    }
    //Die if new password(confirm) contains non-alphanumeric characters
    elseif(shitCheckerNum($passwordNew1) == 1)
    {
      die("Neues Passwort enthält ungültige Buchstaben!");
    }

    //If new pass and new pass(confirm) dont match, die.
    if($passwordNew != $passwordNew1)
    {
        die("Passwörter stimmen nicht überein!");
    }

    //Get acct num from db
	$passwortold = $_POST["passwordOld"];
	$user = strtoupper($account);
	$pwold = strtoupper($passwortold);
	$shapwold = sha1($user.":".$pwold);
    $query = "SELECT acct FROM accounts WHERE login = '".$account."' AND encrypted_password = '".$shapwold."'";

    $result = mysql_query($query) or die(mysql_error());
    $numrows = mysql_num_rows($result);

    echo "<tr><td align=center>";

    //If no rows, means invalid user/pass, die.
    if($numrows == 0)
    {
        die("Falscher Accountname oder falsches Passwort!");
    }

    //Change pass to new password
	$passwortnew = $_POST["passwordNew"];
	$user = strtoupper($account);
	$pwnew = strtoupper($passwortnew);
	$shapwnew = sha1($user.":".$pwnew);

    $query = "UPDATE accounts SET encrypted_password = '".$shapwnew."' WHERE login = '".$account."'";
    $result = mysql_query($query) or die(mysql_error());

    echo "Das Passwort für den Account '".$account."' wurde erfolgreich verändert!";

    echo "</td></tr>";

    //close mysql connection
    mysql_close();
}
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
    
    <title>Passwort Ändern</title>
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
            <tr class="head"><th colspan="2">Passwort Ändern</th></tr>
            <tr>
                <th>Accountname: </th><td align="center"><input class="button" type="text" name="account" value='' size="30" maxlength="16"/></td>
            </tr>
            <tr>
                <th>Altes Passwort: </th><td align="center"><input class="button" type="password" name="passwordOld" value='' size="30" maxlength="16"/></td>
            </tr>
            <tr>
            	<th>Neues Passwort: </th><td align="center"><input class="button" type="password" name="passwordNew" value='' size="30" maxlength="16"/></td>
            </tr>
            <tr>
                <th>Neues Passwort Wiederholen: </th><td align="center"><input class="button" type="password" name="passwordNew1" value='' size="30" maxlength="16"/></td>
            </tr>

				
				
        </table>
        <input type="button" class="button" value="Zurück" onClick="history.go(-1)" />
        <input type="submit" name="submit" value="Bestätigen" class="button"/>
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