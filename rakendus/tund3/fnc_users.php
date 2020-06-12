<?php
require("../../../../configuration.php");

//Sessiooni loomine/kasutamine
session_start();

function signUp($name, $surname, $email, $gender, $birthDate, $password ) {
	$notice = null;
	
    $conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUserName"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
    $statement = $conn->prepare("INSERT INTO vr20_users (firstname, lastname, birthdate, gender, email, password) VALUES (?, ?, ?, ?, ?, ?)");
	echo $conn->error;
	//krüpteerin parooli
	$options = ["cost" => 12, "salt" => substr(sha1(rand()), 0, 22)];
	$pwdhash = password_hash($password, PASSWORD_BCRYPT, $options);
	
    $statement->bind_param("sssiss", $name, $surname, $birthDate, $gender, $email, $pwdhash);
    //i - integer, s - string, d - decimal
	if($statement->execute()) {
		$notice = "Kasutaja edukalt loodud";
	} else {
		$notice = "Kasutaja loomine ebaõnnestus" . $statement->error;
	}

	
	return $notice;
}

function login($email, $password ) {
	$notice = null;
	
    $conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUserName"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
    $statement = $conn->prepare("SELECT id, firstname, lastname, password FROM vr20_users WHERE email=?");
	echo $conn->error;
    $statement->bind_param("s", $email);
    //i - integer, s - string, d - decimal
	$statement->bind_result($idFromDB, $firstnameFromDB, $lastnameFromDB, $passwordFromDB);
	if($statement->execute()) {
		$notice = "Sisselogimine edukas";
	} else {
		$notice = "Sisselogimine ebaõnnestus" . $statement->error;
	}
	if($statement->fetch()) {
		if(password_verify($password, $passwordFromDB)) {
			$_SESSION["userid"] = $idFromDB;
			$_SESSION["userFirstName"] = $firstnameFromDB;
			$_SESSION["userLastName"] = $lastnameFromDB;
			
			$statement->close();
			$conn->close();
			header("Location: home.php");
			exit();
		} else {
			$notice = "Parool on vigane";
		}
	} else {
		$notice = "Kasutajat (" . $email . ") ei leitud";
	}

	
	return $notice;
}

?>