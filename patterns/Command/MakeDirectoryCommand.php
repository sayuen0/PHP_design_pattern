<?php

class MakeDirectoryCommand implements ShellCommand
{
  private $fileSystem;

  public function __construct($fileSystem)
  {
    $this->fileSystem = $fileSystem;
  }

  public function execute()
  {
    return $this->fileSystem->makeDirectory();
  }
  public function undo()
  {
    return $this->fileSystem->removeDirectory();
  }
}
