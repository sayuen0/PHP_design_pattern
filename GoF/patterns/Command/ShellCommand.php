<?php
interface ShellCommand
{
  public function execute();

  public function undo();
}
