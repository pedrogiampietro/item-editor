<?php
include_once("./include/OTB.php");
include_once("./include/Database.php");

$self = "?page=otb";

$otb = new OTB();
$otb->load();

$major = $otb->getMajor();
$minor = $otb->getMinor();
$build = $otb->getBuild();
$csd = $otb->getCsd();

if (isset($_POST['save'])) {
	$otbToSave = new OTB();
	if (isset($_POST["major"])) {
		$majorToSave = $_POST["major"];
		if ($majorToSave < 0) { $majorToSave = 0; }
		$otbToSave->setMajor($majorToSave);
	}
	if (isset($_POST["minor"])) {
		$minorToSave = $_POST["minor"];
		if ($minorToSave < 0) { $minorToSave = 0; }
		$otbToSave->setMinor($minorToSave);
	}
	if (isset($_POST["build"])) {
		$buildToSave = $_POST["build"];
		if ($buildToSave < 0) { $buildToSave = 0; }
		$otbToSave->setBuild($buildToSave);
	}
	if (isset($_POST["csd"])) {
		$csdToSave = $_POST["csd"];
		if (strlen($csdToSave) > 128) { $csdToSave = substr($csdToSave, 0, 128); }
		$otbToSave->setCsd($csdToSave);
	}
	try {
		$otbToSave->save();
	}
	catch (Exception $e) {
		$message = $e->getMessage();
		echo "<font color='red'>$message</font>";
		die();
	}
	header("Location: $self");
}

echo "
<form method='post' action='$self'>
<input name='save' type='hidden'>
<label>MAJOR:</label><input name='major' type='number' value='$major'/><br/>
<label>MINOR:</label><input name='minor' type='number' value='$minor'/><br/>
<label>BUILD:</label><input name='build' type='number' value='$build'/><br/>
<label>CSD:</label><input name='csd' type='text' value='$csd'/><br/>
<input type='submit' name='submit' value='save otb metadata'/>
</form>
";

if (isset($_POST["clearDB"])) {
	$db = Database::getInstance()->getConnection();
	
	$deleteQueryOTB = 'delete from otb';
	$stmt = $db->prepare($deleteQueryOTB);
	$stmt->execute();
	$stmt->close();
	
	$deleteQueryItems = 'delete from items';
	$stmt = $db->prepare($deleteQueryItems);
	$stmt->execute();
	$stmt->close();
	
	header("Location: $self");	
}

echo "
<form method='post' action='$self'>
<input name='clearDB' type='hidden'>
<input type='submit' name='submit' value='unload otb'/>
</form>
";

?>