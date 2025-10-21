<?php

include_once("Database.php");

class OTB {
	private $major;
	private $minor;
	private $build;
	private $csd;
	private $db;
	const NODE_ESCAPE = 253;
	const NODE_START = 254;
	const NODE_END = 255;
	
	function __construct() {
		$this->major = 0;
		$this->minor = 0;
		$this->build = 0;
		$this->csd = "";
		$this->db = Database::getInstance()->getConnection();
	}
	
	function setMajor($major) {
		$this->major = $major;
	}
	function getMajor() {
		return $this->major;
	}
	
	function setMinor($minor) {
		$this->minor = $minor;
	}
	function getMinor() {
		return $this->minor;
	}
	
	function setBuild($build) {
		$this->build = $build;
	}
	function getBuild() {
		return $this->build;
	}
	
	function setCsd($csd) {
		$this->csd = $csd;
	}
	function getCsd() {
		return $this->csd;
	}
	
	function save() {
		// Modificado para aceitar versão 1.3 do arquivo OTB
		if ($this->major != 3 && $this->major != 1) { 
			throw new Exception("UNSUPPORTED OTB MAJOR VERSION (EXPECTED 3 OR 1, GOT: $this->major)"); 
		}
		
		$deleteQuery = "DELETE FROM otb";
		$stmt = $this->db->prepare($deleteQuery);
		$stmt->execute();
		$stmt->close();
		
		$query = "INSERT INTO otb(major, minor, build, csd) VALUES (?, ?, ?, ?)";
		$stmt = $this->db->prepare($query);
		$stmt->bind_param('iiis', $this->major, $this->minor, $this->build, $this->csd);
		$stmt->execute();
		$stmt->close();
	}
	
	function load() {
		$query = "SELECT major, minor, build, csd FROM otb";
		$stmt = $this->db->prepare($query);
		$stmt->execute();
		$stmt->bind_result($major, $minor, $build, $csd);
		$stmt->fetch();
		$stmt->close();
		
		$this->major = $major;
		$this->minor = $minor;
		$this->build = $build;
		$this->csd = $csd;
	}

}

?>