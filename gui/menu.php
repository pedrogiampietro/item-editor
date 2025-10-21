<?php

echo "
<a href='?page=editor'>ITEM EDITOR</a>
<a style='float:right;' href='?page=save'>SAVE OTB</a>
<a style='float:right; margin-right: 20px;' href='?page=load'>LOAD OTB</a>
<a href='?page=otb' style='float:right;margin-right: 20px;'>EDIT OTB METADATA</a>
<hr/>
";

if (isset($_GET['page'])) {
	$page = $_GET['page'];
}

if (isset($page)) {
	include_once($page.'.php');
}

?>