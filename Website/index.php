<?php
    require(__DIR__ . "/includes/config.php"); 

    //New user redirected to login page

    if (empty($_SESSION["id"]))
    {
        redirect("login.php");
    }
    else if($_SESSION["id"] == "cs50rocks")
    {
        require(__DIR__ . "/templates/header.php");
		require(__DIR__ . "/templates/index_main.php");
        require(__DIR__ . "/templates/footer.php");
    }

?>