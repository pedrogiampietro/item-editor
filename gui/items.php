<?php

include_once("./include/Database.php");

$db = Database::getInstance()->getConnection();

$itemServerIdList = array();
		
$itemServerIds = "SELECT serverId FROM items";
$stmt = $db->prepare($itemServerIds);
$stmt->execute();
$stmt->bind_result($serverId);
while ($stmt->fetch()) {
	$itemServerIdList[] = $serverId;
}
$stmt->close();

$counter = 0;
echo "<table>";
foreach ($itemServerIdList as $serverId) {
	if ($counter == 0) { echo "<tr>"; }
	echo "<td>";
	echo "<a href='?page=editor&subpage=item&serverId=$serverId'>$serverId</a>";
	echo "</td>";
	if ($counter == 10) { echo "<tr/>"; }
	$counter++;
	if ($counter == 11) { $counter = 0; }
}
echo "</table>";

?>