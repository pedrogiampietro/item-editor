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

echo "
<form method='post' action='$self' style='display:inline; float:right;'>
<input type='hidden' name='clone' value='$serverId'/>
<input type='submit' name='submit' value='clone this item'/>
</form>
<form method='post' action='$self' style='display:inline; float:right;'>
<input type='hidden' name='delete' value='$serverId'/>
<input type='submit' name='submit' value='delete this item'/>
</form>
<hr/>
";

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
<div style='width: 64px; height: 64px; position: relative'>
<img style='position: absolute; margin: auto; top: 0; left: 0; right: 0; bottom: 0;' src='spr/$clientId.png'/>
</div>
<br/><br/>
";

echo "
<form method='post' action='$self'>
<input type='hidden' name='save'/>
<td><label>SERVER ID:</label><input type='number' name='serverId' value='$serverId' readonly/><br/>
<label>CLIENT ID:</label><input type='number' name='clientId' value='$clientId'/><br/>
<label>GROUP:</label><select name='group'>
";
echo "<option value='0'"; if($group == 0) { echo " selected"; } echo ">none</option>";
echo "<option value='1'"; if($group == 1) { echo " selected"; } echo ">ground</option>";
echo "<option value='2'"; if($group == 2) { echo " selected"; } echo ">container</option>";
echo "<option value='11'"; if($group == 11) { echo " selected"; } echo ">splash</option>";
echo "<option value='12'"; if($group == 12) { echo " selected"; } echo ">fluid</option>";
echo "
</select><br/>";
echo "<table>";

echo "<tr>";
echo "<td><label>UNPASSABLE:</label><input type='checkbox' name='unpassable'"; if ($flagUnpassable) { echo "checked"; } echo "/></td>";
echo "<td><label>BLOCK MISSILES:</label><input type='checkbox' name='blockMissiles'"; if ($flagBlockMissiles) { echo "checked"; } echo "/></td>";
echo "<td><label>BLOCK PATHFINDER:</label><input type='checkbox' name='blockPathfinder'"; if ($flagBlockPathfinder) { echo "checked"; } echo "/></td>";
echo "<td><label>HAS ELEVATION:</label><input type='checkbox' name='hasElevation'"; if ($flagHasElevation) { echo "checked"; } echo "/></td>";
echo "</tr>";

echo "<tr>";
echo "<td><label>USEABLE:</label><input type='checkbox' name='useable'"; if ($flagUseable) { echo "checked"; } echo "/></td>";
echo "<td><label>PICKUPABLE:</label><input type='checkbox' name='pickupable'"; if ($flagPickupable) { echo "checked"; } echo "/></td>";
echo "<td><label>MOVEABLE:</label><input type='checkbox' name='moveable'"; if ($flagMoveable) { echo "checked"; } echo "/></td>";
echo "<td><label>STACKABLE:</label><input type='checkbox' name='stackable'"; if ($flagStackable) { echo "checked"; } echo "/></td>";
echo "</tr>";

echo "<tr>";
echo "<td><label>FLOOR CHANGE DOWN:</label><input type='checkbox' name='floorChangeDown'"; if ($flagFloorChangeDown) { echo "checked"; } echo "/></td>";
echo "<td><label>FLOOR CHANGE NORTH:</label><input type='checkbox' name='floorChangeNorth'"; if ($flagFloorChangeNorth) { echo "checked"; } echo "/></td>";
echo "<td><label>FLOOR CHANGE EAST:</label><input type='checkbox' name='floorChangeEast'"; if ($flagFloorChangeEast) { echo "checked"; } echo "/></td>";
echo "<td><label>FLOOR CHANGE SOUTH:</label><input type='checkbox' name='floorChangeSouth'"; if ($flagFloorChangeSouth) { echo "checked"; } echo "/></td>";
echo "</tr>";

echo "<tr>";
echo "<td><label>FLOOR CHANGE WEST:</label><input type='checkbox' name='floorChangeWest'"; if ($flagFloorChangeWest) { echo "checked"; } echo "/></td>";
echo "<td><label>ALWAYS ON TOP:</label><input type='checkbox' name='alwaysOnTop'"; if ($flagAlwaysOnTop) { echo "checked"; } echo "/></td>";
echo "<td><label>READABLE:</label><input type='checkbox' name='readable'"; if ($flagReadable) { echo "checked"; } echo "/></td>";
echo "<td><label>ROTABLE:</label><input type='checkbox' name='rotable'"; if ($flagRotable) { echo "checked"; } echo "/></td>";
echo "</tr>";

echo "<tr>";
echo "<td><label>HANGABLE:</label><input type='checkbox' name='hangable'"; if ($flagHangable) { echo "checked"; } echo "/></td>";
echo "<td><label>HOOK EAST:</label><input type='checkbox' name='hookEast'"; if ($flagHookEast) { echo "checked"; } echo "/></td>";
echo "<td><label>HOOK SOUTH:</label><input type='checkbox' name='hookSouth'"; if ($flagHookSouth) { echo "checked"; } echo "/></td>";
echo "<td><label>CANNOT DECAY:</label><input type='checkbox' name='cannotDecay'"; if ($flagCannotDecay) { echo "checked"; } echo "/></td>";
echo "</tr>";

echo "<tr>";
echo "<td><label>ALLOW DISTREAD:</label><input type='checkbox' name='allowDistread'"; if ($flagAllowDistread) { echo "checked"; } echo "/></td>";
echo "<td><label>UNUSED:</label><input type='checkbox' name='unused'"; if ($flagUnused) { echo "checked"; } echo "/></td>";
echo "<td><label>CLIENT CHARGES:</label><input type='checkbox' name='clientCharges'"; if ($flagClientCharges) { echo "checked"; } echo "/></td>";
echo "<td><label>IGNORE LOOK:</label><input type='checkbox' name='ignoreLook'"; if ($flagIgnoreLook) { echo "checked"; } echo "/></td>";
echo "</tr>";

echo "</table>";

echo "
<td><label>SPEED:</label><input type='number' name='speed' value='$speed'/><br/>
<td><label>LIGHT LEVEL:</label><input type='number' name='lightLevel' value='$lightLevel'/><br/>
<td><label>LIGHT COLOR:</label><input type='number' name='lightColor' value='$lightColor'/><br/>
<td><label>TOP ORDER:</label><input type='number' name='topOrder' value='$topOrder'/><br/>
<input type='submit' name='submit' value='save this item'/>
</form>
";

?>