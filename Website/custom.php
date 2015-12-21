<?php
	if($_SERVER["REQUEST_METHOD"] == "GET" || $_POST['effect'] == "not")
	{
		require(__DIR__ . "/includes/config.php"); 
	    require(__DIR__ . "/templates/header.php");
	    require(__DIR__ . "/templates/custom_form.php");
	    require(__DIR__ . "/templates/footer.php");
	}

	else if($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['effect'] != "not")
	{
		function hex2rgb($hex) {
		   $hex = str_replace("#", "", $hex);

		   if(strlen($hex) == 3) {
		      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
		      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
		      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
		   } else {
		      $r = hexdec(substr($hex,0,2));
		      $g = hexdec(substr($hex,2,2));
		      $b = hexdec(substr($hex,4,2));
		   }
		   $r = sprintf("%03s", $r);
		   $g = sprintf("%03s", $g);
		   $b = sprintf("%03s", $b);
		   $rgb = array($r, $g, $b);
		   return $rgb; // returns an array with the rgb values
		}

		$color = hex2rgb($_POST['color']);

		$ipfile = fopen(__DIR__ . "/ipkey234986y/ip-config.txt", "r");
		$redirect = fread($ipfile,"25");
		fclose($ipfile);

		$dly = sprintf("%03s", $_POST['dly']);
		$rpt = sprintf("%02s", $_POST['rpt']);
		$len = sprintf("%02s", $_POST['len']);
		if($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['effect'] == 'kal') {
		$sec = ceil(($dly * 16 * $rpt) / 1000);
		}
		if($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['effect'] == 'cwp') {
		$sec = ceil(($dly * 16) / 1000);
		}
		if($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['effect'] == 'rnb') {
		$sec = ceil(($dly * 16 * 16) / 1000);
		}
		if($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['effect'] == 'rbc') {
		$sec = ceil(($dly * 5 * 16 * 16) / 1000) + 1;
		}
		if($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['effect'] == 'glo') {
		$sec = ceil(($rpt * ((50 * 20) + (50 * 20))) / 1000) + 1;
		}
		if($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['effect'] == 'trc') {
		$sec = ceil(($rpt * 10 * $dly) / 1000);
		}
		if($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['effect'] == 'cmt') {
		$sec = ceil(($rpt * $dly * 16) / 1000);
		}

		file_get_contents("http://" . $redirect . ":8081/?q=" . $color[0] . $color[1] . $color[2] . $_POST['effect'] . $dly . $rpt . $len);
		require(__DIR__ . "/includes/config.php"); 
		require(__DIR__ . "/templates/header.php");
		require(__DIR__ . "/templates/custom_form.php");
	    require(__DIR__ . "/templates/footer.php");
	}
?>