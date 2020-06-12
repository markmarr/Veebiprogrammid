<?php
require("../../../../configuration.php");

function courseName($c) {
	switch ($c) {
    case 1:
        return 'Veebirakendused';
        break;
    case 2:
        return 'Disaini alused';
        break;
    case 3:
        return 'Psühholoogia';
        break;
	case 4:
        return 'Videomängude disain';
        break;
	default:
		return "Error:nr->Name";
}
}

function activityName($c) {
	switch ($c) {
    case 1:
        return 'iseseisev materjali omandamine';
        break;
    case 2:
        return 'koduste ülesanne lahendamine';
        break;
    case 3:
        return 'kordamine';
        break;
	case 4:
        return 'rühmatöö';
        break;
	default:
		return "Error:nr->Name";
}
}

function saveEntry($course, $activity, $time) {
    //Loon andmebaasi ühenduse
    $response = null;
    $conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUserName"], $GLOBALS["serverPassword"], $GLOBALS["dataBase"]);
    $statement = $conn->prepare("INSERT INTO vr20_studylog (course, activity, time) VALUES (?, ?, ?)");
    echo $conn->error;
    $statement->bind_param("iid", $course, $activity, $time);
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

function readStudylog() {
    //Loon andmebaasi ühenduse
	//tavapärane limiit on 1000
    $response = '<table class="studylog"><tr><th>Kursus</th><th>Tegevus</th><th>Kestvus</th><th>Kuupäev</th></tr>';
    $conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUserName"], $GLOBALS["serverPassword"], $GLOBALS["dataBase"]);
    $statement = $conn->prepare("SELECT course, activity, time, day FROM vr20_studylog ORDER BY course DESC LIMIT 1000");
	echo $conn->error;
    $statement->bind_result($courseFromDB, $activityFromDB, $timeFromDB, $dayFromDB);
    $statement->execute();
    while($statement->fetch()) {
		$response .= '<tr class="entry infoshard">';
		$response .= '<td class="course infoshard">' . coursename($courseFromDB) . '</td>';
		$response .= '<td class="activity infoshard">' . activityName($activityFromDB) . '</td>';
		$response .= '<td class="time infoshard">' . $timeFromDB . 'h</td>';
		$response .= '<td class="day infoshard">' . $dayFromDB . '</td>';
		$response .= '</tr>';
    }
	$response .= '</table>';
    if($response == '<table class="studylog"><tr><th>Kursus</th><th>Tegevus</th><th>Kestvus</th><th>Kuupäev</th></tr></table>')
	{
		echo "Uudised puuduvad!";
		$response = null;
	}
    $statement->close();
    $conn->close();
    return $response;
}

function readStudylogLimit($limit)
{
	if($limit < 0)
		echo 'Error : request limit < 0';
	else
	{
		$response = '<table class="studylog"><tr><th>Kursus</th><th>Tegevus</th><th>Kestvus</th><th>Kuupäev</th></tr>';
		$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUserName"], $GLOBALS["serverPassword"], $GLOBALS["dataBase"]);
		$statement = $conn->prepare("SELECT course, activity, time, day FROM vr20_studylog ORDER BY course DESC LIMIT " . $limit);
		echo $conn->error;
		$statement->bind_result($courseFromDB, $activityFromDB, $timeFromDB, $dayFromDB);
		$statement->execute();
		while($statement->fetch()) {
		$response .= '<tr class="entry infoshard">';
		$response .= '<td class="course infoshard">' . coursename($courseFromDB) . '</td>';
		$response .= '<td class="activity infoshard">' . activityName($activityFromDB) . '</td>';
		$response .= '<td class="time infoshard">' . $timeFromDB . 'h</td>';
		$response .= '<td class="day infoshard">' . $dayFromDB . '</td>';
		$response .= '</tr>';
		}
		$response .= '</table>';
		if($response == '<table class="studylog"><tr><th>Kursus</th><th>Tegevus</th><th>Kestvus</th><th>Kuupäev</th></tr></table>')
		{
			echo "Uudised puuduvad!";
			$response = null;
		}
		$statement->close();
		$conn->close();
		return $response;
	}
}
?>
