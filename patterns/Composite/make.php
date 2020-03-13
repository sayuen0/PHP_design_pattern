<?php  
require_once "index.php";

// // テストデータ作成


function makeDirs($path)
{
  if (!is_dir($path)) {
    shell_exec("mkdir -p " . $path);
    echo "成功 ". $path;
  }else {
    echo "失敗 ". $path;
  }
}


// makeDirs("tmp/composite");
// makeDirs("tmp/composite/hoge");
// makeDirs("./tmp/composite/fuga");
// makeDirs("./tmp/composite/hoge/buzz");
// makeDirs("./tmp/composite/piyo");
// makeDirs("./tmp/composite/piyo/fizz");

// `touch ./tmp/composite/piyo/file2`;
// `touch ./tmp/composite/piyo/fizz/file1`;
// `touch ./tmp/composite/piyo/fizz/file2`;

$f = opendir("tmp/composite/piyo/fizz");

while ($d = readdir($f)) {
  var_dump($d);
}

?>

<a href="remove.php">削除</a>


