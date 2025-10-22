<?php

$serverId = $item->getServerId();

$self = "?page=editor&subpage=item&serverId=$serverId";

if (isset($_POST["save"])) {
	$itemToSave = new Item();
	
	$savedServerId = $_POST["serverId"];
	$itemToSave->setServerId($savedServerId);
	
	$savedClientId = 100;
	if (!empty($_POST["clientId"])) {
		$savedClientId = $_POST["clientId"];
		if ($savedClientId < 100) { $savedClientId = 100; }
	}
	$itemToSave->setClientId($savedClientId);
	
	
	$savedGroup = $_POST["group"];
	$itemToSave->setGroup($savedGroup);
	
	$savedFlags = 0;
	
	if (isset($_POST["unpassable"])) { $savedFlags += Item::FLAG_UNPASSABLE; }
	if (isset($_POST["blockMissiles"])) { $savedFlags += Item::FLAG_BLOCK_MISSILES; }
	if (isset($_POST["blockPathfinder"])) { $savedFlags += Item::FLAG_BLOCK_PATHFINDER; }
	if (isset($_POST["hasElevation"])) { $savedFlags += Item::FLAG_HAS_ELEVATION; }
	if (isset($_POST["useable"])) { $savedFlags += Item::FLAG_USEABLE; }
	if (isset($_POST["pickupable"])) { $savedFlags += Item::FLAG_PICKUPABLE; }
	
	if (isset($_POST["moveable"])) { $savedFlags += Item::FLAG_MOVEABLE; }
	if (isset($_POST["stackable"])) { $savedFlags += Item::FLAG_STACKABLE; }
	if (isset($_POST["floorChangeDown"])) { $savedFlags += Item::FLAG_FLOORCHANGEDOWN; }
	if (isset($_POST["floorChangeNorth"])) { $savedFlags += Item::FLAG_FLOORCHANGENORTH; }
	if (isset($_POST["floorChangeEast"])) { $savedFlags += Item::FLAG_FLOORCHANGEEAST; }
	if (isset($_POST["floorChangeSouth"])) { $savedFlags += Item::FLAG_FLOORCHANGESOUTH; }
	
	if (isset($_POST["floorChangeWest"])) { $savedFlags += Item::FLAG_FLOORCHANGEWEST; }
	if (isset($_POST["alwaysOnTop"])) { $savedFlags += Item::FLAG_ALWAYSONTOP; }
	if (isset($_POST["readable"])) { $savedFlags += Item::FLAG_READABLE; }
	if (isset($_POST["rotable"])) { $savedFlags += Item::FLAG_ROTABLE; }
	if (isset($_POST["hangable"])) { $savedFlags += Item::FLAG_HANGABLE; }
	if (isset($_POST["hookEast"])) { $savedFlags += Item::FLAG_HOOK_EAST; }
	
	if (isset($_POST["hookSouth"])) { $savedFlags += Item::FLAG_HOOK_SOUTH; }
	if (isset($_POST["cannotDecay"])) { $savedFlags += Item::FLAG_CANNOTDECAY; }
	if (isset($_POST["allowDistread"])) { $savedFlags += Item::FLAG_ALLOWDISTREAD; }
	if (isset($_POST["unused"])) { $savedFlags += Item::FLAG_UNUSED; }
	if (isset($_POST["clientCharges"])) { $savedFlags += Item::FLAG_CLIENTCHARGES; }
	if (isset($_POST["ignoreLook"])) { $savedFlags += Item::FLAG_IGNORE_LOOK; }
	
	$itemToSave->setFlags($savedFlags);
	
	if (isset($_POST["speed"]) && $_POST["speed"] != "") {
		$savedSpeed = $_POST["speed"];
		if ($savedSpeed < 0) { $savedSpeed = 0; }
		$itemToSave->addAttribute(Item::attrSpeed, $savedSpeed);
	}
	if (isset($_POST["lightLevel"]) && $_POST["lightLevel"] != "") {
		$savedLightLevel = $_POST["lightLevel"];
		if ($savedLightLevel < 0) { $savedLightLevel = 0; }
		if ($savedLightLevel > 255) { $savedLightLevel = 255; }
		$itemToSave->addAttribute(Item::attrLightLevel, $savedLightLevel);
		if (empty($_POST["lightColor"])) {
			$itemToSave->addAttribute(Item::attrLightColor, 0);
		}
	}
	if (isset($_POST["lightColor"]) && $_POST["lightColor"] != "") {
		$savedLightColor = $_POST["lightColor"];
		if ($savedLightColor < 0) { $savedLightColor = 0; }
		if ($savedLightColor > 255) { $savedLightColor = 255; }
		$itemToSave->addAttribute(Item::attrLightColor, $savedLightColor);
		if (empty($_POST["lightLevel"])) {
			$itemToSave->addAttribute(Item::attrLightLevel, 0);
		}
	}
	if (isset($_POST["topOrder"]) && $_POST["topOrder"] != "") {
		$savedTopOrder = $_POST["topOrder"];
		if ($savedTopOrder < 0) { $savedTopOrder = 0; }
		$itemToSave->addAttribute(Item::attrTopOrder, $savedTopOrder);
	}
	
	$itemToSave->save();
	header("Location: ?page=editor&subpage=item&serverId=$savedServerId");
}

