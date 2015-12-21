This is ip

<?php
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
    		$secretip = $_SERVER['REMOTE_ADDR'];
//    		query("UPDATE iptable SET ipupdate = ?", $secretip);
    		$ipfile = fopen(__DIR__ . "/../ipsecretfolder/ipaddress.txt", "w");
    		fwrite($ipfile, $secretip);
    		fclose($ipfile);
    }
?>