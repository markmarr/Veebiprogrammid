<?php
	require("fnc_news.php");
	
    $myName = "Markus Marrandi";
    $fullTimeNow = date("d.m.Y | H:i:s");
    $timeHTML = "<p>Lehe avamise hetkel oli: <strong>" . $fullTimeNow . "</strong></p>";
    $hourNow = date("H");

    $partOfDay = "Tundmatu";
    if($hourNow < 10) {
        $partOfDay = "Hommik";
    } else if ($hourNow >= 10 && $hourNow < 18) {
        $partOfDay = "Tööaeg";
    } else {
        $partOfDay = "Vabaaeg";
    }

    $semesterStart = new DateTime("2020-1-27");
    $semesterEnd = new DateTime("2020-6-22");
    $semesterDuration = $semesterStart->diff($semesterEnd);
    $today = new DateTime("now");
    $fromSemesterStart = $semesterStart->diff($today);
    $progressHTML = '<p>Semester on hoos! <meter value="' . $fromSemesterStart->format("%r%a") . '" min="0" max="' . $semesterDuration->format("%r%a") . '"</meter></p>'; 
    $picsDir = "../../pics/";
    $photoTypesAllowed = ["image/jpeg", "image/png"];
    $allFiles = array_slice(scandir($picsDir), 2);
    $unusedPhotos = $photoList = [];
	
	//Pane sobivad pildifailid massiivi
	foreach($allFiles as $file) {
        $fileInfo = getimagesize($picsDir . $file);
        if(in_array($fileInfo["mime"], $photoTypesAllowed) == True) {
            array_push($photoList, $file);
        }
		array_push($unusedPhotos, $file);
    }
	//echo count($unusedPhotos);
	
	function displayUnusedPhoto() {
		global $unusedPhotos;
		if(count($unusedPhotos) > 0) {
			global $picsDir;
			$photoNr = mt_rand(0, count($unusedPhotos) - 1);
			echo '<img src="' . $picsDir . $unusedPhotos[$photoNr] . '" alt="Juhuslik pilt">';
			//echo "\nDebug: ";
			//echo "photoNr>" . $photoNr . ", count>" . count($unusedPhotos);
			
			array_splice($unusedPhotos, $photoNr, 1);
		} else {
			echo "Error: No unique images available!\n";
		}
	}
?>
<!DOCTYPE html>
<html lang="et">
<head>
	<meta charset="utf-8">
	<title>Veebirakendused ja nende loomine 2020</title>
    <style>
        @keyframes example {
            0% {
                background-color:red; left:10px; top:0px;
            }
            50% {
                background-color:green; left:400px; top:0px;
            }
            100% {
                background-color:red; left:10px; top:0px;
            }
        }
        div.example {
            width: 100px;
            height: 100px;
            color: white;
            background-color: red;
            position: relative;
            text-align: center;
            vertical-align: middle;
            animation-name: example;
            animation-iteration-count: infinite;
            animation-direction: alternate;
            animation-duration: 1.5s;
        }
		
		body {
			<?php
			//$partOfDay = "Vabaaeg";
			//Sea lehekülje stiil vastavalt ajale
			if($partOfDay == "Hommik") {
				echo 'color: black; background-color: white;';
			} elseif($partOfDay == "Tööaeg") {
				echo 'color: black; background-color: beige;';
			} else {
				echo 'color: gainsboro; background-color: dimgray;';
			}
			?>
		}
    </style>
</head>
<body>
    <h1>PHP leht</h1>
    <?php
        echo $timeHTML;
    ?>
	<h3><?php echo $myName; ?></h3>
    <b> <?php echo $fullTimeNow; ?> </b>
    <br>
	<b>kuulilennuteetunneliluuk</b>
    <br>
    <p><?php echo "Käes on " . $partOfDay . "."; ?></p>
    <p>Animatsioon algab kell 18:00 ja lõppeb 24:00.</p>
    <div style="background-color: black; padding: 5px; margin: 5px">
    <?php
	
	//Kuva animatsioon, kui on vabaaeg
    if($partOfDay == "Vabaaeg") {
        include "animatsioon.html";
    }
    echo '</div>';
	
	//Kuva protsessiriba, kui sobilik..
	if($fromSemesterStart->format("%r%a") < 0) {
		echo '<strong>Semester pole veel alanud!</strong>';
	} elseif($fromSemesterStart->format("%r%a") > $semesterDuration->format("%r%a")) {
		echo '<strong>Semester on läbi!</strong>';
	} else {
		echo $progressHTML;
	}
	
	//Kuva 3 pilti
    displayUnusedPhoto($unusedPhotos);
	displayUnusedPhoto($unusedPhotos);
	displayUnusedPhoto($unusedPhotos);
	echo readNewsLimit(1);
    ?>

</body>
</html>