$clientId = $item->getClientId();
$group = $item->getGroup();

$flagUnpassable = $flagBlockMissiles = $flagBlockPathfinder = $flagHasElevation = $flagUseable = $flagPickupable = $flagMoveable = $flagStackable = $flagFloorChangeDown = $flagFloorChangeNorth = $flagFloorChangeEast = $flagFloorChangeSouth = $flagFloorChangeWest = $flagAlwaysOnTop = $flagReadable = $flagRotable = $flagHangable = $flagHookEast = $flagHookSouth = $flagCannotDecay = $flagAllowDistread = $flagUnused = $flagClientCharges = $flagIgnoreLook = false;
$flags = $item->getFlags();

if ($flags & Item::FLAG_UNPASSABLE) { $flagUnpassable = true; }
if ($flags & Item::FLAG_BLOCK_MISSILES) { $flagBlockMissiles = true; }
if ($flags & Item::FLAG_BLOCK_PATHFINDER) { $flagBlockPathfinder = true; }
if ($flags & Item::FLAG_HAS_ELEVATION) { $flagHasElevation = true; }
if ($flags & Item::FLAG_USEABLE) { $flagUseable = true; }
if ($flags & Item::FLAG_PICKUPABLE) { $flagPickupable = true; }
if ($flags & Item::FLAG_MOVEABLE) { $flagMoveable = true; }
if ($flags & Item::FLAG_STACKABLE) { $flagStackable = true; }
if ($flags & Item::FLAG_FLOORCHANGEDOWN) { $flagFloorChangeDown = true; }
if ($flags & Item::FLAG_FLOORCHANGENORTH) { $flagFloorChangeNorth = true; }
if ($flags & Item::FLAG_FLOORCHANGEEAST) { $flagFloorChangeEast = true; }
if ($flags & Item::FLAG_FLOORCHANGESOUTH) { $flagFloorChangeSouth = true; }
if ($flags & Item::FLAG_FLOORCHANGEWEST) { $flagFloorChangeWest = true; }
if ($flags & Item::FLAG_ALWAYSONTOP) { $flagAlwaysOnTop = true; }
if ($flags & Item::FLAG_READABLE) { $flagReadable = true; }
if ($flags & Item::FLAG_ROTABLE) { $flagRotable = true; }
if ($flags & Item::FLAG_HANGABLE) { $flagHangable = true; }
if ($flags & Item::FLAG_HOOK_EAST) { $flagHookEast = true; }
if ($flags & Item::FLAG_HOOK_SOUTH) { $flagHookSouth = true; }
if ($flags & Item::FLAG_CANNOTDECAY) { $flagCannotDecay = true; }
if ($flags & Item::FLAG_ALLOWDISTREAD) { $flagAllowDistread = true; }
if ($flags & Item::FLAG_UNUSED) { $flagUnused = true; }
if ($flags & Item::FLAG_CLIENTCHARGES) { $flagClientCharges = true; }
if ($flags & Item::FLAG_IGNORE_LOOK) { $flagIgnoreLook = true; }

