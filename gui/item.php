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
	
	echo "<div class='alert alert-success'>✓ Item deleted successfully!</div>";
	echo "<script>setTimeout(function() { window.location.href = '?page=editor&subpage=items'; }, 1500);</script>";
	return;
}

$addItem = false;

if (isset($_GET["addItem"])) {
	$addItem = true;
}

if (empty($_GET["serverId"]) && !$addItem) {
	echo "<div class='alert alert-error'>❌ Server ID not selected</div>";
	return;
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
	echo "
	<div style='margin-bottom: 20px;'>
		<a class='btn' href='?page=editor&subpage=item&serverId=$previousId'>◀ Previous Item</a>
		<a class='btn' href='?page=editor&subpage=item&serverId=$nextId'>Next Item ▶</a>
		<a class='btn' href='?page=editor&subpage=items' style='float: right;'>📋 Back to List</a>
	</div>
	";
}

if (!$addItem) {
	try {
		$item->loadByServerId($serverId);
	}
	catch (Exception $e) {
		$message = $e->getMessage();
		echo "<div class='alert alert-error'>❌ $message</div>";
		return;
	}
}
else {
	// Get the highest Server ID
	$topIdQuery = "SELECT serverId FROM items ORDER BY serverId DESC LIMIT 1";
	$stmt = $db->prepare($topIdQuery);
	$stmt->execute();
	$stmt->bind_result($dbServerId);
	$stmt->fetch();
	$stmt->close();
	
	$newServerId = $dbServerId+1;
	if ($newServerId < 100) {
		$newServerId = 100;
	}
	
	// Get the highest Client ID
	$topClientIdQuery = "SELECT clientId FROM items ORDER BY clientId DESC LIMIT 1";
	$stmt = $db->prepare($topClientIdQuery);
	$stmt->execute();
	$stmt->bind_result($dbClientId);
	$stmt->fetch();
	$stmt->close();
	
	$newClientId = $dbClientId+1;
	if ($newClientId < 100) {
		$newClientId = 100;
	}
	
	if (!$clone) {
		$item->setServerId($newServerId);
		$item->setClientId($newClientId);
		$item->setGroup(0);
		$item->setFlags(0);
	}
	else {
		try {
			$item->loadByServerId($serverId);
		}
		catch (Exception $e) {
			$message = $e->getMessage();
			echo "<div class='alert alert-error'>❌ $message</div>";
			return;
		}
		
		$item->setServerId($newServerId);
	}
	
	$item->save();
	header("Location: ?page=editor&subpage=item&serverId=$newServerId");
}

include_once("show.php");

?>