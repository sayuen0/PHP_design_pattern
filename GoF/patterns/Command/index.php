<?php
ini_set("display_errors", "1");
require_once("FileSystem.php");
require_once("ShellCommand.php");
require_once("ShellScript.php");
require_once("MakeDirectoryCommand.php");
require_once("RemoveDirectoryCommand.php");






function main()
{
  $sh = new ShellScript();
  $fs = new FileSystem("./tmp/sample/");
  $sh->add(new MakeDirectoryCommand($fs));

  var_dump($sh->run());
  var_dump($sh->undo());
  var_dump($sh->next());

  // var_dump($sh->undo());
  // var_dump($sh->undo());
}

main();
