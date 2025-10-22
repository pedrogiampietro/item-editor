<?php

$name = "";

if (empty($_POST["name"])) {
	$name = "items";
}
else {
	$name = $_POST["name"];
}

$self = '?page=load';

echo "
<div class='card'>
	<div class='card-header'>
		<h2 class='card-title'>📂 Load OTB File</h2>
	</div>
	<div class='card-body'>
		<p style='margin-bottom: 20px; color: var(--text-color);'>Load an OTB (Open Tibia Binary) file from the <strong>/in</strong> directory to import items into the editor.</p>
		
		<form method='post' action='$self'>
			<div class='form-group'>
				<label class='form-label'>OTB Filename (without .otb extension)</label>
				<input type='text' name='name' value='$name' class='form-input' placeholder='items' required/>
				<small style='color: var(--text-muted); display: block; margin-top: 5px;'>File path: /in/{$name}.otb</small>
			</div>
			<button type='submit' class='btn btn-primary' style='font-size: 16px; padding: 12px 30px;'>
				📂 Load File
			</button>
		</form>
";

if (!empty($_POST["name"])) {
	include_once("include/OTBLoader.php");
	$otbDir = "in/$name.otb";
	
	echo "<div style='margin-top: 20px;'>";
	
	try {
		$otbLoader = new OTBLoader($otbDir);
		$otbLoader->load();
		echo "<div class='alert alert-success'>✓ Successfully loaded <strong>$name.otb</strong>! You can now edit items in the Item Editor.</div>";
	}
	catch (Exception $e) {
		$message = $e->getMessage();
		echo "<div class='alert alert-error'>❌ Error while loading <strong>$name.otb</strong>: $message</div>";
	}
	
	echo "</div>";
}

echo "
	</div>
</div>
";

?>