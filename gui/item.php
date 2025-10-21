<?php
include_once("./include/Item.php");
include_once("./include/Database.php");
$db = Database::getInstance()->getConnection();

if (!empty($_POST["delete"])) {
	$deleteServerId = $_POST["delete"];
	$deleteQuery = "DELETE FROM items where serverId=?";
	$stmt = $db->prepare($deleteQuery);
	$stmt->bind_param('i', $deleteServerId);
	$stmt->execute();
	$stmt->close();
}

$addItem = false;

if (isset($_GET["addItem"])) {
	$addItem = true;
}

if (empty($_GET["serverId"]) && !$addItem) {
	echo "<font color='red'>SERVER ID NOT SELECTED<font/>";
	die();
}

if (!empty($_GET["serverId"])) { $serverId = $_GET["serverId"]; }

if (!empty($_POST["clone"])) {
	$addItem = true;
	$serverId = $_POST["clone"];
}

$clone = false;
if ($addItem && isset($serverId)) { $clone = true; }


$item = new Item();

if (isset($serverId)) {
	$previousId = $serverId-1;
	$nextId = $serverId+1;
	echo "<a style='margin-right: 20px;' href='?page=editor&subpage=item&serverId=$previousId'>< previous item<a> <a href='?page=editor&subpage=item&serverId=$nextId'>next item ><a> <br/>";
}
if (!$addItem) {
	try {
		$item->loadByServerId($serverId);
	}
	catch (Exception $e) {
		$message = $e->getMessage();
		echo "<font color='red'>$message</font>";
		die();
	}
}
else {
	$topIdQuery = "SELECT serverId FROM items ORDER BY serverId DESC";
	$stmt = $db->prepare($topIdQuery);
	$stmt->execute();
	$stmt->bind_result($dbServerId);
	$stmt->fetch();
	$stmt->close();
	
	$newId = $dbServerId+1;
	if ($newId < 100) {
		$newId = 100;
	}
	
	if (!$clone) {
		$item->setServerId($newId);
		$item->setClientId(100);
		$item->setGroup(0);
		$item->setFlags(0);
	}
	else {
	try {
		$item->loadByServerId($serverId);
	}
	catch (Exception $e) {
		$message = $e->getMessage();
		echo "<font color='red'>$message</font>";
		die();
	}
	
	$item->setServerId($newId);
	}
	
	$item->save();
	header("Location: ?page=editor&subpage=item&serverId=$newId");
}

include_once("show.php");

?>