<?php
$subpage = isset($_GET['subpage']) ? $_GET['subpage'] : 'items';

echo "
<div class='card'>
	<div class='card-header'>
		<h2 class='card-title'>📝 Item Editor</h2>
		<a href='?page=editor&subpage=item&addItem' class='btn btn-success'>
			➕ Add New Item
		</a>
	</div>
	<div class='card-body'>
		<nav class='nav-pills mb-2'>
			<a href='?page=editor&subpage=items' class='nav-link " . ($subpage == 'items' ? 'active' : '') . "'>
				📋 Item List
			</a>
			<a href='?page=editor&subpage=sprites' class='nav-link " . ($subpage == 'sprites' ? 'active' : '') . "'>
				🎨 Sprite List
			</a>
			<a href='?page=editor&subpage=find' class='nav-link " . ($subpage == 'find' ? 'active' : '') . "'>
				🔍 Find Item
			</a>
		</nav>
";

if (isset($subpage)) {
	$subpageFile = __DIR__ . '/' . $subpage . '.php';
	if (file_exists($subpageFile)) {
		include_once($subpage.'.php');
	} else {
		echo "<div class='alert alert-error'>Page not found: $subpage</div>";
	}
}

echo "
	</div>
</div>
";
?>