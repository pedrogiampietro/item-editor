<?php

$name = "";

if (empty($_POST["name"])) {
	$name = "items";
}
else {
	$name = $_POST["name"];
}

$self = '?page=save';

echo "
<form method='post' action='$self'>
<input type='text' name='name' value='$name'/>
<input type='submit' name='submit' value='save'/>
</form>
";

if (!empty($_POST["name"])) {
	include_once("include/OTBWriter.php");
	$otbDir = "out/$name.otb";
	
	try {
	$otbWriter = new OTBWriter($otbDir);
	$otbWriter->save();
	}
	catch (Exception $e) {
		$message = $e->getMessage();
		echo "<font color='red'>error while saving $name.otb: $message</font>";
		die();
	}
	echo "<font color='green'>successfully saved $name.otb</font>";
}

?>