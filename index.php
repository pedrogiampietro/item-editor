<?php
include_once("includes/header.php");

if (isset($_GET['load'])) {
	$load = $_GET['load'];
	include_once("include/OTBLoader.php");
	$otbDir = "in/$load.otb";
	$otbLoader = new OTBLoader($otbDir);
	$otbLoader->load();
	echo "<div class='alert alert-success'>✓ OTB file '$load.otb' loaded successfully!</div>";
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
	echo "<div class='alert alert-success'>💾 OTB file '$save.otb' saved successfully!</div>";
}

if (isset($_GET['page'])) {
	$page = $_GET['page'];
	if (file_exists("gui/$page.php")) {
		include_once("gui/$page.php");
	}
} else {
	// Dashboard/Home page
	echo "
	<div class='card'>
		<div class='card-header'>
			<h1 class='card-title'>🎮 Welcome to Item Editor</h1>
		</div>
		<div class='card-body'>
			<p style='font-size: 16px; margin-bottom: 20px;'>Manage your OTB (Open Tibia Binary) items with ease. Load, edit, and save item definitions.</p>
			
			<div class='grid grid-3' style='margin-top: 30px;'>
				<div class='card'>
					<h3 style='color: var(--text-white); margin-bottom: 15px;'>📝 Item Editor</h3>
					<p style='margin-bottom: 15px;'>Edit item properties, flags, and attributes.</p>
					<a href='?page=editor' class='btn btn-primary' style='width: 100%; justify-content: center;'>Open Editor</a>
				</div>
				
				<div class='card'>
					<h3 style='color: var(--text-white); margin-bottom: 15px;'>📂 Load OTB</h3>
					<p style='margin-bottom: 15px;'>Import OTB files from your server.</p>
					<a href='?page=load' class='btn btn-primary' style='width: 100%; justify-content: center;'>Load File</a>
				</div>
				
				<div class='card'>
					<h3 style='color: var(--text-white); margin-bottom: 15px;'>💾 Save OTB</h3>
					<p style='margin-bottom: 15px;'>Export your changes to OTB format.</p>
					<a href='?page=save' class='btn btn-primary' style='width: 100%; justify-content: center;'>Save File</a>
				</div>
			</div>
		</div>
	</div>
	";
}

include_once("includes/footer.php");
?>