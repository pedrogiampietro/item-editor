<?php

$serverId = 0;

if (empty($_POST["serverId"])) {
	$serverId = 100;
}
else {
	$serverId = $_POST["serverId"];
}

$self = '?page=editor&subpage=find';
echo "
<div>
<form method='post' action='$self'>
<input type='number' name='serverId' value='$serverId'/>
<input type='submit' name='submit' value='find'/>
</form>
";

if (!empty($_POST["serverId"])) {
	include_once("include/Database.php");
	$db = Database::getInstance()->getConnection();
		
	$findByServerId = "SELECT serverId, clientId FROM items where serverId=?";
	$stmt = $db->prepare($findByServerId);
	$stmt->bind_param('i', $serverId);
	$stmt->execute();
	$stmt->bind_result($dbServerId, $dbClientId);
	$stmt->fetch();
	$stmt->close();
	
	if($serverId != $dbServerId) {
		echo "could not find item with server id: $serverId";
		die();
	}
	
	$link = "?page=editor&subpage=item&serverId=$serverId";
	echo "<img src='spr/$dbClientId.png'/><br/>";
	echo "<a href='$link'>edit item $serverId</a>";
	
}

?>