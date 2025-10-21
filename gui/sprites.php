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
<div>
<form method='post' action='$self' style='display:inline'>
<input type='hidden' name='pagination' value='1'/>
<input type='submit' name='submit' value='<<'/>
</form>
<form method='post' action='$self' style='display:inline'>
<input type='hidden' name='pagination' value='$previous'/>
<input type='submit' name='submit' value='<'/>
</form>
PAGE: $pagination/50
<form method='post' action='$self' style='display:inline'>
<input type='hidden' name='pagination' value='$next'/>
<input type='submit' name='submit' value='>'/>
</form>
<form method='post' action='$self' style='display:inline'>
<input type='hidden' name='pagination' value='50'/>
<input type='submit' name='submit' value='>>'/>
</form>
<form method='post' action='$self' style='display:inline; float:right;'>
<input type='number' name='pagination' value='$pagination'/>
<input type='submit' name='submit' value='go to'/>
</form>
</div>
<hr/>
";


$dirname = "spr/";
$images = glob($dirname."*.png");
natsort($images);

// 1 to 50
$skipped = 0;
$page = $pagination-1;
$max = 100;
$current = 0;

echo "<style>img:hover {outline-style: dotted; outline-color:red;}</style>";

foreach($images as $image) {
	if ($skipped != ($page * $max)) { $skipped++; continue; }
	if ($current == $max) { break; }
	$clientId = preg_replace(array("/spr\//", "/.png/"), "", $image);
   echo "<img title='this sprite has client id: $clientId' src='$image' style='margin: 8px 8px 8px 8px;'/>";
   $current++;
}

?>