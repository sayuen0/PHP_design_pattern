<html lang="ja">

<head>
  <title>作曲家と作品たち</title>
</head>

<body>
  <?php
  $handle = fopen("music.csv", "r");
  $column = 0;
  $tmp = "";
  while ($data = fgetcsv($handle, 1000, ",")) {
    $num = count($data);
    for ($c = 0; $c < $num; $c++) {
      if ($c == 0) {
        if ($column != 0 && $data[$c] != $tmp) {
          echo "</ul>";
        }
        if ($data[$c] != $tmp) {
          echo "<b>" . $data[$c] . "</b>";
          echo "<ul>";
          $tmp = $data[$c];
        }
      } else {
        echo "<li>";
        echo $data[$c];
        echo "</li>";
      }
    }
    $column++;
  }
  echo "</ul>";
  fclose($handle);
  ?>
</body>

</html>
