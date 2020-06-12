<?php
	require("../../../../configuration.php");
	require("sessionmanager.php");
	
	//Algatan sessiooni
	SessionManager::sessionStart("vr20", 0, "/~markus.marrandi/", "tigu.hk.tlu.ee");
	
	if(!isset($_SESSION["userid"])) {
		//Tagasi page.php
		header("Location: page.php");
	}
	
	//logi välja
	if(isset($_GET["logout"]))
	{
		session_destroy();
		header("Location: page.php");
	}

?>
<!DOCTYPE html>
<html lang="et">
<head>
	<meta charset="utf-8">
	<title>Veebirakendused ja nende loomine 2020</title>
</head>
<body>
	<h1>Meie äge koduleht</h1>
	<p>See leht on valminud õppetöö raames!</p>
    <hr>
	<p><a href="?logout=1">Logi välja</a></p>
	
</body>
</html>