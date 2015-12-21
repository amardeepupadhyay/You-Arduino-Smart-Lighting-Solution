<?php

	require(__DIR__ . "/includes/config.php"); 

	if($_SERVER["REQUEST_METHOD"] == "GET")
	{
		//Redirect to login form
		render("login_form.php", ["title" => "Log In"]);
	}
	else if ($_SERVER["REQUEST_METHOD"] == "POST")
	{
		if(empty($_POST["password"]))
		{
			apologize("You must provide a good password");
		}
		else if ($_POST["password"] = "cs50rocks")
		{
			$_SESSION["id"] = "cs50rocks";
		}
		redirect("/");
	}
?>