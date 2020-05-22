<?php

/**
 * Reciever
 */
class FileSystem
{
  private $path;

  public function __construct($path)
  {
    $this->path = $path;
  }

  public function changeDirectory()
  {
    return "cd $this->path";
  }

  public function makeDirectory()
  {
    return exec("mkdir -p $this->path");
  }
  public function removeDirectory()
  {
    return exec("rm -r  $this->path");
  }

  public function createFile()
  {
    return "touch $this->path";
  }

  public function removeFile()
  {
    return "rm $this->path";
  }
}
