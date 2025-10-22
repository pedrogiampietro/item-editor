<?php
include_once("./include/OTB.php");
include_once("./include/Database.php");

$self = "?page=otb";

$otb = new OTB();
$otb->load();

$major = $otb->getMajor();
$minor = $otb->getMinor();
$build = $otb->getBuild();
$csd = $otb->getCsd();

if (isset($_POST['save'])) {
	$otbToSave = new OTB();
	if (isset($_POST["major"])) {
		$majorToSave = $_POST["major"];
		if ($majorToSave < 0) { $majorToSave = 0; }
		$otbToSave->setMajor($majorToSave);
	}
	if (isset($_POST["minor"])) {
		$minorToSave = $_POST["minor"];
		if ($minorToSave < 0) { $minorToSave = 0; }
		$otbToSave->setMinor($minorToSave);
	}
	if (isset($_POST["build"])) {
		$buildToSave = $_POST["build"];
		if ($buildToSave < 0) { $buildToSave = 0; }
		$otbToSave->setBuild($buildToSave);
	}
	if (isset($_POST["csd"])) {
		$csdToSave = $_POST["csd"];
		if (strlen($csdToSave) > 128) { $csdToSave = substr($csdToSave, 0, 128); }
		$otbToSave->setCsd($csdToSave);
	}
	try {
		$otbToSave->save();
		echo "<div class='alert alert-success'>✓ OTB metadata saved successfully!</div>";
	}
	catch (Exception $e) {
		$message = $e->getMessage();
		echo "<div class='alert alert-error'>❌ Error: $message</div>";
	}
	
	// Reload values
	$otb->load();
	$major = $otb->getMajor();
	$minor = $otb->getMinor();
	$build = $otb->getBuild();
	$csd = $otb->getCsd();
}

if (isset($_POST["clearDB"])) {
	$db = Database::getInstance()->getConnection();
	
	$deleteQueryOTB = 'delete from otb';
	$stmt = $db->prepare($deleteQueryOTB);
	$stmt->execute();
	$stmt->close();
	
	$deleteQueryItems = 'delete from items';
	$stmt = $db->prepare($deleteQueryItems);
	$stmt->execute();
	$stmt->close();
	
	echo "<div class='alert alert-success'>✓ Database cleared successfully!</div>";
	
	$major = 0;
	$minor = 0;
	$build = 0;
	$csd = "";
}

echo "
<div class='grid grid-2'>
	<div class='card'>
		<div class='card-header'>
			<h2 class='card-title'>⚙️ OTB Metadata</h2>
		</div>
		<div class='card-body'>
			<p style='margin-bottom: 20px; color: var(--text-color);'>Configure OTB version and description information.</p>
			
			<form method='post' action='$self'>
				<input name='save' type='hidden'>
				
				<div class='form-group'>
					<label class='form-label'>Major Version</label>
					<input name='major' type='number' value='$major' class='form-input' min='0'/>
				</div>
				
				<div class='form-group'>
					<label class='form-label'>Minor Version</label>
					<input name='minor' type='number' value='$minor' class='form-input' min='0'/>
				</div>
				
				<div class='form-group'>
					<label class='form-label'>Build Number</label>
					<input name='build' type='number' value='$build' class='form-input' min='0'/>
				</div>
				
				<div class='form-group'>
					<label class='form-label'>CSD (Description)</label>
					<input name='csd' type='text' value='$csd' class='form-input' maxlength='128' placeholder='e.g., OTServ 0.6.0'/>
					<small style='color: var(--text-muted); display: block; margin-top: 5px;'>Maximum 128 characters</small>
				</div>
				
				<button type='submit' class='btn btn-success' style='font-size: 16px; padding: 12px 30px;'>
					💾 Save Metadata
				</button>
			</form>
		</div>
	</div>
	
	<div class='card'>
		<div class='card-header'>
			<h2 class='card-title'>🗑️ Database Management</h2>
		</div>
		<div class='card-body'>
			<p style='margin-bottom: 20px; color: var(--text-color);'>Clear all items and OTB data from the database.</p>
			
			<div style='padding: 15px; background: rgba(244, 67, 54, 0.1); border-radius: 8px; border: 1px solid var(--danger); margin-bottom: 20px;'>
				<h4 style='color: #ff6b6b; margin-bottom: 10px;'>⚠️ Warning</h4>
				<p style='color: var(--text-color); margin: 0;'>This action will permanently delete all items and OTB metadata from the database. This cannot be undone!</p>
			</div>
			
			<form method='post' action='$self' onsubmit='return confirm(\"Are you sure you want to clear the entire database? This action cannot be undone!\");'>
				<input name='clearDB' type='hidden'>
				<button type='submit' class='btn btn-danger' style='font-size: 16px; padding: 12px 30px;'>
					🗑️ Clear Database
				</button>
			</form>
			
			<div style='margin-top: 20px; padding: 15px; background: var(--bg-primary); border-radius: 8px; border: 1px solid var(--border-color);'>
				<h4 style='color: var(--text-white); margin-bottom: 10px;'>ℹ️ Current Status</h4>
				<div style='color: var(--text-color);'>
					<p style='margin: 5px 0;'><strong>Version:</strong> $major.$minor.$build</p>
					<p style='margin: 5px 0;'><strong>Description:</strong> " . ($csd ? $csd : 'Not set') . "</p>
				</div>
			</div>
		</div>
	</div>
</div>
";

?>