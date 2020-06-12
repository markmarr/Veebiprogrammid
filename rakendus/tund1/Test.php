<?php
	$list = ['one', 'two', 'three'];
	function printArr($arr) {
		$size = count($arr);
		for($i = 0; $i < $size; $i += 1) {
			echo $i . ' => ' . '"' . $arr[$i] . '"';
		}
		echo "\n";
	}
	function printRand() {
		echo mt_rand(0, 100);
		echo "\n";
	}
?>
<!DOCTYPE html>
<html lang="et">
<head>
	<meta charset="utf-8">
</head>
<body>
    <?php
	printArr($list);
	array_splice($list, 1, 1);
	printArr($list);
	printRand();
	printRand();
	printRand();
	printRand();
	printRand();
	printRand();
	?>
</body>
</html>