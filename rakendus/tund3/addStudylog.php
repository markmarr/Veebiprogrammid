<?php
require("fnc_studylog.php");

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$course = null;
$activity = null;
$time = null;

$message = "";

if(isset($_POST["Btn"]))
{
    if(isset($_POST["course"]) and !empty(test_input($_POST["course"])))
    {
		$course = test_input($_POST["course"]);
	}
    else
	{
		$message = "Õppeaine pole valitud ";
	}
    if(isset($_POST["activity"]) and !empty(test_input($_POST["activity"])))
    {
		$activity = test_input($_POST["activity"]);
	}
    else
	{
		$message .= "Tegevus pole valitud! ";
	}
	if(isset($_POST["time"]) and !empty(test_input($_POST["time"])))
    {
		$time = test_input($_POST["time"]);
	}
    else
	{
		$message .= "Aeg pole valitud! ";
	}
    if(empty($message))
	{
		$response = saveEntry($course, $activity, $time);
		if($response == 1)
		{
			$message = "Õnnestus!";
		}
		else
		{
			$message = "Viga!";
		}
	}   
}
?>

<!DOCTYPE html>
<html lang="et">
<head>
	<meta charset="utf-8">
	<title>Veebirakendused ja nende loomine 2020</title>
    <style>

    </style>
</head>
<body>
    <h1>
    Õppelogisse lisamine
    </h1>
    <p>See leht on valminud õppetöö raames.</p>
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		<select name="course">
			<option value="" selected disabled>õppeaine</option>
			<option value="1">Veebirakendused</option> 
			<option value="2">Disaini alused</option> 
			<option value="3">Psühholoogia</option> 
			<option value="4">Videomängude disain</option> 
		</select>
		<select name="activity">
			<option value="" selected disabled>tegevus</option>
			<option value="1">iseseisev materjali omandamine</option> 
			<option value="2">koduste ülesannete lahendamine</option> 
			<option value="3">kordamine</option> 
			<option value="4">rühmatöö</option> 
		</select>
		<input type="number" min=".25" max="24" step=".25" placeholder="kestvus" name="time">
		<input type="submit" name="Btn" value="Salvesta!">
	</form>
	<p><?php echo $message; ?></p>

</body>
</html>