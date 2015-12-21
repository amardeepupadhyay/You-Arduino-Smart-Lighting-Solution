<?php
	if($_SERVER["REQUEST_METHOD"] == "GET")
	{
	    require(__DIR__ . "/includes/config.php"); 
	    require(__DIR__ . "/templates/header.php");
	    require(__DIR__ . "/templates/preset_form.php");
	    require(__DIR__ . "/templates/footer.php");
    }

    else if($_SERVER["REQUEST_METHOD"] == "POST")
    {
    	$query = $_POST['effect'];
		$ipfile = fopen(__DIR__ . "/ipkey234986y/ip-config.txt", "r");
		$redirect = fread($ipfile,"25");

    	switch($query) {
    		case "redcircle":
    			file_get_contents("http://" . $redirect . ":8081/?q=255000000cwp050");
    			break;
			case "greencircle":
    			file_get_contents("http://" . $redirect . ":8081/?q=000255000cwp050");				
    			break;
			case "bluecircle":
				file_get_contents("http://" . $redirect . ":8081/?q=000000255cwp050");
				break;
			case "trcwhite":
    			file_get_contents("http://" . $redirect . ":8081/?q=127127127trc050");
    			break;
			case "trcred":
				file_get_contents("http://" . $redirect . ":8081/?q=127000000trc050");
				break;
			case "trcblue":
				file_get_contents("http://" . $redirect . ":8081/?q=000000127trc050");
				break;
			case "rnb":
	    		file_get_contents("http://" . $redirect . ":8081/?q=000000000rnb020");
	    		break;
    		case "rbc":
    			file_get_contents("http://" . $redirect . ":8081/?q=000000000rbc020");
    			break;
			case "tcr":
				file_get_contents("http://" . $redirect . ":8081/?q=000000000tcr050");	
				break;
			case "glo":
				file_get_contents("http://" . $redirect . ":8081/?q=000128128glo00005");	
				break;
			case "kal":
				file_get_contents("http://" . $redirect . ":8081/?q=255069000kal10005");	
				break;
			case "cmt":
				file_get_contents("http://" . $redirect . ":8081/?q=008232222cmt1000508");	
				break;
    	}

	    require(__DIR__ . "/includes/config.php"); 
	    require(__DIR__ . "/templates/header.php");
	    require(__DIR__ . "/templates/preset_form.php");
	    require(__DIR__ . "/templates/footer.php");


    }
?>