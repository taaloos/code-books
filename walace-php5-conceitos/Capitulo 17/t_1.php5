<?php
$_pop3 	= imap_open("{serivor_pop3:110/pop3/notls}INBOX","user","senha");

echo "<h1>Mailboxes</h1>\n";
$folders = imap_listmailbox($mbox, "{pop.sao.terra.com.br:110/pop3/notls}", "*");

if ($folders == false) {
   echo "Call failed<br />\n";
} else {
   while (list ($key, $val) = each($folders)) {
       echo $val . "<br />\n";
   }
}

echo "<h1>Headers in INBOX</h1>\n";
$headers = imap_headers($mbox);

if ($headers == false) {
   echo "Call failed<br />\n";
} else {
   while (list ($key, $val) = each ($headers)) {
       echo $val . "<br />\n";
   }
}

imap_close($mbox);
?> 