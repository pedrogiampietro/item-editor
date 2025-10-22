<?php
include_once("./include/Database.php");

$serverId = isset($_GET['serverId']) ? intval($_GET['serverId']) : 5109;

$db = Database::getInstance()->getConnection();

$query = "SELECT serverId, clientId, itemGroup, flags FROM items WHERE serverId=?";
$stmt = $db->prepare($query);
$stmt->bind_param('i', $serverId);
$stmt->execute();
$stmt->bind_result($dbServerId, $dbClientId, $dbGroup, $dbFlags);
$stmt->fetch();
$stmt->close();

echo "<h2>Debug Item Data - Server ID: $serverId</h2>";
echo "<table border='1' style='border-collapse: collapse; padding: 10px;'>";
echo "<tr><th style='padding: 10px;'>Field</th><th style='padding: 10px;'>Value</th></tr>";
echo "<tr><td style='padding: 10px;'>Server ID</td><td style='padding: 10px;'>$dbServerId</td></tr>";
echo "<tr><td style='padding: 10px;'>Client ID</td><td style='padding: 10px;'>$dbClientId</td></tr>";
echo "<tr><td style='padding: 10px;'>Group</td><td style='padding: 10px;'>$dbGroup</td></tr>";
echo "<tr><td style='padding: 10px;'>Flags</td><td style='padding: 10px;'>$dbFlags</td></tr>";
echo "</table>";

echo "<br><br>";
echo "<h3>Attributes:</h3>";
$queryAttr = "SELECT name, value FROM itemattributes WHERE serverId=?";
$stmt = $db->prepare($queryAttr);
$stmt->bind_param('i', $serverId);
$stmt->execute();
$stmt->bind_result($attrName, $attrValue);

echo "<table border='1' style='border-collapse: collapse; padding: 10px;'>";
echo "<tr><th style='padding: 10px;'>Name</th><th style='padding: 10px;'>Value</th></tr>";
while ($stmt->fetch()) {
    echo "<tr><td style='padding: 10px;'>$attrName</td><td style='padding: 10px;'>$attrValue</td></tr>";
}
echo "</table>";
$stmt->close();

echo "<br><br>";
echo "<a href='debug_item.php?serverId=$serverId'>Reload</a> | ";
echo "<a href='index.php?page=editor&subpage=item&serverId=$serverId'>Go to Editor</a>";
?>
