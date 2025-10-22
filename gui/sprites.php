<?php

$pagination = 1;

if (empty($_POST["pagination"])) {
	$pagination = 1;
}
else {
	$pagination = $_POST["pagination"];
	if ($pagination < 1) { $pagination = 1; }
	if ($pagination > 50) { $pagination = 50; }
}

$self = '?page=editor&subpage=sprites';

$previous = $pagination - 1;
$next = $pagination + 1;

echo "
<div class='card mb-2'>
	<div class='card-body'>
		<div class='pagination'>
			<form method='post' action='$self'>
				<input type='hidden' name='pagination' value='1'/>
				<button type='submit' class='btn btn-small'>⏮ First</button>
			</form>
			<form method='post' action='$self'>
				<input type='hidden' name='pagination' value='$previous'/>
				<button type='submit' class='btn btn-small'>◀ Previous</button>
			</form>
			<span class='pagination-info'>Page $pagination of 50</span>
			<form method='post' action='$self'>
				<input type='hidden' name='pagination' value='$next'/>
				<button type='submit' class='btn btn-small'>Next ▶</button>
			</form>
			<form method='post' action='$self'>
				<input type='hidden' name='pagination' value='50'/>
				<button type='submit' class='btn btn-small'>Last ⏭</button>
			</form>
			<form method='post' action='$self' style='display: flex; gap: 5px;'>
				<input type='number' name='pagination' value='$pagination' min='1' max='50' placeholder='Page'/>
				<button type='submit' class='btn btn-small btn-primary'>Go</button>
			</form>
		</div>
	</div>
</div>
";

$dirname = "spr/";
$images = glob($dirname."*.png");
natsort($images);

// 1 to 50
$skipped = 0;
$page = $pagination-1;
$max = 100;
$current = 0;

echo "<div class='sprite-gallery'>";

foreach($images as $image) {
	if ($skipped != ($page * $max)) { $skipped++; continue; }
	if ($current == $max) { break; }
	$clientId = preg_replace(array("/spr\//", "/.png/"), "", $image);
	
	echo "
	<div class='sprite-item' title='Client ID: $clientId' onclick='navigator.clipboard.writeText(\"$clientId\"); alert(\"Client ID $clientId copied to clipboard!\");'>
		<img src='$image' alt='Sprite $clientId'/>
		<div style='text-align: center; color: var(--text-white); font-size: 11px; margin-top: 5px;'>ID: $clientId</div>
	</div>
	";
	
	$current++;
}

echo "</div>";

?>