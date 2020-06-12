<?php
require("../../../../configuration.php");
function saveNews($newsTitle, $newsContent) {
    //Loon andmebaasi ühenduse
    $response = null;
    $conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUserName"], $GLOBALS["serverPassword"], $GLOBALS["dataBase"]);
    $statement = $conn->prepare("INSERT INTO vr20_news (userid, title, content) VALUES (?, ?, ?)");
    echo $conn->error;
    $userid = 1;
    $statement->bind_param("iss", $userid, $newsTitle, $newsContent);
    //i - integer, s - string, d - decimal
    if($statement->execute())
	{
        $response = 1;
    }
    else
	{
        $response = 0;
        echo $statement->error;
    } 
    $statement->close();
    $conn->close();
    return $response;
}

function readNews() {
    //Loon andmebaasi ühenduse
    $response = "<hr>";
    $conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUserName"], $GLOBALS["serverPassword"], $GLOBALS["dataBase"]);
    $statement = $conn->prepare("SELECT title, content, created FROM vr20_news WHERE deleted IS NULL ORDER BY id DESC");
	echo $conn->error;
    $statement->bind_result($titleFromDB, $contentFromDB, $createdfromDB);
    $statement->execute();
    while($statement->fetch()) {
        //<h2>uudise pealkiri</h2>
		//<strong>kuupäev</strong>
        //<p>uudise sisu</p>
		$response .= '<div class="newselement">';
		$response .= '<h2>' . $titleFromDB . '</h2>';
		$response .= '<strong>' . $createdfromDB . '</strong>';
		$response .= '<br>';
		$response .= '<p>' . $contentFromDB . '</p>';
		$response .= '</div>';
    }
    if($response == null)
        echo "Uudised puuduvad!";
    $statement->close();
    $conn->close();
    return $response;
}

function readNewsLimit($limit)
{
	if($limit < 0)
		echo 'Error : request limit < 0';
	else
	{
		$response = "<hr>";
		$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUserName"], $GLOBALS["serverPassword"], $GLOBALS["dataBase"]);
		$statement = $conn->prepare("SELECT title, content, created FROM vr20_news WHERE deleted IS NULL ORDER BY id DESC LIMIT " . $limit);
		echo $conn->error;
		$statement->bind_result($titleFromDB, $contentFromDB, $createdfromDB);
		$statement->execute();
		while($statement->fetch()) {
			$response .= '<div class="newselement">';
			$response .= '<h2>' . $titleFromDB . '</h2>';
			$response .= '<strong>' . $createdfromDB . '</strong>';
			$response .= '<br>';
			$response .= '<p>' . $contentFromDB . '</p>';
			$response .= '</div>';
		}
		if($response == null)
			echo "Uudised puuduvad!";
		$statement->close();
		$conn->close();
		return $response;
	}
}
?>
