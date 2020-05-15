# Commandパターン


```sql
SELECT * FROM users
```


```php
<?php
echo "hello world";
?>

<div class="container">
```

# ソース


```php
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

interface ShellCommand
{
  public function execute();

  public function undo();
}

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

```


