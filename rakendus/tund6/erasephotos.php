<?php
	
	require("../../../../configuration.php");
	require("sessionmanager.php");
	SessionManager::sessionStart("vr20", 0, "/~markus.marrandi/", "tigu.hk.tlu.ee");
	
	//kas pole sisseloginud
	if(!isset($_SESSION["userid"])){
		//jõuga avalehele
		header("Location: page.php");
	}
	
	//login välja
	if(isset($_GET["logout"])){
		session_destroy();
		header("Location: page.php");
	}
	
	$deletepath = "";
	
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUserName"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		//$stmt = $conn->prepare("DELETE FROM vr20_photos WHERE filename = ?");
		$stmt = $conn->prepare("UPDATE vr20_photos SET deleted = now() WHERE id = ?");
		echo $conn->error;
		$stmt->bind_param("i", $_POST["delete"]);
		$stmt->execute();
		$stmt->close();
		$conn->close();
		echo "<body onload=\"parent.window.location.reload()\">";
	}

	require("../../../../configuration.php");
	
	require("fnc_gallery.php");
	
	$listhtml = readmyphotos();
	

?>
<!DOCTYPE html>
<html lang="et">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Veebirakendused ja nende loomine 2020</title>	
	<script src="javascript/modal.js" defer></script>
	<style>
	table {
	font-family: arial, sans-serif;
	border-collapse: collapse;
	width: 100%;
	}

	td, th {
	border: 1px solid #dddddd;
	text-align: left;
	padding: 8px;
	}

	tr:nth-child(even) {
	background-color: #dddddd;
	}
	.deletebutton {
		font-family: arial, sans-serif;
		background-color: rgba(255, 100, 100, 255);
		color: white;
		width: 200px;
		height: 50px;
		border-radius: 8px;
	}
		.deletebutton:hover {
		background-color: rgba(255, 0, 0, 255);
	}
	</style>
</head>
<body>
	<h1>Eemalda pilte</h1>
	<h3>Ei oska AJAX'it kasutada</h3>
	<h4>Sain ilma hakkama</h4>
	<p><?php echo $_SESSION["userFirstName"]. " " .$_SESSION["userLastName"] ."."; ?> Logi <a href="?logout=1">välja</a>!</p>
	<p>Tagasi <a href="home.php">avalehele</a>!</p>
	<hr>
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	<table>
	<?php
	echo $listhtml;
	?>
	</table>
	</form>

	<hr>
</body>
</html>