$speed = $item->getAttributeValueByName(Item::attrSpeed);
$lightLevel = $item->getAttributeValueByName(Item::attrLightLevel);
$lightColor = $item->getAttributeValueByName(Item::attrLightColor);
$topOrder = $item->getAttributeValueByName(Item::attrTopOrder);

echo "
<div class='action-buttons mb-3'>
	<form method='post' action='$self' style='display:inline;'>
		<input type='hidden' name='clone' value='$serverId'/>
		<button type='submit' class='btn btn-primary'>📋 Clone Item</button>
	</form>
	<form method='post' action='$self' style='display:inline;'>
		<input type='hidden' name='delete' value='$serverId'/>
		<button type='submit' class='btn btn-danger' onclick='return confirm(\"Are you sure you want to delete this item?\");'>🗑️ Delete Item</button>
	</form>
</div>

<div class='item-editor'>
	<div class='item-preview'>
		<h3 style='color: var(--text-white); margin-bottom: 20px;'>Item Preview</h3>
		<div class='item-preview-sprite'>
";

$spriteFile = "spr/$clientId.png";
if (file_exists($spriteFile)) {
	echo "<img src='$spriteFile' alt='Item $serverId'/>";
} else {
	echo "<span style='color: var(--text-muted);'>No Sprite</span>";
}

echo "
		</div>
		<div class='item-info'>
			<div class='item-info-row'>
				<span class='item-info-label'>Server ID</span>
				<span class='item-info-value'>$serverId</span>
			</div>
			<div class='item-info-row'>
				<span class='item-info-label'>Client ID</span>
				<span class='item-info-value'>$clientId</span>
			</div>
			<div class='item-info-row'>
				<span class='item-info-label'>Group</span>
				<span class='item-info-value'>$group</span>
			</div>
		</div>
	</div>
	
	<div>
		<form method='post' action='$self'>
			<input type='hidden' name='save'/>
			
			<div class='card mb-2'>
				<div class='card-header'>
					<h3 class='card-title'>Basic Information</h3>
				</div>
				<div class='card-body'>
					<div class='grid grid-2'>
						<div class='form-group'>
							<label class='form-label'>Server ID</label>
							<input type='number' name='serverId' value='$serverId' class='form-input' readonly/>
						</div>
						
						<div class='form-group'>
							<label class='form-label'>Client ID (Sprite)</label>
							<input type='number' name='clientId' value='$clientId' class='form-input'/>
						</div>
						
						<div class='form-group'>
							<label class='form-label'>Group</label>
							<select name='group' class='form-select'>
								<option value='0'"; if($group == 0) { echo " selected"; } echo ">None</option>
								<option value='1'"; if($group == 1) { echo " selected"; } echo ">Ground</option>
								<option value='2'"; if($group == 2) { echo " selected"; } echo ">Container</option>
								<option value='11'"; if($group == 11) { echo " selected"; } echo ">Splash</option>
								<option value='12'"; if($group == 12) { echo " selected"; } echo ">Fluid</option>
							</select>
						</div>
					</div>
				</div>
			</div>
			
			<div class='card mb-2'>
				<div class='card-header'>
					<h3 class='card-title'>Item Flags</h3>
				</div>
				<div class='card-body'>
					<div class='form-checkbox-group'>
";

