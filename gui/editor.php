<?php
echo "
<a href='?page=editor&subpage=items' style='margin-right: 20px;'>ITEM LIST</a>
<a href='?page=editor&subpage=sprites' style='margin-right: 20px;'>SPRITE LIST</a>
<a href='?page=editor&subpage=find' style='margin-right: 20px;'>FIND ITEM</a>
<a href='?page=editor&subpage=item&addItem' style='float:right;'>ADD ITEM</a>
<hr/>
";

if (isset($_GET['subpage'])) {
	$subpage = $_GET['subpage'];
}

if (isset($subpage)) {
	include_once($subpage.'.php');
}

?>