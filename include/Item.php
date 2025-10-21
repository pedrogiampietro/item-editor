<?php

include_once("Database.php");

class Item {
	private $serverId;
	private $clientId;
	private $group;
	private $flags;
	private $attributeList;
	private $db;
	
	const attrServerId = 1;
	const attrClientId = 2;
	const attrSpeed = 3;
	const attrLightLevel = 4;
	const attrLightColor = 5;
	const attrTopOrder = 6;
	
	const FLAG_UNPASSABLE = 1;
	const FLAG_BLOCK_MISSILES = 2;
	const FLAG_BLOCK_PATHFINDER = 4;
	const FLAG_HAS_ELEVATION = 8;
	const FLAG_USEABLE = 16;
	const FLAG_PICKUPABLE = 32;
	const FLAG_MOVEABLE = 64;
	const FLAG_STACKABLE = 128;
	const FLAG_FLOORCHANGEDOWN = 256;
	const FLAG_FLOORCHANGENORTH = 512;
	const FLAG_FLOORCHANGEEAST = 1024;
	const FLAG_FLOORCHANGESOUTH = 2048;
	const FLAG_FLOORCHANGEWEST = 4096;
	const FLAG_ALWAYSONTOP = 8192;
	const FLAG_READABLE = 16384;
	const FLAG_ROTABLE = 32768;
	const FLAG_HANGABLE = 65536;
	const FLAG_HOOK_EAST = 131072;
	const FLAG_HOOK_SOUTH = 262144;
	const FLAG_CANNOTDECAY = 524288;
	const FLAG_ALLOWDISTREAD = 1048576;
	const FLAG_UNUSED = 2097152;
	const FLAG_CLIENTCHARGES = 4194304;
	const FLAG_IGNORE_LOOK = 8388608;

	function __construct() {
		$this->serverId = 0;
		$this->clientId = 0;
		$this->group = 0;
		$this->flags = 0;
		$this->attributeList = array();
		$this->db = Database::getInstance()->getConnection();
	}
	
	function setServerId($serverId) {
		$this->serverId = $serverId;
	}
	
	function getServerId() {
		return $this->serverId;
	}
	
	function setClientId($clientId) {
		$this->clientId = $clientId;
	}
	
	function getClientId() {
		return $this->clientId;
	}
	
	function setGroup($group) {
		$this->group = $group;
	}
	
	function getGroup() {
		return $this->group;
	}

	function setFlags($flags) {
		$this->flags = $flags;
	}
	
	function getFlags() {
		return $this->flags;
	}
	
	function getAttributeList() {
		return $this->attributeList;
	}
	
	function addAttribute($name, $value) {
		$this->attributeList[$name] = $value;
	}
	
	function removeAttribute($name) {
		unset($this->attributeList[$name]);
	}
	
	function getAttributeValueByName($name) {
		if (!array_key_exists($name, $this->attributeList)) { return ""; }
		return $this->attributeList[$name];
	}
	
	function save() {
		if ($this->serverId < 100) { throw new Exception("TRIED TO SAVE AN ITEM WITH SERVER ID LESS THAN 100 (id: $this->serverId)"); }
		
		$deleteQuery = "DELETE FROM items WHERE serverId=?";
		$stmt = $this->db->prepare($deleteQuery);
		$stmt->bind_param('i', $this->serverId);
		$stmt->execute();
		$stmt->close();
		
		$itemQuery = "INSERT INTO items (serverId, clientId, itemGroup, flags) VALUES (?, ?, ?, ?)";
		$stmt = $this->db->prepare($itemQuery);
		$stmt->bind_param('iiii', $this->serverId, $this->clientId, $this->group, $this->flags);
		$stmt->execute();
		$stmt->close();
		
		$itemAttributeQuery = "INSERT INTO itemattributes (serverId, name, value) VALUES (?, ?, ?)";
		foreach($this->attributeList as $name => $value) {
			$stmt = $this->db->prepare($itemAttributeQuery);
			$stmt->bind_param('isi', $this->serverId, $name, $value);
			$stmt->execute();
			$stmt->close();
		}
	}
	
	function loadByServerId($serverIdInput) {
		$queryItems = "SELECT serverId, clientId, itemGroup, flags FROM items WHERE serverId=?";
		$stmt = $this->db->prepare($queryItems);
		$stmt->bind_param('i', $serverIdInput);
		$stmt->execute();
		$stmt->bind_result($serverId, $clientId, $itemGroup, $flags);
		$stmt->fetch();
		$stmt->close();
		
		$this->serverId = $serverId;
		$this->clientId = $clientId;
		$this->group = $itemGroup;
		$this->flags = $flags;
		
		if ($this->serverId != $serverIdInput) { throw new Exception("ITEM WITH SERVER ID: $serverIdInput NOT FOUND"); }
		
		$queryAttributes = "SELECT name, value FROM itemattributes WHERE serverId=?";
		$stmt = $this->db->prepare($queryAttributes);
		$stmt->bind_param('i', $serverIdInput);
		$stmt->execute();
		$stmt->bind_result($name, $value);
		while ($stmt->fetch()) {
			$this->addAttribute($name, $value);
		}
		$stmt->close();
	}
	
}

?>