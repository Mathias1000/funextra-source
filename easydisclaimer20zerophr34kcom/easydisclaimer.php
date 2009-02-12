<?php
/*
+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
+                                                                   +
+ easyDisclaimer 2.0                                                +
+ Developed by zerophr34k                                           +
+ Support: 345715229                                                +
+ Released under Creative Commons Attribution 2.0 Germany License   +
+                                                                   +
+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
*/

/* Functions */

function checkCookie() {
$cookie=$_COOKIE['disclaimer_accept'];
if ($cookie != "1") {
echo "onLoad=\"tb_show('','#TB_inline?height=350&width=710&inlineId=disclaimer&modal=true','')\"";
}
}
function echoDisclaimer() {
$cookie=$_COOKIE['disclaimer_accept'];
if ($cookie != "1") {
?>
<div id="disclaimer" style="display:none; text-align:center;">
<p style="text-align:center"><h2>Disclaimer</h2></p>
<textarea cols="85" rows="15" align="center"><?php include "disclaimer-text.php"; ?></textarea>
<p style="text-align:center">
<input type="hidden" value="yes" name="accept"  />
<input type="submit" id="accept" value="Akzeptieren" onclick="killDisclaimer()" />
<input type="button" value="Nicht akzeptieren" onclick="window.location='http://www.google.com'" />
</p>
</div>
<?php
}
}
?>