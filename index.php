<?php

include_once("gui/menu.php");

if (isset($_GET['load'])) {
	$load = $_GET['load'];
	include_once("include/OTBLoader.php");
	$otbDir = "in/$load.otb";
	$otbLoader = new OTBLoader($otbDir);
	$otbLoader->load();
}

if (isset($_GET['id'])) {
	$id = $_GET['id'];
	include_once("include/Item.php");
	$item = new Item();
	$item->loadByServerId($id);
	$item->debug();
}

if (isset($_GET['save'])) {
	$save = $_GET['save'];
	include_once("include/OTBWriter.php");
	$otbDir = "out/$save.otb";
	$otbWriter = new OTBWriter($otbDir);
	$otbWriter->save();
}
?>