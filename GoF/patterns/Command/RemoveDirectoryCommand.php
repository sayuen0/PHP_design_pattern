<?php
require_once("ShellCommand.php");
require_once("FileSystem.php");


class RemoveDirectoryCommand implements ShellCommand
{
  private $fileSystem;

  public function __construct($fileSystem)
  {
    $this->fileSystem = $fileSystem;
  }

  public function execute()
  {
    return $this->fileSystem->removeDirectory();
  }
  public function undo()
  {
    return $this->fileSystem->makeDirectory();
  }
}
