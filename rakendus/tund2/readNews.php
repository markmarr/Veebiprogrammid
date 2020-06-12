<?php
require("fnc_news.php");


function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$newsHTML = readNews();

?>

<!DOCTYPE html>
<html lang="et">
<head>
	<meta charset="utf-8">
	<title>Veebirakendused ja nende loomine 2020</title>
    <style>
	.newselement {
		padding: 20px;
		background-color: #2c2f33;
		color: white;
		outline-style: dotted;
		outline-color: white;
	}
    </style>
</head>
<body>
    <h1>
    Uudiste nimekiri
    </h1>
    <p>See leht on valminud õppetöö raames.</p>
    <div>
        <?php
        echo $newsHTML;
        ?>
    </div>

</body>
</html>