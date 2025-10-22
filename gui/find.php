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
<div class='card'>
	<div class='card-header'>
		<h2 class='card-title'>🔍 Find Item by Server ID</h2>
	</div>
	<div class='card-body'>
		<p style='margin-bottom: 20px; color: var(--text-color);'>Search for an item by its Server ID to quickly access and edit it.</p>
		
		<form method='post' action='$self' style='max-width: 500px;'>
			<div class='form-group'>
				<label class='form-label'>Server ID</label>
				<input type='number' name='serverId' value='$serverId' class='form-input' min='100' placeholder='Enter Server ID' required/>
			</div>
			<button type='submit' class='btn btn-primary' style='font-size: 16px; padding: 12px 30px;'>
				🔍 Search
			</button>
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
	
	echo "<div style='margin-top: 30px;'>";
	
	if($serverId != $dbServerId) {
		echo "<div class='alert alert-error'>❌ Could not find item with Server ID: <strong>$serverId</strong></div>";
	}
	else {
		$link = "?page=editor&subpage=item&serverId=$serverId";
		$spriteFile = "spr/$dbClientId.png";
		
		echo "
		<div class='alert alert-success'>✓ Item found!</div>
		<div class='card' style='max-width: 400px; text-align: center;'>
			<div class='card-body'>
				<div style='width: 128px; height: 128px; margin: 0 auto 20px; background: var(--bg-primary); border-radius: 8px; display: flex; align-items: center; justify-content: center; border: 2px solid var(--border-color);'>
		";
		
		if (file_exists($spriteFile)) {
			echo "<img src='$spriteFile' alt='Item $serverId' style='max-width: 100%; max-height: 100%; image-rendering: pixelated;'/>";
		} else {
			echo "<span style='color: var(--text-muted);'>No Sprite</span>";
		}
		
		echo "
				</div>
				<div style='margin-bottom: 20px;'>
					<p style='color: var(--text-white); font-size: 16px; margin: 5px 0;'><strong>Server ID:</strong> $serverId</p>
					<p style='color: var(--text-color); font-size: 14px; margin: 5px 0;'><strong>Client ID:</strong> $dbClientId</p>
				</div>
				<a href='$link' class='btn btn-primary' style='width: 100%; justify-content: center;'>
					✏️ Edit This Item
				</a>
			</div>
		</div>
		";
	}
	
	echo "</div>";
}

echo "
	</div>
</div>
";

?>