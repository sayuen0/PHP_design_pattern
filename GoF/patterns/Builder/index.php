<?php

/**
 * 複数のディレクタと複数のビルダ
 * 多種多様なことを実現する
 * 
 * 比較的業務に落とし込みやすいが、
 * 最初からBuilderにすることを見越すのは難しい
 * リファクタリング時に構造を見極めるのが現実的
 * 
 * ビルダの構造
 * ディレクタ：ビルダを使う機能を持つ その上で中身を作る
 * ビルダ：インスタンスを生成、目的に応じたプロパティを付与
 * ビルディング：生成物
 * 
 */



//  Builder

interface DocumentBuilder
{
  public function setTitle($str);
  public function setHeader($str);
  public function setBody($str);
  public function setFooter($str);
  public function getResult();
}


// Director 中身を作る
// レポート書きたい人

class ReportDirector
{
  private $builder;

  public function __construct(DocumentBuilder $builder)
  {
    $this->builder = $builder;
  }

  public function build()
  {
    $this->builder->setTitle("報告書");
    $this->builder->setHeader("失敗");
    $this->builder->setBody("プロトタイプを無駄にする");
    $this->builder->setFooter("次頑張りましょう");
    return $this->builder->getResult();
  }
}


// director2 

class DiaryDirector
{
  private $builder;

  public function __construct(DocumentBuilder $builder)
  {
    $this->builder = $builder;
  }

  public function build()
  {
    $this->builder->setTitle("日記2020/03/12");
    $this->builder->setHeader("いい日だった");
    $this->builder->setBody("プロトタイプを多数生成");
    $this->builder->setFooter("明日も頑張る");
    return $this->builder->getResult();
  }
}



// builder1 雛形を作る

class HtmlBuilder implements DocumentBuilder
{
  private $header = null;
  private $body = null;
  private $footer = null;
  private $title = null;

  public function getBody()
  {
    return $this->body;
  }
  public function getFooter()
  {
    return $this->footer;
  }
  public function getHeader()
  {
    return $this->header;
  }
  public function getTitle()
  {
    return $this->title;
  }

  public function setTitle($title)
  {
    $this->title = $title;
  }

  public function setHeader($header)
  {
    $this->header = $header;
  }

  public function setBody($body)
  {
    $this->body = $body;
  }

  public function setFooter($footer)
  {
    $this->footer = $footer;
  }

  public function getResult()
  {
    ob_start();
?>
    <html>

    <head>
      <title><?= htmlspecialchars($this->title, ENT_QUOTES) ?></title>
    </head>

    <body>
      <h1><?= htmlspecialchars($this->header, ENT_QUOTES) ?></h1>

      <div>
        <p>
          <?= htmlspecialchars($this->body) ?>
        </p>
      </div>
      <hr>
      <div><?= htmlspecialchars($this->footer, ENT_QUOTES) ?></div>
    </body>

    </html>
  <?php return ob_get_clean();
  }
}

// builder 2 雛形を作る

class MarkdownBuilder implements DocumentBuilder
{
  private $header = null;
  private $body = null;
  private $footer = null;
  private $title = null;

  public function getBody()
  {
    return $this->body;
  }
  public function getFooter()
  {
    return $this->footer;
  }
  public function getHeader()
  {
    return $this->header;
  }
  public function getTitle()
  {
    return $this->title;
  }

  public function setTitle($title)
  {
    $this->title = $title;
  }

  public function setHeader($header)
  {
    $this->header = $header;
  }

  public function setBody($body)
  {
    $this->body = $body;
  }

  public function setFooter($footer)
  {
    $this->footer = $footer;
  }

  public function getResult()
  {
    ob_start();
  ?>
    # <?= htmlspecialchars($this->title, ENT_QUOTES) ?>
    ## <?= htmlspecialchars($this->header, ENT_QUOTES) ?>

    <?= htmlspecialchars($this->body, ENT_QUOTES) ?>

    ------------------------------------------
    <?= htmlspecialchars($this->footer, ENT_QUOTES) ?>
<?php return ob_get_clean();
  }
}


// 雛形を作るやつをディレクタはプロパティに持つ
$hr = new ReportDirector(new HtmlBuilder());
$mr = new ReportDirector(new MarkdownBuilder());

print($hr->build());
print($mr->build());

// 日記を生成
$hd = new DiaryDirector(new HtmlBuilder());
$md = new DiaryDirector(new MarkdownBuilder());


echo $hd->build();//directorがbuildするのではなくてプロパティのbuilderが手順に従ってbuildしてくれる
echo $md->build();