$flags_array = [
	['name' => 'unpassable', 'label' => 'Unpassable', 'checked' => $flagUnpassable],
	['name' => 'blockMissiles', 'label' => 'Block Missiles', 'checked' => $flagBlockMissiles],
	['name' => 'blockPathfinder', 'label' => 'Block Pathfinder', 'checked' => $flagBlockPathfinder],
	['name' => 'hasElevation', 'label' => 'Has Elevation', 'checked' => $flagHasElevation],
	['name' => 'useable', 'label' => 'Useable', 'checked' => $flagUseable],
	['name' => 'pickupable', 'label' => 'Pickupable', 'checked' => $flagPickupable],
	['name' => 'moveable', 'label' => 'Moveable', 'checked' => $flagMoveable],
	['name' => 'stackable', 'label' => 'Stackable', 'checked' => $flagStackable],
	['name' => 'floorChangeDown', 'label' => 'Floor Change Down', 'checked' => $flagFloorChangeDown],
	['name' => 'floorChangeNorth', 'label' => 'Floor Change North', 'checked' => $flagFloorChangeNorth],
	['name' => 'floorChangeEast', 'label' => 'Floor Change East', 'checked' => $flagFloorChangeEast],
	['name' => 'floorChangeSouth', 'label' => 'Floor Change South', 'checked' => $flagFloorChangeSouth],
	['name' => 'floorChangeWest', 'label' => 'Floor Change West', 'checked' => $flagFloorChangeWest],
	['name' => 'alwaysOnTop', 'label' => 'Always On Top', 'checked' => $flagAlwaysOnTop],
	['name' => 'readable', 'label' => 'Readable', 'checked' => $flagReadable],
	['name' => 'rotable', 'label' => 'Rotable', 'checked' => $flagRotable],
	['name' => 'hangable', 'label' => 'Hangable', 'checked' => $flagHangable],
	['name' => 'hookEast', 'label' => 'Hook East', 'checked' => $flagHookEast],
	['name' => 'hookSouth', 'label' => 'Hook South', 'checked' => $flagHookSouth],
	['name' => 'cannotDecay', 'label' => 'Cannot Decay', 'checked' => $flagCannotDecay],
	['name' => 'allowDistread', 'label' => 'Allow Distread', 'checked' => $flagAllowDistread],
	['name' => 'unused', 'label' => 'Unused', 'checked' => $flagUnused],
	['name' => 'clientCharges', 'label' => 'Client Charges', 'checked' => $flagClientCharges],
	['name' => 'ignoreLook', 'label' => 'Ignore Look', 'checked' => $flagIgnoreLook],
];

foreach ($flags_array as $flag) {
	echo "
						<div class='checkbox-wrapper'>
							<input type='checkbox' id='{$flag['name']}' name='{$flag['name']}'"; if ($flag['checked']) { echo " checked"; } echo "/>
							<label for='{$flag['name']}'>{$flag['label']}</label>
						</div>
	";
}

echo "
					</div>
				</div>
			</div>
			
			<div class='card mb-2'>
				<div class='card-header'>
					<h3 class='card-title'>Attributes</h3>
				</div>
				<div class='card-body'>
					<div class='grid grid-2'>
						<div class='form-group'>
							<label class='form-label'>Speed</label>
							<input type='number' name='speed' value='$speed' class='form-input'/>
						</div>
						
						<div class='form-group'>
							<label class='form-label'>Top Order</label>
							<input type='number' name='topOrder' value='$topOrder' class='form-input'/>
						</div>
						
						<div class='form-group'>
							<label class='form-label'>Light Level (0-255)</label>
							<input type='number' name='lightLevel' value='$lightLevel' min='0' max='255' class='form-input'/>
						</div>
						
						<div class='form-group'>
							<label class='form-label'>Light Color (0-255)</label>
							<input type='number' name='lightColor' value='$lightColor' min='0' max='255' class='form-input'/>
						</div>
					</div>
				</div>
			</div>
			
			<div class='action-buttons'>
				<button type='submit' class='btn btn-success' style='font-size: 16px; padding: 12px 30px;'>
					💾 Save Changes
				</button>
				<a href='?page=editor&subpage=items' class='btn' style='font-size: 16px; padding: 12px 30px;'>
					❌ Cancel
				</a>
			</div>
		</form>
	</div>
</div>
";