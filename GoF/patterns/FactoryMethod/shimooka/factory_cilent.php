<?php
ini_set("display_errors", "1");
require_once("ReaderFactory.class.php");
?>



<html lang="ja">

<head>
  <title>作曲家と作品たち</title>
</head>

<body>
  <?php
  /**
   * 外部からの入力ファイルです
   */
  $filename = 'music.csv';
  $factory = new ReaderFactory();
  $data = $factory->create($filename);
  var_dump($data);
  $data->read();
  $data->display();
  ?>
</body>

</html>
