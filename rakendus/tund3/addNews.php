<?php
require("fnc_news.php");


function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$newsTitle = null;
$newsContent = null;
$newsError = null;



if(isset($_POST["newsBtn"]))
{
    if(isset($_POST["newsTitle"]) and !empty(test_input($_POST["newsTitle"])))
    {
		$newsTitle = test_input($_POST["newsTitle"]);
	}
    else
	{
		$newsError = "Uudise pealkiri on sisestamata! ";
	}
    if(isset($_POST["newsEditor"]) and !empty(test_input($_POST["newsEditor"])))
    {
		$newsContent = test_input($_POST["newsEditor"]);
	}
    else
	{
		$newsError .= "Uudise sisu on sisestmata!";
	}
    if(empty($newsError))
	{
		$response = saveNews($newsTitle, $newsContent);
		if($response == 1)
		{
			$newsError = "Uudis on salvestatud!";
		}
		else
		{
			$newsError = "Uudist ei saanud salvestada!";
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
    Uudise lisamine
    </h1>
    <p>See leht on valminud õppetöö raames.</p>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		<label>Uudise pealkiri: </label><br>
		<input type="text" name="newsTitle" placeholder="Uudise pealkiri" value="<?php echo $newsTitle; ?>"><br>
		<label>Uudise sisu</label><br>
		<textarea name="newsEditor" placeholder="Uudis" rows="10" cols="40"><?php echo $newsContent; ?></textarea>
		<br>
		<input type="submit" name="newsBtn" value="Salvesta uudis!">
		<span><?php echo $newsError; ?></span>
	</form>

</body>
</html>