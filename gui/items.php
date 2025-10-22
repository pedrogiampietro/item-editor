<?php

include_once("./include/Database.php");

$db = Database::getInstance()->getConnection();

$itemList = array();
		
$itemQuery = "SELECT serverId, clientId FROM items ORDER BY serverId ASC";
$stmt = $db->prepare($itemQuery);
$stmt->execute();
$stmt->bind_result($serverId, $clientId);
while ($stmt->fetch()) {
	$itemList[] = array('serverId' => $serverId, 'clientId' => $clientId);
}
$stmt->close();

$totalItems = count($itemList);

echo "<div class='mb-2' style='padding: 15px; background: var(--bg-primary); border-radius: 8px; border: 1px solid var(--border-color);'>";
echo "<p style='color: var(--text-white); font-size: 16px; margin: 0;'>📊 Total Items: <strong style='color: var(--color-primary);'>$totalItems</strong></p>";
echo "</div>";

echo "<div class='grid-items' style='margin-top: 20px;'>";

foreach ($itemList as $item) {
	$serverId = $item['serverId'];
	$clientId = $item['clientId'];
	$spriteFile = "spr/$clientId.png";
	$spriteExists = file_exists($spriteFile);
	
	echo "
	<a href='?page=editor&subpage=item&serverId=$serverId' class='item-card'>
		<div class='item-sprite'>
	";
	
	if ($spriteExists) {
		echo "<img src='$spriteFile' alt='Item $serverId' title='Server ID: $serverId | Client ID: $clientId'/>";
	} else {
		echo "<span style='color: var(--text-muted); font-size: 12px;'>No Sprite</span>";
	}
	
	echo "
		</div>
		<div class='item-id'>ID: $serverId</div>
	</a>
	";
}

echo "</div>";

?>