<?php
require_once "index.php";

$dir = new RemovableDirectory("tmp/composite");

var_dump($dir->remove());

?>
<a href="make.php">生成</a>
