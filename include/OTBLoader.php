<?php

include_once("OTB.php");
include_once("Item.php");
include_once("Database.php");

class OTBLoader {
	private $otbHandle;
	private $startedNodes;
	private $isEscaped;
	private $db;
	
	public function __construct($otbFileDir) {
		$this->setOtbHandle($otbFileDir);
		$this->startedNodes = 0;
		$this->isEscaped = false;
		$this->db = Database::getInstance()->getConnection();
	}
	
	private function setOtbHandle($otbFileDir) {
		if (!file_exists($otbFileDir)) { throw new Exception("INPUT OTB FILE DOES NOT EXIST"); }
		$this->otbHandle = fopen($otbFileDir, "rb");
		if ($this->otbHandle === FALSE) { throw new Exception("INPUT OTB FILE COULD NOT BE OPENED"); }
	}
	
	private function reverseEndian($hex) {
		return implode('',array_reverse(str_split($hex,2)));
	}

	private function readByte($count) {
		$collectedBytes = 0;
		$totalBytes = decbin(0);
		while ($collectedBytes != $count) {
			$byte = fread($this->otbHandle, 1);
			
			if ($this->isEscaped || hexdec(bin2hex($byte)) != OTB::NODE_ESCAPE) {
				$this->isEscaped = false;
				$totalBytes[$collectedBytes] = $byte;
				$collectedBytes += 1;
				continue;
			}
						
			$this->isEscaped = true;
		}
		return $totalBytes;
	}
	
	private function readString($length) {
		return $this->readByte($length);
	}
	
	private function readInt($length) {
		return hexdec($this->reverseEndian(bin2hex($this->readByte($length))));
	}
	
	private function readRootNode() {
		
		if ($this->readInt(1) != OTB::NODE_START) { throw new Exception("NODE START EXPECTED"); }
		$this->startedNodes = 1;
		
		$group = $this->readInt(1);
		$flags = $this->readInt(4);
		
		$attrVersion = $this->readInt(1);
		$length = $this->readInt(2);
		$major = $this->readInt(4);
		$minor = $this->readInt(4);
		$build = $this->readInt(4);
		$csd = $this->readString(128);
		
		$otb = new OTB();
		$otb->setMajor($major);
		$otb->setMinor($minor);
		$otb->setBuild($build);
		$otb->setCsd($csd);
		$otb->save();
		
		while ($this->startedNodes > 0) {
			$read = $this->readInt(1);
			if ($read == OTB::NODE_END) { $this->startedNodes -= 1; }
			if ($this->startedNodes == 0) { break; }
			if ($read != OTB::NODE_START) { throw new Exception("NODE START EXPECTED"); }
			$this->startedNodes += 1;
			
			$item = new Item();
						
			$group = $this->readInt(1);
			$flags = $this->readInt(4);
			
			$item->setGroup($group);
			$item->setFlags($flags);
			
			while ($this->startedNodes > 1) {
				$attribute = $this->readInt(1);
				if ($attribute == OTB::NODE_END) {
					$this->startedNodes -= 1;
					break;
				}
				$length = $this->readInt(2);
				$this->fillItemAttribute($item, $attribute, $length);
			}
			
			$item->save();
		}
		
	}
	
	private function fillItemAttribute(&$item, $attribute, $length) {
		switch($attribute) {
			case 16: // server id
			$serverId = $this->readInt($length);
			$item->setServerId($serverId);
			break;
			case 17: // client id
			$clientId = $this->readInt($length);
			$item->setClientId($clientId);
			break;
			case 20: // speed
			$speed = $this->readInt($length);
			$item->addAttribute(Item::attrSpeed, $speed);
			break;
			case 42: // light 2
			$lightLevel = $this->readInt($length/2);
			$lightColor = $this->readInt($length/2);
			$item->addAttribute(Item::attrLightLevel, $lightLevel);
			$item->addAttribute(Item::attrLightColor, $lightColor);
			break;
			case 43: // top order
			$topOrder = $this->readInt($length);
			$item->addAttribute(Item::attrTopOrder, $topOrder);
			break;
			default:
			$this->readByte($length); // skip unwanted attributes
			break;
		}
	}
	
	public function load() {
		$this->cleanDB();
		$otbi = $this->readString(4);
		$this->readRootNode();
	}
	
	private function cleanDB() {
		$deleteOTB = "DELETE FROM otb";
		$stmt = $this->db->prepare($deleteOTB);
		$stmt->execute();
		$stmt->close();
		
		$deleteItems = "DELETE FROM items";
		$stmt = $this->db->prepare($deleteItems);
		$stmt->execute();
		$stmt->close();
		
		$resetAutoIncrement = "ALTER TABLE itemAttributes AUTO_INCREMENT = 1";
		$stmt = $this->db->prepare($resetAutoIncrement);
		$stmt->execute();
		$stmt->close();
	}
	
}

?>