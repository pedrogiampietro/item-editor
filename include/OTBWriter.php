<?php

include_once("OTB.php");
include_once("Item.php");
include_once("Database.php");

class OTBWriter {
	private $otbHandle;
	private $db;
	
	public function __construct($otbFileDir) {
		$this->setOtbHandle($otbFileDir);
		$this->db = Database::getInstance()->getConnection();
	}
	
	private function setOtbHandle($otbFileDir) {
		$this->otbHandle = fopen($otbFileDir, "wb");
		if ($this->otbHandle === FALSE) { throw new Exception("OUTPUT OTB FILE NOT FOUND"); }
	}
	
	private function reverseEndian($hex) {
		return implode('',array_reverse(str_split($hex,2)));
	}
	
	private function writeIntUnescaped($value) {
		fwrite($this->otbHandle, hex2bin(dechex($value)));
	}
	
	private function writeByte($value, $count) {
		$length = strlen(bin2hex($value));
		if ($length % 2 != 0) {
			$length += 1;
		}
		$byteArray = str_split($value);
		foreach ($byteArray as $byte) {
			$check = hexdec(bin2hex($byte));
			if ($check == OTB::NODE_ESCAPE || $check == OTB::NODE_START || $check == OTB::NODE_END) {
				fwrite($this->otbHandle, hex2bin(dechex(OTB::NODE_ESCAPE)));
			}
			fwrite($this->otbHandle, $byte);
		}
		$length = $length/2;
		while ($length!=$count) {
			fwrite($this->otbHandle, "\0");
			$length++;
		}
	}
	
	private function writeString($value, $length) {
		$this->writeByte($value, $length);
	}
	
	private function writeInt($value, $length) {
		$value = dechex($value);
		if (strlen($value) % 2 != 0) {
			$value = "0" . $value;
		}
		$value = $this->reverseEndian($value);
		$value = hex2bin($value);
		$this->writeByte($value, $length);
	}
	
	private function writeRootNode() {
		$this->writeIntUnescaped(OTB::NODE_START); // ROOT NODE START
		
		$this->writeInt(0, 1); // ROOT NODE GROUP
		$this->writeInt(0, 4); // ROOT NODE FLAGS
		
		$this->writeInt(1, 1); // ROOT NODE ATTR VERSION
		$this->writeInt(140, 2); // ATTR LENGTH
		
		$otb = new OTB();
		$otb->load();
		
		$this->writeInt($otb->getMajor(), 4);
		$this->writeInt($otb->getMinor(), 4);
		$this->writeInt($otb->getBuild(), 4);
		$this->writeString($otb->getCsd(), 128);
		
		$itemServerIdList = array();
		
		$itemServerIds = "SELECT serverId FROM items";
		$stmt = $this->db->prepare($itemServerIds);
		$stmt->execute();
		$stmt->bind_result($serverId);
		while ($stmt->fetch()) {
			$itemServerIdList[] = $serverId;
		}
		$stmt->close();
		
		foreach($itemServerIdList as $serverId) {

			$item = new Item();
			$item->loadByServerId($serverId);
			$this->writeIntUnescaped(OTB::NODE_START); // ITEM NODE START
			
			$this->writeInt($item->getGroup(), 1); // GROUP
			$this->writeInt($item->getFlags(), 4); // FLAGS
			
			$this->writeAttribute(Item::attrServerId, $item); // SERVER ID
			$this->writeAttribute(Item::attrClientId, $item); // CLIENT ID
			
			$list = $item->getAttributeList();
			ksort($list);
			
			foreach ($list as $name => $value) {
				$this->writeAttribute($name, $item);
			}
			
			$this->writeIntUnescaped(OTB::NODE_END); // ITEM NODE END		
		
		}
				
		$this->writeIntUnescaped(OTB::NODE_END); // ROOT NODE END
	}
	
	private function writeAttribute($name, &$item) {
		switch($name) {
			case Item::attrServerId:
			$this->writeInt(16, 1); // ATTR ID
			$this->writeInt(2, 2); // LENGTH
			$this->writeInt($item->getServerId(), 2); // SERVER ID
			break;
			case Item::attrClientId:
			$this->writeInt(17, 1); // ATTR ID
			$this->writeInt(2, 2); // LENGTH
			$this->writeInt($item->getClientId(), 2); // CLIENT ID
			break;
			case Item::attrSpeed:
			$this->writeInt(20, 1); // ATTR ID
			$this->writeInt(2, 2); // LENGTH
			$this->writeInt($item->getAttributeValueByName($name), 2); // SERVER ID
			break;
			case Item::attrLightLevel:
			if (!array_key_exists(Item::attrLightColor, $item->getAttributeList())) { throw new Exception("LIGHT COLOR NOT SET FOR ITEM SERVER ID: $item->getServerId() WITH LIGHT LEVEL SET"); }
			$this->writeInt(42, 1); // ATTR ID
			$this->writeInt(4, 2); // LENGTH
			$this->writeInt($item->getAttributeValueByName($name), 2); // LIGHT LEVEL
			$this->writeInt($item->getAttributeValueByName(Item::attrLightColor), 2); // LIGHT COLOR
			break;
			case Item::attrLightColor:
			if (!array_key_exists(Item::attrLightLevel, $item->getAttributeList())) { throw new Exception("LIGHT LEVEL NOT SET FOR ITEM SERVER ID: $item->getServerId() WITH LIGHT COLOR SET"); }
			// actual writing done in attrLightLevel
			break;
			case Item::attrTopOrder:
			$this->writeInt(43, 1); // ATTR ID
			$this->writeInt(1, 2); // LENGTH
			$this->writeInt($item->getAttributeValueByName($name), 1); // TOP ORDER
			break;
			default: // skip unwanted attributes
			break;
		}
		
	}
	
	public function save() {
		$this->writeString("\0\0\0\0", 4); // OTBI
		$this->writeRootNode();
	}
	
}

?>