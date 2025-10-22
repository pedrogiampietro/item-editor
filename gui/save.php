<?php

$name = "";

if (empty($_POST["name"])) {
	$name = "items";
}
else {
	$name = $_POST["name"];
}

$self = '?page=save';

echo "
<div class='card'>
	<div class='card-header'>
		<h2 class='card-title'>💾 Save OTB File</h2>
	</div>
	<div class='card-body'>
		<p style='margin-bottom: 20px; color: var(--text-color);'>Export your edited items to an OTB file in the <strong>/out</strong> directory.</p>
		
		<form method='post' action='$self'>
			<div class='form-group'>
				<label class='form-label'>OTB Filename (without .otb extension)</label>
				<input type='text' name='name' value='$name' class='form-input' placeholder='items' required/>
				<small style='color: var(--text-muted); display: block; margin-top: 5px;'>File will be saved to: /out/{$name}.otb</small>
			</div>
			<button type='submit' class='btn btn-success' style='font-size: 16px; padding: 12px 30px;'>
				💾 Save File
			</button>
		</form>
";

if (!empty($_POST["name"])) {
	include_once("include/OTBWriter.php");
	$otbDir = "out/$name.otb";
	
	echo "<div style='margin-top: 20px;'>";
	
	try {
		$otbWriter = new OTBWriter($otbDir);
		$otbWriter->save();
		echo "<div class='alert alert-success'>✓ Successfully saved <strong>$name.otb</strong> to the /out directory!</div>";
	}
	catch (Exception $e) {
		$message = $e->getMessage();
		echo "<div class='alert alert-error'>❌ Error while saving <strong>$name.otb</strong>: $message</div>";
	}
	
	echo "</div>";
}

echo "
	</div>
</div>
";

?>