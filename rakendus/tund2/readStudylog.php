<?php
require("fnc_studylog.php");

$newsHTML = null;

if(isset($_POST["Btn"]))
{
    if(isset($_POST["entrycount"]))
    {
		if($_POST["entrycount"] != -1)
			$newsHTML = readStudylogLimit($_POST["entrycount"]);
		else
			$newsHTML = readStudylog();
	}
    else
	{
		$newsHTML = readStudylog();
	}
}
?>

<!DOCTYPE html>
<html lang="et">
<head>
	<meta charset="utf-8">
	<title>Veebirakendused ja nende loomine 2020</title>
    <style>
	table {
		font-family: arial, sans-serif;
		border-collapse: collapse;
		width: 100%;
	}
	
	select, input {
		font-family: arial, sans-serif;
		padding: 4px;
		border-collapse: collapse;
	}

	th {
		border: 2px solid #2c2f33;
		background-color: #7289da;
		color: white;
		text-align: left;
		padding: 8px;
	}
	
	td {
		border: 2px solid #2c2f33;
		color: white;
		text-align: left;
		padding: 8px;
	}

	tr:nth-child(even) {
		background-color: #23272a;
		border: 2px solid #2c2f33;
	}
	
	tr:nth-child(odd) {
		background-color: #2c2f33;
		border: 2px solid #23272a;
	}
    </style>
</head>
<body>
    <h1>
    Õppelogi
    </h1>
    <p>See leht on valminud õppetöö raames.</p>
	<div>
		<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			<select name="entrycount">
				<option value="" selected disabled>mitu kuvada</option>
				<option value="1">1</option> 
				<option value="5">5</option> 
				<option value="25">25</option> 
				<option value="50">50</option> 
				<option value="100">100</option> 
				<option value="200">200</option> 
				<option value="500">500</option> 
				<option value="1000">1000</option> 
				<option value="-1">kõik</option> 
			</select>
			<input type="submit" name="Btn" value="Esita">
		</form>
	</div>
    <div>
        <?php
        echo $newsHTML;
        ?>
    </div>

</body>
</html>