<?php

$name = "";

if (empty($_POST["name"])) {
	$name = "items";
}
else {
	$name = $_POST["name"];
}

$self = '?page=load';

echo "
<form method='post' action='$self'>
<input type='text' name='name' value='$name'/>
<input type='submit' name='submit' value='load'/>
</form>
";

if (!empty($_POST["name"])) {
	include_once("include/OTBLoader.php");
	$otbDir = "in/$name.otb";
	
	try {
	$otbLoader = new OTBLoader($otbDir);
	$otbLoader->load();
	}
	catch (Exception $e) {
		$message = $e->getMessage();
		echo "<font color='red'>error while loading $name.otb: $message</font>";
		die();
	}
	echo "<font color='green'>successfully loaded $name.otb</font>";
}

?>